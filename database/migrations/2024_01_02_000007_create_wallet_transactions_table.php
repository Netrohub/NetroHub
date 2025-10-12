<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');

            $table->enum('type', ['sale', 'refund', 'payout', 'adjustment']);
            $table->decimal('amount', 10, 2);
            $table->decimal('balance_after', 10, 2);

            $table->string('reference_type')->nullable(); // Order, PayoutRequest, etc.
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->text('description')->nullable();
            $table->text('metadata')->nullable(); // JSON

            $table->timestamps();

            $table->index(['seller_id', 'created_at']);
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
