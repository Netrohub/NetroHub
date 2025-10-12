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
        Schema::table('reviews', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (! Schema::hasColumn('reviews', 'reviewable_type')) {
                $table->string('reviewable_type')->after('user_id')->nullable();
            }
            if (! Schema::hasColumn('reviews', 'reviewable_id')) {
                $table->unsignedBigInteger('reviewable_id')->after('reviewable_type')->nullable();
            }
            if (! Schema::hasColumn('reviews', 'title')) {
                $table->string('title')->nullable()->after('rating');
            }
            if (! Schema::hasColumn('reviews', 'body')) {
                $table->text('body')->nullable()->after('title');
            }
            if (! Schema::hasColumn('reviews', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected', 'hidden'])->default('approved')->after('body');
            }
            if (! Schema::hasColumn('reviews', 'reported_at')) {
                $table->timestamp('reported_at')->nullable()->after('status');
            }
            if (! Schema::hasColumn('reviews', 'replied_body')) {
                $table->text('replied_body')->nullable()->after('reported_at');
            }
            if (! Schema::hasColumn('reviews', 'replied_by')) {
                $table->unsignedBigInteger('replied_by')->nullable()->after('replied_body');
            }
        });

        // Copy comment to body if comment column exists and body is null
        if (Schema::hasColumn('reviews', 'comment')) {
            DB::statement('UPDATE reviews SET body = comment WHERE body IS NULL');
        }

        // Migrate existing product reviews to polymorphic structure
        DB::statement("UPDATE reviews SET reviewable_type = 'App\\\\Models\\\\Product', reviewable_id = product_id WHERE product_id IS NOT NULL AND reviewable_type IS NULL");

        // Add indexes
        if (! Schema::hasIndex('reviews', ['reviewable_type', 'reviewable_id'])) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->index(['reviewable_type', 'reviewable_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['reviewable_type', 'reviewable_id']);

            $table->dropColumn([
                'reviewable_type',
                'reviewable_id',
                'title',
                'body',
                'status',
                'reported_at',
                'replied_body',
                'replied_by',
            ]);
        });
    }
};
