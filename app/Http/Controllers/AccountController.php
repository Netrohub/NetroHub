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
            'username' => 'required|string|alpha_dash|min:3|max:30|unique:users,username,'.$user->id,
            'tagline' => 'nullable|string|max:500',
            'public_visibility' => 'nullable|boolean',
            'pref' => 'nullable|array',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        // Handle avatar upload
        $updateData = [
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'username' => $validated['username'],
        ];

        if ($request->hasFile('avatar')) {
            try {
                $file = $request->file('avatar');
                
                // Determine disk - check if S3 is properly configured
                $defaultDisk = config('filesystems.default');
                $disk = 'public'; // Default to public
                
                if ($defaultDisk === 's3' && config('filesystems.disks.s3.region') && config('filesystems.disks.s3.key')) {
                    $disk = 's3';
                }
                
                // Delete old avatar if exists
                if ($user->avatar) {
                    try {
                        Storage::disk($disk)->delete($user->avatar);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to delete old avatar', ['error' => $e->getMessage()]);
                    }
                }

                // Delete old avatar_url if it's a stored file
                if ($user->avatar_url && !filter_var($user->avatar_url, FILTER_VALIDATE_URL)) {
                    try {
                        Storage::disk($disk)->delete($user->avatar_url);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to delete old avatar_url', ['error' => $e->getMessage()]);
                    }
                }

                // Store new avatar
                $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('avatars', $filename, $disk);

                // Update both avatar and avatar_url fields
                $updateData['avatar'] = $path;
                // Clear avatar_url so the accessor uses the new avatar
                $updateData['avatar_url'] = null;

                \Log::info('Avatar uploaded successfully', [
                    'user_id' => $user->id,
                    'path' => $path,
                    'disk' => $disk,
                    'filename' => $filename,
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
        
        // Force refresh to bypass any caching
        $user = $user->fresh();
        
        // Clear cached avatar
        if ($user->avatar) {
            cache()->forget('user_avatar_' . $user->id);
        }
        
        // Log the updated user data
        \Log::info('User updated successfully', [
            'user_id' => $user->id,
            'username' => $user->username,
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

        // Log activity
        \App\Models\ActivityLog::log('account_updated', $user, 'User updated account settings');

        return redirect()->route('account.index', ['tab' => 'my-account'])
            ->with('success', 'Account settings updated successfully! Changes may take a moment to appear.');
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
        // Handle payout request submission
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'amount' => 'required|numeric|min:50',
                'payment_method' => 'required|in:paypal,bank_transfer,crypto',
                'payment_details' => 'required|string|max:500',
            ]);

            $seller = $request->user()->seller;
            
            if (!$seller) {
                return back()->with('error', 'You must be a seller to request payouts.');
            }

            if ($validated['amount'] > $seller->getWalletBalance()) {
                return back()->with('error', 'Insufficient balance for this payout amount.');
            }

            // Create payout request
            $seller->payoutRequests()->create([
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_details' => $validated['payment_details'],
                'status' => 'pending',
            ]);

            return back()->with('success', 'Payout request submitted successfully!');
        }

        return view('account.payouts');
    }

    public function promote(Request $request)
    {
        // Handle promotion request submission
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'promotion_type' => 'required|in:featured,sponsored,premium',
                'duration' => 'required|integer|min:1|max:30',
            ]);

            // Create promotion record (placeholder)
            \Log::info('Promotion request', $validated);

            return back()->with('success', 'Promotion activated successfully!');
        }

        return view('account.promote');
    }

    public function notifications(Request $request)
    {
        // Handle notification actions
        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'mark_all_read') {
                $request->user()->unreadNotifications->markAsRead();
                return back()->with('success', 'All notifications marked as read.');
            }

            if ($action === 'mark_read' && $request->has('notification_id')) {
                $notification = $request->user()->notifications()->find($request->input('notification_id'));
                if ($notification) {
                    $notification->markAsRead();
                }
                return back();
            }
        }

        return view('account.notifications');
    }

    public function blocked(Request $request)
    {
        return view('account.stubs', ['title' => 'Blocked List']);
    }

    public function fees(Request $request)
    {
        return view('account.fees-calculator');
    }

    public function challenges(Request $request)
    {
        return view('account.challenges');
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
