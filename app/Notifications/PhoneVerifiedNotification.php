<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PhoneVerifiedNotification extends Notification
{
    use Queueable;

    protected $phoneNumber;

    /**
     * Create a new notification instance.
     */
    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
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
                    ->subject('📱 Phone Number Verified - NXO')
                    ->greeting('Hello!')
                    ->line('Your phone number has been successfully verified.')
                    ->line('Phone number: **' . $this->phoneNumber . '**')
                    ->line('This adds an extra layer of security to your account and enables additional features.')
                    ->line('Thank you for securing your account!')
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
            'title' => 'Phone Number Verified',
            'message' => 'Your phone number has been successfully verified for enhanced account security.',
            'type' => 'success',
            'phone_number' => $this->phoneNumber,
        ];
    }
}