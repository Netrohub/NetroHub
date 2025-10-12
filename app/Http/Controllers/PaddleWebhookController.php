<?php

namespace App\Http\Controllers;

use App\Models\WebhookLog;
use App\Services\PaddleSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaddleWebhookController extends Controller
{
    public function __construct(
        protected PaddleSubscriptionService $paddleService
    ) {}

    /**
     * Handle incoming Paddle webhooks
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();
        $eventType = $request->input('event_type') ?? $request->input('alert_name');

        // Log webhook
        $this->logWebhook($eventType, $payload);

        try {
            match($eventType) {
                'subscription.created', 'subscription_created' => $this->handleSubscriptionCreated($payload),
                'subscription.updated', 'subscription_updated' => $this->handleSubscriptionUpdated($payload),
                'subscription.cancelled', 'subscription_canceled' => $this->handleSubscriptionCancelled($payload),
                'subscription.past_due', 'subscription_past_due' => $this->handleSubscriptionPastDue($payload),
                'transaction.completed', 'payment_succeeded' => $this->handlePaymentSucceeded($payload),
                'transaction.payment_failed', 'payment_failed' => $this->handlePaymentFailed($payload),
                default => Log::info("Unhandled Paddle webhook: {$eventType}")
            };

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Paddle webhook error', [
                'event_type' => $eventType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle subscription created event
     */
    protected function handleSubscriptionCreated(array $payload): void
    {
        $this->paddleService->handleSubscriptionCreated($payload['data'] ?? $payload);
    }

    /**
     * Handle subscription updated event
     */
    protected function handleSubscriptionUpdated(array $payload): void
    {
        $this->paddleService->handleSubscriptionUpdated($payload['data'] ?? $payload);
    }

    /**
     * Handle subscription cancelled event
     */
    protected function handleSubscriptionCancelled(array $payload): void
    {
        $this->paddleService->handleSubscriptionCancelled($payload['data'] ?? $payload);
    }

    /**
     * Handle subscription past due event
     */
    protected function handleSubscriptionPastDue(array $payload): void
    {
        $data = $payload['data'] ?? $payload;
        $paddleSubId = $data['id'] ?? $data['subscription_id'] ?? null;

        if ($paddleSubId) {
            $subscription = \App\Models\UserSubscription::where('paddle_subscription_id', $paddleSubId)->first();

            if ($subscription) {
                $subscription->update(['status' => 'past_due']);
            }
        }
    }

    /**
     * Handle payment succeeded event
     */
    protected function handlePaymentSucceeded(array $payload): void
    {
        $this->paddleService->handlePaymentSucceeded($payload['data'] ?? $payload);
    }

    /**
     * Handle payment failed event
     */
    protected function handlePaymentFailed(array $payload): void
    {
        $this->paddleService->handlePaymentFailed($payload['data'] ?? $payload);
    }

    /**
     * Log webhook for debugging
     */
    protected function logWebhook(string $eventType, array $payload): void
    {
        WebhookLog::create([
            'provider' => 'paddle',
            'event_type' => $eventType,
            'payload' => $payload,
            'processed_at' => now(),
        ]);
    }
}
