<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update the enum to include new statuses
        DB::statement("ALTER TABLE disputes MODIFY COLUMN status ENUM('open', 'resolved', 'escalated', 'in_review', 'resolved_refund', 'resolved_upheld') DEFAULT 'open'");
        
        // Add escalation timestamp
        Schema::table('disputes', function (Blueprint $table) {
            if (!Schema::hasColumn('disputes', 'escalated_at')) {
                $table->timestamp('escalated_at')->nullable()->after('resolved_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove escalation timestamp
        Schema::table('disputes', function (Blueprint $table) {
            $table->dropColumn('escalated_at');
        });
        
        // Revert enum
        DB::statement("ALTER TABLE disputes MODIFY COLUMN status ENUM('open', 'in_review', 'resolved_refund', 'resolved_upheld') DEFAULT 'open'");
    }
};

