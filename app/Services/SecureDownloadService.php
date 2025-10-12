<?php

namespace App\Services;

use App\Models\DownloadLog;
use App\Models\OrderItem;
use App\Models\ProductFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class SecureDownloadService
{
    private const DOWNLOAD_TTL_HOURS = 24;

    private const MAX_DOWNLOAD_ATTEMPTS = 5;

    /**
     * Generate a signed download URL for a file
     */
    public function generateSignedUrl(OrderItem $orderItem, ProductFile $file, User $user): string
    {
        // Verify user owns this order item
        if (! $this->canUserDownload($orderItem, $user)) {
            throw new \Exception('User not authorized to download this file');
        }

        // Check download limits
        if (! $this->checkDownloadLimits($orderItem, $file)) {
            throw new \Exception('Download limit exceeded for this file');
        }

        // Create signed URL with expiration
        $expiresAt = Carbon::now()->addHours(self::DOWNLOAD_TTL_HOURS);
        $signature = $this->generateSignature($orderItem->id, $file->id, $expiresAt);

        $params = [
            'order_item' => $orderItem->id,
            'file' => $file->id,
            'expires' => $expiresAt->timestamp,
            'signature' => $signature,
        ];

        return route('downloads.secure', $params);
    }

    /**
     * Serve the actual file download
     */
    public function serveDownload(array $params): array
    {
        $orderItemId = $params['order_item'];
        $fileId = $params['file'];
        $expires = $params['expires'];
        $signature = $params['signature'];

        // Verify signature
        if (! $this->verifySignature($orderItemId, $fileId, $expires, $signature)) {
            throw new \Exception('Invalid download signature');
        }

        // Check expiration
        if (Carbon::now()->timestamp > $expires) {
            throw new \Exception('Download link has expired');
        }

        $orderItem = OrderItem::findOrFail($orderItemId);
        $file = ProductFile::findOrFail($fileId);

        // Check download limits again (in case of race conditions)
        if (! $this->checkDownloadLimits($orderItem, $file)) {
            throw new \Exception('Download limit exceeded');
        }

        // Log the download
        $this->logDownload($orderItem, $file);

        // Return file info for download
        return [
            'file_path' => $file->file_path,
            'filename' => $file->original_name ?? basename($file->file_path),
            'mime_type' => $file->mime_type ?? 'application/octet-stream',
        ];
    }

    /**
     * Check if user can download from this order item
     */
    private function canUserDownload(OrderItem $orderItem, User $user): bool
    {
        return $orderItem->order->user_id === $user->id
            && $orderItem->is_delivered
            && $orderItem->order->payment_status === 'completed';
    }

    /**
     * Check download limits for this file
     */
    private function checkDownloadLimits(OrderItem $orderItem, ProductFile $file): bool
    {
        $downloadCount = DownloadLog::where('order_item_id', $orderItem->id)
            ->where('product_file_id', $file->id)
            ->count();

        return $downloadCount < self::MAX_DOWNLOAD_ATTEMPTS;
    }

    /**
     * Generate cryptographic signature for download URL
     */
    private function generateSignature(int $orderItemId, int $fileId, Carbon $expiresAt): string
    {
        $data = "{$orderItemId}:{$fileId}:{$expiresAt->timestamp}";

        return hash_hmac('sha256', $data, config('app.key'));
    }

    /**
     * Verify download signature
     */
    private function verifySignature(int $orderItemId, int $fileId, int $expires, string $signature): bool
    {
        $data = "{$orderItemId}:{$fileId}:{$expires}";
        $expectedSignature = hash_hmac('sha256', $data, config('app.key'));

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Log download attempt
     */
    private function logDownload(OrderItem $orderItem, ProductFile $file): void
    {
        DownloadLog::create([
            'order_item_id' => $orderItem->id,
            'product_file_id' => $file->id,
            'user_id' => $orderItem->order->user_id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'downloaded_at' => now(),
        ]);
    }

    /**
     * Get download statistics for an order item
     */
    public function getDownloadStats(OrderItem $orderItem): array
    {
        $downloads = DownloadLog::where('order_item_id', $orderItem->id)
            ->with('productFile')
            ->get();

        $stats = [];
        foreach ($downloads as $download) {
            $fileId = $download->product_file_id;
            if (! isset($stats[$fileId])) {
                $stats[$fileId] = [
                    'file' => $download->productFile,
                    'count' => 0,
                    'last_downloaded' => null,
                ];
            }
            $stats[$fileId]['count']++;
            if (! $stats[$fileId]['last_downloaded'] ||
                $download->downloaded_at > $stats[$fileId]['last_downloaded']) {
                $stats[$fileId]['last_downloaded'] = $download->downloaded_at;
            }
        }

        return $stats;
    }
}
