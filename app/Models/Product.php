<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'category_id',
        'type',
        'game_title',
        'platform',
        'social_username',
        'title',
        'slug',
        'description',
        'features',
        'tags',
        'metadata',
        'general_checklist',
        'whiteout_survival_checklist',
        'price',
        'delivery_type',
        'delivery_credentials',
        'is_unique_credential',
        'verification_status',
        'thumbnail_url',
        'gallery_urls',
        'stock_count',
        'purchase_limit',
        'status',
        'is_featured',
        'views_count',
        'sales_count',
        'rating',
        'reviews_count',
        'rating_avg',
        'rating_count',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'tags' => 'array',
            'metadata' => 'array',
            'general_checklist' => 'array',
            'whiteout_survival_checklist' => 'array',
            'gallery_urls' => 'array',
            'delivery_credentials' => 'encrypted:array',
            'is_unique_credential' => 'boolean',
            'price' => 'decimal:2',
            'stock_count' => 'integer',
            'purchase_limit' => 'integer',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
            'sales_count' => 'integer',
            'rating' => 'decimal:2',
            'reviews_count' => 'integer',
            'rating_avg' => 'decimal:2',
            'rating_count' => 'integer',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title).'-'.Str::random(6);
            }
        });
    }

    // Relationships
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProductFile::class);
    }

    public function codes(): HasMany
    {
        return $this->hasMany(ProductCode::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('delivery_type', 'file')
                ->orWhere(function ($sq) {
                    $sq->where('delivery_type', 'code')
                        ->where('stock_count', '>', 0);
                });
        });
    }

    // Business logic
    public function isInStock(): bool
    {
        if ($this->delivery_type === 'file') {
            return true;
        }

        if ($this->delivery_type === 'code') {
            return $this->codes()->where('status', 'available')->count() > 0;
        }

        return false;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementSales(): void
    {
        $this->increment('sales_count');
        $this->seller->increment('total_sales');
    }

    public function recalculateRating(): void
    {
        $reviews = $this->reviews()->where('status', 'approved');

        $this->update([
            'rating_avg' => $reviews->avg('rating') ?? 0,
            'rating_count' => $reviews->count(),
        ]);
    }

    // Keep old method for backwards compatibility
    public function updateRating(): void
    {
        $this->recalculateRating();
    }

    public function getAvailableCodesCount(): int
    {
        return $this->codes()->where('status', 'available')->count();
    }

    /**
     * Check if product has credentials for delivery
     */
    public function hasCredentials(): bool
    {
        return ! empty($this->delivery_credentials) &&
               isset($this->delivery_credentials['username']) &&
               isset($this->delivery_credentials['password']);
    }

    /**
     * Check if this product is available for sale (for unique credentials)
     */
    public function isAvailableForSale(): bool
    {
        if (! $this->is_unique_credential) {
            return $this->status === 'active';
        }

        // For unique credentials, check if not already claimed
        $claimed = $this->orderItems()
            ->whereNotNull('credential_claimed_at')
            ->exists();

        return $this->status === 'active' && ! $claimed;
    }

    /**
     * Mark product as sold out (for unique credentials)
     */
    public function markAsSoldOut(): void
    {
        if ($this->is_unique_credential) {
            $this->update([
                'status' => 'archived',
                'stock_count' => 0,
            ]);
        }
    }

    /**
     * Get social media URL for the account
     */
    public function getSocialMediaUrl(): ?string
    {
        if (!$this->platform || !$this->social_username) {
            return null;
        }

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
            return null;
        }

        // Handle special cases
        if ($this->platform === 'Reddit') {
            return $baseUrl . $this->social_username;
        }

        return $baseUrl . $this->social_username;
    }

    /**
     * Check if this product has social media information
     */
    public function hasSocialMedia(): bool
    {
        return !empty($this->platform) && !empty($this->social_username);
    }
}
