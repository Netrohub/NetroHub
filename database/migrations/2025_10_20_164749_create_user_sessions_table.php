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
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('session_id')->unique();
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('location')->nullable(); // Country/City
            $table->boolean('is_current')->default(false);
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_current']);
            $table->index(['user_id', 'last_activity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};