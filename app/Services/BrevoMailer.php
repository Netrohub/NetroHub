<?php

namespace App\Services;

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoMailer
{
    protected TransactionalEmailsApi $api;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.key'));

        $this->api = new TransactionalEmailsApi(new Client(), $config);
    }

    /**
     * Send email verification email using Brevo template
     */
    public function sendEmailVerification(string $toEmail, string $toName, string $verificationLink): void
    {
        try {
            $email = new SendSmtpEmail([
                'to' => [[ 
                    'email' => $toEmail, 
                    'name' => $toName 
                ]],
                'templateId' => (int) config('services.brevo.verify_template_id'),
                'params' => [
                    'verification_link' => $verificationLink,
                    'user_name' => $toName,
                    'year' => now()->year,
                    'app_name' => config('app.name', 'NetroHub'),
                ],
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name'  => config('mail.from.name'),
                ],
            ]);

            $result = $this->api->sendTransacEmail($email);

            \Log::info('Brevo verification email sent', [
                'to' => $toEmail,
                'message_id' => $result->getMessageId(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send Brevo verification email', [
                'to' => $toEmail,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Send welcome email after verification
     */
    public function sendWelcomeEmail(string $toEmail, string $toName): void
    {
        try {
            $welcomeTemplateId = config('services.brevo.welcome_template_id');
            
            if (!$welcomeTemplateId) {
                return; // Skip if not configured
            }

            $email = new SendSmtpEmail([
                'to' => [[ 
                    'email' => $toEmail, 
                    'name' => $toName 
                ]],
                'templateId' => (int) $welcomeTemplateId,
                'params' => [
                    'user_name' => $toName,
                    'dashboard_link' => route('account.index'),
                    'products_link' => route('products.index'),
                    'year' => now()->year,
                    'app_name' => config('app.name', 'NetroHub'),
                ],
                'sender' => [
                    'email' => config('mail.from.address'),
                    'name'  => config('mail.from.name'),
                ],
            ]);

            $this->api->sendTransacEmail($email);

            \Log::info('Brevo welcome email sent', ['to' => $toEmail]);
        } catch (\Exception $e) {
            \Log::warning('Failed to send welcome email (non-critical)', [
                'to' => $toEmail,
                'error' => $e->getMessage(),
            ]);
        }
    }
}


