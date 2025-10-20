<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class VerifyPaymentWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $provider,
        public string $signature,
        public string $payload,
        public array $headers = []
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Check idempotency to prevent duplicate processing
            $idempotencyKey = $this->getIdempotencyKey();
            if ($this->isDuplicate($idempotencyKey)) {
                Log::info('Duplicate webhook ignored', [
                    'provider' => $this->provider,
                    'idempotency_key' => $idempotencyKey
                ]);
                return;
            }

            // Verify webhook signature
            if (!$this->verifySignature()) {
                Log::warning('Invalid webhook signature', [
                    'provider' => $this->provider,
                    'signature' => $this->signature
                ]);
                return;
            }

            // Mark as processed
            $this->markAsProcessed($idempotencyKey);

            // Process the webhook
            $this->processWebhook();

        } catch (\Exception $e) {
            Log::error('Webhook verification failed', [
                'provider' => $this->provider,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Get idempotency key from headers or payload
     */
    private function getIdempotencyKey(): string
    {
        // Try to get from headers first
        $idempotencyKey = $this->headers['x-idempotency-key'] ?? 
                         $this->headers['stripe-idempotency-key'] ?? 
                         $this->headers['idempotency-key'] ?? null;

        if ($idempotencyKey) {
            return $idempotencyKey;
        }

        // Generate from payload hash if not provided
        return hash('sha256', $this->payload);
    }

    /**
     * Check if webhook is duplicate
     */
    private function isDuplicate(string $idempotencyKey): bool
    {
        return Cache::has("webhook_processed_{$idempotencyKey}");
    }

    /**
     * Mark webhook as processed
     */
    private function markAsProcessed(string $idempotencyKey): void
    {
        // Store for 24 hours to prevent duplicates
        Cache::put("webhook_processed_{$idempotencyKey}", true, 86400);
    }

    /**
     * Verify webhook signature
     */
    private function verifySignature(): bool
    {
        switch ($this->provider) {
            case 'stripe':
                return $this->verifyStripeSignature();
            case 'tap':
                return $this->verifyTapSignature();
            default:
                Log::warning('Unknown webhook provider', ['provider' => $this->provider]);
                return false;
        }
    }

    /**
     * Verify Stripe webhook signature
     */
    private function verifyStripeSignature(): bool
    {
        $webhookSecret = config('services.stripe.webhook_secret');
        if (!$webhookSecret) {
            return false;
        }

        $timestamp = $this->headers['stripe-signature'] ?? '';
        $elements = explode(',', $timestamp);
        $signature = '';
        $timestamp = '';

        foreach ($elements as $element) {
            $parts = explode('=', $element, 2);
            if (count($parts) === 2) {
                if ($parts[0] === 't') {
                    $timestamp = $parts[1];
                } elseif ($parts[0] === 'v1') {
                    $signature = $parts[1];
                }
            }
        }

        if (!$signature || !$timestamp) {
            return false;
        }

        // Check timestamp (prevent replay attacks)
        if (abs(time() - $timestamp) > 300) { // 5 minutes tolerance
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $timestamp . '.' . $this->payload, $webhookSecret);
        
        return hash_equals($signature, $expectedSignature);
    }

    /**
     * Verify Tap webhook signature
     */
    private function verifyTapSignature(): bool
    {
        $webhookSecret = config('services.tap.webhook_secret');
        if (!$webhookSecret) {
            return false;
        }

        $signature = $this->headers['x-tap-signature'] ?? '';
        $expectedSignature = hash_hmac('sha256', $this->payload, $webhookSecret);
        
        return hash_equals($signature, $expectedSignature);
    }

    /**
     * Process the verified webhook
     */
    private function processWebhook(): void
    {
        $data = json_decode($this->payload, true);
        
        if (!$data) {
            Log::error('Invalid webhook payload', [
                'provider' => $this->provider,
                'payload' => $this->payload
            ]);
            return;
        }

        // Dispatch appropriate job based on webhook type
        switch ($this->provider) {
            case 'stripe':
                $this->processStripeWebhook($data);
                break;
            case 'tap':
                $this->processTapWebhook($data);
                break;
        }
    }

    /**
     * Process Stripe webhook
     */
    private function processStripeWebhook(array $data): void
    {
        $eventType = $data['type'] ?? '';
        
        switch ($eventType) {
            case 'payment_intent.succeeded':
                // Handle successful payment
                break;
            case 'payment_intent.payment_failed':
                // Handle failed payment
                break;
            case 'charge.dispute.created':
                // Handle dispute creation
                break;
        }
    }

    /**
     * Process Tap webhook
     */
    private function processTapWebhook(array $data): void
    {
        $status = $data['status'] ?? '';
        
        switch ($status) {
            case 'CAPTURED':
                // Handle successful payment
                break;
            case 'FAILED':
                // Handle failed payment
                break;
            case 'DECLINED':
                // Handle declined payment
                break;
        }
    }
}
