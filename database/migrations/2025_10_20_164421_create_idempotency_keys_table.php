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
        Schema::create('idempotency_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('provider'); // stripe, tap, etc.
            $table->string('type'); // webhook, payment, etc.
            $table->json('payload')->nullable();
            $table->string('status')->default('pending'); // pending, processed, failed
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['provider', 'type']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idempotency_keys');
    }
};