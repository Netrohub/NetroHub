<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\PaddleSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected PaddleSubscriptionService $paddleService
    ) {}

    /**
     * Create a checkout session for subscribing to a plan
     */
    public function subscribe(Request $request, Plan $plan, string $interval = 'monthly'): JsonResponse|RedirectResponse
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to subscribe');
        }

        $user = auth()->user();

        // Validate interval
        if (! in_array($interval, ['monthly', 'yearly'])) {
            return back()->with('error', 'Invalid billing interval');
        }

        // If subscribing to free plan, handle directly
        if ($plan->isFree()) {
            return $this->handleFreeSubscription($plan);
        }

        try {
            $checkoutSession = $this->paddleService->createCheckoutSession($user, $plan, $interval);

            return redirect($checkoutSession['checkout_url'] ?? $checkoutSession['url']);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create checkout session: ' . $e->getMessage());
        }
    }

    /**
     * Handle subscription to free plan
     */
    protected function handleFreeSubscription(Plan $plan): RedirectResponse
    {
        $user = auth()->user();

        // Cancel any existing subscriptions
        $user->subscriptions()->where('status', 'active')->each(fn($sub) => $sub->cancel());

        // Create free subscription
        \App\Models\UserSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'active',
            'interval' => 'monthly',
            'period_start' => now(),
        ]);

        // Regenerate entitlements
        $entitlementsService = app(\App\Services\EntitlementsService::class);
        $entitlementsService->regenerateEntitlements($user);

        return redirect()->route('billing.index')->with('success', 'Subscribed to Free plan successfully');
    }

    /**
     * Cancel current subscription
     */
    public function cancel(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        if (! $subscription) {
            return back()->with('error', 'No active subscription found');
        }

        if ($subscription->plan->isFree()) {
            return back()->with('error', 'Cannot cancel free plan');
        }

        try {
            $this->paddleService->cancel($subscription);

            return back()->with('success', 'Subscription will be cancelled at the end of the billing period');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel subscription: ' . $e->getMessage());
        }
    }

    /**
     * Resume cancelled subscription
     */
    public function resume(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        if (! $subscription || ! $subscription->isCancelled()) {
            return back()->with('error', 'No cancelled subscription found');
        }

        try {
            $this->paddleService->resume($subscription);

            return back()->with('success', 'Subscription resumed successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resume subscription: ' . $e->getMessage());
        }
    }

    /**
     * Change plan (upgrade/downgrade)
     */
    public function changePlan(Request $request, Plan $newPlan, string $interval = 'monthly'): RedirectResponse
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        if (! $subscription) {
            return redirect()->route('pricing.index')->with('error', 'No active subscription found');
        }

        if ($subscription->plan_id === $newPlan->id) {
            return back()->with('info', 'You are already subscribed to this plan');
        }

        // If changing to free plan
        if ($newPlan->isFree()) {
            return $this->handleFreeSubscription($newPlan);
        }

        try {
            $this->paddleService->changePlan($subscription, $newPlan, $interval);

            // Debug: Log the plan comparison
            \Log::info('Plan change debug', [
                'current_plan' => $subscription->plan->name . ' ($' . $subscription->plan->price_month . ')',
                'new_plan' => $newPlan->name . ' ($' . $newPlan->price_month . ')',
                'is_upgrade' => $subscription->canUpgrade($newPlan),
                'is_downgrade' => $subscription->canDowngrade($newPlan),
                'user_id' => $user->id,
            ]);

            // Determine if this is an upgrade or downgrade
            $isUpgrade = $newPlan->price_month > $subscription->plan->price_month;
            
            $message = $isUpgrade
                ? 'Plan upgraded successfully! You now have access to all premium features.'
                : 'Plan will be downgraded at the end of the billing period.';

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to change plan: ' . $e->getMessage());
        }
    }
}
