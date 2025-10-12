<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckGoogleAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ga4:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Google Analytics 4 configuration and status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking Google Analytics 4 Configuration...');
        $this->newLine();

        // Check environment
        $environment = app()->environment();
        $this->line("Environment: <fg={$this->getEnvironmentColor($environment)}>{$environment}</>");

        // Check if GA4 is enabled
        $enabled = config('services.google_analytics.enabled');
        $this->line("GA4 Enabled: <fg=" . ($enabled ? 'green' : 'red') . ">" . ($enabled ? 'Yes' : 'No') . "</>");

        // Check measurement ID
        $measurementId = config('services.google_analytics.measurement_id');
        if ($measurementId) {
            $this->line("Measurement ID: <fg=green>{$measurementId}</>");
            
            // Validate format
            if (preg_match('/^G-[A-Z0-9]{10}$/', $measurementId)) {
                $this->line("Measurement ID Format: <fg=green>Valid</>");
            } else {
                $this->line("Measurement ID Format: <fg=red>Invalid (should be G-XXXXXXXXXX)</>");
            }
        } else {
            $this->line("Measurement ID: <fg=red>Not set</>");
        }

        // Check API secret
        $apiSecret = config('services.google_analytics.api_secret');
        $this->line("API Secret: " . ($apiSecret ? '<fg=green>Set</>' : '<fg=yellow>Not set (optional)</>'));

        $this->newLine();

        // Check if tracking will work
        $willTrack = $enabled && $measurementId && $environment === 'production';
        
        if ($willTrack) {
            $this->info('✅ Google Analytics 4 is properly configured and will track in production!');
        } elseif ($environment !== 'production') {
            $this->warn('⚠️  GA4 tracking is disabled in ' . $environment . ' environment (this is normal for development)');
        } else {
            $this->error('❌ Google Analytics 4 is not properly configured for production tracking');
            
            if (!$enabled) {
                $this->line('   - GA4 is disabled in configuration');
            }
            if (!$measurementId) {
                $this->line('   - Measurement ID is not set in .env file');
            }
        }

        $this->newLine();
        $this->line('💡 To configure GA4:');
        $this->line('   1. Add GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX to your .env file');
        $this->line('   2. Set APP_ENV=production for production environment');
        $this->line('   3. Run this command again to verify');
    }

    private function getEnvironmentColor(string $environment): string
    {
        return match ($environment) {
            'production' => 'green',
            'staging' => 'yellow',
            'testing' => 'blue',
            default => 'red',
        };
    }
}
