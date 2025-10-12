<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->order->load('items.product');

        // Check if order contains credential-based products
        $hasCredentials = $this->order->items->filter(function ($item) {
            return $item->product && $item->product->hasCredentials();
        })->isNotEmpty();

        $message = (new MailMessage)
            ->subject('Order Completed - '.$this->order->order_number)
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('Your order has been completed successfully.')
            ->line('Order Number: '.$this->order->order_number)
            ->line('Total: $'.number_format($this->order->total, 2));

        // If order has credentials, link to secure delivery page
        if ($hasCredentials) {
            $message->action('🔒 View Your Credentials', route('orders.delivery', $this->order))
                ->line('⚠️ **Important:** Your credentials are available securely on our platform. Click the button above to access them.')
                ->line('For security reasons, credentials are not sent via email.');
        } else {
            $message->action('View Order', route('checkout.success', $this->order));
        }

        return $message->line('Thank you for your purchase!');
    }
}
