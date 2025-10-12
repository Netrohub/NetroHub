<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->text('code'); // The actual code/license key
            $table->enum('status', ['available', 'claimed', 'expired'])->default('available');
            $table->foreignId('claimed_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_item_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('claimed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_codes');
    }
};
