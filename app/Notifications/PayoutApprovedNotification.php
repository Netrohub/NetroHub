<?php

namespace App\Notifications;

use App\Models\PayoutRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public PayoutRequest $payoutRequest) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payout Approved')
            ->greeting('Good News!')
            ->line('Your payout request has been approved.')
            ->line('Amount: $'.number_format($this->payoutRequest->amount, 2))
            ->line('The funds should arrive within 3-5 business days.')
            ->action('View Payouts', route('seller.payouts.index'))
            ->line('Thank you for being part of NetroHub!');
    }
}
