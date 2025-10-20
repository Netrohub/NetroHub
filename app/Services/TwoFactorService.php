<?php

namespace App\Services;

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class TwoFactorService
{
    private Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Generate 2FA secret for user
     */
    public function generateSecret(User $user): string
    {
        $secret = $this->google2fa->generateSecretKey();
        
        $user->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode($this->generateRecoveryCodes()))
        ]);

        Log::info('2FA secret generated', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return $secret;
    }

    /**
     * Generate QR code URL for 2FA setup
     */
    public function getQRCodeUrl(User $user, string $secret): string
    {
        $companyName = config('app.name');
        $companyEmail = $user->email;
        
        return $this->google2fa->getQRCodeUrl(
            $companyName,
            $companyEmail,
            $secret
        );
    }

    /**
     * Verify 2FA code
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (!$user->two_factor_secret) {
            return false;
        }

        $secret = decrypt($user->two_factor_secret);
        
        // Allow for time window of 1 (30 seconds tolerance)
        $valid = $this->google2fa->verifyKey($secret, $code, 1);
        
        if ($valid) {
            Log::info('2FA code verified successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        } else {
            Log::warning('Invalid 2FA code attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'code' => $code
            ]);
        }

        return $valid;
    }

    /**
     * Verify recovery code
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        if (!$user->two_factor_recovery_codes) {
            return false;
        }

        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
        
        if (in_array($code, $recoveryCodes)) {
            // Remove used recovery code
            $recoveryCodes = array_diff($recoveryCodes, [$code]);
            $user->update([
                'two_factor_recovery_codes' => encrypt(json_encode(array_values($recoveryCodes)))
            ]);

            Log::info('Recovery code used successfully', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return true;
        }

        Log::warning('Invalid recovery code attempt', [
            'user_id' => $user->id,
            'email' => $user->email,
            'code' => $code
        ]);

        return false;
    }

    /**
     * Enable 2FA for user
     */
    public function enableTwoFactor(User $user, string $code): bool
    {
        if (!$this->verifyCode($user, $code)) {
            return false;
        }

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_confirmed_at' => now()
        ]);

        Log::info('2FA enabled for user', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return true;
    }

    /**
     * Disable 2FA for user
     */
    public function disableTwoFactor(User $user, string $code): bool
    {
        if (!$this->verifyCode($user, $code)) {
            return false;
        }

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null
        ]);

        Log::info('2FA disabled for user', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return true;
    }

    /**
     * Check if user needs 2FA
     */
    public function requiresTwoFactor(User $user): bool
    {
        return $user->two_factor_required || $user->two_factor_enabled;
    }

    /**
     * Generate recovery codes
     */
    private function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(substr(md5(uniqid()), 0, 8));
        }
        return $codes;
    }

    /**
     * Get remaining recovery codes
     */
    public function getRemainingRecoveryCodes(User $user): int
    {
        if (!$user->two_factor_recovery_codes) {
            return 0;
        }

        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
        return count($recoveryCodes);
    }

    /**
     * Regenerate recovery codes
     */
    public function regenerateRecoveryCodes(User $user): array
    {
        $newCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($newCodes))
        ]);

        Log::info('Recovery codes regenerated', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return $newCodes;
    }
}
