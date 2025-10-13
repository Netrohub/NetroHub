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
        Schema::table('user_subscriptions', function (Blueprint $table) {
            // Add Tap-specific fields if they don't exist
            if (!Schema::hasColumn('user_subscriptions', 'tap_charge_id')) {
                $table->string('tap_charge_id')->nullable();
            }
            
            if (!Schema::hasColumn('user_subscriptions', 'tap_customer_id')) {
                $table->string('tap_customer_id')->nullable();
            }
            
            if (!Schema::hasColumn('user_subscriptions', 'pending_plan_id')) {
                $table->string('pending_plan_id')->nullable();
            }
            
            if (!Schema::hasColumn('user_subscriptions', 'pending_interval')) {
                $table->string('pending_interval')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscriptions', function (Blueprint $table) {
            $table->dropIndex(['tap_charge_id']);
            $table->dropIndex(['tap_customer_id']);
            
            $table->dropColumn([
                'tap_charge_id',
                'tap_customer_id',
                'pending_plan_id',
                'pending_interval',
            ]);
        });
    }
};
