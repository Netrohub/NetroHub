<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('features')->nullable(); // JSON array
            $table->text('tags')->nullable(); // JSON array

            $table->decimal('price', 10, 2);
            $table->enum('delivery_type', ['file', 'code', 'hybrid'])->default('file');

            // Media
            $table->string('thumbnail_url')->nullable();
            $table->text('gallery_urls')->nullable(); // JSON array

            // Stock & limits
            $table->unsignedInteger('stock_count')->nullable(); // for codes
            $table->unsignedInteger('purchase_limit')->nullable(); // per user

            // Status
            $table->enum('status', ['draft', 'active', 'paused', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);

            // Stats
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('sales_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['seller_id', 'status']);
            $table->index(['category_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
