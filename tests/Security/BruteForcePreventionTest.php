<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;

class BruteForcePreventionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login rate limiting
     */
    public function test_login_rate_limiting(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        // Attempt login with wrong password multiple times
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        // Should be rate limited after 5 attempts
        $response->assertStatus(429);
        $response->assertJson([
            'message' => 'Too many requests. Please try again later.'
        ]);
    }

    /**
     * Test registration rate limiting
     */
    public function test_registration_rate_limiting(): void
    {
        // Attempt registration multiple times
        for ($i = 0; $i < 4; $i++) {
            $response = $this->post('/register', [
                'name' => 'Test User',
                'email' => "test{$i}@example.com",
                'password' => 'password',
                'password_confirmation' => 'password'
            ]);
        }

        // Should be rate limited after 3 attempts
        $response->assertStatus(429);
    }

    /**
     * Test password reset rate limiting
     */
    public function test_password_reset_rate_limiting(): void
    {
        // Attempt password reset multiple times
        for ($i = 0; $i < 4; $i++) {
            $response = $this->post('/forgot-password', [
                'email' => 'test@example.com'
            ]);
        }

        // Should be rate limited after 3 attempts
        $response->assertStatus(429);
    }

    /**
     * Test adaptive rate limiting for trusted users
     */
    public function test_adaptive_rate_limiting_for_trusted_users(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'two_factor_enabled' => true,
            'kyc_verified' => true
        ]);

        $this->actingAs($user);

        // Trusted users should have higher rate limits
        $response = $this->get('/api/products');
        
        // Should not be rate limited for normal usage
        $response->assertStatus(200);
    }

    /**
     * Test rate limiting with different IP addresses
     */
    public function test_rate_limiting_with_different_ips(): void
    {
        // Simulate requests from different IP addresses
        $ips = ['192.168.1.1', '192.168.1.2', '192.168.1.3'];
        
        foreach ($ips as $ip) {
            $this->withServerVariables(['REMOTE_ADDR' => $ip]);
            
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
            
            // Each IP should have its own rate limit
            $response->assertStatus(422); // Validation error, not rate limited
        }
    }

    /**
     * Test rate limiting reset after decay period
     */
    public function test_rate_limiting_reset_after_decay(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        // Exceed rate limit
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        $response->assertStatus(429);

        // Clear rate limiter (simulate decay period)
        RateLimiter::clear('adaptive_rate_limit:login:ip:127.0.0.1');

        // Should be able to attempt login again
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302); // Redirect after successful login
    }

    /**
     * Test suspicious activity detection
     */
    public function test_suspicious_activity_detection(): void
    {
        // Make rapid requests to trigger suspicious activity detection
        for ($i = 0; $i < 25; $i++) {
            $response = $this->get('/');
        }

        // Should still work but log suspicious activity
        $response->assertStatus(200);
    }

    /**
     * Test rate limiting with missing headers
     */
    public function test_rate_limiting_with_missing_headers(): void
    {
        // Make request without proper headers
        $response = $this->withHeaders([
            'User-Agent' => '',
            'Accept' => '',
            'Accept-Language' => ''
        ])->get('/');

        // Should still work but may trigger suspicious activity detection
        $response->assertStatus(200);
    }
}
