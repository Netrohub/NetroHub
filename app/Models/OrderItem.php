<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'product_title',
        'price',
        'seller_amount',
        'platform_commission',
        'quantity',
        'delivery_type',
        'delivery_payload',
        'is_delivered',
        'delivered_at',
        'credential_claimed_at',
        'credential_view_count',
        'credential_view_limit',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'seller_amount' => 'decimal:2',
            'platform_commission' => 'decimal:2',
            'quantity' => 'integer',
            'delivery_payload' => 'array',
            'is_delivered' => 'boolean',
            'delivered_at' => 'datetime',
            'credential_claimed_at' => 'datetime',
            'credential_view_count' => 'integer',
            'credential_view_limit' => 'integer',
        ];
    }

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function codes(): HasMany
    {
        return $this->hasMany(ProductCode::class);
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function credentialViews(): HasMany
    {
        return $this->hasMany(CredentialView::class);
    }

    // Business logic
    public function markAsDelivered(array $payload): void
    {
        $this->update([
            'delivery_payload' => $payload,
            'is_delivered' => true,
            'delivered_at' => now(),
        ]);
    }

    public function canReview(): bool
    {
        return $this->is_delivered && ! $this->review()->exists();
    }

    /**
     * Atomically claim credentials for this order item
     */
    public function claimCredentials(): bool
    {
        if ($this->credential_claimed_at) {
            return false; // Already claimed
        }

        $product = $this->product;

        if (! $product || ! $product->is_unique_credential) {
            // Non-unique credentials don't need claiming
            return true;
        }

        // Atomically claim the credential
        $updated = self::where('id', $this->id)
            ->whereNull('credential_claimed_at')
            ->update([
                'credential_claimed_at' => now(),
            ]);

        if ($updated) {
            $this->refresh();
            // Mark product as sold out
            $product->markAsSoldOut();

            return true;
        }

        return false;
    }

    /**
     * Check if credentials can be viewed
     */
    public function canViewCredentials(): bool
    {
        $product = $this->product;

        if (! $product || ! $product->hasCredentials()) {
            return false;
        }

        // Check if order is paid
        if ($this->order->payment_status !== 'completed') {
            return false;
        }

        // Check view limit
        if ($this->credential_view_count >= $this->credential_view_limit) {
            return false;
        }

        return true;
    }

    /**
     * Increment view count and log the view
     */
    public function recordCredentialView(User $user, ?string $ip = null, ?string $userAgent = null): void
    {
        $this->increment('credential_view_count');

        CredentialView::logView($this, $user, $ip, $userAgent);
    }

    /**
     * Get remaining views
     */
    public function getRemainingViews(): int
    {
        return max(0, $this->credential_view_limit - $this->credential_view_count);
    }

    /**
     * Check if this order item has credentials
     */
    public function hasCredentials(): bool
    {
        return $this->product && $this->product->hasCredentials();
    }
}
