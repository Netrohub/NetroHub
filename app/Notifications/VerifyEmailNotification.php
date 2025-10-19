<?php

namespace App\Notifications;

use App\Models\EmailTemplate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        // Try to get the email template from database
        $template = EmailTemplate::where('key', 'verification_email')
            ->where('is_active', true)
            ->first();

        if ($template) {
            // Use custom template
            $variables = [
                'verification_url' => $verificationUrl,
                'year' => date('Y'),
            ];

            $subject = $template->renderSubject($variables);
            $body = $template->render($variables);

            return (new MailMessage)
                ->subject($subject)
                ->html($body);
        }

        // Fallback to default Laravel verification email
        return (new MailMessage)
            ->subject('Verify your email - NXO')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an account, no further action is required.');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}

