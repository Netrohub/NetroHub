<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Jobs\RecalculateRatingAggregates;
use App\Models\Product;
use App\Models\Review;
use App\Notifications\NewReviewNotification;
use App\Notifications\ReviewReplyNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Show the review form for a product (AJAX endpoint).
     */
    public function form(Product $product)
    {
        // Check authorization via policy
        $this->authorize('createForProduct', [Review::class, $product]);

        // Check if user already has a review
        $existingReview = $product->reviews()
            ->where('reviewable_type', Product::class)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return view('components.review-form', [
                'product' => $product,
                'review' => $existingReview,
            ]);
        }

        return view('components.review-form', [
            'product' => $product,
        ]);
    }

    /**
     * Store a new review for a product.
     */
    public function store(StoreReviewRequest $request, Product $product)
    {
        // Check authorization via policy
        $this->authorize('createForProduct', [Review::class, $product]);

        // Create the review
        $review = Review::create([
            'user_id' => auth()->id(),
            'reviewable_type' => Product::class,
            'reviewable_id' => $product->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'body' => $request->body,
            'status' => 'approved', // Auto-approve for now, can add moderation later
        ]);

        // Notify the seller
        if ($product->seller && $product->seller->user) {
            $product->seller->user->notify(new NewReviewNotification($review));
        }

        // Dispatch job to recalculate ratings
        RecalculateRatingAggregates::dispatch($product);

        // Track analytics
        app(\App\Services\AnalyticsService::class)->trackReviewCreated($review);

        // Log activity
        \App\Models\ActivityLog::log('review_created', $review, "Created review for product: {$product->title}");

        return back()->with('success', 'Thank you for your review!');
    }

    /**
     * Update an existing review.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Recalculate ratings
        if ($review->reviewable_type === Product::class) {
            RecalculateRatingAggregates::dispatch($review->reviewable);
        }

        // Log activity
        \App\Models\ActivityLog::log('review_updated', $review, 'Updated review');

        return back()->with('success', 'Review updated successfully!');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $reviewable = $review->reviewable;

        $review->delete();

        // Recalculate ratings
        if ($reviewable && $reviewable instanceof Product) {
            RecalculateRatingAggregates::dispatch($reviewable);
        }

        // Log activity
        \App\Models\ActivityLog::log('review_deleted', null, 'Deleted review ID: '.$review->id);

        return back()->with('success', 'Review deleted successfully.');
    }

    /**
     * Add a reply to a review (seller or staff only).
     */
    public function reply(Request $request, Review $review)
    {
        $this->authorize('reply', $review);

        $request->validate([
            'replied_body' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $review->update([
            'replied_body' => $request->replied_body,
            'replied_by' => auth()->id(),
        ]);

        // Notify the review author
        $review->user->notify(new ReviewReplyNotification($review));

        // Log activity
        \App\Models\ActivityLog::log('review_replied', $review, 'Replied to review');

        return back()->with('success', 'Reply added successfully!');
    }

    /**
     * Report a review for moderation.
     */
    public function report(Review $review)
    {
        $this->authorize('report', $review);

        // Mark as reported
        $review->update([
            'reported_at' => now(),
        ]);

        // Log activity
        \App\Models\ActivityLog::log('review_reported', $review, 'Review reported by user ID: '.auth()->id());

        return back()->with('success', 'Review has been reported for moderation. Thank you.');
    }
}
