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
        $this->handlePhoneNumberUniqueness();
        $this->addMissingUniqueConstraints();
        $this->addMissingEmailVerificationFields();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is designed to be safe and additive
        // Rolling back would require careful analysis of what was added
    }

    /**
     * Handle phone number uniqueness properly
     */
    private function handlePhoneNumberUniqueness(): void
    {
        if (Schema::hasTable('users')) {
            // Check if phone_number column exists (from later migration)
            if (Schema::hasColumn('users', 'phone_number')) {
                // Check for duplicate phone numbers
                $duplicates = DB::select("
                    SELECT phone_number, COUNT(*) as count 
                    FROM users 
                    WHERE phone_number IS NOT NULL 
                    GROUP BY phone_number 
                    HAVING COUNT(*) > 1
                ");

                if (count($duplicates) > 0) {
                    $this->command->warn("Found duplicate phone numbers in users table:");
                    foreach ($duplicates as $duplicate) {
                        $this->command->warn("  Phone: {$duplicate->phone_number}, Count: {$duplicate->count}");
                    }
                    $this->command->warn("Skipping unique constraint on phone_number due to duplicates");
                } else {
                    // Add unique index on phone_number if no duplicates
                    try {
                        if (!$this->indexExists('users', 'users_phone_number_unique')) {
                            Schema::table('users', function (Blueprint $table) {
                                $table->unique('phone_number', 'users_phone_number_unique');
                            });
                            $this->command->info("Added unique constraint on users.phone_number");
                        }
                    } catch (Exception $e) {
                        $this->command->warn("Could not add unique constraint on phone_number: " . $e->getMessage());
                    }
                }
            }

            // Also handle the 'phone' column if it exists
            if (Schema::hasColumn('users', 'phone')) {
                // Check for duplicate phone numbers
                $duplicates = DB::select("
                    SELECT phone, COUNT(*) as count 
                    FROM users 
                    WHERE phone IS NOT NULL 
                    GROUP BY phone 
                    HAVING COUNT(*) > 1
                ");

                if (count($duplicates) > 0) {
                    $this->command->warn("Found duplicate phone numbers in users.phone column:");
                    foreach ($duplicates as $duplicate) {
                        $this->command->warn("  Phone: {$duplicate->phone}, Count: {$duplicate->count}");
                    }
                    $this->command->warn("Skipping unique constraint on phone due to duplicates");
                } else {
                    // Add unique index on phone if no duplicates
                    try {
                        if (!$this->indexExists('users', 'users_phone_unique')) {
                            Schema::table('users', function (Blueprint $table) {
                                $table->unique('phone', 'users_phone_unique');
                            });
                            $this->command->info("Added unique constraint on users.phone");
                        }
                    } catch (Exception $e) {
                        $this->command->warn("Could not add unique constraint on phone: " . $e->getMessage());
                    }
                }
            }
        }
    }

    /**
     * Add missing unique constraints
     */
    private function addMissingUniqueConstraints(): void
    {
        // Products table - ensure slug is unique
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'slug')) {
            try {
                if (!$this->indexExists('products', 'products_slug_unique')) {
                    Schema::table('products', function (Blueprint $table) {
                        $table->unique('slug', 'products_slug_unique');
                    });
                    $this->command->info("Added unique constraint on products.slug");
                }
            } catch (Exception $e) {
                $this->command->warn("Could not add unique constraint on products.slug: " . $e->getMessage());
            }
        }

        // Orders table - ensure order_number is unique
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'order_number')) {
            try {
                if (!$this->indexExists('orders', 'orders_order_number_unique')) {
                    Schema::table('orders', function (Blueprint $table) {
                        $table->unique('order_number', 'orders_order_number_unique');
                    });
                    $this->command->info("Added unique constraint on orders.order_number");
                }
            } catch (Exception $e) {
                $this->command->warn("Could not add unique constraint on orders.order_number: " . $e->getMessage());
            }
        }

        // Users table - ensure username is unique (if it exists)
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'username')) {
            try {
                if (!$this->indexExists('users', 'users_username_unique')) {
                    Schema::table('users', function (Blueprint $table) {
                        $table->unique('username', 'users_username_unique');
                    });
                    $this->command->info("Added unique constraint on users.username");
                }
            } catch (Exception $e) {
                $this->command->warn("Could not add unique constraint on users.username: " . $e->getMessage());
            }
        }

        // Sellers table - ensure unique seller per user
        if (Schema::hasTable('sellers') && Schema::hasColumn('sellers', 'user_id')) {
            try {
                if (!$this->indexExists('sellers', 'sellers_user_id_unique')) {
                    Schema::table('sellers', function (Blueprint $table) {
                        $table->unique('user_id', 'sellers_user_id_unique');
                    });
                    $this->command->info("Added unique constraint on sellers.user_id");
                }
            } catch (Exception $e) {
                $this->command->warn("Could not add unique constraint on sellers.user_id: " . $e->getMessage());
            }
        }
    }

    /**
     * Add missing email verification fields
     */
    private function addMissingEmailVerificationFields(): void
    {
        // Users table - ensure email_verified_at exists
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
                $table->index('email_verified_at');
            });
            $this->command->info("Added email_verified_at column to users table");
        }

        // Users table - ensure phone_verified_at exists
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'phone_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone');
                $table->index('phone_verified_at');
            });
            $this->command->info("Added phone_verified_at column to users table");
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
};