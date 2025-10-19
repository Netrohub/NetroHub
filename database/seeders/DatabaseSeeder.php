<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCode;
use App\Models\Review;
use App\Models\Seller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        // Create subscription plans
        $this->call(PlansSeeder::class);
        
        // Setup admin panel data (CMS pages, email templates)
        $this->call(AdminSetupSeeder::class);

        // Create owner user (if doesn't exist)
        $ownerEmail = env('ADMIN_EMAIL', 'admin@nxo.com');
        $owner = User::where('email', $ownerEmail)->first();
        
        if (!$owner) {
            $owner = User::create([
                'name' => env('ADMIN_NAME', 'Platform Owner'),
                'email' => $ownerEmail,
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            $owner->assignRole('owner');
        }

        // Create settings (if don't exist)
        Setting::firstOrCreate(['key' => 'platform_commission_percent'], [
            'value' => '10',
            'type' => 'integer',
            'description' => 'Platform commission percentage on sales',
        ]);

        Setting::firstOrCreate(['key' => 'platform_name'], [
            'value' => 'NXO',
            'type' => 'string',
            'description' => 'Platform name',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Social accounts', 'slug' => 'social-accounts', 'icon' => '👤', 'description' => 'Social media accounts and profiles'],
            ['name' => 'Games accounts', 'slug' => 'games-accounts', 'icon' => '🎮', 'description' => 'Gaming accounts and profiles'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }

        // Create seller users (if don't exist)
        $sellers = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = User::firstOrCreate(['email' => "seller{$i}@example.com"], [
                'name' => "Seller {$i}",
                'email' => "seller{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            
            if (!$user->hasRole('seller')) {
                $user->assignRole('seller');
            }

            $seller = Seller::firstOrCreate(['user_id' => $user->id], [
                'user_id' => $user->id,
                'display_name' => "Seller {$i}",
                'bio' => 'Professional digital creator with years of experience.',
                'kyc_status' => $i === 1 ? 'approved' : 'pending',
                'is_active' => true,
                'rating' => rand(40, 50) / 10,
            ]);

            $sellers[] = $seller;
        }

        // Create buyer users (if don't exist)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(['email' => "buyer{$i}@example.com"], [
                'name' => "Buyer {$i}",
                'email' => "buyer{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        }

        // Create products
        $productTemplates = [
            ['title' => 'Premium Website Template', 'description' => 'Modern, responsive website template built with latest technologies.', 'price' => 49.99, 'delivery_type' => 'file'],
            ['title' => 'Stock Photo Bundle', 'description' => '100+ high-quality stock photos for commercial use.', 'price' => 29.99, 'delivery_type' => 'file'],
            ['title' => 'SEO Ebook', 'description' => 'Complete guide to mastering SEO in 2024.', 'price' => 19.99, 'delivery_type' => 'file'],
            ['title' => 'Premium VST Plugin', 'description' => 'Professional audio plugin for music production.', 'price' => 99.99, 'delivery_type' => 'code'],
            ['title' => 'Video Editing Presets', 'description' => 'Pack of 50 professional video editing presets.', 'price' => 39.99, 'delivery_type' => 'file'],
            ['title' => 'Logo Design Pack', 'description' => '20 customizable logo templates for any business.', 'price' => 59.99, 'delivery_type' => 'file'],
            ['title' => 'WordPress Security Plugin', 'description' => 'Comprehensive security solution for WordPress.', 'price' => 79.99, 'delivery_type' => 'code'],
            ['title' => 'Marketing Course', 'description' => 'Complete digital marketing masterclass.', 'price' => 149.99, 'delivery_type' => 'file'],
            ['title' => 'UI Kit Components', 'description' => 'Modern UI components library for web development.', 'price' => 44.99, 'delivery_type' => 'file'],
            ['title' => 'Music Loop Pack', 'description' => '200+ royalty-free music loops and samples.', 'price' => 34.99, 'delivery_type' => 'file'],
        ];

        $allCategories = Category::all();

        foreach ($productTemplates as $index => $productData) {
            $seller = $sellers[array_rand($sellers)];
            $category = $allCategories->random();

            $product = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'title' => $productData['title'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'delivery_type' => $productData['delivery_type'],
                'status' => 'active',
                'is_featured' => $index < 4,
                'views_count' => rand(100, 1000),
                'sales_count' => rand(10, 100),
                'rating' => rand(40, 50) / 10,
                'reviews_count' => rand(5, 20),
                'features' => ['High quality', 'Instant delivery', 'Money-back guarantee'],
                'tags' => ['popular', 'trending', 'best-seller'],
            ]);

            // Add product codes if delivery type is code
            if ($productData['delivery_type'] === 'code') {
                for ($j = 1; $j <= 10; $j++) {
                    ProductCode::create([
                        'product_id' => $product->id,
                        'code' => strtoupper(\Illuminate\Support\Str::random(20)),
                        'status' => 'available',
                    ]);
                }
                $product->update(['stock_count' => 10]);
            }
        }

        // Create some sample reviews
        $buyers = User::role('user')->get();
        $products = Product::all();

        foreach ($products->take(5) as $product) {
            $buyer = $buyers->random();
            Review::create([
                'product_id' => $product->id,
                'user_id' => $buyer->id,
                'rating' => rand(4, 5),
                'comment' => 'Great product! Highly recommended.',
                'is_verified_purchase' => true,
                'is_visible' => true,
            ]);
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('🔐 Owner Login:');
        $this->command->info('Email: '.$owner->email);
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('👤 Demo Seller:');
        $this->command->info('Email: seller1@example.com');
        $this->command->info('Password: password');
        $this->command->info('');
        $this->command->info('🛒 Demo Buyer:');
        $this->command->info('Email: buyer1@example.com');
        $this->command->info('Password: password');
    }
}
