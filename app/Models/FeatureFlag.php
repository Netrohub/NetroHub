<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FeatureFlag extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'is_enabled',
        'environment',
        'rollout_percentage',
        'allowed_users',
        'allowed_roles',
        'enabled_at',
        'disabled_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'rollout_percentage' => 'integer',
        'allowed_users' => 'array',
        'allowed_roles' => 'array',
        'enabled_at' => 'datetime',
        'disabled_at' => 'datetime',
    ];

    /**
     * Check if a feature is enabled for a specific user
     */
    public static function isEnabled(string $key, ?User $user = null): bool
    {
        $flag = Cache::remember("feature_flag_{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$flag || !$flag->is_enabled) {
            return false;
        }

        // Check environment
        if ($flag->environment !== 'all' && $flag->environment !== app()->environment()) {
            return false;
        }

        // Check if specific user is allowed
        if ($user && $flag->allowed_users && count($flag->allowed_users) > 0) {
            if (!in_array($user->id, $flag->allowed_users)) {
                return false;
            }
        }

        // Check if user role is allowed
        if ($user && $flag->allowed_roles && count($flag->allowed_roles) > 0) {
            $userRole = $user->seller ? 'seller' : 'buyer';
            if ($user->hasRole('admin')) {
                $userRole = 'admin';
            }
            
            if (!in_array($userRole, $flag->allowed_roles)) {
                return false;
            }
        }

        // Check rollout percentage
        if ($flag->rollout_percentage < 100) {
            if ($user) {
                // Use user ID for consistent rollout
                $hash = crc32($user->id . $flag->key);
                $percentage = ($hash % 100) + 1;
                return $percentage <= $flag->rollout_percentage;
            }
            
            // For anonymous users, use random
            return rand(1, 100) <= $flag->rollout_percentage;
        }

        return true;
    }

    /**
     * Enable a feature flag
     */
    public function enable(): self
    {
        $this->update([
            'is_enabled' => true,
            'enabled_at' => now(),
            'disabled_at' => null,
        ]);

        Cache::forget("feature_flag_{$this->key}");
        
        return $this;
    }

    /**
     * Disable a feature flag
     */
    public function disable(): self
    {
        $this->update([
            'is_enabled' => false,
            'disabled_at' => now(),
        ]);

        Cache::forget("feature_flag_{$this->key}");
        
        return $this;
    }

    /**
     * Set rollout percentage
     */
    public function setRollout(int $percentage): self
    {
        $this->update([
            'rollout_percentage' => max(0, min(100, $percentage)),
        ]);

        Cache::forget("feature_flag_{$this->key}");
        
        return $this;
    }

    /**
     * Clear feature flags cache
     */
    public static function clearCache(): void
    {
        Cache::tags(['feature_flags'])->flush();
    }

    /**
     * Boot method to clear cache on save/delete
     */
    protected static function booted(): void
    {
        static::saved(function ($flag) {
            Cache::forget("feature_flag_{$flag->key}");
        });

        static::deleted(function ($flag) {
            Cache::forget("feature_flag_{$flag->key}");
        });
    }
}
