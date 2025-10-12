<?php

namespace App\Notifications;

use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionActivatedNotification extends Notification implements ShouldQueue
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
            ->subject('Welcome to '.$this->subscription->plan->name.'!')
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('Your '.$this->subscription->plan->name.' subscription is now active.')
            ->line('You now have access to all the premium features included in your plan.')
            ->action('View Benefits', route('account.billing'))
            ->line('Thank you for upgrading!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'plan_name' => $this->subscription->plan->name,
            'message' => 'Your '.$this->subscription->plan->name.' subscription is now active',
        ];
    }
}
