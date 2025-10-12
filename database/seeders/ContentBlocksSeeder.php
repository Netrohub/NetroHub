<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use Illuminate\Database\Seeder;

class ContentBlocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blocks = [
            // Hero Section
            [
                'identifier' => 'homepage_hero',
                'page' => 'homepage',
                'section' => 'hero',
                'order' => 1,
                'type' => 'hero',
                'title' => 'Buy & Sell Digital Products',
                'content' => 'The easiest way to monetize your digital creations. Start selling in seconds with just one click.',
                'metadata' => [
                    'subtitle' => 'Your Premium Digital Marketplace',
                    'cta_primary_text' => 'Browse Products',
                    'cta_primary_link' => '/products',
                    'cta_secondary_text' => 'Start Selling',
                    'cta_secondary_link' => '/sell',
                    'background_image' => null,
                    'icon' => 'box',
                ],
                'is_active' => true,
                'visibility' => 'public',
            ],

            // Features Section
            [
                'identifier' => 'homepage_features',
                'page' => 'homepage',
                'section' => 'features',
                'order' => 2,
                'type' => 'grid',
                'title' => 'Why Choose NetroHub?',
                'content' => 'Everything you need to succeed in digital commerce',
                'metadata' => [
                    'features' => [
                        [
                            'icon' => '🔒',
                            'title' => 'Secure Transactions',
                            'description' => 'Military-grade encryption for all payments and data',
                        ],
                        [
                            'icon' => '⚡',
                            'title' => 'Instant Delivery',
                            'description' => 'Automated delivery system sends products immediately',
                        ],
                        [
                            'icon' => '💰',
                            'title' => 'Low Fees',
                            'description' => 'Competitive rates starting at just 5% per transaction',
                        ],
                        [
                            'icon' => '🌍',
                            'title' => 'Global Reach',
                            'description' => 'Sell to customers worldwide in 50+ countries',
                        ],
                        [
                            'icon' => '📊',
                            'title' => 'Analytics',
                            'description' => 'Real-time insights into your sales and performance',
                        ],
                        [
                            'icon' => '🛡️',
                            'title' => 'Buyer Protection',
                            'description' => 'Money-back guarantee and dispute resolution',
                        ],
                    ],
                ],
                'is_active' => true,
                'visibility' => 'public',
            ],

            // Stats Section
            [
                'identifier' => 'homepage_stats',
                'page' => 'homepage',
                'section' => 'stats',
                'order' => 3,
                'type' => 'stats',
                'title' => 'Trusted by Thousands',
                'content' => 'Join our growing community of digital entrepreneurs',
                'metadata' => [
                    'stats' => [
                        ['value' => 15000, 'label' => 'Products Listed', 'suffix' => '+'],
                        ['value' => 50000, 'label' => 'Active Users', 'suffix' => '+'],
                        ['value' => 98, 'label' => 'Satisfaction Rate', 'suffix' => '%'],
                        ['value' => 1000000, 'label' => 'Total Sales', 'suffix' => '+'],
                    ],
                ],
                'is_active' => true,
                'visibility' => 'public',
            ],

            // How It Works
            [
                'identifier' => 'homepage_how_it_works',
                'page' => 'homepage',
                'section' => 'how_it_works',
                'order' => 4,
                'type' => 'steps',
                'title' => 'How NetroHub Works',
                'content' => 'Get started in three simple steps',
                'metadata' => [
                    'steps' => [
                        [
                            'icon' => '👤',
                            'title' => 'Create Account',
                            'description' => 'Sign up in seconds. One account for buying and selling.',
                        ],
                        [
                            'icon' => '📦',
                            'title' => 'List Products',
                            'description' => 'Upload your digital products and set your price.',
                        ],
                        [
                            'icon' => '💸',
                            'title' => 'Get Paid',
                            'description' => 'Receive payments instantly when customers buy.',
                        ],
                    ],
                ],
                'is_active' => true,
                'visibility' => 'public',
            ],

            // Testimonials
            [
                'identifier' => 'homepage_testimonials',
                'page' => 'homepage',
                'section' => 'testimonials',
                'order' => 5,
                'type' => 'testimonials',
                'title' => 'What Our Users Say',
                'content' => 'Hear from successful sellers on our platform',
                'metadata' => [
                    'testimonials' => [
                        [
                            'name' => 'Alex Chen',
                            'role' => 'Game Developer',
                            'avatar' => '/images/avatars/avatar1.jpg',
                            'rating' => 5,
                            'content' => 'NetroHub made it incredibly easy to sell my game assets. The automated delivery is a game-changer!',
                        ],
                        [
                            'name' => 'Sarah Miller',
                            'role' => 'Digital Artist',
                            'avatar' => '/images/avatars/avatar2.jpg',
                            'rating' => 5,
                            'content' => 'I\'ve been using NetroHub for 6 months and made over $10,000. The platform is intuitive and reliable.',
                        ],
                        [
                            'name' => 'James Wilson',
                            'role' => 'Social Media Manager',
                            'avatar' => '/images/avatars/avatar3.jpg',
                            'rating' => 5,
                            'content' => 'Best marketplace for social media accounts. Great support team and fair pricing structure.',
                        ],
                    ],
                ],
                'is_active' => true,
                'visibility' => 'public',
            ],

            // CTA Section
            [
                'identifier' => 'homepage_cta',
                'page' => 'homepage',
                'section' => 'cta',
                'order' => 6,
                'type' => 'cta',
                'title' => 'Ready to Start Selling?',
                'content' => 'Join thousands of sellers who trust NetroHub with their digital products',
                'metadata' => [
                    'cta_text' => 'Create Free Account',
                    'cta_link' => '/register',
                    'secondary_text' => 'Browse Products',
                    'secondary_link' => '/products',
                    'background_gradient' => true,
                ],
                'is_active' => true,
                'visibility' => 'public',
            ],
        ];

        foreach ($blocks as $block) {
            ContentBlock::updateOrCreate(
                ['identifier' => $block['identifier']],
                $block
            );
        }

        $this->command->info('Homepage content blocks seeded successfully!');
    }
}
