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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique(); // e.g., 'hero_section', 'features_grid'
            $table->string('page')->default('homepage'); // homepage, about, pricing, etc.
            $table->string('section')->nullable(); // header, body, footer
            $table->integer('order')->default(0);
            $table->string('type')->default('text'); // text, html, image, video, slider, grid, cta
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->json('metadata')->nullable(); // Images, links, button text, etc.
            $table->json('styling')->nullable(); // Custom CSS classes, colors
            $table->boolean('is_active')->default(true);
            $table->string('visibility')->default('public'); // public, members_only, premium
            $table->timestamps();
            
            $table->index(['page', 'section', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
