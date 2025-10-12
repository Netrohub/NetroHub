<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanFeature extends Model
{
    protected $fillable = [
        'plan_id',
        'key',
        'label',
        'value_json',
        'sort_order',
        'is_new',
    ];

    protected function casts(): array
    {
        return [
            'value_json' => 'array',
            'sort_order' => 'integer',
            'is_new' => 'boolean',
        ];
    }

    // Relationships
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    // Accessors
    public function getValue()
    {
        return $this->value_json['value'] ?? null;
    }

    public function getType(): string
    {
        return $this->value_json['type'] ?? 'text';
    }

    public function isEnabled(): bool
    {
        if ($this->getType() === 'boolean') {
            return $this->getValue() === true;
        }

        return ! empty($this->getValue());
    }
}
