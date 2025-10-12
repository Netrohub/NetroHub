<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Services\SecureDownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureDownloadController extends Controller
{
    public function __construct(
        private SecureDownloadService $downloadService
    ) {}

    /**
     * Serve secure file download
     */
    public function download(Request $request)
    {
        try {
            $params = $request->all();

            $fileInfo = $this->downloadService->serveDownload($params);

            return $this->streamFile($fileInfo);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    /**
     * Generate signed download URL
     */
    public function generateUrl(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'file_id' => 'required|exists:product_files,id',
        ]);

        try {
            $fileId = $request->input('file_id');
            $file = \App\Models\ProductFile::findOrFail($fileId);

            $url = $this->downloadService->generateSignedUrl(
                $orderItem,
                $file,
                $request->user()
            );

            return response()->json([
                'download_url' => $url,
                'expires_in_hours' => 24,
                'max_downloads' => 5,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 403);
        }
    }

    /**
     * Get download statistics for an order item
     */
    public function stats(OrderItem $orderItem)
    {
        if ($orderItem->order->user_id !== request()->user()->id) {
            abort(403);
        }

        $stats = $this->downloadService->getDownloadStats($orderItem);

        return response()->json($stats);
    }

    /**
     * Stream file download
     */
    private function streamFile(array $fileInfo): StreamedResponse
    {
        $filePath = $fileInfo['file_path'];
        $filename = $fileInfo['filename'];
        $mimeType = $fileInfo['mime_type'];

        if (! Storage::exists($filePath)) {
            abort(404, 'File not found');
        }

        return Storage::download($filePath, $filename, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
