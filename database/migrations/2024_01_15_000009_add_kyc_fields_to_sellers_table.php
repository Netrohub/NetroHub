<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'kyc_status')) {
                $table->string('kyc_status')->default('pending')->after('verified'); // pending, approved, rejected, resubmit
            }
            if (!Schema::hasColumn('sellers', 'kyc_documents')) {
                $table->json('kyc_documents')->nullable()->after('kyc_status');
            }
            if (!Schema::hasColumn('sellers', 'kyc_rejection_reason')) {
                $table->text('kyc_rejection_reason')->nullable()->after('kyc_documents');
            }
            if (!Schema::hasColumn('sellers', 'kyc_reviewed_by')) {
                $table->foreignId('kyc_reviewed_by')->nullable()->after('kyc_rejection_reason')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('sellers', 'kyc_reviewed_at')) {
                $table->timestamp('kyc_reviewed_at')->nullable()->after('kyc_reviewed_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['kyc_status', 'kyc_documents', 'kyc_rejection_reason', 'kyc_reviewed_by', 'kyc_reviewed_at']);
        });
    }
};

