<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellController extends Controller
{
    /**
     * Show the sell landing page with product type selection
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Auto-create seller profile if doesn't exist
        $seller = $this->ensureSellerProfile($user);

        // Check if seller is blocked
        if (! $seller->is_active) {
            return view('seller.blocked', compact('seller'));
        }

        return view('sell.index', compact('seller'));
    }

    /**
     * Legacy entry point - redirect to new landing
     */
    public function entry(Request $request)
    {
        return redirect()->route('sell.index');
    }

    /**
     * Show the game account selling form
     */
    public function createGame(Request $request)
    {
        $user = $request->user();
        $seller = $this->ensureSellerProfile($user);

        if (! $seller->is_active) {
            return view('seller.blocked', compact('seller'));
        }

        $categories = Category::active()->ordered()->get();

        return view('sell.game', compact('seller', 'categories'));
    }

    /**
     * Show the social account selling form
     */
    public function createSocial(Request $request)
    {
        $user = $request->user();
        $seller = $this->ensureSellerProfile($user);

        if (! $seller->is_active) {
            return view('seller.blocked', compact('seller'));
        }

        return view('sell.social', compact('seller'));
    }

    /**
     * Store a game account listing
     */
    public function storeGame(Request $request)
    {
        $user = $request->user();
        $seller = $this->ensureSellerProfile($user);

        $isDraft = $request->input('action') === 'draft';
        $canPublish = $seller->kyc_status === 'approved';

        $validated = $request->validate([
            'title' => 'required|string|max:190',
            // Limit categories to three options via a key, store in metadata
            'game_category' => 'nullable|in:fortnite,whiteout_survival,others',
            'platform' => 'required|in:Mobile,PC,PlayStation,Xbox,Nintendo,Other',
            'description' => 'required|string|min:50',
            'price' => 'required|numeric|min:0.01',
            'images.*' => 'nullable|image|max:5120', // 5MB
            'agree_no_external_contact' => 'required|accepted',
            'agree_legal_responsibility' => 'required|accepted',
            // Modal flow inputs
            'delivery_email' => $isDraft ? 'nullable|email' : 'required|email',
            'delivery_password' => $isDraft ? 'nullable|string' : 'required|string',
            'delivery_instructions' => 'nullable|string|max:5000',
            'delivery_extras_key.*' => 'nullable|string|max:190',
            'delivery_extras_value.*' => 'nullable|string|max:1000',
            'verification_status' => 'nullable|in:pending,verified,skipped_draft',
            'verification_code' => 'nullable|string|max:20',
            'verification_proof' => 'nullable|image|max:5120',
        ]);

        // Check if publishing requires at least one image
        if (! $isDraft && (! $request->hasFile('images') || count($request->file('images')) === 0)) {
            return back()->withErrors(['images' => 'At least one image is required to publish.'])->withInput();
        }

        $status = ($isDraft || ! $canPublish) ? 'draft' : 'active';

        $product = $seller->products()->create([
            'type' => 'game_account',
            'title' => $validated['title'],
            // Category stored via metadata key restriction
            'category_id' => null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => $status,
            'delivery_type' => 'code', // Game accounts are delivered via credentials
            'metadata' => [
                'platform' => $validated['platform'],
                'game_category' => $validated['game_category'] ?? null,
                // Verification fields default
                'verification_status' => $validated['verification_status'] ?? ($isDraft ? 'skipped_draft' : 'pending'),
                'verification_code' => $validated['verification_code'] ?? null,
            ],
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $galleryUrls = [];
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/game-accounts', 's3');
                $galleryUrls[] = $path;

                // First image becomes thumbnail
                if ($index === 0) {
                    $product->update(['thumbnail_url' => $path]);
                }
            }
            $product->update(['gallery_urls' => $galleryUrls]);
        }

        // Handle verification proof upload
        if ($request->hasFile('verification_proof')) {
            $proofPath = $request->file('verification_proof')->store('products/verification', 's3');
            $meta = $product->metadata ?? [];
            $meta['verification_proof_path'] = $proofPath;
            $product->update(['metadata' => $meta]);
        }

        // Store delivery credentials encrypted-at-rest inside metadata
        $credentials = [
            'email' => $validated['delivery_email'] ?? null,
            'password' => $validated['delivery_password'] ?? null,
            'instructions' => $validated['delivery_instructions'] ?? null,
            'extras' => collect($request->input('delivery_extras_key', []))
                ->zip($request->input('delivery_extras_value', []))
                ->map(function ($pair) {
                    return ['key' => $pair[0], 'value' => $pair[1]];
                })
                ->filter(fn ($row) => filled($row['key']) || filled($row['value']))
                ->values()
                ->all(),
        ];
        $encrypted = encrypt(json_encode($credentials));
        $meta = $product->metadata ?? [];
        $meta['delivery_encrypted'] = $encrypted;
        $meta['delivery_view_limit'] = 3;
        $meta['delivery_view_count'] = 0;
        $product->update(['metadata' => $meta]);

        \App\Models\ActivityLog::log('product_created', $product, "Created game account listing: {$product->title}");

        if (! $canPublish && ! $isDraft) {
            return redirect()->route('seller.products.edit', $product)
                ->with('warning', 'Draft created. Your listing will be visible after KYC verification.');
        }

        return redirect()->route('seller.products.edit', $product)
            ->with('success', $isDraft ? 'Draft saved successfully!' : 'Game account listed successfully!');
    }

    /**
     * Store a social account listing
     */
    public function storeSocial(Request $request)
    {
        $user = $request->user();
        $seller = $this->ensureSellerProfile($user);

        $isDraft = $request->input('action') === 'draft';
        $canPublish = $seller->kyc_status === 'approved';

        $validated = $request->validate([
            'platform' => 'required|in:Instagram,TikTok,X (Twitter),YouTube,Discord,Other',
            'handle' => 'required|string|max:255',
            'niche' => 'nullable|string|max:255',
            'title' => 'required|string|max:190',
            'description' => 'required|string|min:50',
            'monetization_status' => 'nullable|in:Not monetized,Eligible,Monetized',
            'followers' => 'nullable|integer|min:0',
            'engagement_rate' => 'nullable|numeric|min:0|max:100',
            'price' => 'required|numeric|min:0.01',
            'images.*' => 'nullable|image|max:5120',
            'agree_no_external_contact' => 'required|accepted',
            'agree_legal_responsibility' => 'required|accepted',
            // Modal flow inputs
            'delivery_email' => $isDraft ? 'nullable|email' : 'required|email',
            'delivery_password' => $isDraft ? 'nullable|string' : 'required|string',
            'delivery_instructions' => 'nullable|string|max:5000',
            'delivery_extras_key.*' => 'nullable|string|max:190',
            'delivery_extras_value.*' => 'nullable|string|max:1000',
            'verification_status' => 'nullable|in:pending,verified,skipped_draft',
            'verification_code' => 'nullable|string|max:20',
            'verification_proof' => 'nullable|image|max:5120',
        ]);

        // Check if publishing requires at least one image
        if (! $isDraft && (! $request->hasFile('images') || count($request->file('images')) === 0)) {
            return back()->withErrors(['images' => 'At least one image is required to publish.'])->withInput();
        }

        $status = ($isDraft || ! $canPublish) ? 'draft' : 'active';

        $product = $seller->products()->create([
            'type' => 'social_account',
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'status' => $status,
            'delivery_type' => 'code',
            'metadata' => [
                'platform' => $validated['platform'],
                'handle' => $validated['handle'],
                'niche' => $validated['niche'] ?? null,
                'monetization_status' => $validated['monetization_status'] ?? null,
                'followers' => $validated['followers'] ?? null,
                'engagement_rate' => $validated['engagement_rate'] ?? null,
                'verification_status' => $validated['verification_status'] ?? ($isDraft ? 'skipped_draft' : 'pending'),
                'verification_code' => $validated['verification_code'] ?? null,
            ],
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $galleryUrls = [];
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products/social-accounts', 's3');
                $galleryUrls[] = $path;

                if ($index === 0) {
                    $product->update(['thumbnail_url' => $path]);
                }
            }
            $product->update(['gallery_urls' => $galleryUrls]);
        }

        // Handle verification proof upload
        if ($request->hasFile('verification_proof')) {
            $proofPath = $request->file('verification_proof')->store('products/verification', 's3');
            $meta = $product->metadata ?? [];
            $meta['verification_proof_path'] = $proofPath;
            $product->update(['metadata' => $meta]);
        }

        // Store delivery credentials encrypted-at-rest inside metadata
        $credentials = [
            'email' => $validated['delivery_email'] ?? null,
            'password' => $validated['delivery_password'] ?? null,
            'instructions' => $validated['delivery_instructions'] ?? null,
            'extras' => collect($request->input('delivery_extras_key', []))
                ->zip($request->input('delivery_extras_value', []))
                ->map(function ($pair) {
                    return ['key' => $pair[0], 'value' => $pair[1]];
                })
                ->filter(fn ($row) => filled($row['key']) || filled($row['value']))
                ->values()
                ->all(),
        ];
        $encrypted = encrypt(json_encode($credentials));
        $meta = $product->metadata ?? [];
        $meta['delivery_encrypted'] = $encrypted;
        $meta['delivery_view_limit'] = 3;
        $meta['delivery_view_count'] = 0;
        $product->update(['metadata' => $meta]);

        \App\Models\ActivityLog::log('product_created', $product, "Created social account listing: {$product->title}");

        if (! $canPublish && ! $isDraft) {
            return redirect()->route('seller.products.edit', $product)
                ->with('warning', 'Draft created. Your listing will be visible after KYC verification.');
        }

        return redirect()->route('seller.products.edit', $product)
            ->with('success', $isDraft ? 'Draft saved successfully!' : 'Social account listed successfully!');
    }

    /**
     * Ensure user has a seller profile, create if not exists
     */
    private function ensureSellerProfile($user)
    {
        $seller = $user->seller;

        if (! $seller) {
            $seller = Seller::create([
                'user_id' => $user->id,
                'display_name' => $user->name,
                'kyc_status' => 'pending',
                'is_active' => true,
            ]);

            \App\Models\ActivityLog::log(
                'seller_profile_created',
                $seller,
                'User became a seller'
            );
        }

        return $seller;
    }
}
