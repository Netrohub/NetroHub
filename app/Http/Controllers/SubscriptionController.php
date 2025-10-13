<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\TapPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected TapPaymentService $tapService
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
            $this->tapService->cancelSubscription($subscription);

            return back()->with('success', 'Subscription will be cancelled at the end of the billing period');
        } catch (\Exception $e) {
            \Log::error('Subscription cancellation failed', [
                'error' => $e->getMessage(),
                'subscription_id' => $subscription->id,
            ]);
            
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
            $this->tapService->resumeSubscription($subscription);

            return back()->with('success', 'Subscription resumed successfully');
        } catch (\Exception $e) {
            \Log::error('Subscription resume failed', [
                'error' => $e->getMessage(),
                'subscription_id' => $subscription->id,
            ]);
            
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
            // Normalize prices for comparison (convert to monthly equivalent)
            $currentMonthlyPrice = $subscription->billing_interval === 'monthly' 
                ? (float) ($subscription->plan->price_month ?? 0)
                : (float) ($subscription->plan->price_year ?? 0) / 12;
                
            $newMonthlyPrice = $interval === 'monthly'
                ? (float) ($newPlan->price_month ?? 0)
                : (float) ($newPlan->price_year ?? 0) / 12;
            
            // Handle edge case where both are 0 (free plans) - compare sort_order instead
            if ($currentMonthlyPrice === 0.0 && $newMonthlyPrice === 0.0) {
                $currentSortOrder = $subscription->plan->sort_order ?? 0;
                $newSortOrder = $newPlan->sort_order ?? 0;
                $isUpgrade = $newSortOrder > $currentSortOrder;
            } else {
                $isUpgrade = $newMonthlyPrice > $currentMonthlyPrice;
            }
            
            // Calculate proration if upgrading mid-cycle
            $proratedAmount = 0;
            if ($isUpgrade && $subscription->current_period_end) {
                $now = now();
                $periodEnd = \Carbon\Carbon::parse($subscription->current_period_end);
                $periodStart = \Carbon\Carbon::parse($subscription->current_period_start ?? $subscription->created_at);
                
                // Days remaining in current billing period
                $totalDays = $periodStart->diffInDays($periodEnd);
                $remainingDays = $now->diffInDays($periodEnd);
                
                if ($totalDays > 0 && $remainingDays > 0) {
                    // Unused portion of current plan
                    $currentDailyRate = $currentMonthlyPrice / 30;
                    $unusedCredit = $currentDailyRate * $remainingDays;
                    
                    // Cost for new plan for remaining period
                    $newDailyRate = $newMonthlyPrice / 30;
                    $newCost = $newDailyRate * $remainingDays;
                    
                    // Prorated amount = new cost - unused credit
                    $proratedAmount = max(0, $newCost - $unusedCredit);
                }
            }

            // Log for debugging
            \Log::info('Plan change initiated', [
                'user_id' => $user->id,
                'current_plan' => $subscription->plan->name,
                'current_monthly_price' => $currentMonthlyPrice,
                'new_plan' => $newPlan->name,
                'new_monthly_price' => $newMonthlyPrice,
                'is_upgrade' => $isUpgrade,
                'prorated_amount' => $proratedAmount,
            ]);

            // Execute the plan change with proration
            $success = $this->tapService->changePlan($subscription, $newPlan, $interval, $isUpgrade);
            
            if (!$success) {
                throw new \Exception('Plan change failed');
            }

            // Regenerate entitlements immediately
            $entitlementsService = app(\App\Services\EntitlementsService::class);
            $entitlementsService->regenerateEntitlements($user);
            
            if ($isUpgrade) {
                $message = 'Plan upgraded successfully! You now have access to all premium features.';
                if ($proratedAmount > 0) {
                    $message .= ' Prorated charge of $' . number_format($proratedAmount, 2) . ' for the remaining billing period.';
                }
            } else {
                $message = 'Plan will be downgraded at the end of the billing period.';
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Plan change failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->with('error', 'Failed to change plan: ' . $e->getMessage());
        }
    }
}
