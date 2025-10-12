<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Review $review
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'review_id' => $this->review->id,
            'rating' => $this->review->rating,
            'title' => $this->review->title,
            'reviewer_name' => $this->review->user->name,
            'product_id' => $this->review->reviewable_id,
            'product_title' => $this->review->reviewable->title ?? 'Product',
            'message' => "{$this->review->user->name} left a {$this->review->rating}-star review on your product.",
        ];
    }
}
