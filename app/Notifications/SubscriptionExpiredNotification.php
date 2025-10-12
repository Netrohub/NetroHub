<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification implements ShouldQueue
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
            ->subject('Your Subscription Has Expired')
            ->greeting('Hello '.$notifiable->name)
            ->line('Your '.$this->subscription->plan->name.' subscription has expired.')
            ->line('You have been switched to the Free plan.')
            ->line('You can resubscribe at any time to regain access to premium features.')
            ->action('View Plans', route('pricing'))
            ->line('We hope you\'ll join us again soon!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'plan_name' => $this->subscription->plan->name,
            'message' => 'Your subscription has expired',
        ];
    }
}
