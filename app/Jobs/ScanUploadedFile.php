<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ScanUploadedFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $filePath,
        public string $disk = 'local'
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $fullPath = Storage::disk($this->disk)->path($this->filePath);
            
            // Basic file validation
            if (!$this->validateFile($fullPath)) {
                $this->quarantineFile();
                return;
            }

            // Re-encode images for security
            if ($this->isImageFile($fullPath)) {
                $this->reEncodeImage($fullPath);
            }

            // Run antivirus scan
            if (!$this->runAntivirusScan($fullPath)) {
                Log::warning('Antivirus scan failed', ['file_path' => $this->filePath]);
                $this->quarantineFile();
                return;
            }

            // Log successful scan
            Log::info('File scan completed successfully', [
                'file_path' => $this->filePath,
                'disk' => $this->disk
            ]);

        } catch (\Exception $e) {
            Log::error('File scan failed', [
                'file_path' => $this->filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->quarantineFile();
        }
    }

    /**
     * Validate file for security threats
     */
    private function validateFile(string $filePath): bool
    {
        // Check if file exists
        if (!file_exists($filePath)) {
            return false;
        }

        // Check file size (max 5MB for security)
        if (filesize($filePath) > 5 * 1024 * 1024) {
            Log::warning('File too large', ['file_path' => $this->filePath, 'size' => filesize($filePath)]);
            return false;
        }

        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'application/pdf',
            'text/plain',
        ];

        if (!in_array($mimeType, $allowedMimeTypes)) {
            return false;
        }

        // Check file extension
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'txt'];

        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        // Check for malicious content in file headers
        if ($this->containsMaliciousContent($filePath)) {
            return false;
        }

        return true;
    }

    /**
     * Check for malicious content in file
     */
    private function containsMaliciousContent(string $filePath): bool
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return true; // Treat as malicious if we can't read
        }

        // Read first 1KB to check for malicious signatures
        $content = fread($handle, 1024);
        fclose($handle);

        $maliciousSignatures = [
            '<?php',
            '<script',
            'javascript:',
            'vbscript:',
            'data:text/html',
            'eval(',
            'base64_decode(',
            'gzinflate(',
            'str_rot13(',
        ];

        foreach ($maliciousSignatures as $signature) {
            if (stripos($content, $signature) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Re-encode image for security
     */
    private function reEncodeImage(string $filePath): void
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($filePath);
            
            // Re-encode the image to remove any embedded malicious content
            $image->toJpeg(90)->save($filePath);
            
        } catch (\Exception $e) {
            Log::warning('Image re-encoding failed', [
                'file_path' => $filePath,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check if file is an image
     */
    private function isImageFile(string $filePath): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        return in_array($extension, $imageExtensions);
    }

    /**
     * Run antivirus scan on file
     */
    private function runAntivirusScan(string $filePath): bool
    {
        try {
            // Check if ClamAV is available
            $clamavPath = config('services.clamav.path', '/usr/bin/clamscan');
            
            if (!file_exists($clamavPath)) {
                Log::warning('ClamAV not available, skipping antivirus scan', ['file_path' => $filePath]);
                return true; // Allow file if ClamAV not available
            }

            // Run ClamAV scan
            $command = escapeshellcmd($clamavPath) . ' --no-summary --infected --stdout ' . escapeshellarg($filePath);
            $output = [];
            $returnCode = 0;
            
            exec($command, $output, $returnCode);
            
            // Return code 0 means no threats found
            if ($returnCode === 0) {
                Log::info('Antivirus scan passed', ['file_path' => $filePath]);
                return true;
            }
            
            // Return code 1 means threats found
            Log::warning('Antivirus scan detected threats', [
                'file_path' => $filePath,
                'output' => implode("\n", $output)
            ]);
            return false;
            
        } catch (\Exception $e) {
            Log::error('Antivirus scan failed with exception', [
                'file_path' => $filePath,
                'error' => $e->getMessage()
            ]);
            return false; // Fail safe - quarantine if scan fails
        }
    }

    /**
     * Quarantine malicious file
     */
    private function quarantineFile(): void
    {
        try {
            $quarantinePath = 'quarantine/' . basename($this->filePath) . '_' . time();
            Storage::disk($this->disk)->move($this->filePath, $quarantinePath);
            
            Log::warning('File quarantined', [
                'original_path' => $this->filePath,
                'quarantine_path' => $quarantinePath
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to quarantine file', [
                'file_path' => $this->filePath,
                'error' => $e->getMessage()
            ]);
        }
    }
}
