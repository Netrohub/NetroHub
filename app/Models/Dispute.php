<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispute extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_item_id',
        'buyer_id',
        'seller_id',
        'reason',
        'description',
        'status',
        'evidence',
        'admin_notes',
        'resolved_by',
        'resolved_at',
        'escalated_at',
    ];

    protected function casts(): array
    {
        return [
            'evidence' => 'array',
            'resolved_at' => 'datetime',
            'escalated_at' => 'datetime',
        ];
    }

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DisputeMessage::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeEscalated($query)
    {
        return $query->whereIn('status', ['escalated', 'in_review']);
    }

    public function scopeInReview($query)
    {
        return $query->where('status', 'in_review');
    }

    public function scopeBetweenParties($query)
    {
        return $query->whereIn('status', ['open', 'resolved']);
    }

    // Business logic
    public function escalate(): void
    {
        $this->update([
            'status' => 'escalated',
            'escalated_at' => now(),
        ]);
    }

    public function markResolvedByBuyer(): void
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }

    public function resolve(User $admin, string $status, ?string $notes = null): void
    {
        $this->update([
            'status' => $status,
            'admin_notes' => $notes,
            'resolved_by' => $admin->id,
            'resolved_at' => now(),
        ]);
    }

    public function isEscalated(): bool
    {
        return in_array($this->status, ['escalated', 'in_review']);
    }

    public function canEscalate(): bool
    {
        return in_array($this->status, ['open']);
    }
}
