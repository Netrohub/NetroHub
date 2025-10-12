<?php

namespace App\Notifications;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSaleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public OrderItem $orderItem) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Sale - '.$this->orderItem->product_title)
            ->greeting('Congratulations!')
            ->line('You have a new sale!')
            ->line('Product: '.$this->orderItem->product_title)
            ->line('Amount: $'.number_format($this->orderItem->seller_amount, 2))
            ->action('View Dashboard', route('seller.dashboard'))
            ->line('Keep up the great work!');
    }
}
