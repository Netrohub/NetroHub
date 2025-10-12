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
        Schema::create('feature_flags', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g., 'enable_chat', 'beta_dashboard'
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->string('environment')->default('all'); // all, production, staging, development
            $table->integer('rollout_percentage')->default(100); // For gradual rollout (0-100)
            $table->json('allowed_users')->nullable(); // Specific user IDs for beta testing
            $table->json('allowed_roles')->nullable(); // admin, seller, buyer
            $table->timestamp('enabled_at')->nullable();
            $table->timestamp('disabled_at')->nullable();
            $table->timestamps();
            
            $table->index('is_enabled');
            $table->index('environment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_flags');
    }
};
