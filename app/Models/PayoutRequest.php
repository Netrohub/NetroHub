<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayoutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'amount',
        'status',
        'payout_method',
        'payout_details',
        'admin_notes',
        'transaction_reference',
        'processed_at',
        'processed_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payout_details' => 'array',
            'processed_at' => 'datetime',
        ];
    }

    // Relationships
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Business logic
    public function approve(User $admin, ?string $transactionRef = null): void
    {
        $this->update([
            'status' => 'completed',
            'processed_by' => $admin->id,
            'processed_at' => now(),
            'transaction_reference' => $transactionRef,
        ]);
    }

    public function reject(User $admin, ?string $reason = null): void
    {
        $this->update([
            'status' => 'rejected',
            'processed_by' => $admin->id,
            'processed_at' => now(),
            'admin_notes' => $reason,
        ]);
    }
}
