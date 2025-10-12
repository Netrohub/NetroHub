<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('type', ['digital_product', 'game_account', 'social_account'])->default('digital_product')->after('seller_id');
            $table->json('metadata')->nullable()->after('tags'); // For storing platform, handle, followers, etc.
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'metadata']);
        });
    }
};
