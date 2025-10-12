<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\KycSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Notifications\KycApprovedNotification;
use App\Notifications\KycRejectedNotification;

class KycController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show KYC verification form
     */
    public function show()
    {
        $user = Auth::user();
        $latestSubmission = $user->latestKycSubmission;

        return view('account.kyc-verification', compact('user', 'latestSubmission'));
    }

    /**
     * Submit KYC verification
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if user already has a pending submission
        if ($user->kycSubmissions()->where('status', 'pending')->exists()) {
            return redirect()->back()->with('error', 'You already have a pending verification submission.');
        }

        $validator = Validator::make($request->all(), [
            'country_code' => 'required|string|size:2',
            'full_name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'id_type' => 'required|in:national_id,passport,driver_license',
            'id_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle file upload
            $file = $request->file('id_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kyc/documents', $filename, 'private');

            // Encrypt the file path
            $encryptedPath = encrypt($path);

            // Create KYC submission
            $submission = KycSubmission::create([
                'user_id' => $user->id,
                'country_code' => $request->country_code,
                'full_name' => $request->full_name,
                'dob' => $request->dob,
                'id_type' => $request->id_type,
                'id_image_path' => $encryptedPath,
                'status' => 'pending',
            ]);

            // Send confirmation email
            $this->sendSubmissionConfirmationEmail($user, $submission);

            // Log the submission
            Log::info('KYC submission created', [
                'user_id' => $user->id,
                'submission_id' => $submission->id,
                'country' => $request->country_code,
                'id_type' => $request->id_type,
            ]);

            return redirect()->route('account.index')
                ->with('success', 'KYC verification submitted successfully! We will review your documents within 24-48 hours.');

        } catch (\Exception $e) {
            Log::error('KYC submission failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to submit KYC verification. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show KYC status page
     */
    public function status()
    {
        $user = Auth::user();
        $submissions = $user->kycSubmissions()->latest()->get();

        return view('account.kyc-status', compact('user', 'submissions'));
    }

    /**
     * Send submission confirmation email
     */
    private function sendSubmissionConfirmationEmail($user, $submission)
    {
        try {
            // For now, we'll just log it. In production, you'd send actual emails
            Log::info('KYC submission confirmation email sent', [
                'user_id' => $user->id,
                'email' => $user->email,
                'submission_id' => $submission->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send KYC confirmation email', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle status update and send appropriate notifications
     */
    public static function handleStatusUpdate($submission, $newStatus, $notes = null)
    {
        $submission->update([
            'status' => $newStatus,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'notes' => $notes,
        ]);

        // Update user verification status
        if ($newStatus === 'approved') {
            $submission->user->update(['is_verified' => true]);
            $submission->user->notify(new KycApprovedNotification($submission));
            
            Log::info('KYC approved and user notified', [
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
            ]);
        } elseif ($newStatus === 'rejected') {
            $submission->user->update(['is_verified' => false]);
            $submission->user->notify(new KycRejectedNotification($submission));
            
            Log::info('KYC rejected and user notified', [
                'user_id' => $submission->user_id,
                'submission_id' => $submission->id,
                'notes' => $notes,
            ]);
        }
    }
}