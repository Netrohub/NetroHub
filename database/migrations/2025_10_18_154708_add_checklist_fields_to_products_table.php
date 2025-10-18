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
            // General checklist fields for all products
            $table->json('general_checklist')->nullable()->after('metadata');
            
            // Whiteout Survival specific checklist
            $table->json('whiteout_survival_checklist')->nullable()->after('general_checklist');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['general_checklist', 'whiteout_survival_checklist']);
        });
    }
};
