<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class HealthController extends Controller
{
    public function check()
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'queue' => $this->checkQueue(),
            'storage' => $this->checkStorage(),
            'mail' => $this->checkMail(),
        ];

        $allHealthy = collect($checks)->every(fn ($check) => $check['healthy']);

        $status = $allHealthy ? 200 : 503;

        return response()->json([
            'status' => $allHealthy ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toISOString(),
            'checks' => $checks,
        ], $status);
    }

    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();

            return [
                'healthy' => true,
                'message' => 'Database connection successful',
                'details' => [
                    'driver' => DB::connection()->getDriverName(),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Database connection failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function checkQueue(): array
    {
        try {
            // Test queue connection
            $queue = Queue::connection();

            return [
                'healthy' => true,
                'message' => 'Queue connection successful',
                'details' => [
                    'driver' => config('queue.default'),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Queue connection failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function checkStorage(): array
    {
        try {
            $testFile = 'health-check-'.time().'.txt';
            $testContent = 'Health check test file';

            // Test write
            Storage::put($testFile, $testContent);

            // Test read
            $content = Storage::get($testFile);

            // Test delete
            Storage::delete($testFile);

            return [
                'healthy' => $content === $testContent,
                'message' => 'Storage operations successful',
                'details' => [
                    'driver' => config('filesystems.default'),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Storage operations failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    private function checkMail(): array
    {
        try {
            // Just check if mail configuration is valid
            $mailer = Mail::getMailer();

            return [
                'healthy' => true,
                'message' => 'Mail configuration valid',
                'details' => [
                    'driver' => config('mail.default'),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Mail configuration invalid',
                'error' => $e->getMessage(),
            ];
        }
    }
}
