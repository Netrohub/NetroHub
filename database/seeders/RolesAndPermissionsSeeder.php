<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions
        $permissions = [
            // Users
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'ban_users',
            'impersonate_users',
            
            // Sellers & KYC
            'view_sellers',
            'edit_sellers',
            'approve_kyc',
            'reject_kyc',
            
            // Products
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            'feature_products',
            'moderate_products',
            
            // Orders
            'view_orders',
            'edit_orders',
            'refund_orders',
            'cancel_orders',
            
            // Disputes
            'view_disputes',
            'resolve_disputes',
            
            // Reviews
            'view_reviews',
            'moderate_reviews',
            'delete_reviews',
            
            // Reports
            'view_reports',
            'moderate_reports',
            
            // Wallet & Payouts
            'view_wallets',
            'view_payouts',
            'approve_payouts',
            'reject_payouts',
            
            // Subscriptions
            'view_subscriptions',
            'edit_subscriptions',
            'manage_plans',
            
            // Payments & Webhooks
            'view_webhooks',
            'replay_webhooks',
            'manage_payment_settings',
            
            // CMS
            'view_cms_pages',
            'create_cms_pages',
            'edit_cms_pages',
            'delete_cms_pages',
            'publish_cms_pages',
            
            // Email Templates
            'view_email_templates',
            'edit_email_templates',
            'test_email_templates',
            
            // Announcements
            'view_announcements',
            'create_announcements',
            'edit_announcements',
            'delete_announcements',
            
            // Settings
            'view_settings',
            'edit_settings',
            'publish_settings',
            
            // Navigation
            'manage_navigation',
            
            // Copy Strings
            'manage_copy_strings',
            
            // Media
            'manage_media',
            
            // Audit Logs
            'view_audit_logs',
            
            // Developer Tools
            'access_developer_tools',
            'manage_queues',
            'trigger_backups',
            
            // Dashboard
            'view_dashboard',
            'view_health_checks',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // SuperAdmin - has all permissions
        $superAdmin = Role::create(['name' => 'SuperAdmin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Moderator - content moderation
        $moderator = Role::create(['name' => 'Moderator']);
        $moderator->givePermissionTo([
            'view_dashboard',
            'view_users',
            'view_sellers',
            'view_products',
            'moderate_products',
            'view_orders',
            'view_disputes',
            'resolve_disputes',
            'view_reviews',
            'moderate_reviews',
            'delete_reviews',
            'view_reports',
            'moderate_reports',
            'view_audit_logs',
        ]);

        // Finance - payments and payouts
        $finance = Role::create(['name' => 'Finance']);
        $finance->givePermissionTo([
            'view_dashboard',
            'view_users',
            'view_sellers',
            'view_orders',
            'refund_orders',
            'view_wallets',
            'view_payouts',
            'approve_payouts',
            'reject_payouts',
            'view_subscriptions',
            'view_webhooks',
            'view_audit_logs',
        ]);

        // Support - user support
        $support = Role::create(['name' => 'Support']);
        $support->givePermissionTo([
            'view_dashboard',
            'view_users',
            'view_sellers',
            'view_products',
            'view_orders',
            'view_disputes',
            'view_reviews',
            'view_reports',
            'view_subscriptions',
            'view_audit_logs',
        ]);

        // Content - CMS and content management
        $content = Role::create(['name' => 'Content']);
        $content->givePermissionTo([
            'view_dashboard',
            'view_cms_pages',
            'create_cms_pages',
            'edit_cms_pages',
            'delete_cms_pages',
            'publish_cms_pages',
            'view_email_templates',
            'edit_email_templates',
            'view_announcements',
            'create_announcements',
            'edit_announcements',
            'delete_announcements',
            'manage_navigation',
            'manage_copy_strings',
            'manage_media',
        ]);
        
        // Regular user roles
        Role::create(['name' => 'user']);
        Role::create(['name' => 'seller']);
        Role::create(['name' => 'owner']);
    }
}
