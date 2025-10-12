<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price_month',
        'price_year',
        'currency',
        'paddle_price_id_month',
        'paddle_price_id_year',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_month' => 'decimal:2',
            'price_year' => 'decimal:2',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Relationships
    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class)->orderBy('sort_order');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // Business logic
    public function isFree(): bool
    {
        return $this->slug === 'free';
    }

    public function getPrice(string $interval = 'monthly'): float
    {
        return $interval === 'yearly' ? $this->price_year : $this->price_month;
    }

    public function getPaddlePriceId(string $interval = 'monthly'): ?string
    {
        return $interval === 'yearly' ? $this->paddle_price_id_year : $this->paddle_price_id_month;
    }

    public function getFeatureValue(string $key, $default = null)
    {
        $feature = $this->features()->where('key', $key)->first();

        if (! $feature) {
            return $default;
        }

        return $feature->value_json['value'] ?? $default;
    }

    public function getMonthlySavings(): float
    {
        if ($this->price_year <= 0) {
            return 0;
        }

        $yearlyMonthly = $this->price_year / 12;

        return max(0, $this->price_month - $yearlyMonthly);
    }

    public function getAnnualSavingsPercentage(): int
    {
        if ($this->price_month <= 0 || $this->price_year <= 0) {
            return 0;
        }

        $yearlyTotal = $this->price_month * 12;
        $savings = $yearlyTotal - $this->price_year;

        return (int) round(($savings / $yearlyTotal) * 100);
    }
}
