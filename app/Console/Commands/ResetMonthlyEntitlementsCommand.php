<?php

namespace App\Console\Commands;

use App\Jobs\ResetMonthlyEntitlements;
use Illuminate\Console\Command;

class ResetMonthlyEntitlementsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entitlements:reset-monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset monthly entitlements for all users (e.g., boost slots, username changes)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting monthly entitlements reset...');
        
        // Dispatch the job to handle the actual reset
        ResetMonthlyEntitlements::dispatch();
        
        $this->info('Monthly entitlements reset job dispatched successfully.');
        
        return Command::SUCCESS;
    }
}