<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'source')) {
                $table->string('source')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'billing_country')) {
                $table->string('billing_country', 2)->nullable()->after('source');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'billing_country')) {
                $table->dropColumn('billing_country');
            }
            if (Schema::hasColumn('orders', 'source')) {
                $table->dropColumn('source');
            }
        });
    }
};


