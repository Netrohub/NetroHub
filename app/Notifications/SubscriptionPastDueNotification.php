<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionPastDueNotification extends Notification implements ShouldQueue
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
            ->subject('Payment Failed - Action Required')
            ->greeting('Hello '.$notifiable->name)
            ->line('We were unable to process your subscription payment.')
            ->line('Please update your payment method to continue enjoying your premium features.')
            ->action('Update Payment Method', route('account.billing'))
            ->line('If we don\'t receive payment soon, your subscription may be cancelled.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'message' => 'Payment failed - please update your payment method',
        ];
    }
}
