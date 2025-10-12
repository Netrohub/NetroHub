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
        // Add credential delivery fields to products table
        Schema::table('products', function (Blueprint $table) {
            $table->text('delivery_credentials')->nullable()->after('delivery_type');
            $table->boolean('is_unique_credential')->default(false)->after('delivery_credentials');
            $table->enum('verification_status', ['pending', 'verified', 'skipped_draft'])->default('pending')->after('is_unique_credential');
        });

        // Add credential claiming and viewing fields to order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->timestamp('credential_claimed_at')->nullable()->after('delivered_at');
            $table->integer('credential_view_count')->default(0)->after('credential_claimed_at');
            $table->integer('credential_view_limit')->default(3)->after('credential_view_count');
        });

        // Create credential_views table for audit logging
        Schema::create('credential_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('viewed_at')->useCurrent();
            $table->index(['order_item_id', 'viewed_at']);
            $table->index(['user_id', 'viewed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credential_views');

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['credential_claimed_at', 'credential_view_count', 'credential_view_limit']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['delivery_credentials', 'is_unique_credential', 'verification_status']);
        });
    }
};
