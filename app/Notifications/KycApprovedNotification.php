<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycApprovedNotification extends Notification
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
        return (new MailMessage)
                    ->subject('🎉 Identity Verification Approved - NXO')
                    ->greeting('Congratulations!')
                    ->line('Your identity verification has been approved by our team.')
                    ->line('You can now:')
                    ->line('• List and sell products on NXO')
                    ->line('• Access all seller features')
                    ->line('• Request payouts')
                    ->action('Start Selling', url('/sell'))
                    ->line('Thank you for completing the verification process!')
                    ->salutation('The NXO Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Identity Verification Approved',
            'message' => 'Your identity verification has been approved. You can now start selling on NXO.',
            'type' => 'success',
            'action_url' => '/sell',
            'action_text' => 'Start Selling',
            'kyc_submission_id' => $this->kycSubmission->id,
        ];
    }
}