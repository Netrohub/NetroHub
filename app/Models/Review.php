<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'rating',
        'title',
        'body',
        'status',
        'reported_at',
        'replied_body',
        'replied_by',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'reported_at' => 'datetime',
        ];
    }

    // Polymorphic relationship
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    // Author of the review
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Author of the reply
    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRecent($query)
    {
        return $query->latest();
    }

    public function scopeReported($query)
    {
        return $query->whereNotNull('reported_at');
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('reviewable_type', Product::class)
            ->where('reviewable_id', $productId);
    }

    // Helpers
    public function isReported(): bool
    {
        return ! is_null($this->reported_at);
    }

    public function hasReply(): bool
    {
        return ! is_null($this->replied_body);
    }

    public function isVerifiedPurchase(): bool
    {
        if ($this->reviewable_type !== Product::class) {
            return false;
        }

        // Check if user actually purchased this product
        return OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', $this->user_id)
                ->where('payment_status', 'completed');
        })->where('product_id', $this->reviewable_id)
            ->exists();
    }

    // Events
    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            if ($review->reviewable_type === Product::class) {
                $review->reviewable->recalculateRating();
            }
        });

        static::updated(function ($review) {
            if ($review->reviewable_type === Product::class) {
                $review->reviewable->recalculateRating();
            }
        });

        static::deleted(function ($review) {
            if ($review->reviewable_type === Product::class && $review->reviewable) {
                $review->reviewable->recalculateRating();
            }
        });
    }
}
