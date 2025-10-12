<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Enhance sellers table with comprehensive KYC fields
        Schema::table('sellers', function (Blueprint $table) {
            // Enhanced KYC fields - only add if they don't exist
            if (!Schema::hasColumn('sellers', 'kyc_full_name')) {
                $table->string('kyc_full_name')->nullable()->after('kyc_status');
            }
            if (!Schema::hasColumn('sellers', 'kyc_date_of_birth')) {
                $table->date('kyc_date_of_birth')->nullable()->after('kyc_full_name');
            }
            if (!Schema::hasColumn('sellers', 'kyc_country')) {
                $table->string('kyc_country')->nullable()->after('kyc_date_of_birth');
            }
            if (!Schema::hasColumn('sellers', 'kyc_id_type')) {
                $table->string('kyc_id_type')->nullable()->after('kyc_country'); // passport, national_id, driver_license
            }
            if (!Schema::hasColumn('sellers', 'kyc_id_number')) {
                $table->string('kyc_id_number')->nullable()->after('kyc_id_type');
            }
            if (!Schema::hasColumn('sellers', 'kyc_id_front_url')) {
                $table->string('kyc_id_front_url')->nullable()->after('kyc_id_number');
            }
            if (!Schema::hasColumn('sellers', 'kyc_id_back_url')) {
                $table->string('kyc_id_back_url')->nullable()->after('kyc_id_front_url');
            }
            if (!Schema::hasColumn('sellers', 'kyc_reviewed_by')) {
                $table->foreignId('kyc_reviewed_by')->nullable()->after('kyc_rejection_reason')->constrained('users')->nullOnDelete();
            }
        });

        // Add phone verification fields to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone_verification_code')) {
                $table->string('phone_verification_code')->nullable()->after('phone_verified_at');
            }
            if (!Schema::hasColumn('users', 'phone_verification_code_expires_at')) {
                $table->timestamp('phone_verification_code_expires_at')->nullable()->after('phone_verification_code');
            }
        });

        // Create KYC verification attempts table for audit trail
        Schema::create('kyc_verification_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->string('status'); // submitted, approved, rejected, resubmit
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_verification_attempts');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_verification_code', 'phone_verification_code_expires_at']);
        });

        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'kyc_full_name',
                'kyc_date_of_birth', 
                'kyc_country',
                'kyc_id_type',
                'kyc_id_number',
                'kyc_id_front_url',
                'kyc_id_back_url',
                'kyc_rejection_reason',
                'kyc_reviewed_by'
            ]);
        });
    }
};
