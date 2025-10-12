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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('currency', 3)->default('USD')->after('total');
            $table->string('paddle_transaction_id')->nullable()->after('payment_intent_id');
            $table->string('paddle_subscription_id')->nullable()->after('paddle_transaction_id');
            $table->json('webhook_data')->nullable()->after('paddle_subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['currency', 'paddle_transaction_id', 'paddle_subscription_id', 'webhook_data']);
        });
    }
};
