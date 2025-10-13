<?php

namespace App\Http\Controllers;

use App\Services\TapPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TapWebhookController extends Controller
{
    public function __construct(
        protected TapPaymentService $tapService
    ) {}

    /**
     * Handle Tap webhook
     */
    public function handle(Request $request): Response
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Tap-Signature') ?? $request->header('Tap-Signature');

        // Log webhook receipt
        Log::info('Tap webhook received', [
            'headers' => $request->headers->all(),
            'has_signature' => !empty($signature),
        ]);

        // Verify signature if available
        if ($signature && !$this->tapService->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Tap webhook signature verification failed');
            return response('Invalid signature', 401);
        }

        try {
            $event = $request->all();
            
            // Log the event
            Log::info('Processing Tap webhook event', [
                'event_type' => $event['event'] ?? $event['type'] ?? 'unknown',
                'charge_id' => $event['id'] ?? ($event['charge']['id'] ?? null),
            ]);

            // Process the webhook
            $this->tapService->processWebhook($event);

            return response('Webhook processed', 200);
        } catch (\Exception $e) {
            Log::error('Tap webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response('Webhook processing failed', 500);
        }
    }

    /**
     * Handle callback from Tap checkout
     */
    public function callback(Request $request): \Illuminate\Http\RedirectResponse
    {
        $tapId = $request->get('tap_id');
        $status = $request->get('status');

        Log::info('Tap payment callback', [
            'tap_id' => $tapId,
            'status' => $status,
            'all_params' => $request->all(),
        ]);

        if ($status === 'CAPTURED' || $status === 'captured') {
            return redirect()->route('account.billing')
                ->with('success', 'Payment successful! Your subscription is now active.');
        } elseif ($status === 'CANCELLED' || $status === 'cancelled') {
            return redirect()->route('pricing.index')
                ->with('error', 'Payment was cancelled.');
        } else {
            return redirect()->route('pricing.index')
                ->with('error', 'Payment failed. Please try again.');
        }
    }
}

