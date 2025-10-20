<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

class FileUploadSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Queue::fake();
    }

    /**
     * Test malicious file upload prevention
     */
    public function test_malicious_file_upload_prevention(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a malicious PHP file
        $maliciousFile = UploadedFile::fake()->create('malicious.php', 100, 'text/plain');
        $maliciousContent = '<?php system($_GET["cmd"]); ?>';
        file_put_contents($maliciousFile->getPathname(), $maliciousContent);

        $response = $this->post('/upload', [
            'file' => $maliciousFile
        ]);

        $response->assertStatus(422); // Validation error
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * Test file size limit enforcement
     */
    public function test_file_size_limit_enforcement(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a file larger than 10MB
        $largeFile = UploadedFile::fake()->create('large_file.jpg', 11000); // 11MB

        $response = $this->post('/upload', [
            'file' => $largeFile
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * Test MIME type validation
     */
    public function test_mime_type_validation(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a file with suspicious MIME type
        $suspiciousFile = UploadedFile::fake()->create('suspicious.exe', 100, 'application/x-executable');

        $response = $this->post('/upload', [
            'file' => $suspiciousFile
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * Test file extension validation
     */
    public function test_file_extension_validation(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a file with suspicious extension
        $suspiciousFile = UploadedFile::fake()->create('suspicious.bat', 100, 'text/plain');

        $response = $this->post('/upload', [
            'file' => $suspiciousFile
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * Test image re-encoding job dispatch
     */
    public function test_image_re_encoding_job_dispatch(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $imageFile = UploadedFile::fake()->image('test.jpg', 100, 100);

        $response = $this->post('/upload', [
            'file' => $imageFile
        ]);

        $response->assertStatus(200);

        Queue::assertPushed(\App\Jobs\ScanUploadedFile::class);
    }

    /**
     * Test file with embedded malicious content
     */
    public function test_file_with_embedded_malicious_content(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a file with embedded malicious content
        $maliciousContent = 'GIF89a<script>alert("XSS")</script>';
        $maliciousFile = UploadedFile::fake()->create('malicious.gif', 100, 'image/gif');
        file_put_contents($maliciousFile->getPathname(), $maliciousContent);

        $response = $this->post('/upload', [
            'file' => $maliciousFile
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * Test valid file upload
     */
    public function test_valid_file_upload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $validFile = UploadedFile::fake()->image('test.jpg', 100, 100);

        $response = $this->post('/upload', [
            'file' => $validFile
        ]);

        $response->assertStatus(200);
        
        // File should be stored
        Storage::disk('local')->assertExists('uploads/' . $validFile->hashName());
    }

    /**
     * Test file upload with suspicious headers
     */
    public function test_file_upload_with_suspicious_headers(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a file with suspicious headers
        $suspiciousContent = "\xFF\xD8\xFF\xE0\x00\x10JFIF\x00\x01\x01\x01\x00H\x00H\x00\x00\xFF\xDB\x00C\x00<script>alert('XSS')</script>";
        $suspiciousFile = UploadedFile::fake()->create('suspicious.jpg', 100, 'image/jpeg');
        file_put_contents($suspiciousFile->getPathname(), $suspiciousContent);

        $response = $this->post('/upload', [
            'file' => $suspiciousFile
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }

    /**
     * Test file upload rate limiting
     */
    public function test_file_upload_rate_limiting(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Attempt to upload multiple files rapidly
        for ($i = 0; $i < 15; $i++) {
            $file = UploadedFile::fake()->image("test{$i}.jpg", 100, 100);
            
            $response = $this->post('/upload', [
                'file' => $file
            ]);
        }

        // Should be rate limited after 10 attempts
        $response->assertStatus(429);
    }

    /**
     * Test file upload with empty file
     */
    public function test_file_upload_with_empty_file(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $emptyFile = UploadedFile::fake()->create('empty.txt', 0);

        $response = $this->post('/upload', [
            'file' => $emptyFile
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['file']);
    }
}
