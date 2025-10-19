<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class TurnstileService
{
    /**
     * Verify Turnstile token with Cloudflare
     */
    public function verify(?string $token, ?string $remoteIp = null): bool
    {
        $secretKey = config('services.turnstile.secret_key');
        
        if (!$secretKey) {
            // If Turnstile is not configured, allow the request
            return true;
        }

        if (empty($token)) {
            \Log::warning('Turnstile verification failed - empty token', [
                'token' => $token,
                'ip' => $remoteIp ?? request()->ip()
            ]);
            return false;
        }

        try {
            $response = Http::asForm()->timeout(10)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $remoteIp ?? request()->ip(),
            ]);

            if (!$response->ok()) {
                \Log::warning('Turnstile verification failed - HTTP error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }

            $result = $response->json();
            
            \Log::info('Turnstile verification response', [
                'success' => $result['success'] ?? false,
                'error_codes' => $result['error-codes'] ?? [],
                'challenge_ts' => $result['challenge_ts'] ?? null,
                'hostname' => $result['hostname'] ?? null,
                'action' => $result['action'] ?? null,
                'cdata' => $result['cdata'] ?? null,
            ]);

            // Log detailed error information if verification fails
            if (!($result['success'] ?? false)) {
                $errorCodes = $result['error-codes'] ?? [];
                $errorMessages = array_map(function($code) {
                    return $this->getErrorMessage($code);
                }, $errorCodes);
                
                \Log::warning('Turnstile verification failed with errors', [
                    'error_codes' => $errorCodes,
                    'error_messages' => $errorMessages,
                    'token_length' => strlen($token),
                    'token_preview' => substr($token, 0, 20) . '...',
                    'remote_ip' => $remoteIp ?? request()->ip(),
                    'request_hostname' => request()->getHost(),
                ]);
            }

            return $result['success'] ?? false;
        } catch (\Exception $e) {
            \Log::error('Turnstile verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify Turnstile token and throw validation exception on failure
     */
    public function verifyOrFail(?string $token, ?string $remoteIp = null): void
    {
        if (!$this->verify($token, $remoteIp)) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Human verification failed. Please try again.',
            ]);
        }
    }

    /**
     * Get error message for specific error code
     */
    public function getErrorMessage(string $errorCode): string
    {
        $messages = [
            'missing-input-secret' => 'The secret parameter is missing.',
            'invalid-input-secret' => 'The secret parameter is invalid or malformed.',
            'missing-input-response' => 'The response parameter is missing.',
            'invalid-input-response' => 'The response parameter is invalid or malformed.',
            'bad-request' => 'The request is invalid or malformed.',
            'timeout-or-duplicate' => 'The response is no longer valid: either is too old or has been used previously.',
            'internal-error' => 'An internal error happened while validating the response.',
        ];

        return $messages[$errorCode] ?? 'Verification failed. Please try again.';
    }
}
