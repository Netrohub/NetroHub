<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ContentModerationService
{
    /**
     * Profanity and inappropriate content keywords
     */
    protected array $bannedWords = [
        'porn', 'xxx', 'nude', 'naked', 'sex', 'nsfw', 'dick', 'cock', 'pussy', 
        'vagina', 'penis', 'fuck', 'shit', 'ass', 'bitch', 'bastard', 'damn',
        'hell', 'cunt', 'whore', 'slut', 'nigger', 'faggot', 'rape', 'violence',
        'gore', 'blood', 'kill', 'death', 'suicide', 'terrorist', 'bomb', 'weapon',
        'drug', 'cocaine', 'heroin', 'meth', 'weed', 'marijuana', 'cannabis'
    ];

    /**
     * Check if text contains profanity or inappropriate content
     */
    public function containsProfanity(string $text): bool
    {
        $text = strtolower($text);
        
        foreach ($this->bannedWords as $word) {
            if (str_contains($text, $word)) {
                Log::warning('Profanity detected in text', [
                    'matched_word' => $word,
                ]);
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if filename contains inappropriate content
     */
    public function isImageFilenameInappropriate(UploadedFile $file): bool
    {
        $filename = strtolower($file->getClientOriginalName());
        
        return $this->containsProfanity($filename);
    }

    /**
     * Basic image content check (checks EXIF data and file properties)
     */
    public function isImageInappropriate(UploadedFile $file): bool
    {
        try {
            // Check filename first
            if ($this->isImageFilenameInappropriate($file)) {
                return true;
            }

            // Check if file is actually an image
            $mimeType = $file->getMimeType();
            if (!str_starts_with($mimeType, 'image/')) {
                Log::warning('Non-image file uploaded as image', [
                    'filename' => $file->getClientOriginalName(),
                    'mime_type' => $mimeType,
                ]);
                return true;
            }

            // Check file size (anything over 10MB is suspicious for game screenshots)
            $maxSize = 10 * 1024 * 1024; // 10MB
            if ($file->getSize() > $maxSize) {
                Log::warning('Image file too large', [
                    'filename' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);
                return true;
            }

            // Check EXIF data for inappropriate tags (if JPEG)
            if (function_exists('exif_read_data') && in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg'])) {
                try {
                    $exif = @exif_read_data($file->getRealPath());
                    if ($exif && isset($exif['ImageDescription'])) {
                        if ($this->containsProfanity($exif['ImageDescription'])) {
                            return true;
                        }
                    }
                } catch (\Exception $e) {
                    // EXIF reading failed, continue
                }
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Image moderation check failed', [
                'filename' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);
            
            // On error, flag for manual review
            return true;
        }
    }

    /**
     * Sanitize text by removing profanity
     */
    public function sanitizeText(string $text): string
    {
        $sanitized = $text;
        
        foreach ($this->bannedWords as $word) {
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';
            $sanitized = preg_replace($pattern, str_repeat('*', strlen($word)), $sanitized);
        }
        
        return $sanitized;
    }

    /**
     * Get moderation suggestions for admin review
     */
    public function getModerationFlags(UploadedFile $file): array
    {
        $flags = [];

        if ($this->isImageFilenameInappropriate($file)) {
            $flags[] = 'Inappropriate filename';
        }

        if ($file->getSize() > 10 * 1024 * 1024) {
            $flags[] = 'File size exceeds 10MB';
        }

        $mimeType = $file->getMimeType();
        if (!str_starts_with($mimeType, 'image/')) {
            $flags[] = 'Invalid file type';
        }

        return $flags;
    }
}


