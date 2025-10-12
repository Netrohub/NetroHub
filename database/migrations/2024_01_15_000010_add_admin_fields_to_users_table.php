<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_banned')) {
                $table->boolean('is_banned')->default(false)->after('email_verified_at');
            }
            if (!Schema::hasColumn('users', 'banned_reason')) {
                $table->text('banned_reason')->nullable()->after('is_banned');
            }
            if (!Schema::hasColumn('users', 'banned_at')) {
                $table->timestamp('banned_at')->nullable()->after('banned_reason');
            }
            if (!Schema::hasColumn('users', 'banned_by')) {
                $table->foreignId('banned_by')->nullable()->after('banned_at')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('banned_by');
            }
            if (!Schema::hasColumn('users', 'last_login_ip')) {
                $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_reason', 'banned_at', 'banned_by', 'last_login_at', 'last_login_ip']);
        });
    }
};

