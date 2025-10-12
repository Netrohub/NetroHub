<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycRejectedNotification extends Notification
{
    use Queueable;

    protected $kycSubmission;

    /**
     * Create a new notification instance.
     */
    public function __construct($kycSubmission)
    {
        $this->kycSubmission = $kycSubmission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
                    ->subject('⚠️ Identity Verification Requires Attention - NetroHub')
                    ->greeting('Hello!')
                    ->line('Your identity verification submission requires additional attention.')
                    ->line('Please review the feedback below and resubmit your verification:');

        if ($this->kycSubmission->notes) {
            $mailMessage->line('**Feedback:** ' . $this->kycSubmission->notes);
        }

        $mailMessage->line('Common issues include:')
                    ->line('• Unclear or blurry document images')
                    ->line('• Expired documents')
                    ->line('• Information mismatch')
                    ->line('• Incomplete document coverage')
                    ->action('Resubmit Verification', url('/account/kyc'))
                    ->line('If you have questions, please contact our support team.')
                    ->salutation('The NetroHub Team');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Identity Verification Rejected',
            'message' => 'Your identity verification was rejected. Please review the feedback and resubmit.',
            'type' => 'warning',
            'action_url' => '/account/kyc',
            'action_text' => 'Resubmit Verification',
            'kyc_submission_id' => $this->kycSubmission->id,
            'feedback' => $this->kycSubmission->notes,
        ];
    }
}