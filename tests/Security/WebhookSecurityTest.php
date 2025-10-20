<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\IdempotencyKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

class WebhookSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test webhook signature verification
     */
    public function test_webhook_signature_verification(): void
    {
        $payload = ['test' => 'data'];
        $signature = hash_hmac('sha256', json_encode($payload), 'test_secret');

        $response = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t=1234567890,v1={$signature}"
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test webhook signature verification with invalid signature
     */
    public function test_webhook_signature_verification_with_invalid_signature(): void
    {
        $payload = ['test' => 'data'];
        $invalidSignature = 'invalid_signature';

        $response = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t=1234567890,v1={$invalidSignature}"
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test webhook idempotency
     */
    public function test_webhook_idempotency(): void
    {
        $payload = ['id' => 'evt_test123', 'type' => 'payment_intent.succeeded'];
        $signature = hash_hmac('sha256', json_encode($payload), 'test_secret');

        // First request
        $response1 = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t=1234567890,v1={$signature}",
            'Idempotency-Key' => 'test-key-123'
        ]);

        $response1->assertStatus(200);

        // Second request with same idempotency key
        $response2 = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t=1234567890,v1={$signature}",
            'Idempotency-Key' => 'test-key-123'
        ]);

        $response2->assertStatus(200);
        
        // Should not process duplicate
        $this->assertDatabaseHas('idempotency_keys', [
            'key' => 'test-key-123',
            'status' => 'processed'
        ]);
    }

    /**
     * Test webhook timestamp validation
     */
    public function test_webhook_timestamp_validation(): void
    {
        $payload = ['test' => 'data'];
        $oldTimestamp = now()->subMinutes(10)->timestamp;
        $signature = hash_hmac('sha256', $oldTimestamp . '.' . json_encode($payload), 'test_secret');

        $response = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t={$oldTimestamp},v1={$signature}"
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test webhook payload validation
     */
    public function test_webhook_payload_validation(): void
    {
        $invalidPayload = 'invalid json';

        $response = $this->postJson('/webhooks/stripe', $invalidPayload, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test webhook job dispatch
     */
    public function test_webhook_job_dispatch(): void
    {
        Queue::fake();

        $payload = ['id' => 'evt_test123', 'type' => 'payment_intent.succeeded'];
        $signature = hash_hmac('sha256', json_encode($payload), 'test_secret');

        $response = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t=1234567890,v1={$signature}"
        ]);

        $response->assertStatus(200);

        Queue::assertPushed(\App\Jobs\VerifyPaymentWebhook::class);
    }

    /**
     * Test webhook with missing required headers
     */
    public function test_webhook_with_missing_headers(): void
    {
        $payload = ['test' => 'data'];

        $response = $this->postJson('/webhooks/stripe', $payload);

        $response->assertStatus(400);
    }

    /**
     * Test webhook with malformed signature
     */
    public function test_webhook_with_malformed_signature(): void
    {
        $payload = ['test' => 'data'];

        $response = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => 'malformed-signature'
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test webhook replay attack prevention
     */
    public function test_webhook_replay_attack_prevention(): void
    {
        $payload = ['id' => 'evt_test123', 'type' => 'payment_intent.succeeded'];
        $timestamp = now()->subMinutes(1)->timestamp;
        $signature = hash_hmac('sha256', $timestamp . '.' . json_encode($payload), 'test_secret');

        // First request with valid timestamp
        $response1 = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t={$timestamp},v1={$signature}"
        ]);

        $response1->assertStatus(200);

        // Second request with same timestamp (replay attack)
        $response2 = $this->postJson('/webhooks/stripe', $payload, [
            'Stripe-Signature' => "t={$timestamp},v1={$signature}"
        ]);

        $response2->assertStatus(400);
    }
}
