<?php

namespace App\Services;

use App\Models\User;
use App\Models\KycSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class KycService
{
    private string $personaApiKey;
    private string $personaWebhookSecret;
    private string $personaBaseUrl;

    public function __construct()
    {
        $this->personaApiKey = config('services.persona.api_key');
        $this->personaWebhookSecret = config('services.persona.webhook_secret');
        $this->personaBaseUrl = config('services.persona.base_url', 'https://withpersona.com/api/v1');
    }

    /**
     * Initiate KYC verification for a user
     */
    public function initiateKyc(User $user): array
    {
        try {
            // Create KYC submission record
            $kycSubmission = KycSubmission::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'initiated_at' => now()
            ]);

            // Create Persona inquiry
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->personaApiKey,
                'Content-Type' => 'application/json',
                'Persona-Version' => '2023-01-05'
            ])->post($this->personaBaseUrl . '/inquiries', [
                'data' => [
                    'type' => 'inquiry',
                    'attributes' => [
                        'name-first' => $user->first_name,
                        'name-last' => $user->last_name,
                        'email-address' => $user->email,
                        'phone-number' => $user->phone,
                        'reference-id' => $kycSubmission->id,
                        'template-id' => config('services.persona.template_id'),
                        'redirect-uri' => route('kyc.callback'),
                        'webhook-url' => route('kyc.webhook')
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                $kycSubmission->update([
                    'persona_inquiry_id' => $data['data']['id'],
                    'persona_reference_id' => $data['data']['attributes']['reference-id'],
                    'verification_url' => $data['data']['attributes']['verification-url']
                ]);

                Log::info('KYC verification initiated', [
                    'user_id' => $user->id,
                    'kyc_submission_id' => $kycSubmission->id,
                    'persona_inquiry_id' => $data['data']['id']
                ]);

                return [
                    'success' => true,
                    'verification_url' => $data['data']['attributes']['verification-url'],
                    'kyc_submission_id' => $kycSubmission->id
                ];
            }

            throw new \Exception('Failed to create Persona inquiry: ' . $response->body());

        } catch (\Exception $e) {
            Log::error('KYC initiation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to initiate KYC verification'
            ];
        }
    }

    /**
     * Process Persona webhook
     */
    public function processWebhook(array $payload, string $signature): bool
    {
        try {
            // Verify webhook signature
            if (!$this->verifyWebhookSignature($payload, $signature)) {
                Log::warning('Invalid Persona webhook signature');
                return false;
            }

            $eventType = $payload['data']['attributes']['status'] ?? '';
            $inquiryId = $payload['data']['id'] ?? '';

            // Find KYC submission by Persona inquiry ID
            $kycSubmission = KycSubmission::where('persona_inquiry_id', $inquiryId)->first();
            
            if (!$kycSubmission) {
                Log::warning('KYC submission not found for Persona inquiry', [
                    'inquiry_id' => $inquiryId
                ]);
                return false;
            }

            // Update KYC submission status
            $this->updateKycStatus($kycSubmission, $eventType, $payload);

            Log::info('Persona webhook processed', [
                'kyc_submission_id' => $kycSubmission->id,
                'user_id' => $kycSubmission->user_id,
                'status' => $eventType
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Persona webhook processing failed', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);

            return false;
        }
    }

    /**
     * Verify Persona webhook signature
     */
    private function verifyWebhookSignature(array $payload, string $signature): bool
    {
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $this->personaWebhookSecret);
        return hash_equals($signature, $expectedSignature);
    }

    /**
     * Update KYC submission status
     */
    private function updateKycStatus(KycSubmission $kycSubmission, string $status, array $payload): void
    {
        $statusMapping = [
            'completed' => 'approved',
            'failed' => 'rejected',
            'expired' => 'expired',
            'abandoned' => 'abandoned'
        ];

        $newStatus = $statusMapping[$status] ?? 'pending';

        $kycSubmission->update([
            'status' => $newStatus,
            'persona_response' => $payload,
            'completed_at' => $newStatus === 'approved' ? now() : null,
            'rejected_at' => $newStatus === 'rejected' ? now() : null
        ]);

        // Update user verification status
        if ($newStatus === 'approved') {
            $kycSubmission->user->update([
                'kyc_verified' => true,
                'kyc_verified_at' => now()
            ]);
        }
    }

    /**
     * Get KYC status for user
     */
    public function getKycStatus(User $user): array
    {
        $kycSubmission = $user->kycSubmissions()->latest()->first();

        if (!$kycSubmission) {
            return [
                'status' => 'not_started',
                'message' => 'KYC verification not started'
            ];
        }

        return [
            'status' => $kycSubmission->status,
            'submitted_at' => $kycSubmission->created_at,
            'completed_at' => $kycSubmission->completed_at,
            'rejected_at' => $kycSubmission->rejected_at,
            'verification_url' => $kycSubmission->verification_url
        ];
    }

    /**
     * Check if user can perform KYC
     */
    public function canPerformKyc(User $user): bool
    {
        $kycSubmission = $user->kycSubmissions()->latest()->first();

        if (!$kycSubmission) {
            return true;
        }

        // Allow new KYC if previous was rejected or expired
        return in_array($kycSubmission->status, ['rejected', 'expired', 'abandoned']);
    }
}
