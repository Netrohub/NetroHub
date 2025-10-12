<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('set null');

            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment')->nullable();

            $table->boolean('is_verified_purchase')->default(false);
            $table->boolean('is_visible')->default(true);

            $table->unsignedInteger('helpful_count')->default(0);

            $table->timestamps();

            $table->unique(['product_id', 'user_id', 'order_item_id']);
            $table->index(['product_id', 'is_visible']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
