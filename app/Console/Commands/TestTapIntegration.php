<?php

namespace App\Console\Commands;

use App\Services\TapPaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestTapIntegration extends Command
{
    protected $signature = 'tap:test {--charge-id= : Test with specific charge ID}';
    protected $description = 'Test Tap payment gateway integration';

    public function handle(TapPaymentService $tapService): int
    {
        $this->info('🧪 Testing Tap Payment Gateway Integration...');
        $this->newLine();

        // Test 1: Configuration
        $this->info('1. Testing Configuration...');
        $this->line("   Sandbox Mode: " . ($tapService->isSandbox() ? '✅ Enabled' : '❌ Disabled'));
        $this->line("   Public Key: " . (strlen($tapService->getPublicKey()) > 0 ? '✅ Set' : '❌ Not Set'));
        $this->newLine();

        // Test 2: API Connection
        $this->info('2. Testing API Connection...');
        try {
            // Try to get a test charge to verify API connectivity
            $chargeId = $this->option('charge-id');
            if ($chargeId) {
                $charge = $tapService->getCharge($chargeId);
                $this->line("   ✅ API Connection: Success");
                $this->line("   Charge Status: " . ($charge['status'] ?? 'Unknown'));
            } else {
                $this->line("   ⚠️  API Connection: Skipped (no charge ID provided)");
                $this->line("   💡 Use --charge-id=CHARGE_ID to test API connection");
            }
        } catch (\Exception $e) {
            $this->line("   ❌ API Connection: Failed - " . $e->getMessage());
        }
        $this->newLine();

        // Test 3: Configuration Summary
        $this->info('3. Configuration Summary:');
        $this->line("   Environment: " . config('app.env'));
        $this->line("   API URL: " . config('services.tap.api_url'));
        $this->line("   Sandbox: " . (config('services.tap.sandbox') ? 'Yes' : 'No'));
        $this->line("   Secret Key: " . (config('services.tap.secret_key') ? 'Set (' . substr(config('services.tap.secret_key'), 0, 10) . '...)' : 'Not Set'));
        $this->line("   Public Key: " . (config('services.tap.public_key') ? 'Set (' . substr(config('services.tap.public_key'), 0, 10) . '...)' : 'Not Set'));
        $this->line("   Webhook Secret: " . (config('services.tap.webhook_secret') ? 'Set' : 'Not Set'));
        $this->newLine();

        // Test 4: Recommendations
        $this->info('4. Recommendations:');
        if (!config('services.tap.secret_key')) {
            $this->line("   ⚠️  Set TAP_SECRET_KEY in your .env file");
        }
        if (!config('services.tap.public_key')) {
            $this->line("   ⚠️  Set TAP_PUBLIC_KEY in your .env file");
        }
        if (!config('services.tap.webhook_secret')) {
            $this->line("   ⚠️  Set TAP_WEBHOOK_SECRET in your .env file");
        }
        if (config('services.tap.secret_key') && config('services.tap.public_key')) {
            $this->line("   ✅ Tap is ready for testing!");
            $this->line("   💡 Create a test payment to verify full integration");
        }

        $this->newLine();
        $this->info('🎉 Tap Integration Test Complete!');

        return Command::SUCCESS;
    }
}
