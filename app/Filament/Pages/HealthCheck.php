<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HealthCheck extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static string $view = 'filament.pages.health-check';
    
    protected static ?string $navigationGroup = 'System';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $title = 'System Health';

    public array $checks = [];

    public function mount(): void
    {
        $this->checks = $this->runHealthChecks();
    }

    protected function runHealthChecks(): array
    {
        return [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
            'queue' => $this->checkQueue(),
            'environment' => $this->getEnvironmentInfo(),
        ];
    }

    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            $version = DB::select('SELECT VERSION() as version')[0]->version ?? 'Unknown';
            return [
                'status' => 'healthy',
                'message' => "Connected (Version: {$version})",
                'color' => 'success',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'color' => 'danger',
            ];
        }
    }

    protected function checkCache(): array
    {
        try {
            $key = 'health_check_' . time();
            Cache::put($key, 'test', 10);
            $value = Cache::get($key);
            Cache::forget($key);
            
            if ($value === 'test') {
                return [
                    'status' => 'healthy',
                    'message' => 'Cache is working',
                    'color' => 'success',
                ];
            }
            
            return [
                'status' => 'warning',
                'message' => 'Cache test failed',
                'color' => 'warning',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'color' => 'danger',
            ];
        }
    }

    protected function checkStorage(): array
    {
        try {
            $disks = ['local', 'public'];
            $status = [];
            
            foreach ($disks as $disk) {
                try {
                    Storage::disk($disk)->exists('test');
                    $status[$disk] = 'OK';
                } catch (\Exception $e) {
                    $status[$disk] = 'FAIL';
                }
            }
            
            $allOk = !in_array('FAIL', $status);
            
            return [
                'status' => $allOk ? 'healthy' : 'warning',
                'message' => implode(', ', array_map(fn($k, $v) => "{$k}: {$v}", array_keys($status), $status)),
                'color' => $allOk ? 'success' : 'warning',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'color' => 'danger',
            ];
        }
    }

    protected function checkQueue(): array
    {
        try {
            $queueDriver = config('queue.default');
            $failedJobs = DB::table('failed_jobs')->count();
            
            return [
                'status' => $failedJobs > 0 ? 'warning' : 'healthy',
                'message' => "Driver: {$queueDriver} | Failed jobs: {$failedJobs}",
                'color' => $failedJobs > 0 ? 'warning' : 'success',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
                'color' => 'danger',
            ];
        }
    }

    protected function getEnvironmentInfo(): array
    {
        return [
            'status' => 'info',
            'message' => sprintf(
                'PHP: %s | Laravel: %s | Environment: %s',
                PHP_VERSION,
                app()->version(),
                config('app.env')
            ),
            'color' => config('app.env') === 'production' ? 'success' : 'warning',
        ];
    }

    public function refresh(): void
    {
        $this->checks = $this->runHealthChecks();
        $this->dispatch('health-check-refreshed');
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_health_checks');
    }
}

