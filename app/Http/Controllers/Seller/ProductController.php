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
        $user = auth()->user();
        $seller = $user->seller;

        if (! $seller) {
            return redirect()->route('sell.entry');
        }

        if (! $seller->is_active) {
            return view('seller.blocked', compact('seller'));
        }

        // Check if user can create more products (draft limit)
        if (!$user->canCreateProduct()) {
            $currentDrafts = $seller->products()->where('status', 'draft')->count();
            $draftLimit = $user->getDraftLimit();
            
            return redirect()->route('seller.products.index')
                ->with('error', "You've reached your draft limit ({$draftLimit}). Please publish or delete existing drafts, or upgrade your plan for more storage.");
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
            'type' => 'required|in:social_account,game_account,digital_product,service',
            'game_title' => 'required_if:type,game_account|nullable|string|max:255',
            'platform' => 'required_if:type,social_account|nullable|string|max:100',
            'social_username' => 'required_if:type,social_account|nullable|string|max:255|regex:/^[a-zA-Z0-9._-]+$/',
            'price' => 'required|numeric|min:0',
            'delivery_type' => 'required|in:file,code,hybrid',
            'features' => 'nullable|array',
            'tags' => 'nullable|array',
            'thumbnail' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:5120', // 5MB per image
            'files.*' => 'nullable|file|max:102400', // 100MB
            'codes' => 'nullable|string',
            'has_credentials' => 'required|boolean',
            'credential_username' => 'required_if:has_credentials,1|nullable|string|max:255',
            'credential_password' => 'required_if:has_credentials,1|nullable|string|max:255',
            'credential_extras_keys' => 'nullable|array',
            'credential_extras_values' => 'nullable|array',
            'credential_instructions' => 'nullable|string',
            'is_unique_credential' => 'nullable|boolean',
            // Metadata fields
            'metadata' => 'nullable|array',
            // Checklist fields
            'general_checklist' => 'nullable|array',
            'whiteout_survival_checklist' => 'nullable|array',
            'legal_agreement' => 'required_if:type,social_account|accepted',
        ], [
            'legal_agreement.required_if' => 'يجب الموافقة على التعهد قبل عرض الحساب.',
            'legal_agreement.accepted' => 'يجب الموافقة على التعهد قبل عرض الحساب.',
        ]);

        // Check social account verification for social media accounts
        if ($validated['type'] === 'social_account') {
            $verification = \App\Models\SocialAccountVerification::where('user_id', auth()->id())
                ->where('platform', $validated['platform'])
                ->where('username', $validated['social_username'])
                ->where('is_verified', true)
                ->first();

            if (!$verification) {
                return back()->withErrors([
                    'social_username' => 'This social media account must be verified before listing. Please complete the verification process first.'
                ])->withInput();
            }
        }

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

        // Check if user is KYC verified (required for selling)
        $user = auth()->user();
        $kycStatus = $user->latestKycSubmission?->status ?? 'none';
        
        if ($kycStatus !== 'approved') {
            return back()->with('error', 'You must complete KYC verification before creating products.')
                ->withInput();
        }

        // Validate that credentials are provided (mandatory)
        if (!$request->filled('has_credentials') || !$request->has_credentials) {
            return back()->with('error', 'Account credentials are required for automatic delivery.')
                ->withInput();
        }

        // Build metadata based on product type
        $metadata = [
            'automatic_delivery' => true, // Always true
            'kyc_verified' => true, // Always true (verified above)
        ];

        // Add type-specific metadata
        if ($validated['type'] === 'social_account') {
            $metadata['with_primary_email'] = $request->boolean('with_primary_email');
            $metadata['with_current_email'] = $request->boolean('with_current_email');
            $metadata['linked_to_number'] = $request->boolean('linked_to_number');
            $metadata['platform'] = $validated['platform'] ?? null;
        } elseif ($validated['type'] === 'game_account' && $validated['game_title'] === 'Whiteout Survival') {
            // Use different field names for game accounts to avoid conflicts
            $metadata['with_primary_email'] = $request->boolean('with_primary_email_game');
            $metadata['linked_to_facebook'] = $request->boolean('linked_to_facebook');
            $metadata['linked_to_google'] = $request->boolean('linked_to_google');
            $metadata['linked_to_apple'] = $request->boolean('linked_to_apple');
            $metadata['linked_to_game_center'] = $request->boolean('linked_to_game_center');
            $metadata['game_title'] = $validated['game_title'];
        }

        $product = $seller->products()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'type' => $validated['type'],
            'game_title' => $validated['game_title'] ?? null,
            'platform' => $validated['platform'] ?? null,
            'social_username' => $validated['social_username'] ?? null,
            'price' => $validated['price'],
            'delivery_type' => $validated['delivery_type'],
            'features' => $validated['features'] ?? [],
            'tags' => $validated['tags'] ?? [],
            'metadata' => $metadata,
            'general_checklist' => $validated['general_checklist'] ?? [],
            'whiteout_survival_checklist' => $validated['whiteout_survival_checklist'] ?? [],
            'delivery_credentials' => $credentialData,
            'is_unique_credential' => $request->filled('is_unique_credential') ? true : false,
            'verification_status' => 'pending',
            'status' => 'draft',
        ]);

        // Content moderation service
        $moderationService = app(\App\Services\ContentModerationService::class);

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            
            // Check for inappropriate content
            if ($moderationService->isImageInappropriate($thumbnailFile)) {
                return back()->with('error', 'Thumbnail image failed content moderation. Please upload an appropriate image.')
                    ->withInput();
            }
            
            $path = $thumbnailFile->store('products/thumbnails', 'public');
            $product->update(['thumbnail_url' => $path]);
        }

        // Handle gallery images (for game accounts)
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            
            foreach ($request->file('gallery_images') as $image) {
                // Check for inappropriate content
                if ($moderationService->isImageInappropriate($image)) {
                    \Log::warning('Gallery image failed moderation', [
                        'product_id' => $product->id,
                        'filename' => $image->getClientOriginalName(),
                    ]);
                    continue; // Skip this image
                }
                
                $path = $image->store('products/gallery', 'public');
                $galleryPaths[] = $path;
            }
            
            if (!empty($galleryPaths)) {
                $product->update(['gallery_urls' => $galleryPaths]);
            }
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
