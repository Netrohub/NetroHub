<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('seller_id')->constrained()->onDelete('restrict');

            // Snapshot data
            $table->string('product_title');
            $table->decimal('price', 10, 2);
            $table->decimal('seller_amount', 10, 2); // after commission
            $table->decimal('platform_commission', 10, 2);
            $table->unsignedInteger('quantity')->default(1);

            // Delivery
            $table->enum('delivery_type', ['file', 'code', 'hybrid']);
            $table->text('delivery_payload')->nullable(); // JSON: file URLs or codes
            $table->boolean('is_delivered')->default(false);
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();

            $table->index(['seller_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
