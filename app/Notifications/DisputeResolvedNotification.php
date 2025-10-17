<?php

namespace App\Notifications;

use App\Models\Dispute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisputeResolvedNotification extends Notification implements ShouldQueue
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
        $resolution = $this->dispute->status === 'resolved_refund' ? 'Refund Approved' : 'Seller Upheld';
        
        return (new MailMessage)
            ->subject('Dispute Resolved - Order #' . $this->dispute->order->order_number)
            ->line('Your dispute has been resolved.')
            ->line('**Resolution:** ' . $resolution)
            ->line('**Order:** #' . $this->dispute->order->order_number)
            ->action('View Details', route('disputes.show', $this->dispute))
            ->line('Thank you for your patience.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'dispute_id' => $this->dispute->id,
            'order_number' => $this->dispute->order->order_number,
            'status' => $this->dispute->status,
            'message' => 'Dispute for order #' . $this->dispute->order->order_number . ' has been resolved.',
        ];
    }
}


