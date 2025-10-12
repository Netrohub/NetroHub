<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Product $product,
        public int $availableCount
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert - '.$this->product->title)
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('Your product "'.$this->product->title.'" is running low on license codes.')
            ->line('Available codes: '.$this->availableCount)
            ->action('Manage Product', route('seller.products.edit', $this->product))
            ->line('Consider adding more codes to avoid losing sales.')
            ->salutation('Best regards, NetroHub Team');
    }

    public function toArray($notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_title' => $this->product->title,
            'available_count' => $this->availableCount,
            'message' => "Your product \"{$this->product->title}\" is running low on license codes ({$this->availableCount} remaining).",
        ];
    }
}
