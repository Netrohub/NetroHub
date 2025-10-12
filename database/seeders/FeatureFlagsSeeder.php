<?php

namespace Database\Seeders;

use App\Models\FeatureFlag;
use Illuminate\Database\Seeder;

class FeatureFlagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flags = [
            [
                'key' => 'beta_dashboard',
                'name' => 'Beta Dashboard',
                'description' => 'New analytics dashboard with advanced charts and insights',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 25,
                'allowed_roles' => ['admin'],
            ],
            [
                'key' => 'premium_search',
                'name' => 'Premium Search Features',
                'description' => 'Advanced filtering, sorting, and search autocomplete',
                'is_enabled' => true,
                'environment' => 'all',
                'rollout_percentage' => 100,
            ],
            [
                'key' => 'live_chat',
                'name' => 'Live Chat Support',
                'description' => 'Real-time customer support chat widget',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 0,
            ],
            [
                'key' => 'product_offers',
                'name' => 'Product Offers System',
                'description' => 'Allow buyers to make offers on products',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 0,
            ],
            [
                'key' => 'wishlists',
                'name' => 'Wishlist Feature',
                'description' => 'Users can save products to wishlist for later',
                'is_enabled' => true,
                'environment' => 'all',
                'rollout_percentage' => 100,
            ],
            [
                'key' => 'seller_verification',
                'name' => 'Seller Verification Badge',
                'description' => 'Display verification badges for trusted sellers',
                'is_enabled' => true,
                'environment' => 'all',
                'rollout_percentage' => 100,
            ],
            [
                'key' => 'referral_program',
                'name' => 'Referral Program',
                'description' => 'Earn rewards by referring new users',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 50,
            ],
            [
                'key' => 'product_bundles',
                'name' => 'Product Bundles',
                'description' => 'Create and sell product bundles at discounted prices',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 0,
                'allowed_roles' => ['seller', 'admin'],
            ],
            [
                'key' => 'advanced_analytics',
                'name' => 'Advanced Analytics',
                'description' => 'Detailed analytics for sellers including traffic sources, conversion rates',
                'is_enabled' => false,
                'environment' => 'production',
                'rollout_percentage' => 0,
                'allowed_roles' => ['admin'],
            ],
            [
                'key' => 'social_sharing',
                'name' => 'Social Media Sharing',
                'description' => 'Share products directly to social media platforms',
                'is_enabled' => true,
                'environment' => 'all',
                'rollout_percentage' => 100,
            ],
            [
                'key' => 'product_reviews_moderation',
                'name' => 'Review Moderation',
                'description' => 'Require admin approval before reviews are published',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 100,
            ],
            [
                'key' => 'dynamic_pricing',
                'name' => 'Dynamic Pricing',
                'description' => 'Allow sellers to set time-based pricing and discounts',
                'is_enabled' => false,
                'environment' => 'all',
                'rollout_percentage' => 0,
            ],
        ];

        foreach ($flags as $flag) {
            FeatureFlag::updateOrCreate(
                ['key' => $flag['key']],
                $flag
            );
        }

        $this->command->info('Feature flags seeded successfully!');
    }
}
