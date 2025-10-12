<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine if the user can create a review for a product.
     */
    public function createForProduct(User $user, Product $product): bool
    {
        // Check if user has purchased this product in a completed order
        $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('payment_status', 'completed');
        })->where('product_id', $product->id)->exists();

        if (! $hasPurchased) {
            return false;
        }

        // Check if user hasn't already reviewed this product
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('reviewable_type', Product::class)
            ->where('reviewable_id', $product->id)
            ->exists();

        return ! $alreadyReviewed;
    }

    /**
     * Determine if the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        // Only the author can update their own review
        return $user->id === $review->user_id;
    }

    /**
     * Determine if the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        // Author can delete their own review, or admins can delete any review
        return $user->id === $review->user_id || $user->hasRole('admin');
    }

    /**
     * Determine if the user can reply to a review.
     */
    public function reply(User $user, Review $review): bool
    {
        // Staff/admins can reply to any review
        if ($user->hasRole(['admin', 'staff'])) {
            return true;
        }

        // For product reviews, the product's seller can reply
        if ($review->reviewable_type === Product::class) {
            $product = $review->reviewable;

            return $product && $product->seller_id === $user->seller?->id;
        }

        return false;
    }

    /**
     * Determine if the user can report a review.
     */
    public function report(User $user, Review $review): bool
    {
        // Any authenticated user except the review author can report
        return $user->id !== $review->user_id;
    }
}
