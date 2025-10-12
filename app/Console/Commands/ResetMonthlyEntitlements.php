<?php

namespace App\Console\Commands;

use App\Services\EntitlementsService;
use Illuminate\Console\Command;

class ResetMonthlyEntitlements extends Command
{
    protected $signature = 'entitlements:reset-monthly';

    protected $description = 'Reset monthly entitlements (boost slots, etc.)';

    public function handle(EntitlementsService $entitlementsService): int
    {
        $this->info('Resetting monthly entitlements...');

        $entitlementsService->resetMonthlyEntitlements();

        $this->info('Monthly entitlements reset successfully!');

        return Command::SUCCESS;
    }
}
