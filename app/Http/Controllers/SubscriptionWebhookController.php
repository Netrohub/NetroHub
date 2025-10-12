<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\WebhookLog;
use App\Services\EntitlementsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionWebhookController extends Controller
{
    public function __construct(
        private EntitlementsService $entitlementsService
    ) {}

    /**
     * Handle Paddle subscription webhooks
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $eventId = $request->header('Paddle-Event-Id');
        $eventType = $request->input('event_type');

        try {
            // Check for idempotency
            if ($eventId) {
                $existingWebhook = WebhookLog::where('event_id', $eventId)->first();
                if ($existingWebhook && $existingWebhook->status === 'processed') {
                    return response()->json(['status' => 'already_processed'], 200);
                }
            }

            // Log webhook event
            $webhookLog = WebhookLog::create([
                'event_id' => $eventId,
                'event_type' => $eventType,
                'payload' => $payload,
                'status' => 'received',
            ]);

            // Handle different subscription events
            $event = json_decode($payload, true);

            match ($eventType) {
                'subscription.created' => $this->handleSubscriptionCreated($event['data'], $webhookLog),
                'subscription.updated' => $this->handleSubscriptionUpdated($event['data'], $webhookLog),
                'subscription.activated' => $this->handleSubscriptionActivated($event['data'], $webhookLog),
                'subscription.cancelled' => $this->handleSubscriptionCancelled($event['data'], $webhookLog),
                'subscription.paused' => $this->handleSubscriptionPaused($event['data'], $webhookLog),
                'subscription.resumed' => $this->handleSubscriptionResumed($event['data'], $webhookLog),
                'subscription.past_due' => $this->handleSubscriptionPastDue($event['data'], $webhookLog),
                'subscription.expired' => $this->handleSubscriptionExpired($event['data'], $webhookLog),
                'transaction.completed' => $this->handleTransactionCompleted($event['data'], $webhookLog),
                'transaction.payment_failed' => $this->handlePaymentFailed($event['data'], $webhookLog),
                default => Log::info('Unhandled subscription webhook', ['event_type' => $eventType])
            };

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Subscription webhook processing failed', [
                'error' => $e->getMessage(),
                'event_id' => $eventId,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Handle subscription created
     */
    private function handleSubscriptionCreated($data, $webhookLog)
    {
        $userId = $data['custom_data']['user_id'] ?? null;
        $planId = $data['custom_data']['plan_id'] ?? null;
        $interval = $data['custom_data']['interval'] ?? 'monthly';

        if (! $userId || ! $planId) {
            Log::warning('Missing user_id or plan_id in subscription.created', ['data' => $data]);
            if ($webhookLog) {
                $webhookLog->update(['status' => 'failed']);
            }

            return;
        }

        $user = User::find($userId);
        $plan = Plan::find($planId);

        if (! $user || ! $plan) {
            Log::warning('User or plan not found', ['user_id' => $userId, 'plan_id' => $planId]);
            if ($webhookLog) {
                $webhookLog->update(['status' => 'failed']);
            }

            return;
        }

        DB::transaction(function () use ($user, $plan, $data, $interval, $webhookLog) {
            // Cancel any existing active subscription first
            $existingSubscription = $user->activeSubscription()->first();
            if ($existingSubscription && $existingSubscription->paddle_subscription_id !== $data['id']) {
                $existingSubscription->update(['status' => 'cancelled', 'cancel_at' => now()]);
            }

            // Create or update subscription
            $subscription = UserSubscription::updateOrCreate(
                ['paddle_subscription_id' => $data['id']],
                [
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'status' => 'active',
                    'interval' => $interval,
                    'period_start' => now(),
                    'period_end' => isset($data['next_billed_at']) ? \Carbon\Carbon::parse($data['next_billed_at']) : null,
                    'renews_at' => isset($data['next_billed_at']) ? \Carbon\Carbon::parse($data['next_billed_at']) : null,
                    'metadata' => json_encode($data),
                ]
            );

            // Regenerate entitlements
            $this->entitlementsService->regenerateEntitlements($user);

            // Send notification
            $user->notify(new \App\Notifications\SubscriptionActivatedNotification($subscription));

            if ($webhookLog) {
                $webhookLog->update(['status' => 'processed']);
            }
        });
    }

    /**
     * Handle subscription updated
     */
    private function handleSubscriptionUpdated($data, $webhookLog)
    {
        $subscription = UserSubscription::where('paddle_subscription_id', $data['id'])->first();

        if (! $subscription) {
            Log::warning('Subscription not found for update', ['subscription_id' => $data['id']]);

            return;
        }

        DB::transaction(function () use ($subscription, $data, $webhookLog) {
            $subscription->update([
                'status' => $data['status'] ?? $subscription->status,
                'period_end' => isset($data['next_billed_at']) ? \Carbon\Carbon::parse($data['next_billed_at']) : $subscription->period_end,
                'renews_at' => isset($data['next_billed_at']) ? \Carbon\Carbon::parse($data['next_billed_at']) : $subscription->renews_at,
                'metadata' => json_encode($data),
            ]);

            // If plan changed, regenerate entitlements
            if (isset($data['items']) && count($data['items']) > 0) {
                // Check if price changed (plan upgrade/downgrade)
                $this->entitlementsService->regenerateEntitlements($subscription->user);
            }

            $webhookLog->update(['status' => 'processed']);
        });
    }

    /**
     * Handle subscription activated
     */
    private function handleSubscriptionActivated($data, $webhookLog)
    {
        $this->handleSubscriptionCreated($data, $webhookLog);
    }

    /**
     * Handle subscription cancelled
     */
    private function handleSubscriptionCancelled($data, $webhookLog)
    {
        $subscription = UserSubscription::where('paddle_subscription_id', $data['id'])->first();

        if (! $subscription) {
            Log::warning('Subscription not found for cancellation', ['subscription_id' => $data['id']]);

            return;
        }

        DB::transaction(function () use ($subscription, $data, $webhookLog) {
            $subscription->update([
                'status' => 'cancelled',
                'cancel_at' => isset($data['cancelled_at']) ? \Carbon\Carbon::parse($data['cancelled_at']) : now(),
                'metadata' => json_encode($data),
            ]);

            // Send notification
            $subscription->user->notify(new \App\Notifications\SubscriptionCancelledNotification($subscription));

            $webhookLog->update(['status' => 'processed']);
        });
    }

    /**
     * Handle subscription paused
     */
    private function handleSubscriptionPaused($data, $webhookLog)
    {
        $subscription = UserSubscription::where('paddle_subscription_id', $data['id'])->first();

        if ($subscription) {
            $subscription->update(['status' => 'paused']);
            $webhookLog->update(['status' => 'processed']);
        }
    }

    /**
     * Handle subscription resumed
     */
    private function handleSubscriptionResumed($data, $webhookLog)
    {
        $subscription = UserSubscription::where('paddle_subscription_id', $data['id'])->first();

        if ($subscription) {
            DB::transaction(function () use ($subscription, $webhookLog) {
                $subscription->update([
                    'status' => 'active',
                    'cancel_at' => null,
                ]);

                $this->entitlementsService->regenerateEntitlements($subscription->user);
                $webhookLog->update(['status' => 'processed']);
            });
        }
    }

    /**
     * Handle subscription past due
     */
    private function handleSubscriptionPastDue($data, $webhookLog)
    {
        $subscription = UserSubscription::where('paddle_subscription_id', $data['id'])->first();

        if ($subscription) {
            $subscription->update(['status' => 'past_due']);
            $subscription->user->notify(new \App\Notifications\SubscriptionPastDueNotification($subscription));
            $webhookLog->update(['status' => 'processed']);
        }
    }

    /**
     * Handle subscription expired
     */
    private function handleSubscriptionExpired($data, $webhookLog)
    {
        $subscription = UserSubscription::where('paddle_subscription_id', $data['id'])->first();

        if (! $subscription) {
            return;
        }

        DB::transaction(function () use ($subscription, $webhookLog) {
            $subscription->update([
                'status' => 'expired',
                'period_end' => now(),
            ]);

            // Switch to free plan
            $freePlan = Plan::where('slug', 'free')->first();
            if ($freePlan) {
                UserSubscription::create([
                    'user_id' => $subscription->user_id,
                    'plan_id' => $freePlan->id,
                    'status' => 'active',
                    'interval' => 'monthly',
                    'period_start' => now(),
                ]);

                $this->entitlementsService->regenerateEntitlements($subscription->user);
            }

            $subscription->user->notify(new \App\Notifications\SubscriptionExpiredNotification($subscription));
            $webhookLog->update(['status' => 'processed']);
        });
    }

    /**
     * Handle successful payment (renewal)
     */
    private function handleTransactionCompleted($data, $webhookLog)
    {
        if (! isset($data['subscription_id'])) {
            // Not a subscription payment, ignore
            return;
        }

        $subscription = UserSubscription::where('paddle_subscription_id', $data['subscription_id'])->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'active',
                'renews_at' => isset($data['billing_period']['ends_at'])
                    ? \Carbon\Carbon::parse($data['billing_period']['ends_at'])
                    : $subscription->renews_at,
            ]);

            // Reset monthly entitlements if it's a new billing period
            if ($subscription->interval === 'monthly') {
                foreach ($subscription->user->entitlements()->where('reset_period', 'monthly')->get() as $entitlement) {
                    $this->entitlementsService->resetEntitlement($subscription->user, $entitlement->key);
                }
            }

            $webhookLog->update(['status' => 'processed']);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailed($data, $webhookLog)
    {
        if (! isset($data['subscription_id'])) {
            return;
        }

        $subscription = UserSubscription::where('paddle_subscription_id', $data['subscription_id'])->first();

        if ($subscription) {
            $subscription->update(['status' => 'past_due']);
            $subscription->user->notify(new \App\Notifications\SubscriptionPaymentFailedNotification($subscription));
            $webhookLog->update(['status' => 'processed']);
        }
    }
}
