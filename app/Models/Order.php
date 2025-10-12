<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'platform_fee',
        'total',
        'currency',
        'payment_method',
        'payment_intent_id',
        'paddle_transaction_id',
        'paddle_subscription_id',
        'webhook_data',
        'payment_status',
        'paid_at',
        'status',
        'buyer_email',
        'buyer_name',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'total' => 'decimal:2',
            'webhook_data' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'NH-'.strtoupper(uniqid());
            }
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'completed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Business logic
    public function markAsPaid(?string $paymentIntentId = null): void
    {
        $this->update([
            'payment_status' => 'completed',
            'payment_intent_id' => $paymentIntentId,
            'paid_at' => now(),
            'status' => 'processing',
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
        ]);
    }

    public function getUniqueSellers()
    {
        return $this->items()->with('seller')->get()->pluck('seller')->unique('id');
    }
}
