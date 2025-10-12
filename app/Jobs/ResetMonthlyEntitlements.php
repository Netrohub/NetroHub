<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\EntitlementsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetMonthlyEntitlements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(EntitlementsService $entitlementsService): void
    {
        Log::info('Starting monthly entitlements reset');

        $resetCount = 0;
        $errorCount = 0;

        User::with('activeSubscription')->chunk(100, function ($users) use ($entitlementsService, &$resetCount, &$errorCount) {
            foreach ($users as $user) {
                try {
                    $entitlementsService->resetMonthlyEntitlements($user);
                    $resetCount++;
                } catch (\Exception $e) {
                    Log::error('Failed to reset entitlements for user', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);
                    $errorCount++;
                }
            }
        });

        Log::info('Monthly entitlements reset completed', [
            'users_processed' => $resetCount,
            'errors' => $errorCount
        ]);
    }
}