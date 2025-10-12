<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CopyString extends Model
{
    protected $fillable = [
        'key',
        'value',
        'locale',
        'group',
        'description',
    ];

    public static function trans(string $key, string $locale = 'en', $default = null)
    {
        return Cache::remember("copy.{$locale}.{$key}", 3600, function () use ($key, $locale, $default) {
            $copy = self::where('key', $key)->where('locale', $locale)->first();
            return $copy?->value ?? $default ?? $key;
        });
    }

    public static function clearCache(): void
    {
        Cache::tags(['copy_strings'])->flush();
    }
}

