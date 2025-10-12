<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDemoData extends Command
{
    protected $signature = 'admin:demo-data';

    protected $description = 'Create demo data for admin panel';

    public function handle()
    {
        $this->info('Creating demo data...');

        // Create categories if they don't exist
        $categories = [
            ['name' => 'Software & Tools', 'slug' => 'software-tools', 'icon' => '💻', 'description' => 'Software applications and development tools'],
            ['name' => 'Graphics & Design', 'slug' => 'graphics-design', 'icon' => '🎨', 'description' => 'Graphics templates, design assets'],
            ['name' => 'Game Accounts', 'slug' => 'game-accounts', 'icon' => '🎮', 'description' => 'Gaming accounts and items'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }

        // Create sellers if they don't exist
        $sellers = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = User::firstOrCreate(
                ['email' => "seller{$i}@example.com"],
                [
                    'name' => "Seller {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );
            $user->assignRole('seller');

            $seller = Seller::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'display_name' => "Seller {$i}",
                    'bio' => 'Professional digital creator with years of experience.',
                    'kyc_status' => $i === 1 ? 'approved' : 'pending',
                    'is_active' => true,
                    'rating' => rand(40, 50) / 10,
                    'total_sales' => rand(5, 50),
                ]
            );

            $sellers[] = $seller;
        }

        // Create products
        $productTemplates = [
            ['title' => 'Premium Website Template', 'price' => 49.99, 'delivery_type' => 'file'],
            ['title' => 'Fortnite Account Level 200', 'price' => 89.99, 'delivery_type' => 'code'],
            ['title' => 'Instagram Growth Service', 'price' => 29.99, 'delivery_type' => 'file'],
            ['title' => 'Stock Photo Bundle', 'price' => 19.99, 'delivery_type' => 'file'],
            ['title' => 'TikTok Account 10K Followers', 'price' => 99.99, 'delivery_type' => 'code'],
        ];

        $allCategories = Category::all();

        foreach ($productTemplates as $index => $productData) {
            $seller = $sellers[array_rand($sellers)];
            $category = $allCategories->random();

            Product::firstOrCreate(
                ['title' => $productData['title']],
                [
                    'seller_id' => $seller->id,
                    'category_id' => $category->id,
                    'description' => 'High-quality digital product with instant delivery.',
                    'features' => ['High quality', 'Instant delivery', 'Money-back guarantee'],
                    'tags' => ['popular', 'trending'],
                    'price' => $productData['price'],
                    'delivery_type' => $productData['delivery_type'],
                    'status' => 'active',
                    'is_featured' => $index < 2,
                    'views_count' => rand(100, 1000),
                    'sales_count' => rand(10, 100),
                    'rating' => rand(40, 50) / 10,
                    'reviews_count' => rand(5, 20),
                ]
            );
        }

        // Create some orders
        $buyers = User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })->get();

        if ($buyers->count() == 0) {
            for ($i = 1; $i <= 5; $i++) {
                $user = User::create([
                    'name' => "Buyer {$i}",
                    'email' => "buyer{$i}@example.com",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);
                $user->assignRole('user');
                $buyers->push($user);
            }
        }

        $products = Product::all();

        for ($i = 0; $i < 10; $i++) {
            $buyer = $buyers->random();
            $product = $products->random();

            Order::create([
                'user_id' => $buyer->id,
                'subtotal' => $product->price,
                'platform_fee' => $product->price * 0.1,
                'total' => $product->price * 1.1,
                'currency' => 'USD',
                'payment_method' => 'paddle',
                'payment_status' => 'completed',
                'status' => 'completed',
                'buyer_email' => $buyer->email,
                'buyer_name' => $buyer->name,
                'paid_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->info('Demo data created successfully!');
        $this->info('- Created categories, sellers, products, and orders');
        $this->info('- Admin panel dashboard should now show meaningful statistics');
    }
}
