<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionCancelledNotification extends Notification implements ShouldQueue
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
            ->subject('Subscription Cancelled')
            ->greeting('Hello '.$notifiable->name)
            ->line('Your subscription has been cancelled.')
            ->line('You will continue to have access to your premium features until '.$this->subscription->period_end?->format('F d, Y').'.')
            ->line('After that, your account will automatically switch to the Free plan.')
            ->action('Reactivate Subscription', route('account.billing'))
            ->line('We hope to see you again soon!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'plan_name' => $this->subscription->plan->name,
            'expires_at' => $this->subscription->period_end,
            'message' => 'Your subscription has been cancelled',
        ];
    }
}
