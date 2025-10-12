<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCode;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        $products = $seller->products()
            ->with('category')
            ->withCount('reviews')
            ->latest()
            ->paginate(15);

        return view('seller.products.index', compact('products', 'seller'));
    }

    public function create()
    {
        $seller = auth()->user()->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        if (! $seller->is_active) {
            return view('seller.blocked', compact('seller'));
        }

        $categories = Category::active()->ordered()->get();

        return view('seller.products.create', compact('categories', 'seller'));
    }

    public function store(Request $request)
    {
        $seller = auth()->user()->seller;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'delivery_type' => 'required|in:file,code,hybrid',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
            'thumbnail' => 'nullable|image|max:2048',
            'files.*' => 'nullable|file|max:102400', // 100MB
            'codes' => 'nullable|string',
            'has_credentials' => 'nullable|boolean',
            'credential_username' => 'required_if:has_credentials,1|nullable|string|max:255',
            'credential_password' => 'required_if:has_credentials,1|nullable|string|max:255',
            'credential_extras_keys' => 'nullable|array',
            'credential_extras_values' => 'nullable|array',
            'credential_instructions' => 'nullable|string',
            'is_unique_credential' => 'nullable|boolean',
        ]);

        // Prepare credential data if provided
        $credentialData = null;
        if ($request->filled('has_credentials') && $request->has_credentials) {
            $extras = [];
            if ($request->filled('credential_extras_keys') && $request->filled('credential_extras_values')) {
                $keys = $request->credential_extras_keys;
                $values = $request->credential_extras_values;

                foreach ($keys as $index => $key) {
                    if (! empty($key) && ! empty($values[$index])) {
                        $extras[] = [
                            'k' => $key,
                            'v' => $values[$index],
                        ];
                    }
                }
            }

            $credentialData = [
                'username' => $request->credential_username,
                'password' => $request->credential_password,
                'extras' => $extras,
                'instructions' => $request->credential_instructions ?? '',
            ];
        }

        $product = $seller->products()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'delivery_type' => $validated['delivery_type'],
            'features' => $validated['features'] ?? [],
            'tags' => $validated['tags'] ?? [],
            'delivery_credentials' => $credentialData,
            'is_unique_credential' => $request->filled('is_unique_credential') ? true : false,
            'verification_status' => 'pending',
            'status' => 'draft',
        ]);

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('products/thumbnails', 's3');
            $product->update(['thumbnail_url' => $path]);
        }

        // Handle product files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = Str::random(40).'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('products/files', $filename, 's3');

                ProductFile::create([
                    'product_id' => $product->id,
                    'filename' => $filename,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Handle codes
        if ($request->filled('codes') && in_array($validated['delivery_type'], ['code', 'hybrid'])) {
            $codes = array_filter(explode("\n", $request->codes));
            foreach ($codes as $code) {
                ProductCode::create([
                    'product_id' => $product->id,
                    'code' => trim($code),
                    'status' => 'available',
                ]);
            }
            $product->update(['stock_count' => count($codes)]);
        }

        \App\Models\ActivityLog::log('product_created', $product, "Created product: {$product->title}");

        return redirect()->route('seller.products.edit', $product)
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::active()->ordered()->get();
        $seller = auth()->user()->seller;

        return view('seller.products.edit', compact('product', 'categories', 'seller'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,active,paused,archived',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $product->update($validated);

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
