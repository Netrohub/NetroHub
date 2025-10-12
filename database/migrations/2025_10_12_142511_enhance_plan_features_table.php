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
        Schema::table('plan_features', function (Blueprint $table) {
            // Add feature categorization
            $table->string('category')->default('general')->after('id'); // general, limits, premium, priority
            $table->string('feature_type')->default('boolean')->after('category'); // boolean, limit, percentage
            $table->string('unit')->nullable()->after('feature_type'); // listings, boosts, GB, etc.
            $table->boolean('is_highlight')->default(false)->after('unit'); // Show prominently on pricing page
            $table->string('icon')->nullable()->after('is_highlight'); // Icon class or name
            $table->text('tooltip')->nullable()->after('icon'); // Explanation on hover
            
            $table->index(['category', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_features', function (Blueprint $table) {
            $table->dropIndex(['category', 'sort_order']);
            $table->dropColumn([
                'category',
                'feature_type',
                'unit',
                'is_highlight',
                'icon',
                'tooltip'
            ]);
        });
    }
};
