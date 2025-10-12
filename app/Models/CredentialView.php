<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CredentialView extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'order_item_id',
        'user_id',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    // Relationships
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a credential view with request metadata
     */
    public static function logView(OrderItem $orderItem, User $user, ?string $ip = null, ?string $userAgent = null): self
    {
        return self::create([
            'order_item_id' => $orderItem->id,
            'user_id' => $user->id,
            'ip_address' => $ip ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
            'viewed_at' => now(),
        ]);
    }
}
