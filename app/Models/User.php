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
        $adminRoles = ['SuperAdmin', 'Moderator', 'Finance', 'Support', 'Content', 'owner'];
        return $this->hasAnyRole($adminRoles);
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

    /**
     * Get user's plan name
     */
    public function getPlanName(): string
    {
        return $this->entitlementsService()->getPlanName($this);
    }

    /**
     * Check if user is on free plan
     */
    public function isFreePlan(): bool
    {
        return $this->entitlementsService()->isFreePlan($this);
    }

    /**
     * Check if user is on plus plan
     */
    public function isPlusPlan(): bool
    {
        return $this->entitlementsService()->isPlusPlan($this);
    }

    /**
     * Check if user is on pro plan
     */
    public function isProPlan(): bool
    {
        return $this->entitlementsService()->isProPlan($this);
    }

    /**
     * Check if user can boost products
     */
    public function canBoostProduct(): bool
    {
        return $this->entitlementsService()->canBoostProduct($this);
    }

    /**
     * Check if user can create more products (draft limit)
     */
    public function canCreateProduct(): bool
    {
        return $this->entitlementsService()->canCreateProduct($this);
    }

    /**
     * Get subscription badge HTML
     */
    public function getSubscriptionBadge(): string
    {
        $badgeType = $this->getBadgeType();
        
        if ($badgeType === 'pro') {
            return '<span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full shadow-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        PRO
                    </span>';
        }
        
        if ($badgeType === 'plus') {
            return '<span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs font-bold rounded-full shadow-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        PLUS
                    </span>';
        }
        
        return '';
    }

    public function getAvatarUrlAttribute($value): string
    {
        // Priority 1: If user has uploaded an avatar (avatar field), use that
        if (!empty($this->attributes['avatar'])) {
            $avatarPath = $this->attributes['avatar'];
            
            // Check if it's already a full URL
            if (filter_var($avatarPath, FILTER_VALIDATE_URL)) {
                return $avatarPath;
            }

            // Determine which disk to use - check if S3 is properly configured
            $defaultDisk = config('filesystems.default');
            $disk = 'public'; // Default to public
            
            if ($defaultDisk === 's3' && config('filesystems.disks.s3.region') && config('filesystems.disks.s3.key')) {
                $disk = 's3';
            }

            // Generate URL based on disk
            try {
                if ($disk === 's3') {
                    // For S3, use the URL method
                    return Storage::disk('s3')->url($avatarPath);
                } else {
                    // For public disk, check if file exists
                    $fullPath = storage_path('app/public/' . $avatarPath);
                    if (file_exists($fullPath)) {
                        // Add timestamp to prevent caching
                        return asset('storage/' . $avatarPath) . '?v=' . filemtime($fullPath);
                    }
                    // Fallback without cache busting
                    return asset('storage/' . $avatarPath) . '?v=' . time();
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to generate avatar URL from avatar field', [
                    'user_id' => $this->id,
                    'avatar' => $avatarPath,
                    'disk' => $disk,
                    'error' => $e->getMessage(),
                ]);

                // Fallback: try asset path with cache busting
                return asset('storage/' . $avatarPath) . '?v=' . time();
            }
        }

        // Priority 2: Use the avatar_url field (for external URLs like OAuth providers)
        if (!empty($value)) {
            return $value;
        }

        // Default avatar
        return asset('img/default-avatar.svg');
    }

    /**
     * Send the email verification notification using Brevo.
     */
    public function sendEmailVerificationNotification(): void
    {
        try {
            // Use Brevo if configured
            if (config('services.brevo.key') && config('services.brevo.verify_template_id')) {
                $brevoMailer = app(\App\Services\BrevoMailer::class);
                $urlGenerator = app(\App\Actions\Auth\MakeEmailVerificationUrl::class);
                
                $verificationUrl = $urlGenerator($this);
                
                $brevoMailer->sendEmailVerification(
                    $this->email,
                    $this->name ?? 'User',
                    $verificationUrl
                );
                
                \Log::info('Brevo verification email sent via sendEmailVerificationNotification', [
                    'user_id' => $this->id,
                ]);
            } else {
                // Fallback to default Laravel notification
                $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
                
                \Log::info('Fallback Laravel verification email sent', [
                    'user_id' => $this->id,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send email verification', [
                'user_id' => $this->id,
                'error' => $e->getMessage(),
            ]);
            
            // Fallback to default
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        }
    }

}
