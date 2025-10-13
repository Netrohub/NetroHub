<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Translation extends Model
{
    protected $fillable = [
        'key',
        'en',
        'ar',
        'group',
        'description',
    ];

    /**
     * Sync translations to JSON files
     */
    public static function syncToFiles(): void
    {
        $translations = static::all();
        
        $enTranslations = [];
        $arTranslations = [];
        
        foreach ($translations as $translation) {
            $enTranslations[$translation->key] = $translation->en;
            $arTranslations[$translation->key] = $translation->ar;
        }
        
        File::put(
            lang_path('en.json'),
            json_encode($enTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
        
        File::put(
            lang_path('ar.json'),
            json_encode($arTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * Import translations from JSON files
     */
    public static function importFromFiles(): void
    {
        $enPath = lang_path('en.json');
        $arPath = lang_path('ar.json');
        
        if (!File::exists($enPath) || !File::exists($arPath)) {
            return;
        }
        
        $enTranslations = json_decode(File::get($enPath), true);
        $arTranslations = json_decode(File::get($arPath), true);
        
        foreach ($enTranslations as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                [
                    'en' => $value,
                    'ar' => $arTranslations[$key] ?? '',
                ]
            );
        }
    }
}
