<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;

class TurnstileService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 3, // Total timeout
            'connect_timeout' => 2, // Connection timeout
            'read_timeout' => 3, // Read timeout
        ]);
    }

    public function verifyToken(?string $token, string $ip = null): bool
    {
        if (empty($token)) {
            \Log::warning('Turnstile verification failed: empty token', [
                'ip' => $ip,
                'has_token' => false
            ]);
            return false;
        }

        $secret = config('services.turnstile.secret_key');
        if (empty($secret)) {
            \Log::warning('Turnstile verification failed: secret not configured', [
                'ip' => $ip,
                'has_secret' => false
            ]);
            return false;
        }

        try {
            $response = $this->client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'form_params' => [
                    'secret' => $secret,
                    'response' => $token,
                    'remoteip' => $ip,
                ],
                'headers' => [
                    'User-Agent' => 'NXO-Marketplace/1.0',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                \Log::warning('Turnstile verification failed: non-200 response', [
                    'ip' => $ip,
                    'status_code' => $statusCode,
                    'response_body' => $response->getBody()->getContents()
                ]);
                return false;
            }

            $json = json_decode($response->getBody()->getContents(), true);
            $success = (bool)($json['success'] ?? false);

            if (!$success) {
                \Log::warning('Turnstile verification failed: API returned success=false', [
                    'ip' => $ip,
                    'response' => $json,
                    'error_codes' => $json['error-codes'] ?? []
                ]);
            }

            return $success;

        } catch (ConnectException $e) {
            \Log::warning('Turnstile verification failed: connection error', [
                'ip' => $ip,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode()
            ]);
            return false;

        } catch (RequestException $e) {
            \Log::warning('Turnstile verification failed: request error', [
                'ip' => $ip,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);
            return false;

        } catch (TransferException $e) {
            \Log::warning('Turnstile verification failed: transfer error', [
                'ip' => $ip,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode()
            ]);
            return false;

        } catch (\Exception $e) {
            \Log::warning('Turnstile verification failed: unexpected error', [
                'ip' => $ip,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}