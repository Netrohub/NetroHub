<?php

namespace App\Notifications;

use App\Models\Dispute;
use App\Models\DisputeMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisputeMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Dispute $dispute,
        public DisputeMessage $message
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Message in Dispute - Order #' . $this->dispute->order->order_number)
            ->line('You have received a new message in a dispute.')
            ->line('**From:** ' . $this->message->user->name)
            ->line('**Message:** ' . \Illuminate\Support\Str::limit($this->message->message, 100))
            ->action('View Dispute', route('disputes.show', $this->dispute))
            ->line('Please respond promptly to help resolve this dispute.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'dispute_id' => $this->dispute->id,
            'message_id' => $this->message->id,
            'order_number' => $this->dispute->order->order_number,
            'from_user' => $this->message->user->name,
            'message' => 'New message in dispute for order #' . $this->dispute->order->order_number,
        ];
    }
}


