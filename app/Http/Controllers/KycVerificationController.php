<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\KycVerificationAttempt;
use App\Models\KycSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KycVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('sell.index')->with('error', 'Please create a seller account first.');
        }

        return view('account.kyc-verification', compact('seller'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('sell.index')->with('error', 'Please create a seller account first.');
        }

        $validator = Validator::make($request->all(), [
            'kyc_country' => 'required|string|max:255',
            'kyc_id_type' => 'required|in:passport,national_id,driver_license',
            'kyc_id_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle file upload
            $frontPath = $this->uploadDocument($request->file('kyc_id_front'), 'kyc/front');

            // Update seller with KYC information
            $seller->update([
                'kyc_country' => $request->kyc_country,
                'kyc_id_type' => $request->kyc_id_type,
                'kyc_id_front_url' => $frontPath,
                'kyc_id_back_url' => null, // Not required
                'kyc_status' => 'pending',
                'kyc_submitted_at' => now(),
                'kyc_rejection_reason' => null, // Clear any previous rejection
            ]);

            // Create verification attempt record
            KycVerificationAttempt::create([
                'seller_id' => $seller->id,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return redirect()->route('account.index')
                ->with('success', 'KYC verification submitted successfully! We will review your documents within 24-48 hours.');

        } catch (\Exception $e) {
            \Log::error('KYC verification submission failed', [
                'user_id' => $user->id,
                'seller_id' => $seller->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to submit KYC verification. Please try again.')
                ->withInput();
        }
    }

    public function status()
    {
        $user = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            return redirect()->route('sell.index')->with('error', 'Please create a seller account first.');
        }

        $attempts = $seller->kycVerificationAttempts()->latest()->get();

        return view('account.kyc-status', compact('seller', 'attempts'));
    }

    private function uploadDocument($file, $directory)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'private');
        
        return $path;
    }
}
