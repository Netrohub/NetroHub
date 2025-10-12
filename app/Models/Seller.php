<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'display_name',
        'bio',
        'avatar_url',
        'banner_url',
        'kyc_status',
        'kyc_documents',
        'kyc_notes',
        'kyc_submitted_at',
        'kyc_reviewed_at',
        'kyc_full_name',
        'kyc_date_of_birth',
        'kyc_country',
        'kyc_id_type',
        'kyc_id_number',
        'kyc_id_front_url',
        'kyc_id_back_url',
        'kyc_rejection_reason',
        'kyc_reviewed_by',
        'is_active',
        'rating',
        'total_sales',
        'payout_method',
        'payout_details',
    ];

    protected function casts(): array
    {
        return [
            'kyc_documents' => 'array',
            'payout_details' => 'array',
            'kyc_submitted_at' => 'datetime',
            'kyc_reviewed_at' => 'datetime',
            'kyc_date_of_birth' => 'date',
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
            'total_sales' => 'integer',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function payoutRequests(): HasMany
    {
        return $this->hasMany(PayoutRequest::class);
    }

    public function kycVerificationAttempts(): HasMany
    {
        return $this->hasMany(KycVerificationAttempt::class);
    }

    public function kycReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kyc_reviewed_by');
    }

    // KYC Verification Methods
    public function isKycVerified(): bool
    {
        return $this->kyc_status === 'approved';
    }

    public function isKycPending(): bool
    {
        return $this->kyc_status === 'pending';
    }

    public function isKycRejected(): bool
    {
        return $this->kyc_status === 'rejected';
    }

    public function canSell(): bool
    {
        return $this->is_active && $this->isKycVerified();
    }

    public function getKycStatusBadge(): string
    {
        return match($this->kyc_status) {
            'approved' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Verified</span>',
            'pending' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">⏳ Pending</span>',
            'rejected' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ Rejected</span>',
            default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">📝 Not Submitted</span>',
        };
    }

    // Business logic
    public function getWalletBalance(): float
    {
        return $this->walletTransactions()
            ->selectRaw('COALESCE(SUM(CASE 
                WHEN type IN ("sale", "adjustment") THEN amount 
                WHEN type IN ("payout", "refund") THEN -amount 
                ELSE 0 
            END), 0) as balance')
            ->value('balance') ?? 0;
    }

    public function isKycApproved(): bool
    {
        return $this->kyc_status === 'approved';
    }

    public function canRequestPayout(): bool
    {
        return $this->is_active && $this->isKycApproved() && $this->getWalletBalance() > 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKycApproved($query)
    {
        return $query->where('kyc_status', 'approved');
    }
}
