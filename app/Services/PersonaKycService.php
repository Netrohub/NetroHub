<?php

namespace App\Services;

use App\Models\User;
use App\Models\KycSubmission;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PersonaKycService
{
    protected $apiKey;
    protected $templateId;
    protected $environment;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.persona.api_key');
        $this->templateId = config('services.persona.template_id');
        $this->environment = config('services.persona.environment', 'sandbox');
        $this->baseUrl = $this->environment === 'production' 
            ? 'https://withpersona.com/api/v1' 
            : 'https://withpersona.com/api/v1';
    }

    /**
     * Create a new inquiry for a user
     */
    public function createInquiry(User $user): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Persona-Version' => '2023-01-05',
            ])->post($this->baseUrl . '/inquiries', [
                'data' => [
                    'type' => 'inquiry',
                    'attributes' => [
                        'inquiry-template-id' => $this->templateId,
                        'reference-id' => 'user-' . $user->id,
                        'note' => 'KYC verification for NetroHub user',
                        'fields' => [
                            'name_first' => $user->name,
                            'email_address' => $user->email,
                            'phone_number' => $user->phone ?? null,
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Store inquiry in database
                KycSubmission::create([
                    'user_id' => $user->id,
                    'persona_inquiry_id' => $data['data']['id'],
                    'status' => 'pending',
                    'full_name' => $user->name,
                ]);

                return [
                    'success' => true,
                    'inquiry_id' => $data['data']['id'],
                    'session_token' => $data['data']['attributes']['session-token'] ?? null,
                ];
            }

            Log::error('Persona inquiry creation failed', [
                'user_id' => $user->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => 'Failed to create verification inquiry',
            ];

        } catch (\Exception $e) {
            Log::error('Persona API error', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get inquiry status
     */
    public function getInquiryStatus(string $inquiryId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Persona-Version' => '2023-01-05',
            ])->get($this->baseUrl . '/inquiries/' . $inquiryId);

            if ($response->successful()) {
                $data = $response->json();
                $status = $data['data']['attributes']['status'];

                return [
                    'success' => true,
                    'status' => $status,
                    'data' => $data['data'],
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to fetch inquiry status',
            ];

        } catch (\Exception $e) {
            Log::error('Persona inquiry status check failed', [
                'inquiry_id' => $inquiryId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle webhook payload from Persona
     */
    public function handleWebhook(array $payload): bool
    {
        try {
            $eventType = $payload['data']['type'] ?? null;
            $attributes = $payload['data']['attributes'] ?? [];

            if ($eventType === 'inquiry.completed' || $eventType === 'inquiry.approved') {
                return $this->handleInquiryApproved($payload);
            }

            if ($eventType === 'inquiry.failed' || $eventType === 'inquiry.declined') {
                return $this->handleInquiryFailed($payload);
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Persona webhook processing failed', [
                'payload' => $payload,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Handle approved inquiry
     */
    protected function handleInquiryApproved(array $payload): bool
    {
        $inquiryId = $payload['data']['id'];
        $referenceId = $payload['data']['attributes']['reference-id'] ?? null;

        if (!$referenceId) {
            return false;
        }

        $userId = str_replace('user-', '', $referenceId);
        $submission = KycSubmission::where('persona_inquiry_id', $inquiryId)->first();

        if (!$submission) {
            $submission = KycSubmission::where('user_id', $userId)->latest()->first();
        }

        if ($submission) {
            $submission->update([
                'status' => 'approved',
                'reviewed_at' => now(),
            ]);

            $submission->user->update(['is_verified' => true]);

            Log::info('KYC approved via Persona', [
                'user_id' => $userId,
                'inquiry_id' => $inquiryId,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Handle failed/declined inquiry
     */
    protected function handleInquiryFailed(array $payload): bool
    {
        $inquiryId = $payload['data']['id'];
        $referenceId = $payload['data']['attributes']['reference-id'] ?? null;

        if (!$referenceId) {
            return false;
        }

        $userId = str_replace('user-', '', $referenceId);
        $submission = KycSubmission::where('persona_inquiry_id', $inquiryId)->first();

        if (!$submission) {
            $submission = KycSubmission::where('user_id', $userId)->latest()->first();
        }

        if ($submission) {
            $submission->update([
                'status' => 'rejected',
                'reviewed_at' => now(),
                'notes' => $payload['data']['attributes']['failure-reason'] ?? 'Verification failed',
            ]);

            $submission->user->update(['is_verified' => false]);

            Log::info('KYC rejected via Persona', [
                'user_id' => $userId,
                'inquiry_id' => $inquiryId,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $webhookSecret = config('services.persona.webhook_secret');
        
        if (!$webhookSecret) {
            return true; // Skip verification if secret not configured
        }

        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        
        return hash_equals($expectedSignature, $signature);
    }
}

