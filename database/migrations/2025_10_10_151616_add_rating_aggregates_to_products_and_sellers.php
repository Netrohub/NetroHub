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
        // Add rating aggregates to products table
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'rating_avg')) {
                $table->decimal('rating_avg', 3, 2)->default(0)->after('price');
            }
            if (! Schema::hasColumn('products', 'rating_count')) {
                $table->unsignedInteger('rating_count')->default(0)->after('rating_avg');
            }
        });

        // Add rating aggregates to sellers table
        Schema::table('sellers', function (Blueprint $table) {
            if (! Schema::hasColumn('sellers', 'rating_avg')) {
                $table->decimal('rating_avg', 3, 2)->default(0)->after('kyc_status');
            }
            if (! Schema::hasColumn('sellers', 'rating_count')) {
                $table->unsignedInteger('rating_count')->default(0)->after('rating_avg');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'rating_avg')) {
                $table->dropColumn('rating_avg');
            }
            if (Schema::hasColumn('products', 'rating_count')) {
                $table->dropColumn('rating_count');
            }
        });

        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'rating_avg')) {
                $table->dropColumn('rating_avg');
            }
            if (Schema::hasColumn('sellers', 'rating_count')) {
                $table->dropColumn('sellers', 'rating_count');
            }
        });
    }
};
