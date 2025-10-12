<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ContentBlock extends Model
{
    protected $fillable = [
        'identifier',
        'page',
        'section',
        'order',
        'type',
        'title',
        'content',
        'metadata',
        'styling',
        'is_active',
        'visibility',
    ];

    protected $casts = [
        'metadata' => 'array',
        'styling' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get all active blocks for a page
     */
    public static function getByPage(string $page, ?string $section = null): \Illuminate\Database\Eloquent\Collection
    {
        $cacheKey = "content_blocks_{$page}" . ($section ? "_{$section}" : '');
        
        return Cache::remember($cacheKey, 3600, function () use ($page, $section) {
            $query = static::where('page', $page)
                ->where('is_active', true)
                ->orderBy('order');

            if ($section) {
                $query->where('section', $section);
            }

            return $query->get();
        });
    }

    /**
     * Get a specific block by identifier
     */
    public static function getByIdentifier(string $identifier)
    {
        return Cache::remember("content_block_{$identifier}", 3600, function () use ($identifier) {
            return static::where('identifier', $identifier)
                ->where('is_active', true)
                ->first();
        });
    }

    /**
     * Check if user can view this block based on visibility
     */
    public function canView(?User $user = null): bool
    {
        return match ($this->visibility) {
            'members_only' => $user !== null,
            'premium' => $user?->activeSubscription !== null,
            default => true,
        };
    }

    /**
     * Clear content blocks cache
     */
    public static function clearCache(): void
    {
        Cache::tags(['content_blocks'])->flush();
    }

    /**
     * Boot method to clear cache on save/delete
     */
    protected static function booted(): void
    {
        static::saved(function ($block) {
            Cache::forget("content_block_{$block->identifier}");
            Cache::forget("content_blocks_{$block->page}");
            Cache::forget("content_blocks_{$block->page}_{$block->section}");
        });

        static::deleted(function ($block) {
            Cache::forget("content_block_{$block->identifier}");
            Cache::forget("content_blocks_{$block->page}");
            Cache::forget("content_blocks_{$block->page}_{$block->section}");
        });
    }
}
