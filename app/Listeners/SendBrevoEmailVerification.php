<?php

namespace App\Listeners;

use App\Actions\Auth\MakeEmailVerificationUrl;
use App\Services\BrevoMailer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBrevoEmailVerification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected BrevoMailer $brevo,
        protected MakeEmailVerificationUrl $makeUrl,
    ) {}

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Skip if user is already verified
        if (method_exists($user, 'hasVerifiedEmail') && $user->hasVerifiedEmail()) {
            \Log::info('User already verified, skipping verification email', [
                'user_id' => $user->id,
            ]);
            return;
        }

        // Skip if Brevo is not configured
        if (!config('services.brevo.key') || !config('services.brevo.verify_template_id')) {
            \Log::warning('Brevo not configured, skipping verification email', [
                'user_id' => $user->id,
            ]);
            return;
        }

        try {
            // Generate signed verification URL
            $link = ($this->makeUrl)($user);

            // Send email via Brevo
            $this->brevo->sendEmailVerification(
                toEmail: $user->email,
                toName: $user->name ?? 'User',
                verificationLink: $link
            );

            \Log::info('Verification email queued for user', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            // Don't throw - let registration complete even if email fails
        }
    }
}


