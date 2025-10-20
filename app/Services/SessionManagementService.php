<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SessionManagementService
{
    /**
     * Create or update user session
     */
    public function createSession(User $user, string $sessionId, array $requestData): UserSession
    {
        $deviceInfo = $this->parseUserAgent($requestData['user_agent'] ?? '');
        $location = $this->getLocationFromIP($requestData['ip_address'] ?? '');

        // Mark all other sessions as not current
        UserSession::where('user_id', $user->id)->update(['is_current' => false]);

        $session = UserSession::create([
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'ip_address' => $requestData['ip_address'] ?? '',
            'user_agent' => $requestData['user_agent'] ?? '',
            'device_type' => $deviceInfo['device_type'],
            'browser' => $deviceInfo['browser'],
            'os' => $deviceInfo['os'],
            'location' => $location,
            'is_current' => true,
            'last_activity' => now()
        ]);

        Log::info('User session created', [
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'ip_address' => $requestData['ip_address'] ?? '',
            'device_type' => $deviceInfo['device_type']
        ]);

        return $session;
    }

    /**
     * Update session activity
     */
    public function updateActivity(string $sessionId): void
    {
        UserSession::where('session_id', $sessionId)
            ->update(['last_activity' => now()]);
    }

    /**
     * Get user's active sessions
     */
    public function getActiveSessions(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return UserSession::where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    /**
     * Revoke specific session
     */
    public function revokeSession(User $user, string $sessionId): bool
    {
        $session = UserSession::where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->first();

        if (!$session) {
            return false;
        }

        $session->delete();

        Log::info('User session revoked', [
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'revoked_by' => auth()->id()
        ]);

        return true;
    }

    /**
     * Revoke all other sessions (except current)
     */
    public function revokeAllOtherSessions(User $user): int
    {
        $currentSessionId = session()->getId();
        
        $revokedCount = UserSession::where('user_id', $user->id)
            ->where('session_id', '!=', $currentSessionId)
            ->delete();

        Log::info('All other sessions revoked', [
            'user_id' => $user->id,
            'revoked_count' => $revokedCount,
            'revoked_by' => auth()->id()
        ]);

        return $revokedCount;
    }

    /**
     * Clean up expired sessions
     */
    public function cleanupExpiredSessions(): int
    {
        $expiredSessions = UserSession::where('last_activity', '<', now()->subDays(30))
            ->delete();

        Log::info('Expired sessions cleaned up', [
            'expired_count' => $expiredSessions
        ]);

        return $expiredSessions;
    }

    /**
     * Check for suspicious login activity
     */
    public function checkSuspiciousActivity(User $user, array $requestData): array
    {
        $suspicious = [];
        $ipAddress = $requestData['ip_address'] ?? '';
        $userAgent = $requestData['user_agent'] ?? '';

        // Check for multiple IP addresses in short time
        $recentSessions = UserSession::where('user_id', $user->id)
            ->where('created_at', '>', now()->subHours(24))
            ->get();

        $uniqueIPs = $recentSessions->pluck('ip_address')->unique();
        if ($uniqueIPs->count() > 3) {
            $suspicious[] = 'Multiple IP addresses detected';
        }

        // Check for unusual location
        $location = $this->getLocationFromIP($ipAddress);
        $recentLocations = $recentSessions->pluck('location')->unique();
        if ($recentLocations->count() > 2) {
            $suspicious[] = 'Multiple locations detected';
        }

        // Check for unusual device/browser
        $deviceInfo = $this->parseUserAgent($userAgent);
        $recentBrowsers = $recentSessions->pluck('browser')->unique();
        if ($recentBrowsers->count() > 2) {
            $suspicious[] = 'Multiple browsers detected';
        }

        if (!empty($suspicious)) {
            Log::warning('Suspicious login activity detected', [
                'user_id' => $user->id,
                'ip_address' => $ipAddress,
                'suspicious_indicators' => $suspicious
            ]);
        }

        return $suspicious;
    }

    /**
     * Parse user agent string
     */
    private function parseUserAgent(string $userAgent): array
    {
        $deviceType = 'unknown';
        $browser = 'unknown';
        $os = 'unknown';

        // Detect device type
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/Tablet|iPad/', $userAgent)) {
            $deviceType = 'tablet';
        } else {
            $deviceType = 'desktop';
        }

        // Detect browser
        if (preg_match('/Chrome/', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/', $userAgent)) {
            $browser = 'Edge';
        }

        // Detect OS
        if (preg_match('/Windows/', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac/', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iOS/', $userAgent)) {
            $os = 'iOS';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os
        ];
    }

    /**
     * Get location from IP address (simplified)
     */
    private function getLocationFromIP(string $ipAddress): string
    {
        // In production, you would use a service like MaxMind GeoIP2
        // For now, return a placeholder
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return 'Unknown Location';
        }
        
        return 'Local Network';
    }
}
