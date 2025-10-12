<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('location')->default('footer'); // footer, header
            $table->string('label');
            $table->string('url')->nullable();
            $table->foreignId('cms_page_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('opens_new_tab')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['location', 'order', 'is_visible']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_items');
    }
};

