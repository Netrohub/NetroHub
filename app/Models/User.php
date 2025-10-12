<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasRoles, Notifiable, \App\Traits\HasFeatureGates;

    protected static function booted(): void
    {
        // Automatically assign free plan to new users
        static::created(function (User $user) {
            $entitlementsService = app(\App\Services\EntitlementsService::class);
            $freePlan = \App\Models\Plan::where('slug', 'free')->first();

            if ($freePlan) {
                \App\Models\UserSubscription::create([
                    'user_id' => $user->id,
                    'plan_id' => $freePlan->id,
                    'status' => 'active',
                    'interval' => 'monthly',
                    'period_start' => now(),
                ]);

                $entitlementsService->regenerateEntitlements($user);
            }
        });
    }

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'is_verified',
        'phone_number',
        'phone_verified_at',
        'password',
        'avatar_url',
        'avatar',
        'is_active',
        'paddle_customer_id',
        'privacy_mode',
        'phone_verified_at',
        'phone_verification_code',
        'phone_verification_code_expires_at',
        'provider',
        'provider_id',
        'is_banned',
        'banned_reason',
        'banned_at',
        'banned_by',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'phone_verification_code_expires_at' => 'datetime',
        'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'privacy_mode' => 'boolean',
            'is_banned' => 'boolean',
            'banned_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    // Relationships
    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(UserSubscription::class)->where('status', 'active')->latest();
    }

    public function entitlements(): HasMany
    {
        return $this->hasMany(UserEntitlement::class);
    }

    public function products(): HasMany
    {
        return $this->hasManyThrough(Product::class, Seller::class);
    }

    public function kycSubmissions(): HasMany
    {
        return $this->hasMany(KycSubmission::class);
    }

    public function latestKycSubmission(): HasOne
    {
        return $this->hasOne(KycSubmission::class)->latest();
    }

    // Helper methods
    public function isSeller(): bool
    {
        return $this->seller !== null;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    public function isPhoneVerified(): bool
    {
        return $this->phone_verified_at !== null;
    }

    public function canSell(): bool
    {
        return $this->is_verified;
    }

    public function getVerificationStatusBadge(): string
    {
        if ($this->is_verified) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified</span>';
        }
        
        $latestKyc = $this->latestKycSubmission;
        if ($latestKyc) {
            return match($latestKyc->status) {
                'pending' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Under Review</span>',
                'rejected' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>',
                default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Not Verified</span>',
            };
        }
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Not Verified</span>';
    }

    public function getPhoneVerificationStatusBadge(): string
    {
        if ($this->isPhoneVerified()) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Verified ✅</span>';
        }
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Not Verified</span>';
    }

    /**
     * Get user's current subscription plan
     */
    public function currentPlan(): ?\App\Models\Plan
    {
        return $this->activeSubscription?->plan;
    }

    /**
     * Get entitlements service instance
     */
    protected function entitlementsService(): \App\Services\EntitlementsService
    {
        return app(\App\Services\EntitlementsService::class);
    }

    /**
     * Check if user can use a feature based on entitlements
     */
    public function canUse(string $key): bool
    {
        return $this->entitlementsService()->canUse($this, $key);
    }

    /**
     * Get user's badge type (plus/pro/null)
     */
    public function getBadgeType(): ?string
    {
        return $this->entitlementsService()->getBadgeType($this);
    }

    /**
     * Get platform fee percentage for seller
     */
    public function getPlatformFee(): float
    {
        return $this->entitlementsService()->getPlatformFee($this);
    }

    /**
     * Check if user has priority support
     */
    public function hasPrioritySupport(): bool
    {
        return $this->entitlementsService()->hasPrioritySupport($this);
    }

    /**
     * Check if user has featured placement
     */
    public function hasFeaturedPlacement(): bool
    {
        return $this->entitlementsService()->hasFeaturedPlacement($this);
    }

    /**
     * Get remaining boost slots
     */
    public function getRemainingBoosts(): int
    {
        return $this->entitlementsService()->getRemainingBoosts($this);
    }

    /**
     * Get draft limit
     */
    public function getDraftLimit(): int
    {
        return $this->entitlementsService()->getDraftLimit($this);
    }

    public function getAvatarUrlAttribute($value): string
    {
        // If user has uploaded an avatar, use that
        if ($this->avatar) {
            // Check if it's already a full URL
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }

            // Determine which disk to use
            $disk = config('filesystems.default') === 's3' ? 's3' : 'public';

            // Generate URL based on disk
            try {
                if ($disk === 's3') {
                    return Storage::disk('s3')->url($this->avatar);
                } else {
                    // For public disk, use asset path
                    return asset('storage/'.$this->avatar);
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to generate avatar URL', [
                    'user_id' => $this->id,
                    'avatar' => $this->avatar,
                    'disk' => $disk,
                    'error' => $e->getMessage(),
                ]);

                // Fallback: try asset path
                return asset('storage/'.$this->avatar);
            }
        }

        // Use the avatar_url field (for external URLs)
        if ($value) {
            return $value;
        }

        // Default avatar
        return asset('img/default-avatar.svg');
    }

}
