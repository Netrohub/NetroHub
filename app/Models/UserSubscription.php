<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'paddle_subscription_id',
        'status',
        'interval',
        'period_start',
        'period_end',
        'cancel_at',
        'renews_at',
        'is_gifted',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'datetime',
            'period_end' => 'datetime',
            'cancel_at' => 'datetime',
            'renews_at' => 'datetime',
            'is_gifted' => 'boolean',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePastDue($query)
    {
        return $query->where('status', 'past_due');
    }

    // Business logic
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled' || $this->cancel_at !== null;
    }

    public function willRenew(): bool
    {
        return $this->isActive() && ! $this->isCancelled() && $this->renews_at !== null;
    }

    public function daysUntilRenewal(): int
    {
        if (! $this->renews_at) {
            return 0;
        }

        return max(0, now()->diffInDays($this->renews_at, false));
    }

    public function canUpgrade(Plan $newPlan): bool
    {
        return $newPlan->price_month > $this->plan->price_month;
    }

    public function canDowngrade(Plan $newPlan): bool
    {
        return $newPlan->price_month < $this->plan->price_month;
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancel_at' => $this->period_end ?? now(),
        ]);
    }

    public function resume(): void
    {
        $this->update([
            'status' => 'active',
            'cancel_at' => null,
        ]);
    }
}
