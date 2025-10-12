<?php

namespace App\Jobs;

use App\Models\KycSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupKycDocuments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $retentionDays;

    /**
     * Create a new job instance.
     */
    public function __construct($retentionDays = 90)
    {
        $this->retentionDays = $retentionDays;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays($this->retentionDays);
        
        Log::info('Starting KYC document cleanup', [
            'retention_days' => $this->retentionDays,
            'cutoff_date' => $cutoffDate->toDateString(),
        ]);

        // Find old rejected submissions
        $oldRejectedSubmissions = KycSubmission::where('status', 'rejected')
            ->where('created_at', '<', $cutoffDate)
            ->get();

        $deletedCount = 0;
        $errorCount = 0;

        foreach ($oldRejectedSubmissions as $submission) {
            try {
                // Get the decrypted file path
                $filePath = $submission->getDecryptedImagePath();
                
                if ($filePath && Storage::disk('private')->exists($filePath)) {
                    // Delete the physical file
                    Storage::disk('private')->delete($filePath);
                    
                    // Anonymize the submission record
                    $submission->update([
                        'full_name' => '[ANONYMIZED]',
                        'id_image_path' => '[DELETED]',
                        'notes' => 'Document deleted after retention period',
                    ]);
                    
                    $deletedCount++;
                    
                    Log::info('KYC document cleaned up', [
                        'submission_id' => $submission->id,
                        'file_path' => $filePath,
                    ]);
                }
            } catch (\Exception $e) {
                $errorCount++;
                Log::error('Failed to cleanup KYC document', [
                    'submission_id' => $submission->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('KYC document cleanup completed', [
            'deleted_count' => $deletedCount,
            'error_count' => $errorCount,
            'total_processed' => $oldRejectedSubmissions->count(),
        ]);
    }
}