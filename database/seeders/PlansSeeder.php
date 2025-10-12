<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanFeature;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing plans (disable foreign key checks temporarily)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PlanFeature::query()->delete();
        Plan::query()->delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Free Plan
        $freePlan = Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'price_month' => 0,
            'price_year' => 0,
            'currency' => 'USD',
            'paddle_price_id_month' => null,
            'paddle_price_id_year' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->createFeatures($freePlan, [
            ['key' => 'can_list_accounts', 'label' => 'Can list accounts', 'value' => true, 'type' => 'boolean', 'sort' => 1],
            ['key' => 'can_open_disputes', 'label' => 'Can open disputes', 'value' => true, 'type' => 'boolean', 'sort' => 2],
            ['key' => 'boost_slots', 'label' => '1 "boost" slot per month', 'value' => 1, 'type' => 'integer', 'sort' => 3],
            ['key' => 'draft_limit', 'label' => '1 draft listing storage', 'value' => 1, 'type' => 'integer', 'sort' => 4],
            ['key' => 'platform_fee_pct', 'label' => 'Standard platform fee (10%)', 'value' => 10, 'type' => 'decimal', 'sort' => 5],
        ]);

        // Plus Plan
        $plusPlan = Plan::create([
            'name' => 'Plus',
            'slug' => 'plus',
            'price_month' => 9.90,
            'price_year' => 99.00,
            'currency' => 'USD',
            'paddle_price_id_month' => env('PADDLE_PRICE_PLUS_MONTHLY', null),
            'paddle_price_id_year' => env('PADDLE_PRICE_PLUS_YEARLY', null),
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $this->createFeatures($plusPlan, [
            ['key' => 'has_name_badge', 'label' => 'Name tag badge next to profile', 'value' => true, 'type' => 'boolean', 'sort' => 1],
            ['key' => 'platform_fee_pct', 'label' => 'Reduced platform fee (7%)', 'value' => 7, 'type' => 'decimal', 'sort' => 2],
            ['key' => 'payout_fee_discount_pct', 'label' => 'Reduced payout fee (-2%) up to $5', 'value' => 2, 'type' => 'decimal', 'sort' => 3],
            ['key' => 'priority_listing_social', 'label' => 'Priority listing eligibility for Social (TikTok/Instagram/Twitter)', 'value' => true, 'type' => 'boolean', 'sort' => 4],
            ['key' => 'boost_slots', 'label' => '3 boosts / month', 'value' => 3, 'type' => 'integer', 'sort' => 5],
            ['key' => 'draft_limit', 'label' => '3 draft storage', 'value' => 3, 'type' => 'integer', 'sort' => 6],
            ['key' => 'priority_support', 'label' => 'Priority support', 'value' => true, 'type' => 'boolean', 'sort' => 7],
            ['key' => 'username_changes', 'label' => '1 free username change / month', 'value' => 1, 'type' => 'integer', 'sort' => 8],
            ['key' => 'waive_dispute_fee_under', 'label' => 'Waive dispute processing fee on orders ≤ $10', 'value' => 10, 'type' => 'decimal', 'sort' => 9, 'is_new' => true],
        ]);

        // Pro Plan
        $proPlan = Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'price_month' => 39.90,
            'price_year' => 399.00,
            'currency' => 'USD',
            'paddle_price_id_month' => env('PADDLE_PRICE_PRO_MONTHLY', null),
            'paddle_price_id_year' => env('PADDLE_PRICE_PRO_YEARLY', null),
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $this->createFeatures($proPlan, [
            ['key' => 'has_pro_badge', 'label' => 'Pro badge next to name', 'value' => true, 'type' => 'boolean', 'sort' => 1],
            ['key' => 'platform_fee_pct', 'label' => 'Lowest platform fee (5%)', 'value' => 5, 'type' => 'decimal', 'sort' => 2],
            ['key' => 'payout_fee_discount_pct', 'label' => 'Lowest payout fee (−3%) up to $10', 'value' => 3, 'type' => 'decimal', 'sort' => 3],
            ['key' => 'featured_placement', 'label' => 'Featured placement (carousel / highlight)', 'value' => true, 'type' => 'boolean', 'sort' => 4],
            ['key' => 'boost_slots', 'label' => '10 boosts / month', 'value' => 10, 'type' => 'integer', 'sort' => 5],
            ['key' => 'draft_limit', 'label' => '10 draft storage', 'value' => 10, 'type' => 'integer', 'sort' => 6],
            ['key' => 'priority_verification', 'label' => 'Priority verification & seller review', 'value' => true, 'type' => 'boolean', 'sort' => 7],
            ['key' => 'early_access_categories', 'label' => 'Early access to new categories', 'value' => true, 'type' => 'boolean', 'sort' => 8],
            ['key' => 'zero_rush_withdrawal_fee', 'label' => 'Zero "rush withdrawal" fee', 'value' => true, 'type' => 'boolean', 'sort' => 9, 'is_new' => true],
        ]);

        $this->command->info('Plans seeded successfully!');
        $this->command->info('Free: 5 features');
        $this->command->info('Plus: 9 features (including 1 new)');
        $this->command->info('Pro: 9 features (including 1 new)');
    }

    /**
     * Create features for a plan
     */
    private function createFeatures(Plan $plan, array $features): void
    {
        foreach ($features as $feature) {
            PlanFeature::create([
                'plan_id' => $plan->id,
                'key' => $feature['key'],
                'label' => $feature['label'],
                'value_json' => [
                    'value' => $feature['value'],
                    'type' => $feature['type'],
                ],
                'sort_order' => $feature['sort'],
                'is_new' => $feature['is_new'] ?? false,
            ]);
        }
    }
}
