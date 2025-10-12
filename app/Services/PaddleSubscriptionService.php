<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaddleSubscriptionService
{
    protected string $apiUrl;
    protected ?string $vendorId;
    protected ?string $apiKey;
    protected bool $sandbox;

    public function __construct()
    {
        $this->sandbox = config('services.paddle.environment', 'sandbox') === 'sandbox';
        $this->apiUrl = $this->sandbox 
            ? 'https://sandbox-api.paddle.com'
            : 'https://api.paddle.com';
        $this->vendorId = config('services.paddle.vendor_id');
        $this->apiKey = config('services.paddle.api_key');
    }

    /**
     * Create a checkout session for a plan
     */
    public function createCheckoutSession(User $user, Plan $plan, string $interval = 'monthly'): array
    {
        $priceId = $plan->getPaddlePriceId($interval);

        if (! $priceId) {
            throw new \Exception("No Paddle price ID configured for {$plan->name} - {$interval}");
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->apiUrl}/subscriptions", [
            'items' => [
                [
                    'price_id' => $priceId,
                    'quantity' => 1,
                ]
            ],
            'customer_id' => $user->paddle_customer_id,
            'customer_email' => $user->email,
            'return_url' => route('billing.success'),
            'custom_data' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'interval' => $interval,
            ],
        ]);

        if ($response->failed()) {
            Log::error('Paddle checkout creation failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'response' => $response->body(),
            ]);

            throw new \Exception('Failed to create checkout session');
        }

        return $response->json();
    }

    /**
     * Handle subscription created webhook
     */
    public function handleSubscriptionCreated(array $data): void
    {
        $customData = $data['custom_data'] ?? [];
        $userId = $customData['user_id'] ?? null;
        $planId = $customData['plan_id'] ?? null;
        $interval = $customData['interval'] ?? 'monthly';

        if (! $userId || ! $planId) {
            Log::warning('Missing user_id or plan_id in subscription created webhook', $data);
            return;
        }

        $user = User::find($userId);
        $plan = Plan::find($planId);

        if (! $user || ! $plan) {
            Log::warning('User or plan not found for subscription', compact('userId', 'planId'));
            return;
        }

        // Cancel any existing active subscriptions
        UserSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->each(fn($sub) => $sub->cancel());

        // Create new subscription
        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'paddle_subscription_id' => $data['id'] ?? null,
            'status' => 'active',
            'interval' => $interval,
            'period_start' => $data['current_billing_period']['starts_at'] ?? now(),
            'period_end' => $data['current_billing_period']['ends_at'] ?? now()->addMonth(),
            'renews_at' => $data['next_billed_at'] ?? null,
        ]);

        // Regenerate entitlements
        $entitlementsService = app(EntitlementsService::class);
        $entitlementsService->regenerateEntitlements($user);

        Log::info('Subscription created', [
            'user_id' => $user->id,
            'plan' => $plan->name,
            'subscription_id' => $subscription->id,
        ]);
    }

    /**
     * Handle subscription updated webhook
     */
    public function handleSubscriptionUpdated(array $data): void
    {
        $paddleSubId = $data['id'] ?? null;

        if (! $paddleSubId) {
            return;
        }

        $subscription = UserSubscription::where('paddle_subscription_id', $paddleSubId)->first();

        if (! $subscription) {
            Log::warning('Subscription not found for update', ['paddle_subscription_id' => $paddleSubId]);
            return;
        }

        $subscription->update([
            'status' => $data['status'] ?? $subscription->status,
            'period_start' => $data['current_billing_period']['starts_at'] ?? $subscription->period_start,
            'period_end' => $data['current_billing_period']['ends_at'] ?? $subscription->period_end,
            'renews_at' => $data['next_billed_at'] ?? $subscription->renews_at,
        ]);

        Log::info('Subscription updated', [
            'subscription_id' => $subscription->id,
            'status' => $subscription->status,
        ]);
    }

    /**
     * Handle subscription cancelled webhook
     */
    public function handleSubscriptionCancelled(array $data): void
    {
        $paddleSubId = $data['id'] ?? null;

        if (! $paddleSubId) {
            return;
        }

        $subscription = UserSubscription::where('paddle_subscription_id', $paddleSubId)->first();

        if (! $subscription) {
            Log::warning('Subscription not found for cancellation', ['paddle_subscription_id' => $paddleSubId]);
            return;
        }

        $subscription->update([
            'status' => 'cancelled',
            'cancel_at' => $data['canceled_at'] ?? now(),
        ]);

        // If cancelled immediately (not at period end), revert to free plan
        if ($subscription->cancel_at <= now()) {
            $freePlan = Plan::where('slug', 'free')->first();

            if ($freePlan) {
                UserSubscription::create([
                    'user_id' => $subscription->user_id,
                    'plan_id' => $freePlan->id,
                    'status' => 'active',
                    'interval' => 'monthly',
                    'period_start' => now(),
                ]);

                $entitlementsService = app(EntitlementsService::class);
                $entitlementsService->regenerateEntitlements($subscription->user);
            }
        }

        Log::info('Subscription cancelled', [
            'subscription_id' => $subscription->id,
            'cancel_at' => $subscription->cancel_at,
        ]);
    }

    /**
     * Handle payment succeeded webhook
     */
    public function handlePaymentSucceeded(array $data): void
    {
        $paddleSubId = $data['subscription_id'] ?? null;

        if (! $paddleSubId) {
            return;
        }

        $subscription = UserSubscription::where('paddle_subscription_id', $paddleSubId)->first();

        if (! $subscription) {
            return;
        }

        // Ensure subscription is active
        if ($subscription->status !== 'active') {
            $subscription->update(['status' => 'active']);

            // Regenerate entitlements if was not active
            $entitlementsService = app(EntitlementsService::class);
            $entitlementsService->regenerateEntitlements($subscription->user);
        }

        Log::info('Payment succeeded for subscription', [
            'subscription_id' => $subscription->id,
            'amount' => $data['amount'] ?? null,
        ]);
    }

    /**
     * Handle payment failed webhook
     */
    public function handlePaymentFailed(array $data): void
    {
        $paddleSubId = $data['subscription_id'] ?? null;

        if (! $paddleSubId) {
            return;
        }

        $subscription = UserSubscription::where('paddle_subscription_id', $paddleSubId)->first();

        if (! $subscription) {
            return;
        }

        $subscription->update(['status' => 'past_due']);

        Log::warning('Payment failed for subscription', [
            'subscription_id' => $subscription->id,
            'user_id' => $subscription->user_id,
        ]);
    }

    /**
     * Cancel a subscription (at period end)
     */
    public function cancel(UserSubscription $subscription): bool
    {
        if (! $subscription->paddle_subscription_id) {
            $subscription->cancel();
            return true;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post("{$this->apiUrl}/subscriptions/{$subscription->paddle_subscription_id}/cancel", [
            'effective_from' => 'next_billing_period',
        ]);

        if ($response->successful()) {
            $subscription->update([
                'status' => 'cancelled',
                'cancel_at' => $subscription->period_end,
            ]);

            return true;
        }

        Log::error('Failed to cancel Paddle subscription', [
            'subscription_id' => $subscription->id,
            'paddle_subscription_id' => $subscription->paddle_subscription_id,
            'response' => $response->body(),
        ]);

        return false;
    }

    /**
     * Resume a cancelled subscription
     */
    public function resume(UserSubscription $subscription): bool
    {
        if (! $subscription->paddle_subscription_id) {
            $subscription->resume();
            return true;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post("{$this->apiUrl}/subscriptions/{$subscription->paddle_subscription_id}/resume");

        if ($response->successful()) {
            $subscription->update([
                'status' => 'active',
                'cancel_at' => null,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Change subscription plan (upgrade/downgrade)
     */
    public function changePlan(UserSubscription $subscription, Plan $newPlan, string $interval = 'monthly'): bool
    {
        $priceId = $newPlan->getPaddlePriceId($interval);

        if (! $priceId) {
            return false;
        }

        if (! $subscription->paddle_subscription_id) {
            // If no Paddle subscription, just create a new local subscription
            $subscription->cancel();

            UserSubscription::create([
                'user_id' => $subscription->user_id,
                'plan_id' => $newPlan->id,
                'status' => 'active',
                'interval' => $interval,
                'period_start' => now(),
                'period_end' => now()->addMonth(),
            ]);

            $entitlementsService = app(EntitlementsService::class);
            $entitlementsService->regenerateEntitlements($subscription->user);

            return true;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->patch("{$this->apiUrl}/subscriptions/{$subscription->paddle_subscription_id}", [
            'items' => [
                [
                    'price_id' => $priceId,
                    'quantity' => 1,
                ]
            ],
            'proration_billing_mode' => ($newPlan->price_month > $subscription->plan->price_month) ? 'prorated_immediately' : 'do_not_bill',
        ]);

        if ($response->successful()) {
            $subscription->update([
                'plan_id' => $newPlan->id,
                'interval' => $interval,
            ]);

            $entitlementsService = app(EntitlementsService::class);
            $entitlementsService->regenerateEntitlements($subscription->user);

            return true;
        }

        Log::error('Failed to change Paddle subscription plan', [
            'subscription_id' => $subscription->id,
            'new_plan_id' => $newPlan->id,
            'response' => $response->body(),
        ]);

        return false;
    }
}

