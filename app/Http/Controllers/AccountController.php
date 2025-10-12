<?php

namespace App\Http\Controllers;

use App\Services\EntitlementsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $seller = $user->seller;
        $tab = $request->query('tab', 'my-account');

        // Load data per tab
        $products = $seller ? $seller->products()->latest()->paginate(12) : collect();
        $socialProducts = $seller ? $seller->products()->where('type', 'social_account')->latest()->paginate(12) : collect();
        $reviews = $seller ? $seller->products()->with(['reviews' => function ($q) {
            $q->latest();
        }])->get()->pluck('reviews')->flatten() : collect();

        return view('account.index', compact(
            'user', 'seller', 'tab', 'products', 'socialProducts', 'reviews'
        ));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $seller = $user->seller;

        // Debug: Log the request
        \Log::info('Account update request', [
            'user_id' => $user->id,
            'has_file' => $request->hasFile('avatar'),
            'files' => $request->allFiles(),
        ]);

        $validated = $request->validate([
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'username' => 'nullable|string|max:255|unique:users,username,'.$user->id,
            'tagline' => 'nullable|string|max:500',
            'public_visibility' => 'nullable|boolean',
            'pref' => 'nullable|array',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle avatar upload
        $updateData = [
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'username' => $validated['username'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            try {
                $file = $request->file('avatar');
                
                // Try S3 first if configured, fallback to public
                $disk = config('filesystems.default') === 's3' ? 's3' : 'public';
                
                // Delete old avatar if exists
                if ($user->avatar) {
                    try {
                        Storage::disk($disk)->delete($user->avatar);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to delete old avatar', ['error' => $e->getMessage()]);
                    }
                }

                // Store new avatar
                $filename = Str::random(40).'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('avatars', $filename, $disk);

                $updateData['avatar'] = $path;

                \Log::info('Avatar uploaded successfully', [
                    'user_id' => $user->id,
                    'path' => $path,
                    'disk' => $disk,
                    'full_url' => Storage::disk($disk)->url($path),
                ]);
            } catch (\Exception $e) {
                \Log::error('Avatar upload failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return back()->with('error', 'Failed to upload avatar: '.$e->getMessage());
            }
        }

        // Update user
        $user->update($updateData);
        
        // Refresh user to get updated avatar path
        $user->refresh();
        
        // Log the updated user data
        \Log::info('User updated', [
            'user_id' => $user->id,
            'avatar' => $user->avatar,
            'avatar_url' => $user->avatar_url,
        ]);

        // Update seller if exists
        if ($seller) {
            $seller->update([
                'display_name' => $validated['display_name'] ?? $user->name,
                'bio' => $validated['tagline'] ?? null,
            ]);
        } elseif (! empty($validated['display_name']) || ! empty($validated['tagline'])) {
            // Create seller profile if it doesn't exist and user provided seller data
            $user->seller()->create([
                'display_name' => $validated['display_name'] ?? $user->name,
                'bio' => $validated['tagline'] ?? null,
                'kyc_status' => 'pending',
                'is_active' => true,
            ]);
        }

        return redirect()->route('account.index', ['tab' => 'my-account'])
            ->with('success', 'Account settings updated successfully!');
    }

    public function sales(Request $request)
    {
        $user = $request->user();
        $seller = $user->seller;
        $tab = $request->query('tab', 'social'); // social|games|services
        $query = $seller ? $seller->orderItems()->with(['order', 'product']) : collect();
        if ($seller) {
            if ($tab === 'social') {
                $query->whereHas('product', fn ($q) => $q->where('type', 'social_account'));
            }
            if ($tab === 'games') {
                $query->whereHas('product', fn ($q) => $q->where('type', 'game_account'));
            }
        }
        $sales = $seller ? $query->latest()->paginate(15) : collect();

        return view('account.sales', compact('sales', 'tab'));
    }

    public function wallet(Request $request)
    {
        $user = $request->user();
        $seller = $user->seller;
        $tab = $request->query('tab', 'all');
        $transactions = $seller ? $seller->walletTransactions()->latest() : collect();
        if ($seller) {
            if ($tab === 'sales') {
                $transactions->whereIn('type', ['sale', 'adjustment']);
            } elseif ($tab === 'payouts') {
                $transactions->where('type', 'payout');
            } elseif ($tab === 'refunds') {
                $transactions->whereIn('type', ['refund']);
            }
            $transactions = $transactions->paginate(15);
        }
        $stats = [
            'available' => $seller?->getWalletBalance() ?? 0,
            'pending' => 0,
            'earned' => ($seller?->walletTransactions()->whereIn('type', ['sale', 'adjustment'])->sum('amount')) ?? 0,
            'fees' => abs(($seller?->walletTransactions()->whereIn('type', ['refund'])->sum('amount')) ?? 0),
        ];

        return view('account.wallet', compact('seller', 'stats', 'transactions', 'tab'));
    }

    public function orders(Request $request)
    {
        $user = $request->user();
        $tab = $request->query('tab', 'social'); // social|games|services|disputes
        $query = $user->orders()->with(['items.product']);
        if ($tab === 'social') {
            $query->whereHas('items.product', fn ($q) => $q->where('type', 'social_account'));
        }
        if ($tab === 'games') {
            $query->whereHas('items.product', fn ($q) => $q->where('type', 'game_account'));
        }
        if ($tab === 'services') {
            $query->whereHas('items.product', fn ($q) => $q->where('type', 'service'));
        }
        $orders = $query->latest()->paginate(15);

        return view('account.orders', compact('orders', 'tab'));
    }

    public function payouts(Request $request)
    {
        return view('account.stubs', ['title' => 'Payouts / Cashbox']);
    }

    public function promote(Request $request)
    {
        return view('account.stubs', ['title' => 'Promote Product']);
    }

    public function notifications(Request $request)
    {
        $unread = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('notifications') && method_exists($request->user(), 'unreadNotifications')) {
            $unread = $request->user()->unreadNotifications()->count();
        }

        return view('account.stubs', ['title' => 'Notifications ('.$unread.')']);
    }

    public function blocked(Request $request)
    {
        return view('account.stubs', ['title' => 'Blocked List']);
    }

    public function fees(Request $request)
    {
        return view('account.stubs', ['title' => 'Fees Calculator']);
    }

    public function challenges(Request $request)
    {
        return view('account.stubs', ['title' => 'Challenges']);
    }

    public function togglePrivacy(Request $request)
    {
        $user = $request->user();
        $user->privacy_mode = ! (bool) ($user->privacy_mode ?? false);
        $user->save();

        return redirect()->back()->with('success', $user->privacy_mode ? 'Privacy Mode enabled.' : 'Privacy Mode disabled.');
    }

    public function billing(EntitlementsService $entitlementsService)
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        // Get entitlements
        $entitlements = $entitlementsService->getUserEntitlements($user);
        $entitlements['boost_slots_remaining'] = $entitlementsService->getRemainingBoosts($user);
        $entitlements['platform_fee_pct'] = $entitlementsService->getPlatformFee($user);
        $entitlements['payout_fee_discount_pct'] = $entitlementsService->getPayoutFeeDiscount($user);
        $entitlements['draft_limit'] = $entitlementsService->getDraftLimit($user);
        $entitlements['priority_support'] = $entitlementsService->hasPrioritySupport($user);
        $entitlements['featured_placement'] = $entitlementsService->hasFeaturedPlacement($user);

        return view('account.billing', compact('subscription', 'entitlements'));
    }
}
