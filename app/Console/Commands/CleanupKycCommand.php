<?php

namespace App\Console\Commands;

use App\Jobs\CleanupKycDocuments;
use Illuminate\Console\Command;

class CleanupKycCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kyc:cleanup {--days=90 : Number of days to retain rejected documents}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old KYC documents and anonymize rejected submissions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $retentionDays = $this->option('days');
        
        $this->info("Starting KYC cleanup process...");
        $this->info("Retention period: {$retentionDays} days");
        
        // Dispatch the cleanup job
        CleanupKycDocuments::dispatch($retentionDays);
        
        $this->info('KYC cleanup job has been dispatched.');
        $this->info('Check the logs for cleanup results.');
        
        return 0;
    }
}