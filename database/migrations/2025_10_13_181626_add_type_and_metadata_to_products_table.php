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
        Schema::table('products', function (Blueprint $table) {
            // Add product type (social_account, game_account, digital_product, service, etc.)
            if (!Schema::hasColumn('products', 'type')) {
                $table->string('type')->default('digital_product')->after('category_id');
                $table->index('type');
            }
            
            // Add metadata for storing product-specific information (JSON)
            if (!Schema::hasColumn('products', 'metadata')) {
                $table->json('metadata')->nullable()->after('tags');
            }
            
            // Add game_title for game accounts
            if (!Schema::hasColumn('products', 'game_title')) {
                $table->string('game_title')->nullable()->after('type');
            }
            
            // Add platform for social accounts
            if (!Schema::hasColumn('products', 'platform')) {
                $table->string('platform')->nullable()->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropColumn(['type', 'metadata', 'game_title', 'platform']);
        });
    }
};
