<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionPaymentFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public UserSubscription $subscription) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Failed')
            ->greeting('Hello '.$notifiable->name)
            ->line('We were unable to process your subscription renewal payment.')
            ->line('Please update your payment method to avoid service interruption.')
            ->action('Update Payment Method', route('account.billing'))
            ->line('Thank you for your prompt attention to this matter.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'message' => 'Subscription payment failed',
        ];
    }
}
