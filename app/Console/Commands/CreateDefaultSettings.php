<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class CreateDefaultSettings extends Command
{
    protected $signature = 'admin:create-settings';

    protected $description = 'Create default settings for the admin panel';

    public function handle()
    {
        $this->info('Creating default settings...');

        $defaultSettings = [
            [
                'key' => 'platform_commission_percent',
                'value' => '10',
                'type' => 'integer',
                'description' => 'Platform commission percentage on sales',
            ],
            [
                'key' => 'platform_name',
                'value' => 'NXO',
                'type' => 'string',
                'description' => 'Platform name',
            ],
            [
                'key' => 'min_payout_amount',
                'value' => '50',
                'type' => 'integer',
                'description' => 'Minimum payout amount in USD',
            ],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->info('Default settings created successfully!');
    }
}
