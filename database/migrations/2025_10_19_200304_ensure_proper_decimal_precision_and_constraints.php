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
        $this->ensureDecimalPrecision();
        $this->addCheckConstraints();
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
     * Ensure proper decimal precision for monetary values
     */
    private function ensureDecimalPrecision(): void
    {
        // Products table - ensure price has proper precision
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'price')) {
            try {
                DB::statement('ALTER TABLE `products` MODIFY COLUMN `price` DECIMAL(12,2) NOT NULL');
                $this->command->info("Updated products.price to DECIMAL(12,2)");
            } catch (Exception $e) {
                $this->command->warn("Could not update products.price: " . $e->getMessage());
            }
        }

        // Orders table - ensure monetary fields have proper precision
        if (Schema::hasTable('orders')) {
            $monetaryFields = ['subtotal', 'platform_fee', 'total'];
            foreach ($monetaryFields as $field) {
                if (Schema::hasColumn('orders', $field)) {
                    try {
                        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `{$field}` DECIMAL(12,2) NOT NULL");
                        $this->command->info("Updated orders.{$field} to DECIMAL(12,2)");
                    } catch (Exception $e) {
                        $this->command->warn("Could not update orders.{$field}: " . $e->getMessage());
                    }
                }
            }
        }

        // Order items table - ensure monetary fields have proper precision
        if (Schema::hasTable('order_items')) {
            $monetaryFields = ['price', 'seller_amount', 'platform_commission'];
            foreach ($monetaryFields as $field) {
                if (Schema::hasColumn('order_items', $field)) {
                    try {
                        DB::statement("ALTER TABLE `order_items` MODIFY COLUMN `{$field}` DECIMAL(12,2) NOT NULL");
                        $this->command->info("Updated order_items.{$field} to DECIMAL(12,2)");
                    } catch (Exception $e) {
                        $this->command->warn("Could not update order_items.{$field}: " . $e->getMessage());
                    }
                }
            }
        }

        // Wallet transactions table - ensure amount has proper precision
        if (Schema::hasTable('wallet_transactions') && Schema::hasColumn('wallet_transactions', 'amount')) {
            try {
                DB::statement('ALTER TABLE `wallet_transactions` MODIFY COLUMN `amount` DECIMAL(12,2) NOT NULL');
                $this->command->info("Updated wallet_transactions.amount to DECIMAL(12,2)");
            } catch (Exception $e) {
                $this->command->warn("Could not update wallet_transactions.amount: " . $e->getMessage());
            }
        }

        // Payout requests table - ensure amount has proper precision
        if (Schema::hasTable('payout_requests') && Schema::hasColumn('payout_requests', 'amount')) {
            try {
                DB::statement('ALTER TABLE `payout_requests` MODIFY COLUMN `amount` DECIMAL(12,2) NOT NULL');
                $this->command->info("Updated payout_requests.amount to DECIMAL(12,2)");
            } catch (Exception $e) {
                $this->command->warn("Could not update payout_requests.amount: " . $e->getMessage());
            }
        }

        // Refunds table - ensure amount has proper precision
        if (Schema::hasTable('refunds') && Schema::hasColumn('refunds', 'amount')) {
            try {
                DB::statement('ALTER TABLE `refunds` MODIFY COLUMN `amount` DECIMAL(12,2) NOT NULL');
                $this->command->info("Updated refunds.amount to DECIMAL(12,2)");
            } catch (Exception $e) {
                $this->command->warn("Could not update refunds.amount: " . $e->getMessage());
            }
        }
    }

    /**
     * Add check constraints for data integrity
     */
    private function addCheckConstraints(): void
    {
        // Products table constraints
        if (Schema::hasTable('products')) {
            try {
                // Ensure price is positive
                DB::statement('ALTER TABLE `products` ADD CONSTRAINT `products_price_positive` CHECK (`price` >= 0)');
                $this->command->info("Added check constraint: products.price >= 0");
            } catch (Exception $e) {
                $this->command->warn("Could not add price constraint to products: " . $e->getMessage());
            }

            try {
                // Ensure stock_count is non-negative
                DB::statement('ALTER TABLE `products` ADD CONSTRAINT `products_stock_non_negative` CHECK (`stock_count` IS NULL OR `stock_count` >= 0)');
                $this->command->info("Added check constraint: products.stock_count >= 0");
            } catch (Exception $e) {
                $this->command->warn("Could not add stock constraint to products: " . $e->getMessage());
            }

            try {
                // Ensure rating is between 0 and 5
                DB::statement('ALTER TABLE `products` ADD CONSTRAINT `products_rating_range` CHECK (`rating` >= 0 AND `rating` <= 5)');
                $this->command->info("Added check constraint: products.rating between 0 and 5");
            } catch (Exception $e) {
                $this->command->warn("Could not add rating constraint to products: " . $e->getMessage());
            }
        }

        // Orders table constraints
        if (Schema::hasTable('orders')) {
            try {
                // Ensure monetary values are non-negative
                DB::statement('ALTER TABLE `orders` ADD CONSTRAINT `orders_subtotal_positive` CHECK (`subtotal` >= 0)');
                DB::statement('ALTER TABLE `orders` ADD CONSTRAINT `orders_platform_fee_positive` CHECK (`platform_fee` >= 0)');
                DB::statement('ALTER TABLE `orders` ADD CONSTRAINT `orders_total_positive` CHECK (`total` >= 0)');
                $this->command->info("Added monetary constraints to orders table");
            } catch (Exception $e) {
                $this->command->warn("Could not add monetary constraints to orders: " . $e->getMessage());
            }
        }

        // Order items table constraints
        if (Schema::hasTable('order_items')) {
            try {
                // Ensure monetary values are non-negative
                DB::statement('ALTER TABLE `order_items` ADD CONSTRAINT `order_items_price_positive` CHECK (`price` >= 0)');
                DB::statement('ALTER TABLE `order_items` ADD CONSTRAINT `order_items_seller_amount_positive` CHECK (`seller_amount` >= 0)');
                DB::statement('ALTER TABLE `order_items` ADD CONSTRAINT `order_items_commission_positive` CHECK (`platform_commission` >= 0)');
                
                // Ensure quantity is positive
                DB::statement('ALTER TABLE `order_items` ADD CONSTRAINT `order_items_quantity_positive` CHECK (`quantity` > 0)');
                
                $this->command->info("Added constraints to order_items table");
            } catch (Exception $e) {
                $this->command->warn("Could not add constraints to order_items: " . $e->getMessage());
            }
        }

        // Users table constraints
        if (Schema::hasTable('users')) {
            try {
                // Ensure is_active is boolean
                DB::statement('ALTER TABLE `users` ADD CONSTRAINT `users_is_active_boolean` CHECK (`is_active` IN (0, 1))');
                $this->command->info("Added boolean constraint to users.is_active");
            } catch (Exception $e) {
                $this->command->warn("Could not add boolean constraint to users: " . $e->getMessage());
            }
        }

        // OTP verifications table constraints
        if (Schema::hasTable('otp_verifications')) {
            try {
                // Ensure OTP is 6 digits
                DB::statement('ALTER TABLE `otp_verifications` ADD CONSTRAINT `otp_verifications_otp_length` CHECK (CHAR_LENGTH(`otp`) = 6)');
                
                // Ensure verified is boolean
                DB::statement('ALTER TABLE `otp_verifications` ADD CONSTRAINT `otp_verifications_verified_boolean` CHECK (`verified` IN (0, 1))');
                
                $this->command->info("Added constraints to otp_verifications table");
            } catch (Exception $e) {
                $this->command->warn("Could not add constraints to otp_verifications: " . $e->getMessage());
            }
        }
    }
};