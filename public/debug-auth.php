<?php
// Simple debug script to test authentication
require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "<h1>Authentication Debug</h1>";

// Check if we have any users
$userCount = User::count();
echo "<p>Total users in database: $userCount</p>";

if ($userCount > 0) {
    $firstUser = User::first();
    echo "<p>First user: {$firstUser->email}</p>";
    echo "<p>User active: " . ($firstUser->is_active ? 'Yes' : 'No') . "</p>";
    echo "<p>Email verified: " . ($firstUser->email_verified_at ? 'Yes' : 'No') . "</p>";
    
    // Test password hash
    $testPassword = 'password';
    $isValidPassword = Hash::check($testPassword, $firstUser->password);
    echo "<p>Password 'password' valid: " . ($isValidPassword ? 'Yes' : 'No') . "</p>";
    
    // Test authentication attempt
    $credentials = [
        'email' => $firstUser->email,
        'password' => $testPassword
    ];
    
    $authResult = Auth::attempt($credentials);
    echo "<p>Auth::attempt() result: " . ($authResult ? 'Success' : 'Failed') . "</p>";
    
    if ($authResult) {
        echo "<p>Authenticated user ID: " . Auth::id() . "</p>";
        echo "<p>Authenticated user email: " . Auth::user()->email . "</p>";
    }
} else {
    echo "<p>No users found in database!</p>";
}

// Check Turnstile configuration
echo "<h2>Turnstile Configuration</h2>";
echo "<p>Turnstile Site Key: " . (config('services.turnstile.site_key') ? 'Set' : 'Not Set') . "</p>";
echo "<p>Turnstile Secret Key: " . (config('services.turnstile.secret_key') ? 'Set' : 'Not Set') . "</p>";

// Check session configuration
echo "<h2>Session Configuration</h2>";
echo "<p>Session Driver: " . config('session.driver') . "</p>";
echo "<p>Session Lifetime: " . config('session.lifetime') . " minutes</p>";
echo "<p>Session Domain: " . config('session.domain') . "</p>";
echo "<p>Session Secure: " . (config('session.secure') ? 'Yes' : 'No') . "</p>";
echo "<p>Session HTTP Only: " . (config('session.http_only') ? 'Yes' : 'No') . "</p>";

// Check current session
echo "<h2>Current Session</h2>";
if (session()->isStarted()) {
    echo "<p>Session started: Yes</p>";
    echo "<p>Session ID: " . session()->getId() . "</p>";
    echo "<p>Session data: " . json_encode(session()->all()) . "</p>";
} else {
    echo "<p>Session started: No</p>";
}
?>
