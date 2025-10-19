<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->convertTablesToUtf8mb4();
        $this->addMissingIndexes();
        $this->addMissingForeignKeys();
        $this->addMissingSoftDeletes();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is designed to be safe and additive
        // Rolling back would require careful analysis of what was added
        // For now, we'll leave the improvements in place
    }

    /**
     * Convert tables to utf8mb4 charset and utf8mb4_unicode_ci collation
     */
    private function convertTablesToUtf8mb4(): void
    {
        $tables = [
            'users', 'products', 'orders', 'order_items', 'disputes', 
            'dispute_messages', 'product_files', 'otp_verifications',
            'reviews', 'sellers', 'categories', 'wallet_transactions',
            'payout_requests', 'settings', 'activity_logs', 'admin_audit',
            'cms_pages', 'email_templates', 'announcements', 'navigation_items',
            'copy_strings', 'webhook_logs', 'refunds', 'download_logs',
            'user_subscriptions', 'plans', 'plan_features', 'notifications',
            'kyc_submissions', 'kyc_verification_attempts', 'translations',
            'social_account_verifications', 'permissions', 'roles', 'model_has_permissions',
            'model_has_roles', 'role_has_permissions'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    DB::statement("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    echo "Converted table {$table} to utf8mb4\n";
                } catch (Exception $e) {
                    echo "Could not convert table {$table}: " . $e->getMessage() . "\n";
                }
            }
        }
    }

    /**
     * Add missing indexes for better performance
     */
    private function addMissingIndexes(): void
    {
        // Users table improvements
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Add composite index for common queries
                if (!$this->indexExists('users', 'users_status_created_at_index')) {
                    $table->index(['is_active', 'created_at'], 'users_status_created_at_index');
                }
                
                // Add index on email_verified_at for verification queries
                if (!$this->indexExists('users', 'users_email_verified_at_index')) {
                    $table->index('email_verified_at');
                }
                
                // Add index on phone_verified_at
                if (!$this->indexExists('users', 'users_phone_verified_at_index')) {
                    $table->index('phone_verified_at');
                }
            });
        }

        // Products table improvements
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Add individual indexes for better query performance
                if (!$this->indexExists('products', 'products_status_index')) {
                    $table->index('status');
                }
                
                if (!$this->indexExists('products', 'products_created_at_index')) {
                    $table->index('created_at');
                }
                
                if (!$this->indexExists('products', 'products_is_featured_index')) {
                    $table->index('is_featured');
                }
                
                // Add composite index for seller dashboard queries
                if (!$this->indexExists('products', 'products_seller_status_created_index')) {
                    $table->index(['seller_id', 'status', 'created_at'], 'products_seller_status_created_index');
                }
                
                // Add index for soft deletes
                if (!$this->indexExists('products', 'products_deleted_at_index')) {
                    $table->index('deleted_at');
                }
            });
        }

        // Orders table improvements
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Add composite indexes for common queries
                if (!$this->indexExists('orders', 'orders_user_created_index')) {
                    $table->index(['user_id', 'created_at'], 'orders_user_created_index');
                }
                
                if (!$this->indexExists('orders', 'orders_status_created_index')) {
                    $table->index(['status', 'created_at'], 'orders_status_created_index');
                }
                
                if (!$this->indexExists('orders', 'orders_payment_status_index')) {
                    $table->index('payment_status');
                }
                
                if (!$this->indexExists('orders', 'orders_paid_at_index')) {
                    $table->index('paid_at');
                }
            });
        }

        // Order items table improvements
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                // Add composite index for seller queries
                if (!$this->indexExists('order_items', 'order_items_seller_created_index')) {
                    $table->index(['seller_id', 'created_at'], 'order_items_seller_created_index');
                }
                
                if (!$this->indexExists('order_items', 'order_items_product_index')) {
                    $table->index('product_id');
                }
                
                if (!$this->indexExists('order_items', 'order_items_delivered_at_index')) {
                    $table->index('delivered_at');
                }
            });
        }

        // Disputes table improvements
        if (Schema::hasTable('disputes')) {
            Schema::table('disputes', function (Blueprint $table) {
                if (!$this->indexExists('disputes', 'disputes_order_index')) {
                    $table->index('order_id');
                }
                
                if (!$this->indexExists('disputes', 'disputes_buyer_index')) {
                    $table->index('buyer_id');
                }
                
                if (!$this->indexExists('disputes', 'disputes_seller_index')) {
                    $table->index('seller_id');
                }
                
                if (!$this->indexExists('disputes', 'disputes_status_created_index')) {
                    $table->index(['status', 'created_at'], 'disputes_status_created_index');
                }
                
                if (!$this->indexExists('disputes', 'disputes_resolved_at_index')) {
                    $table->index('resolved_at');
                }
            });
        }

        // Product files table improvements
        if (Schema::hasTable('product_files')) {
            Schema::table('product_files', function (Blueprint $table) {
                if (!$this->indexExists('product_files', 'product_files_product_index')) {
                    $table->index('product_id');
                }
                
                if (!$this->indexExists('product_files', 'product_files_is_primary_index')) {
                    $table->index('is_primary');
                }
                
                if (!$this->indexExists('product_files', 'product_files_mime_type_index')) {
                    $table->index('mime_type');
                }
            });
        }

        // OTP verifications table improvements
        if (Schema::hasTable('otp_verifications')) {
            Schema::table('otp_verifications', function (Blueprint $table) {
                // Add unique constraint for active OTPs per phone
                if (!$this->indexExists('otp_verifications', 'otp_verifications_phone_active_unique')) {
                    try {
                        $table->unique(['phone', 'verified'], 'otp_verifications_phone_active_unique');
                    } catch (Exception $e) {
                        $this->command->warn("Could not add unique constraint to otp_verifications: " . $e->getMessage());
                    }
                }
                
                if (!$this->indexExists('otp_verifications', 'otp_verifications_phone_created_index')) {
                    $table->index(['phone', 'created_at'], 'otp_verifications_phone_created_index');
                }
            });
        }

        // Reviews table improvements
        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                if (!$this->indexExists('reviews', 'reviews_reviewable_index')) {
                    $table->index(['reviewable_type', 'reviewable_id'], 'reviews_reviewable_index');
                }
                
                if (!$this->indexExists('reviews', 'reviews_user_index')) {
                    $table->index('user_id');
                }
                
                if (!$this->indexExists('reviews', 'reviews_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }
    }

    /**
     * Add missing foreign key constraints
     */
    private function addMissingForeignKeys(): void
    {
        // Orders table - add missing foreign keys
        if (Schema::hasTable('orders') && Schema::hasTable('users')) {
            Schema::table('orders', function (Blueprint $table) {
                // Check if foreign key already exists
                $foreignKeys = $this->getForeignKeys('orders');
                if (!in_array('orders_user_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
                        echo "Added foreign key: orders.user_id -> users.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key orders.user_id: " . $e->getMessage() . "\n";
                    }
                }
            });
        }

        // Order items table - add missing foreign keys
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                $foreignKeys = $this->getForeignKeys('order_items');
                
                if (!in_array('order_items_order_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                        echo "Added foreign key: order_items.order_id -> orders.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key order_items.order_id: " . $e->getMessage() . "\n";
                    }
                }
                
                if (!in_array('order_items_product_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
                        echo "Added foreign key: order_items.product_id -> products.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key order_items.product_id: " . $e->getMessage() . "\n";
                    }
                }
                
                if (!in_array('order_items_seller_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('restrict');
                        echo "Added foreign key: order_items.seller_id -> sellers.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key order_items.seller_id: " . $e->getMessage() . "\n";
                    }
                }
            });
        }

        // Disputes table - add missing foreign keys
        if (Schema::hasTable('disputes')) {
            Schema::table('disputes', function (Blueprint $table) {
                $foreignKeys = $this->getForeignKeys('disputes');
                
                if (!in_array('disputes_order_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                        echo "Added foreign key: disputes.order_id -> orders.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key disputes.order_id: " . $e->getMessage() . "\n";
                    }
                }
                
                if (!in_array('disputes_buyer_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('buyer_id')->references('id')->on('users')->onDelete('restrict');
                        echo "Added foreign key: disputes.buyer_id -> users.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key disputes.buyer_id: " . $e->getMessage() . "\n";
                    }
                }
                
                if (!in_array('disputes_seller_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('restrict');
                        echo "Added foreign key: disputes.seller_id -> sellers.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key disputes.seller_id: " . $e->getMessage() . "\n";
                    }
                }
            });
        }

        // Product files table - add missing foreign key
        if (Schema::hasTable('product_files')) {
            Schema::table('product_files', function (Blueprint $table) {
                $foreignKeys = $this->getForeignKeys('product_files');
                
                if (!in_array('product_files_product_id_foreign', $foreignKeys)) {
                    try {
                        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                        echo "Added foreign key: product_files.product_id -> products.id\n";
                    } catch (Exception $e) {
                        echo "Could not add foreign key product_files.product_id: " . $e->getMessage() . "\n";
                    }
                }
            });
        }
    }

    /**
     * Add missing soft deletes where appropriate
     */
    private function addMissingSoftDeletes(): void
    {
        // Add soft deletes to disputes table if it doesn't exist
        if (Schema::hasTable('disputes') && !Schema::hasColumn('disputes', 'deleted_at')) {
            Schema::table('disputes', function (Blueprint $table) {
                $table->softDeletes();
                $table->index('deleted_at');
            });
            echo "Added soft deletes to disputes table\n";
        }

        // Add soft deletes to reviews table if it doesn't exist
        if (Schema::hasTable('reviews') && !Schema::hasColumn('reviews', 'deleted_at')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->softDeletes();
                $table->index('deleted_at');
            });
            echo "Added soft deletes to reviews table\n";
        }

        // Add soft deletes to sellers table if it doesn't exist
        if (Schema::hasTable('sellers') && !Schema::hasColumn('sellers', 'deleted_at')) {
            Schema::table('sellers', function (Blueprint $table) {
                $table->softDeletes();
                $table->index('deleted_at');
            });
            echo "Added soft deletes to sellers table\n";
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $indexName): bool
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get foreign keys for a table
     */
    private function getForeignKeys(string $table): array
    {
        try {
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = ? 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ", [$table]);
            
            return array_column($foreignKeys, 'CONSTRAINT_NAME');
        } catch (Exception $e) {
            return [];
        }
    }
};