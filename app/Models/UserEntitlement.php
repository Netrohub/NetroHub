<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEntitlement extends Model
{
    protected $fillable = [
        'user_id',
        'key',
        'value_int',
        'value_bool',
        'value_decimal',
        'value_string',
        'reset_period',
        'period_start',
        'period_end',
    ];

    protected function casts(): array
    {
        return [
            'value_int' => 'integer',
            'value_bool' => 'boolean',
            'value_decimal' => 'decimal:2',
            'period_start' => 'datetime',
            'period_end' => 'datetime',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getValue()
    {
        if ($this->value_int !== null) {
            return $this->value_int;
        }
        if ($this->value_bool !== null) {
            return $this->value_bool;
        }
        if ($this->value_decimal !== null) {
            return $this->value_decimal;
        }

        return $this->value_string;
    }

    public function setValue($value): void
    {
        // Clear all value fields first
        $this->value_int = null;
        $this->value_bool = null;
        $this->value_decimal = null;
        $this->value_string = null;

        // Set the appropriate field based on type
        if (is_bool($value)) {
            $this->value_bool = $value;
        } elseif (is_int($value)) {
            $this->value_int = $value;
        } elseif (is_float($value) || is_numeric($value)) {
            $this->value_decimal = $value;
        } else {
            $this->value_string = $value;
        }
    }

    // Business logic
    public function needsReset(): bool
    {
        if ($this->reset_period === 'never') {
            return false;
        }

        if (! $this->period_end) {
            return true;
        }

        return now()->isAfter($this->period_end);
    }

    public function resetPeriod(): void
    {
        $start = now();
        $end = null;

        if ($this->reset_period === 'monthly') {
            $end = $start->copy()->addMonth();
        } elseif ($this->reset_period === 'yearly') {
            $end = $start->copy()->addYear();
        }

        $this->update([
            'period_start' => $start,
            'period_end' => $end,
        ]);
    }

    public function decrementValue(int $amount = 1): bool
    {
        if ($this->value_int === null || $this->value_int < $amount) {
            return false;
        }

        $this->value_int -= $amount;
        $this->save();

        return true;
    }

    public function incrementValue(int $amount = 1): void
    {
        if ($this->value_int === null) {
            $this->value_int = 0;
        }

        $this->value_int += $amount;
        $this->save();
    }
}
