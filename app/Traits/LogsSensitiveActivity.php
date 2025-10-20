<?php

namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

trait LogsSensitiveActivity
{
    use LogsActivity;

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->getLoggableAttributes())
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => $this->getActivityDescription($eventName));
    }

    /**
     * Get attributes that should be logged
     */
    protected function getLoggableAttributes(): array
    {
        return array_diff($this->fillable, $this->getSensitiveAttributes());
    }

    /**
     * Get sensitive attributes that should be masked
     */
    protected function getSensitiveAttributes(): array
    {
        return [
            'password',
            'password_confirmation',
            'remember_token',
            'api_token',
            'phone',
            'id_number',
            'ssn',
            'credit_card_number',
            'bank_account_number',
            'secret_key',
            'private_key'
        ];
    }

    /**
     * Get activity description
     */
    protected function getActivityDescription(string $eventName): string
    {
        $modelName = class_basename($this);
        
        return match($eventName) {
            'created' => "{$modelName} was created",
            'updated' => "{$modelName} was updated",
            'deleted' => "{$modelName} was deleted",
            'restored' => "{$modelName} was restored",
            default => "{$modelName} {$eventName}"
        };
    }

    /**
     * Override to mask sensitive data before logging
     */
    public function tapActivity(\Spatie\Activitylog\Contracts\Activity $activity, string $eventName): void
    {
        $properties = $activity->properties;
        
        // Mask sensitive attributes in old values
        if ($properties->has('old')) {
            $old = $properties->get('old');
            foreach ($this->getSensitiveAttributes() as $attribute) {
                if (isset($old[$attribute])) {
                    $old[$attribute] = $this->maskSensitiveValue($old[$attribute]);
                }
            }
            $properties->put('old', $old);
        }
        
        // Mask sensitive attributes in new values
        if ($properties->has('attributes')) {
            $attributes = $properties->get('attributes');
            foreach ($this->getSensitiveAttributes() as $attribute) {
                if (isset($attributes[$attribute])) {
                    $attributes[$attribute] = $this->maskSensitiveValue($attributes[$attribute]);
                }
            }
            $properties->put('attributes', $attributes);
        }
        
        $activity->properties = $properties;
    }

    /**
     * Mask sensitive values
     */
    protected function maskSensitiveValue($value): string
    {
        if (empty($value)) {
            return '[EMPTY]';
        }
        
        $length = strlen($value);
        
        if ($length <= 4) {
            return str_repeat('*', $length);
        }
        
        return substr($value, 0, 2) . str_repeat('*', $length - 4) . substr($value, -2);
    }
}
