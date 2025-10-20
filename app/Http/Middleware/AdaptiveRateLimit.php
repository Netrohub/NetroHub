<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class AdaptiveRateLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $key = 'default')
    {
        $identifier = $this->getIdentifier($request);
        $rateLimitKey = "adaptive_rate_limit:{$key}:{$identifier}";
        
        // Get current rate limit based on user behavior
        $rateLimit = $this->getAdaptiveRateLimit($request, $key);
        
        // Check if rate limit is exceeded
        if (RateLimiter::tooManyAttempts($rateLimitKey, $rateLimit['max_attempts'])) {
            $retryAfter = RateLimiter::availableIn($rateLimitKey);
            
            Log::warning('Rate limit exceeded', [
                'key' => $key,
                'identifier' => $identifier,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'retry_after' => $retryAfter
            ]);
            
            return response()->json([
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $retryAfter
            ], 429)->header('Retry-After', $retryAfter);
        }
        
        // Hit the rate limiter
        RateLimiter::hit($rateLimitKey, $rateLimit['decay_minutes'] * 60);
        
        // Log suspicious activity
        $this->logSuspiciousActivity($request, $key, $identifier);
        
        return $next($request);
    }

    /**
     * Get identifier for rate limiting
     */
    private function getIdentifier(Request $request): string
    {
        // Use user ID if authenticated, otherwise IP address
        if ($request->user()) {
            return 'user:' . $request->user()->id;
        }
        
        return 'ip:' . $request->ip();
    }

    /**
     * Get adaptive rate limit based on user behavior
     */
    private function getAdaptiveRateLimit(Request $request, string $key): array
    {
        $identifier = $this->getIdentifier($request);
        $user = $request->user();
        
        // Base rate limits
        $baseLimits = [
            'login' => ['max_attempts' => 5, 'decay_minutes' => 15],
            'register' => ['max_attempts' => 3, 'decay_minutes' => 60],
            'password_reset' => ['max_attempts' => 3, 'decay_minutes' => 60],
            'api' => ['max_attempts' => 60, 'decay_minutes' => 1],
            'upload' => ['max_attempts' => 10, 'decay_minutes' => 60],
            'default' => ['max_attempts' => 100, 'decay_minutes' => 1]
        ];
        
        $rateLimit = $baseLimits[$key] ?? $baseLimits['default'];
        
        // Adjust based on user trust level
        if ($user) {
            $trustLevel = $this->calculateTrustLevel($user);
            
            // Increase limits for trusted users
            if ($trustLevel >= 0.8) {
                $rateLimit['max_attempts'] = (int) ($rateLimit['max_attempts'] * 2);
            } elseif ($trustLevel >= 0.6) {
                $rateLimit['max_attempts'] = (int) ($rateLimit['max_attempts'] * 1.5);
            }
        }
        
        // Adjust based on recent activity
        $recentActivity = $this->getRecentActivity($identifier);
        if ($recentActivity['suspicious_count'] > 3) {
            // Reduce limits for suspicious activity
            $rateLimit['max_attempts'] = max(1, (int) ($rateLimit['max_attempts'] * 0.5));
            $rateLimit['decay_minutes'] = $rateLimit['decay_minutes'] * 2;
        }
        
        return $rateLimit;
    }

    /**
     * Calculate user trust level
     */
    private function calculateTrustLevel($user): float
    {
        $trustScore = 0.5; // Base trust score
        
        // Increase trust for verified users
        if ($user->email_verified_at) {
            $trustScore += 0.2;
        }
        
        // Increase trust for users with 2FA enabled
        if ($user->two_factor_enabled) {
            $trustScore += 0.1;
        }
        
        // Increase trust for users with KYC verification
        if ($user->kyc_verified) {
            $trustScore += 0.1;
        }
        
        // Increase trust based on account age
        $accountAge = now()->diffInDays($user->created_at);
        if ($accountAge > 30) {
            $trustScore += 0.1;
        }
        
        // Decrease trust for users with recent violations
        $recentViolations = $this->getRecentViolations($user->id);
        $trustScore -= $recentViolations * 0.1;
        
        return max(0, min(1, $trustScore));
    }

    /**
     * Get recent activity for identifier
     */
    private function getRecentActivity(string $identifier): array
    {
        $cacheKey = "recent_activity:{$identifier}";
        $activity = Cache::get($cacheKey, [
            'request_count' => 0,
            'suspicious_count' => 0,
            'last_request' => null
        ]);
        
        return $activity;
    }

    /**
     * Get recent violations for user
     */
    private function getRecentViolations(int $userId): int
    {
        $cacheKey = "user_violations:{$userId}";
        return Cache::get($cacheKey, 0);
    }

    /**
     * Log suspicious activity
     */
    private function logSuspiciousActivity(Request $request, string $key, string $identifier): void
    {
        $suspicious = false;
        $reasons = [];
        
        // Check for rapid requests
        $recentRequests = Cache::get("recent_requests:{$identifier}", []);
        $recentRequests[] = now()->timestamp;
        
        // Keep only last 60 seconds
        $recentRequests = array_filter($recentRequests, function($timestamp) {
            return $timestamp > (now()->timestamp - 60);
        });
        
        Cache::put("recent_requests:{$identifier}", $recentRequests, 60);
        
        if (count($recentRequests) > 20) {
            $suspicious = true;
            $reasons[] = 'Rapid requests';
        }
        
        // Check for unusual user agent
        $userAgent = $request->userAgent();
        if (empty($userAgent) || strlen($userAgent) < 10) {
            $suspicious = true;
            $reasons[] = 'Suspicious user agent';
        }
        
        // Check for missing or invalid headers
        if (!$request->header('Accept') || !$request->header('Accept-Language')) {
            $suspicious = true;
            $reasons[] = 'Missing headers';
        }
        
        if ($suspicious) {
            Log::warning('Suspicious activity detected', [
                'key' => $key,
                'identifier' => $identifier,
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'reasons' => $reasons,
                'url' => $request->fullUrl(),
                'method' => $request->method()
            ]);
            
            // Update suspicious activity count
            $activity = $this->getRecentActivity($identifier);
            $activity['suspicious_count']++;
            $activity['last_request'] = now();
            
            Cache::put("recent_activity:{$identifier}", $activity, 3600);
        }
    }
}
