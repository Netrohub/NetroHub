<?php

namespace App\Http\Controllers;

use App\Services\PersonaKycService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PersonaKycController extends Controller
{
    protected $personaService;

    public function __construct(PersonaKycService $personaService)
    {
        $this->middleware('auth');
        $this->personaService = $personaService;
    }

    /**
     * Show KYC verification page
     */
    public function show()
    {
        $user = Auth::user();
        $latestSubmission = $user->latestKycSubmission;

        // Check if user already has an approved KYC
        if ($user->is_verified && $latestSubmission && $latestSubmission->isApproved()) {
            return redirect()->route('account.index')
                ->with('success', 'Your identity is already verified!');
        }

        return view('account.kyc-persona', compact('user', 'latestSubmission'));
    }

    /**
     * Create Persona inquiry and return session token
     */
    public function createInquiry(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending inquiry
        $latestSubmission = $user->latestKycSubmission;
        if ($latestSubmission && $latestSubmission->isPending()) {
            return response()->json([
                'error' => 'You already have a pending verification.',
            ], 400);
        }

        $result = $this->personaService->createInquiry($user);

        if ($result['success']) {
            return response()->json([
                'inquiry_id' => $result['inquiry_id'],
                'session_token' => $result['session_token'],
            ]);
        }

        return response()->json([
            'error' => $result['error'] ?? 'Failed to start verification',
        ], 500);
    }

    /**
     * Handle Persona webhook
     */
    public function webhook(Request $request)
    {
        $signature = $request->header('Persona-Signature');
        $payload = $request->getContent();

        // Verify webhook signature
        if (!$this->personaService->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Invalid Persona webhook signature');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = $request->all();
        
        $success = $this->personaService->handleWebhook($data);

        if ($success) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['error' => 'Webhook processing failed'], 500);
    }

    /**
     * Get current inquiry status
     */
    public function status(Request $request)
    {
        $user = Auth::user();
        $latestSubmission = $user->latestKycSubmission;

        if (!$latestSubmission) {
            return response()->json([
                'status' => 'not_started',
            ]);
        }

        if ($latestSubmission->persona_inquiry_id) {
            $result = $this->personaService->getInquiryStatus($latestSubmission->persona_inquiry_id);
            
            if ($result['success']) {
                return response()->json([
                    'status' => $result['status'],
                    'submission' => $latestSubmission,
                ]);
            }
        }

        return response()->json([
            'status' => $latestSubmission->status,
            'submission' => $latestSubmission,
        ]);
    }
}

