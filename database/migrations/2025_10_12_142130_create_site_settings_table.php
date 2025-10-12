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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('group')->default('general'); // general, branding, seo, legal, monetization, email, advanced
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, number, boolean, json, image, color, select
            $table->text('description')->nullable();
            $table->json('options')->nullable(); // For select type
            $table->boolean('is_public')->default(false); // Can be accessed by frontend
            $table->timestamps();
            
            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
