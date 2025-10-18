<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SocialAccountVerification extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'username',
        'verification_token',
        'expires_at',
        'is_verified',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'is_verified' => 'boolean',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
                    ->where('is_verified', false);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    // Static methods
    public static function generateToken(): string
    {
        return strtoupper(Str::random(6));
    }

    public static function createVerification(int $userId, string $platform, string $username): self
    {
        // Clean up any existing unverified tokens for this user/platform/username
        self::where('user_id', $userId)
            ->where('platform', $platform)
            ->where('username', $username)
            ->where('is_verified', false)
            ->delete();

        return self::create([
            'user_id' => $userId,
            'platform' => $platform,
            'username' => $username,
            'verification_token' => self::generateToken(),
            'expires_at' => now()->addMinutes(10),
        ]);
    }

    // Instance methods
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->is_verified && !$this->isExpired();
    }

    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    public function getTimeRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return $this->expires_at->diffInSeconds(now());
    }

    public function getFormattedTimeRemaining(): string
    {
        $seconds = $this->getTimeRemaining();
        
        if ($seconds <= 0) {
            return 'Expired';
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        return sprintf('%02d:%02d', $minutes, $remainingSeconds);
    }

    public function getAccountUrl(): string
    {
        $urls = [
            'Instagram' => 'https://www.instagram.com/',
            'TikTok' => 'https://www.tiktok.com/@',
            'X (Twitter)' => 'https://x.com/',
            'YouTube' => 'https://www.youtube.com/@',
            'Discord' => 'https://discord.com/users/',
            'Facebook' => 'https://www.facebook.com/',
            'Snapchat' => 'https://www.snapchat.com/add/',
            'Twitch' => 'https://www.twitch.tv/',
            'LinkedIn' => 'https://www.linkedin.com/in/',
            'Reddit' => 'https://www.reddit.com/user/',
        ];

        $baseUrl = $urls[$this->platform] ?? null;
        
        if (!$baseUrl) {
            return '#';
        }

        return $baseUrl . $this->username;
    }

    public function getBioCheckUrl(): string
    {
        // For now, we'll use a simple approach
        // In a real implementation, you might use platform APIs
        return $this->getAccountUrl();
    }
}
