<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSetupSeeder extends Seeder
{
    public function run(): void
    {
        // Create SuperAdmin user
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@netrohub.com',
            'password' => Hash::make('Admin@123456'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assign SuperAdmin role
        $superAdminRole = Role::where('name', 'SuperAdmin')->first();
        if ($superAdminRole) {
            $admin->assignRole($superAdminRole);
        }

        // Create initial CMS pages
        $this->createCmsPages();

        // Create email templates
        $this->createEmailTemplates();

        $this->command->info('Admin user created:');
        $this->command->info('Email: admin@netrohub.com');
        $this->command->info('Password: Admin@123456');
    }

    protected function createCmsPages(): void
    {
        $pages = [
            [
                'slug' => 'terms-of-service',
                'title' => 'Terms of Service',
                'content' => '<h1>Terms of Service</h1><p>Welcome to NetroHub. By using our platform, you agree to these terms...</p>',
                'status' => 'published',
                'meta_title' => 'Terms of Service - NetroHub',
                'meta_description' => 'Read our terms of service for using the NetroHub marketplace.',
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us. This policy explains how we collect and use your data...</p>',
                'status' => 'published',
                'meta_title' => 'Privacy Policy - NetroHub',
                'meta_description' => 'Learn about how NetroHub protects your privacy.',
            ],
            [
                'slug' => 'refund-policy',
                'title' => 'Refund & Dispute Policy',
                'content' => '<h1>Refund & Dispute Policy</h1><p>We want you to be satisfied with your purchase. Here\'s our refund policy...</p>',
                'status' => 'published',
                'meta_title' => 'Refund Policy - NetroHub',
                'meta_description' => 'Understand our refund and dispute resolution process.',
            ],
            [
                'slug' => 'seller-agreement',
                'title' => 'Seller Agreement',
                'content' => '<h1>Seller Agreement</h1><p>As a seller on NetroHub, you agree to the following terms...</p>',
                'status' => 'published',
                'meta_title' => 'Seller Agreement - NetroHub',
                'meta_description' => 'Terms and conditions for sellers on NetroHub.',
            ],
            [
                'slug' => 'about',
                'title' => 'About NetroHub',
                'content' => '<h1>About Us</h1><p>NetroHub is a digital marketplace connecting buyers and sellers...</p>',
                'status' => 'published',
                'meta_title' => 'About NetroHub',
                'meta_description' => 'Learn more about NetroHub and our mission.',
            ],
        ];

        foreach ($pages as $pageData) {
            CmsPage::create($pageData);
        }

        $this->command->info('Created ' . count($pages) . ' CMS pages');
    }

    protected function createEmailTemplates(): void
    {
        $templates = [
            [
                'key' => 'order_receipt',
                'name' => 'Order Receipt',
                'description' => 'Sent to buyer after successful purchase',
                'subject' => 'Your Order #{{order_id}} - NetroHub',
                'body' => '<h2>Thank you for your purchase!</h2><p>Hi {{user_name}},</p><p>Your order #{{order_id}} has been completed.</p><p><strong>Total:</strong> ${{total}}</p><p>You can view your order details and download your items here: <a href="{{order_url}}">View Order</a></p>',
                'available_variables' => ['user_name', 'order_id', 'total', 'order_url'],
                'is_active' => true,
            ],
            [
                'key' => 'new_sale',
                'name' => 'New Sale Notification',
                'description' => 'Sent to seller when they make a sale',
                'subject' => 'You made a sale! Order #{{order_id}}',
                'body' => '<h2>Congratulations on your sale!</h2><p>Hi {{seller_name}},</p><p>You just made a sale!</p><p><strong>Product:</strong> {{product_name}}</p><p><strong>Amount:</strong> ${{amount}}</p><p><a href="{{order_url}}">View Order Details</a></p>',
                'available_variables' => ['seller_name', 'order_id', 'product_name', 'amount', 'order_url'],
                'is_active' => true,
            ],
            [
                'key' => 'refund_processed',
                'name' => 'Refund Processed',
                'description' => 'Sent when a refund is processed',
                'subject' => 'Refund Processed - Order #{{order_id}}',
                'body' => '<h2>Your refund has been processed</h2><p>Hi {{user_name}},</p><p>Your refund for order #{{order_id}} has been processed.</p><p><strong>Amount:</strong> ${{refund_amount}}</p><p>It may take 5-10 business days for the funds to appear in your account.</p>',
                'available_variables' => ['user_name', 'order_id', 'refund_amount'],
                'is_active' => true,
            ],
            [
                'key' => 'payout_approved',
                'name' => 'Payout Approved',
                'description' => 'Sent when seller payout is approved',
                'subject' => 'Your payout has been approved',
                'body' => '<h2>Payout Approved</h2><p>Hi {{seller_name}},</p><p>Your payout request of ${{amount}} has been approved and processed.</p><p>You should receive the funds within {{processing_days}} business days.</p>',
                'available_variables' => ['seller_name', 'amount', 'processing_days'],
                'is_active' => true,
            ],
            [
                'key' => 'verification_email',
                'name' => 'Email Verification',
                'description' => 'Email verification link',
                'subject' => 'Verify your email address',
                'body' => '<h2>Welcome to NetroHub!</h2><p>Hi {{user_name}},</p><p>Please verify your email address by clicking the link below:</p><p><a href="{{verification_url}}">Verify Email</a></p><p>This link will expire in 24 hours.</p>',
                'available_variables' => ['user_name', 'verification_url'],
                'is_active' => true,
            ],
            [
                'key' => 'review_reply',
                'name' => 'Review Reply Notification',
                'description' => 'Sent when seller replies to a review',
                'subject' => 'The seller replied to your review',
                'body' => '<h2>New Reply to Your Review</h2><p>Hi {{user_name}},</p><p>The seller has replied to your review for {{product_name}}.</p><p><a href="{{review_url}}">View Reply</a></p>',
                'available_variables' => ['user_name', 'product_name', 'review_url'],
                'is_active' => true,
            ],
            [
                'key' => 'subscription_activated',
                'name' => 'Subscription Activated',
                'description' => 'Sent when subscription becomes active',
                'subject' => 'Welcome to {{plan_name}}!',
                'body' => '<h2>Your subscription is active!</h2><p>Hi {{user_name}},</p><p>Your {{plan_name}} subscription is now active.</p><p><strong>Benefits:</strong></p><ul>{{benefits_list}}</ul><p>Your subscription will renew on {{renewal_date}}.</p>',
                'available_variables' => ['user_name', 'plan_name', 'benefits_list', 'renewal_date'],
                'is_active' => true,
            ],
        ];

        foreach ($templates as $templateData) {
            EmailTemplate::create($templateData);
        }

        $this->command->info('Created ' . count($templates) . ' email templates');
    }
}

