<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'group' => 'general',
                'value' => 'NXO',
                'type' => 'text',
                'description' => 'The name of your marketplace',
                'is_public' => true,
            ],
            [
                'key' => 'site_tagline',
                'group' => 'general',
                'value' => 'Your Premium Digital Marketplace',
                'type' => 'text',
                'description' => 'A short tagline describing your platform',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'group' => 'general',
                'value' => 'Buy and sell premium digital products, gaming accounts, and social media services.',
                'type' => 'textarea',
                'description' => 'Brief description for SEO and about page',
                'is_public' => true,
            ],
            [
                'key' => 'contact_email',
                'group' => 'general',
                'value' => 'support@nxo.com',
                'type' => 'text',
                'description' => 'Main contact email address',
                'is_public' => true,
            ],
            [
                'key' => 'support_email',
                'group' => 'general',
                'value' => 'help@nxo.com',
                'type' => 'text',
                'description' => 'Customer support email',
                'is_public' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'group' => 'general',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable maintenance mode to hide site from public',
                'is_public' => false,
            ],
            [
                'key' => 'registration_enabled',
                'group' => 'general',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Allow new user registrations',
                'is_public' => true,
            ],

            // Branding Settings
            [
                'key' => 'logo_url',
                'group' => 'branding',
                'value' => '/stellar-assets/images/logo.svg',
                'type' => 'image',
                'description' => 'Main logo displayed in header',
                'is_public' => true,
            ],
            [
                'key' => 'logo_dark_url',
                'group' => 'branding',
                'value' => '/stellar-assets/images/logo.svg',
                'type' => 'image',
                'description' => 'Dark mode logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_light_url',
                'group' => 'branding',
                'value' => '/stellar-assets/images/logo-light.svg',
                'type' => 'image',
                'description' => 'Light mode logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_monochrome_url',
                'group' => 'branding',
                'value' => '/stellar-assets/images/logo-monochrome.svg',
                'type' => 'image',
                'description' => 'Monochrome logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_horizontal_url',
                'group' => 'branding',
                'value' => '/stellar-assets/images/logo-horizontal.svg',
                'type' => 'image',
                'description' => 'Horizontal logo with tagline',
                'is_public' => true,
            ],
            [
                'key' => 'favicon_url',
                'group' => 'branding',
                'value' => '/favicon.svg',
                'type' => 'image',
                'description' => 'Favicon for browser tabs',
                'is_public' => true,
            ],
            [
                'key' => 'favicon_ico_url',
                'group' => 'branding',
                'value' => '/favicon.ico',
                'type' => 'image',
                'description' => 'Favicon ICO for older browsers',
                'is_public' => true,
            ],
            [
                'key' => 'primary_color',
                'group' => 'branding',
                'value' => '#00BFFF',
                'type' => 'color',
                'description' => 'Primary brand color (Electric Blue)',
                'is_public' => true,
            ],
            [
                'key' => 'secondary_color',
                'group' => 'branding',
                'value' => '#7B2FF7',
                'type' => 'color',
                'description' => 'Secondary brand color (Neon Purple)',
                'is_public' => true,
            ],

            // SEO Settings
            [
                'key' => 'seo_title',
                'group' => 'seo',
                'value' => 'NXO - Premium Digital Marketplace',
                'type' => 'text',
                'description' => 'Default page title for SEO',
                'is_public' => true,
            ],
            [
                'key' => 'seo_description',
                'group' => 'seo',
                'value' => 'Buy and sell premium digital products, gaming accounts, and social media services on NXO.',
                'type' => 'textarea',
                'description' => 'Default meta description',
                'is_public' => true,
            ],
            [
                'key' => 'seo_keywords',
                'group' => 'seo',
                'value' => 'digital marketplace, gaming accounts, social media accounts, digital products',
                'type' => 'text',
                'description' => 'Default meta keywords',
                'is_public' => true,
            ],
            [
                'key' => 'og_image',
                'group' => 'seo',
                'value' => '/img/nxo-og.svg',
                'type' => 'image',
                'description' => 'Open Graph image for social sharing (1200x630)',
                'is_public' => true,
            ],
            [
                'key' => 'google_analytics_id',
                'group' => 'seo',
                'value' => '',
                'type' => 'text',
                'description' => 'Google Analytics tracking ID (G-XXXXXXXXXX)',
                'is_public' => false,
            ],

            // Social Media
            [
                'key' => 'twitter_handle',
                'group' => 'social',
                'value' => '@nxo',
                'type' => 'text',
                'description' => 'Twitter/X handle',
                'is_public' => true,
            ],
            [
                'key' => 'facebook_url',
                'group' => 'social',
                'value' => '',
                'type' => 'text',
                'description' => 'Facebook page URL',
                'is_public' => true,
            ],
            [
                'key' => 'instagram_url',
                'group' => 'social',
                'value' => '',
                'type' => 'text',
                'description' => 'Instagram profile URL',
                'is_public' => true,
            ],
            [
                'key' => 'discord_url',
                'group' => 'social',
                'value' => '',
                'type' => 'text',
                'description' => 'Discord server invite URL',
                'is_public' => true,
            ],

            // Monetization Settings
            [
                'key' => 'platform_fee_percentage',
                'group' => 'monetization',
                'value' => '10',
                'type' => 'number',
                'description' => 'Default platform fee percentage (can be overridden by plans)',
                'is_public' => false,
            ],
            [
                'key' => 'minimum_payout',
                'group' => 'monetization',
                'value' => '50',
                'type' => 'number',
                'description' => 'Minimum balance required for payout',
                'is_public' => false,
            ],
            [
                'key' => 'payout_fee',
                'group' => 'monetization',
                'value' => '2',
                'type' => 'number',
                'description' => 'Fixed fee for payouts (in USD)',
                'is_public' => false,
            ],
            [
                'key' => 'free_listings_limit',
                'group' => 'monetization',
                'value' => '5',
                'type' => 'number',
                'description' => 'Number of free listings for free plan users',
                'is_public' => false,
            ],

            // Email Settings
            [
                'key' => 'email_from_address',
                'group' => 'email',
                'value' => 'noreply@nxo.com',
                'type' => 'text',
                'description' => 'From email address for outgoing emails',
                'is_public' => false,
            ],
            [
                'key' => 'email_from_name',
                'group' => 'email',
                'value' => 'NXO',
                'type' => 'text',
                'description' => 'From name for outgoing emails',
                'is_public' => false,
            ],
            [
                'key' => 'email_signature',
                'group' => 'email',
                'value' => 'Best regards,<br>The NXO Team',
                'type' => 'textarea',
                'description' => 'Default email signature',
                'is_public' => false,
            ],

            // Legal Settings
            [
                'key' => 'terms_last_updated',
                'group' => 'legal',
                'value' => now()->toDateString(),
                'type' => 'text',
                'description' => 'Date when Terms & Conditions were last updated',
                'is_public' => true,
            ],
            [
                'key' => 'privacy_last_updated',
                'group' => 'legal',
                'value' => now()->toDateString(),
                'type' => 'text',
                'description' => 'Date when Privacy Policy was last updated',
                'is_public' => true,
            ],
            [
                'key' => 'company_name',
                'group' => 'legal',
                'value' => 'NXO Inc.',
                'type' => 'text',
                'description' => 'Legal company name',
                'is_public' => true,
            ],
            [
                'key' => 'company_address',
                'group' => 'legal',
                'value' => '',
                'type' => 'textarea',
                'description' => 'Company registered address',
                'is_public' => true,
            ],

            // Features / Experiments
            [
                'key' => 'enable_chat',
                'group' => 'features',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Enable live chat support',
                'is_public' => false,
            ],
            [
                'key' => 'enable_reviews',
                'group' => 'features',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Allow product reviews',
                'is_public' => true,
            ],
            [
                'key' => 'enable_wishlists',
                'group' => 'features',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable wishlist functionality',
                'is_public' => true,
            ],
            [
                'key' => 'enable_offers',
                'group' => 'features',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Allow buyers to make offers on products',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Site settings seeded successfully!');
    }
}
