<?php

namespace App\Notifications;

use App\Models\Dispute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisputeCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Dispute $dispute
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Dispute Created - Order #' . $this->dispute->order->order_number)
            ->line('A dispute has been created for your order.')
            ->line('**Reason:** ' . $this->dispute->reason)
            ->line('**Order:** #' . $this->dispute->order->order_number)
            ->action('View Dispute', route('disputes.show', $this->dispute))
            ->line('Please respond to this dispute as soon as possible.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'dispute_id' => $this->dispute->id,
            'order_number' => $this->dispute->order->order_number,
            'reason' => $this->dispute->reason,
            'message' => 'A dispute has been created for order #' . $this->dispute->order->order_number,
        ];
    }
}


