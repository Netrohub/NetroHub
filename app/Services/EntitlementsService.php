<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserEntitlement;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EntitlementsService
{
    /**
     * Get entitlement value for user with caching
     */
    public function get(User $user, string $key, mixed $default = null): mixed
    {
        $cacheKey = "entitlements.{$user->id}.{$key}";

        return Cache::remember($cacheKey, now()->addHour(), function () use ($user, $key, $default) {
            $entitlement = UserEntitlement::where('user_id', $user->id)
                ->where('key', $key)
                ->first();

            if (! $entitlement) {
                return $default;
            }

            // Check if needs reset
            if ($entitlement->needsReset()) {
                $this->resetEntitlement($entitlement);
            }

            return $entitlement->getValue();
        });
    }

    /**
     * Check if user has entitlement
     */
    public function has(User $user, string $key): bool
    {
        $value = $this->get($user, $key, false);

        if (is_bool($value)) {
            return $value;
        }

        return !empty($value);
    }

    /**
     * Check if user can perform action (has remaining slots)
     */
    public function canUse(User $user, string $key, int $amount = 1): bool
    {
        $remaining = $this->get($user, $key, 0);

        return is_numeric($remaining) && $remaining >= $amount;
    }

    /**
     * Use/decrement an entitlement (for limited resources like boosts)
     */
    public function use(User $user, string $key, int $amount = 1): bool
    {
        $entitlement = UserEntitlement::where('user_id', $user->id)
            ->where('key', $key)
            ->first();

        if (! $entitlement) {
            return false;
        }

        $success = $entitlement->decrementValue($amount);

        if ($success) {
            $this->clearCache($user, $key);
        }

        return $success;
    }

    /**
     * Grant/add to an entitlement
     */
    public function grant(User $user, string $key, int $amount = 1): void
    {
        $entitlement = UserEntitlement::where('user_id', $user->id)
            ->where('key', $key)
            ->first();

        if ($entitlement) {
            $entitlement->incrementValue($amount);
            $this->clearCache($user, $key);
        }
    }

    /**
     * Get platform fee percentage for user
     */
    public function getPlatformFee(User $user): float
    {
        return (float) $this->get($user, 'platform_fee_pct', 10.0);
    }

    /**
     * Get payout fee discount for user
     */
    public function getPayoutFeeDiscount(User $user): float
    {
        return (float) $this->get($user, 'payout_fee_discount_pct', 0.0);
    }

    /**
     * Regenerate all entitlements for a user based on their plan
     */
    public function regenerateEntitlements(User $user): void
    {
        DB::transaction(function () use ($user) {
            // Get active subscription
            $subscription = $user->activeSubscription;

            if (! $subscription || ! $subscription->plan) {
                // If no subscription, use free plan
                $plan = Plan::where('slug', 'free')->first();
            } else {
                $plan = $subscription->plan;
            }

            if (! $plan) {
                return;
            }

            // Clear existing entitlements
            UserEntitlement::where('user_id', $user->id)->delete();

            // Create entitlements from plan features
            foreach ($plan->features as $feature) {
                $value = $feature->getValue();
                $resetPeriod = $this->getResetPeriod($feature->key);

                $entitlement = UserEntitlement::create([
                    'user_id' => $user->id,
                    'key' => $feature->key,
                    'reset_period' => $resetPeriod,
                ]);

                $entitlement->setValue($value);

                if ($resetPeriod === 'monthly') {
                    $entitlement->period_start = now();
                    $entitlement->period_end = now()->addMonth();
                }

                $entitlement->save();
            }

            // Clear all entitlement caches for this user
            $this->clearAllCache($user);
        });
    }

    /**
     * Reset monthly entitlements for a user
     */
    public function resetMonthlyEntitlements(User $user): void
    {
        $entitlements = UserEntitlement::where('user_id', $user->id)
            ->where('reset_period', 'monthly')
            ->get();

        foreach ($entitlements as $entitlement) {
            if ($entitlement->needsReset()) {
                $this->resetEntitlement($entitlement);
            }
        }

        $this->clearAllCache($user);
    }

    /**
     * Reset a single entitlement to its plan default
     */
    protected function resetEntitlement(UserEntitlement $entitlement): void
    {
        $user = $entitlement->user;
        $subscription = $user->activeSubscription;

        if (! $subscription || ! $subscription->plan) {
            return;
        }

        $feature = $subscription->plan->features()
            ->where('key', $entitlement->key)
            ->first();

        if ($feature) {
            $entitlement->setValue($feature->getValue());
            $entitlement->resetPeriod();
        }
    }

    /**
     * Determine if a key should reset monthly
     */
    protected function getResetPeriod(string $key): string
    {
        $monthlyKeys = [
            'boost_slots',
            'username_changes',
        ];

        return in_array($key, $monthlyKeys) ? 'monthly' : 'never';
    }

    /**
     * Clear cache for specific entitlement
     */
    protected function clearCache(User $user, string $key): void
    {
        Cache::forget("entitlements.{$user->id}.{$key}");
    }

    /**
     * Clear all entitlement caches for user
     */
    protected function clearAllCache(User $user): void
    {
        // Clear user-specific cache pattern
        Cache::forget("entitlements.{$user->id}.*");
    }

    /**
     * Check if user has a specific badge
     */
    public function hasBadge(User $user, string $badge): bool
    {
        $key = match($badge) {
            'plus' => 'has_name_badge',
            'pro' => 'has_pro_badge',
            default => null,
        };

        return $key ? $this->has($user, $key) : false;
    }

    /**
     * Get badge type for user
     */
    public function getBadgeType(User $user): ?string
    {
        if ($this->has($user, 'has_pro_badge')) {
            return 'pro';
        }

        if ($this->has($user, 'has_name_badge')) {
            return 'plus';
        }

        return null;
    }
}
