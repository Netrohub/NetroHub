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
        // Plans table
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Free, Plus, Pro
            $table->string('slug')->unique(); // free, plus, pro
            $table->decimal('price_month', 10, 2)->default(0);
            $table->decimal('price_year', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('paddle_price_id_month')->nullable();
            $table->string('paddle_price_id_year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Plan features table
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('key'); // e.g., boost_slots, platform_fee_pct
            $table->string('label'); // Display label
            $table->json('value_json'); // Flexible value storage
            $table->integer('sort_order')->default(0);
            $table->boolean('is_new')->default(false); // "New" badge
            $table->timestamps();

            $table->index(['plan_id', 'key']);
        });

        // User subscriptions table
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('restrict');
            $table->string('paddle_subscription_id')->unique()->nullable();
            $table->enum('status', ['active', 'past_due', 'cancelled', 'expired', 'paused'])->default('active');
            $table->enum('interval', ['monthly', 'yearly'])->default('monthly');
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->timestamp('renews_at')->nullable();
            $table->boolean('is_gifted')->default(false);
            $table->text('metadata')->nullable(); // Additional Paddle data
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['plan_id', 'status']);
            $table->index('paddle_subscription_id');
            $table->index('renews_at');
        });

        // User entitlements table (computed from plan features)
        Schema::create('user_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('key'); // boost_slots, draft_limit, platform_fee_pct, etc.
            $table->integer('value_int')->nullable();
            $table->boolean('value_bool')->nullable();
            $table->decimal('value_decimal', 10, 2)->nullable();
            $table->string('value_string')->nullable();
            $table->enum('reset_period', ['monthly', 'yearly', 'never'])->default('never');
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'key']);
            $table->index(['user_id', 'reset_period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_entitlements');
        Schema::dropIfExists('user_subscriptions');
        Schema::dropIfExists('plan_features');
        Schema::dropIfExists('plans');
    }
};
