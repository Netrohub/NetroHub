<?php

use App\Services\EntitlementsService;

if (! function_exists('entitlement')) {
    /**
     * Get an entitlement value for the current user
     */
    function entitlement(string $key, mixed $default = null): mixed
    {
        $user = auth()->user();
        if (! $user) {
            return $default;
        }
        
        return app(EntitlementsService::class)->get($user, $key, $default);
    }
}

if (! function_exists('hasEntitlement')) {
    /**
     * Check if user has an entitlement (boolean check)
     */
    function hasEntitlement(string $key): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }
        
        return app(EntitlementsService::class)->has($user, $key);
    }
}

if (! function_exists('canUseFeature')) {
    /**
     * Check if user can use a feature (has remaining slots)
     */
    function canUseFeature(string $key, int $amount = 1): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }
        
        return app(EntitlementsService::class)->canUse($user, $key, $amount);
    }
}

if (! function_exists('useFeature')) {
    /**
     * Use/consume a feature slot
     */
    function useFeature(string $key, int $amount = 1): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }
        
        return app(EntitlementsService::class)->use($user, $key, $amount);
    }
}

if (! function_exists('userBadge')) {
    /**
     * Get user's plan badge type (plus, pro, or null)
     */
    function userBadge($user = null): ?string
    {
        $user = $user ?? auth()->user();
        if (! $user) {
            return null;
        }
        
        return app(EntitlementsService::class)->getBadgeType($user);
    }
}

if (! function_exists('currentPlan')) {
    /**
     * Get user's current plan
     */
    function currentPlan()
    {
        $user = auth()->user();
        if (! $user) {
            return null;
        }
        
        $subscription = $user->activeSubscription;
        return $subscription?->plan;
    }
}

if (! function_exists('platformFee')) {
    /**
     * Get platform fee percentage for current user
     */
    function platformFee(): float
    {
        $user = auth()->user();
        if (! $user) {
            return 10.0; // Default fee
        }
        
        return app(EntitlementsService::class)->getPlatformFee($user);
    }
}

if (! function_exists('payoutDiscount')) {
    /**
     * Get payout fee discount for current user
     */
    function payoutDiscount(): float
    {
        $user = auth()->user();
        if (! $user) {
            return 0.0;
        }
        
        return app(EntitlementsService::class)->getPayoutFeeDiscount($user);
    }
}

if (! function_exists('csp_nonce')) {
    /**
     * Get the CSP nonce for the current request
     */
    function csp_nonce(): string {
        return \App\Http\Middleware\CspHeaders::nonce();
    }
}

