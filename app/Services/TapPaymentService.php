<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TapPaymentService
{
    protected Client $client;
    protected string $apiUrl;
    protected string $secretKey;
    protected string $publicKey;
    protected bool $sandbox;

    public function __construct()
    {
        $this->secretKey = config('services.tap.secret_key');
        $this->publicKey = config('services.tap.public_key');
        $this->sandbox = config('services.tap.sandbox', true);
        $this->apiUrl = config('services.tap.api_url');

        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    /**
     * Create a new subscription
     */
    public function createSubscription(User $user, Plan $plan, string $interval = 'monthly'): array
    {
        try {
            $amount = $interval === 'monthly' ? $plan->price_month : $plan->price_year;
            
            // Create a charge (one-time payment that will be recurring)
            $response = $this->client->post('/charges', [
                'json' => [
                    'amount' => (float) $amount,
                    'currency' => 'USD',
                    'customer' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'phone' => [
                            'country_code' => '965',
                            'number' => $user->phone ?? '12345678'
                        ]
                    ],
                    'source' => [
                        'id' => 'src_all', // This will show all payment methods
                    ],
                    'redirect' => [
                        'url' => route('subscription.callback'),
                    ],
                    'post' => [
                        'url' => route('webhook.tap'),
                    ],
                    'description' => "Subscription to {$plan->name} ({$interval})",
                    'metadata' => [
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'interval' => $interval,
                        'type' => 'subscription',
                    ],
                    'receipt' => [
                        'email' => true,
                        'sms' => false,
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            Log::info('Tap subscription created', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'charge_id' => $data['id'] ?? null,
            ]);

            return $data;
        } catch (GuzzleException $e) {
            Log::error('Tap create subscription failed', [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to create subscription: ' . $e->getMessage());
        }
    }

    /**
     * Create a one-time payment (for upgrades with proration)
     */
    public function createCharge(User $user, float $amount, string $description, array $metadata = []): array
    {
        try {
            $response = $this->client->post('/charges', [
                'json' => [
                    'amount' => $amount,
                    'currency' => 'USD',
                    'customer' => [
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'phone' => [
                            'country_code' => '965',
                            'number' => $user->phone ?? '12345678'
                        ]
                    ],
                    'source' => [
                        'id' => 'src_all',
                    ],
                    'redirect' => [
                        'url' => route('subscription.callback'),
                    ],
                    'post' => [
                        'url' => route('webhook.tap'),
                    ],
                    'description' => $description,
                    'metadata' => array_merge([
                        'user_id' => $user->id,
                    ], $metadata),
                    'receipt' => [
                        'email' => true,
                        'sms' => false,
                    ],
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Tap create charge failed', [
                'user_id' => $user->id,
                'amount' => $amount,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to create charge: ' . $e->getMessage());
        }
    }

    /**
     * Retrieve charge details
     */
    public function getCharge(string $chargeId): array
    {
        try {
            $response = $this->client->get("/charges/{$chargeId}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Tap get charge failed', [
                'charge_id' => $chargeId,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to retrieve charge: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a subscription (refund if within period)
     */
    public function cancelSubscription(UserSubscription $subscription): bool
    {
        try {
            // Mark subscription for cancellation at period end
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'ends_at' => $subscription->current_period_end,
            ]);

            Log::info('Tap subscription cancelled', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Tap cancel subscription failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Resume a cancelled subscription
     */
    public function resumeSubscription(UserSubscription $subscription): bool
    {
        try {
            $subscription->update([
                'status' => 'active',
                'cancelled_at' => null,
                'ends_at' => null,
            ]);

            Log::info('Tap subscription resumed', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Tap resume subscription failed', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Change plan (upgrade/downgrade)
     */
    public function changePlan(UserSubscription $subscription, Plan $newPlan, string $interval, bool $isUpgrade = true): bool
    {
        try {
            $newAmount = $interval === 'monthly' ? $newPlan->price_month : $newPlan->price_year;

            if ($isUpgrade) {
                // For upgrades, we'll create a new charge immediately
                // The webhook will update the subscription
                $charge = $this->createCharge(
                    $subscription->user,
                    (float) $newAmount,
                    "Upgrade to {$newPlan->name}",
                    [
                        'type' => 'plan_change',
                        'old_plan_id' => $subscription->plan_id,
                        'new_plan_id' => $newPlan->id,
                        'subscription_id' => $subscription->id,
                        'interval' => $interval,
                    ]
                );

                Log::info('Tap plan upgrade initiated', [
                    'subscription_id' => $subscription->id,
                    'charge_id' => $charge['id'] ?? null,
                ]);

                return true;
            } else {
                // For downgrades, schedule change at period end
                $subscription->update([
                    'pending_plan_id' => $newPlan->id,
                    'pending_interval' => $interval,
                ]);

                Log::info('Tap plan downgrade scheduled', [
                    'subscription_id' => $subscription->id,
                    'new_plan_id' => $newPlan->id,
                ]);

                return true;
            }
        } catch (\Exception $e) {
            Log::error('Tap change plan failed', [
                'subscription_id' => $subscription->id,
                'new_plan_id' => $newPlan->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Create a refund
     */
    public function createRefund(string $chargeId, float $amount, string $reason = ''): array
    {
        try {
            $response = $this->client->post('/refunds', [
                'json' => [
                    'charge_id' => $chargeId,
                    'amount' => $amount,
                    'currency' => 'USD',
                    'reason' => $reason ?: 'Customer request',
                    'metadata' => [
                        'refunded_at' => now()->toIso8601String(),
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            Log::info('Tap refund created', [
                'charge_id' => $chargeId,
                'refund_id' => $data['id'] ?? null,
                'amount' => $amount,
            ]);

            return $data;
        } catch (GuzzleException $e) {
            Log::error('Tap create refund failed', [
                'charge_id' => $chargeId,
                'amount' => $amount,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to create refund: ' . $e->getMessage());
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $webhookSecret = config('services.tap.webhook_secret');
        
        if (!$webhookSecret) {
            Log::warning('Tap webhook secret not configured');
            return false;
        }

        $computedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        
        return hash_equals($computedSignature, $signature);
    }

    /**
     * Process webhook event
     */
    public function processWebhook(array $event): void
    {
        $eventType = $event['event'] ?? $event['type'] ?? null;
        $charge = $event['charge'] ?? $event['data'] ?? [];

        Log::info('Tap webhook received', [
            'event_type' => $eventType,
            'charge_id' => $charge['id'] ?? null,
        ]);

        switch ($eventType) {
            case 'charge.created':
            case 'CHARGE_CREATED':
                $this->handleChargeCreated($charge);
                break;

            case 'charge.updated':
            case 'CHARGE_UPDATED':
                $this->handleChargeUpdated($charge);
                break;

            case 'charge.captured':
            case 'CAPTURED':
                $this->handleChargeSucceeded($charge);
                break;

            case 'charge.failed':
            case 'FAILED':
                $this->handleChargeFailed($charge);
                break;

            case 'refund.created':
            case 'REFUND_CREATED':
                $this->handleRefundCreated($charge);
                break;

            default:
                Log::info('Unhandled Tap webhook event', ['event' => $eventType]);
        }
    }

    protected function handleChargeCreated(array $charge): void
    {
        Log::info('Charge created', ['charge_id' => $charge['id'] ?? null]);
    }

    protected function handleChargeUpdated(array $charge): void
    {
        Log::info('Charge updated', [
            'charge_id' => $charge['id'] ?? null,
            'status' => $charge['status'] ?? null,
        ]);
    }

    protected function handleChargeSucceeded(array $charge): void
    {
        $metadata = $charge['metadata'] ?? [];
        $userId = $metadata['user_id'] ?? null;
        $planId = $metadata['plan_id'] ?? null;
        $type = $metadata['type'] ?? null;

        if ($type === 'subscription' && $userId && $planId) {
            $user = User::find($userId);
            $plan = Plan::find($planId);

            if ($user && $plan) {
                // Create or update subscription
                $interval = $metadata['interval'] ?? 'monthly';
                $periodEnd = now()->addMonths($interval === 'monthly' ? 1 : 12);

                UserSubscription::updateOrCreate(
                    ['user_id' => $userId],
                    [
                        'plan_id' => $planId,
                        'status' => 'active',
                        'billing_interval' => $interval,
                        'current_period_start' => now(),
                        'current_period_end' => $periodEnd,
                        'tap_charge_id' => $charge['id'] ?? null,
                        'tap_customer_id' => $charge['customer']['id'] ?? null,
                    ]
                );

                // Regenerate entitlements
                app(EntitlementsService::class)->regenerateEntitlements($user);

                Log::info('Subscription activated', [
                    'user_id' => $userId,
                    'plan_id' => $planId,
                ]);
            }
        } elseif ($type === 'plan_change' && $metadata['subscription_id'] ?? null) {
            // Handle plan upgrade
            $subscription = UserSubscription::find($metadata['subscription_id']);
            $newPlan = Plan::find($metadata['new_plan_id'] ?? null);

            if ($subscription && $newPlan) {
                $interval = $metadata['interval'] ?? 'monthly';
                $periodEnd = now()->addMonths($interval === 'monthly' ? 1 : 12);

                $subscription->update([
                    'plan_id' => $newPlan->id,
                    'billing_interval' => $interval,
                    'current_period_start' => now(),
                    'current_period_end' => $periodEnd,
                    'tap_charge_id' => $charge['id'] ?? null,
                    'status' => 'active',
                ]);

                // Regenerate entitlements
                app(EntitlementsService::class)->regenerateEntitlements($subscription->user);

                Log::info('Plan changed successfully', [
                    'subscription_id' => $subscription->id,
                    'new_plan_id' => $newPlan->id,
                ]);
            }
        }
    }

    protected function handleChargeFailed(array $charge): void
    {
        $metadata = $charge['metadata'] ?? [];
        $userId = $metadata['user_id'] ?? null;

        if ($userId) {
            $user = User::find($userId);
            if ($user && $user->activeSubscription) {
                $user->activeSubscription->update([
                    'status' => 'past_due',
                ]);

                Log::warning('Subscription payment failed', [
                    'user_id' => $userId,
                    'subscription_id' => $user->activeSubscription->id,
                ]);
            }
        }
    }

    protected function handleRefundCreated(array $refund): void
    {
        Log::info('Refund created', [
            'refund_id' => $refund['id'] ?? null,
            'charge_id' => $refund['charge_id'] ?? null,
        ]);
    }

    /**
     * Get public key for frontend
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * Check if sandbox mode
     */
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }
}

