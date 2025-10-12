<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'code',
        'status',
        'claimed_by_user_id',
        'order_item_id',
        'claimed_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'claimed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function claimedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by_user_id');
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Business logic
    public function claim(User $user, OrderItem $orderItem): bool
    {
        // Use database-level locking to prevent race conditions
        $updated = \DB::transaction(function () use ($user, $orderItem) {
            // Lock the row for update
            $code = ProductCode::where('id', $this->id)
                ->where('status', 'available')
                ->lockForUpdate()
                ->first();

            if (! $code) {
                return false; // Code already claimed or doesn't exist
            }

            $code->update([
                'status' => 'claimed',
                'claimed_by_user_id' => $user->id,
                'order_item_id' => $orderItem->id,
                'claimed_at' => now(),
            ]);

            return true;
        });

        if ($updated) {
            // Check for low stock after successful claim
            $this->checkLowStockNotification();
        }

        return $updated;
    }

    /**
     * Check if product is running low on codes and send notification
     */
    private function checkLowStockNotification(): void
    {
        $product = $this->product;
        $availableCodes = $product->codes()->available()->count();

        // Send notification if less than 5 codes available
        if ($availableCodes <= 5 && $availableCodes > 0) {
            $this->sendLowStockNotification($product, $availableCodes);
        }
    }

    /**
     * Send low stock notification to seller
     */
    private function sendLowStockNotification(Product $product, int $availableCount): void
    {
        $seller = $product->seller;

        if ($seller && $seller->user) {
            try {
                $seller->user->notify(new \App\Notifications\LowStockNotification($product, $availableCount));
            } catch (\Exception $e) {
                \Log::error('Failed to send low stock notification', [
                    'product_id' => $product->id,
                    'seller_id' => $seller->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
