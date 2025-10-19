<?php
// Diagnostic script for environment variable issues
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Environment Variable Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #1a1a1a; color: white; }
        .container { max-width: 800px; margin: 0 auto; }
        .status { padding: 15px; margin: 10px 0; border-radius: 8px; }
        .success { background: #10b981; }
        .error { background: #ef4444; }
        .warning { background: #f59e0b; }
        .info { background: #3b82f6; }
        .code { background: #2d2d2d; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Environment Variable Diagnostic</h1>
        
        <?php
        echo "<div class='status info'>";
        echo "<h3>📋 System Information</h3>";
        echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
        echo "<p><strong>Current Directory:</strong> " . getcwd() . "</p>";
        echo "<p><strong>Script Location:</strong> " . __FILE__ . "</p>";
        echo "<p><strong>Laravel Root:</strong> " . (file_exists('.env') ? '✅ Found' : '❌ Not found') . "</p>";
        echo "</div>";
        
        echo "<div class='status info'>";
        echo "<h3>📁 .env File Check</h3>";
        if (file_exists('.env')) {
            echo "<p>✅ .env file exists</p>";
            echo "<p><strong>Size:</strong> " . filesize('.env') . " bytes</p>";
            echo "<p><strong>Permissions:</strong> " . substr(sprintf('%o', fileperms('.env')), -4) . "</p>";
            echo "<p><strong>Owner:</strong> " . posix_getpwuid(fileowner('.env'))['name'] . "</p>";
            
            $envContent = file_get_contents('.env');
            $turnstileLines = array_filter(explode("\n", $envContent), function($line) {
                return strpos($line, 'TURNSTILE') !== false;
            });
            
            if (!empty($turnstileLines)) {
                echo "<p>✅ TURNSTILE variables found in .env:</p>";
                echo "<div class='code'>";
                foreach ($turnstileLines as $line) {
                    echo htmlspecialchars($line) . "\n";
                }
                echo "</div>";
            } else {
                echo "<p>❌ No TURNSTILE variables found in .env</p>";
            }
        } else {
            echo "<p>❌ .env file not found</p>";
        }
        echo "</div>";
        
        echo "<div class='status info'>";
        echo "<h3>🔧 Environment Variable Test</h3>";
        
        // Test getenv()
        $siteKey = getenv('TURNSTILE_SITE_KEY');
        $secretKey = getenv('TURNSTILE_SECRET_KEY');
        
        echo "<p><strong>getenv('TURNSTILE_SITE_KEY'):</strong> " . ($siteKey ? "✅ " . substr($siteKey, 0, 20) . "..." : "❌ Not found") . "</p>";
        echo "<p><strong>getenv('TURNSTILE_SECRET_KEY'):</strong> " . ($secretKey ? "✅ " . substr($secretKey, 0, 20) . "..." : "❌ Not found") . "</p>";
        
        // Test $_ENV
        echo "<p><strong>\$_ENV['TURNSTILE_SITE_KEY']:</strong> " . (isset($_ENV['TURNSTILE_SITE_KEY']) ? "✅ Found" : "❌ Not found") . "</p>";
        echo "<p><strong>\$_ENV['TURNSTILE_SECRET_KEY']:</strong> " . (isset($_ENV['TURNSTILE_SECRET_KEY']) ? "✅ Found" : "❌ Not found") . "</p>";
        
        // Test $_SERVER
        echo "<p><strong>\$_SERVER['TURNSTILE_SITE_KEY']:</strong> " . (isset($_SERVER['TURNSTILE_SITE_KEY']) ? "✅ Found" : "❌ Not found") . "</p>";
        echo "<p><strong>\$_SERVER['TURNSTILE_SECRET_KEY']:</strong> " . (isset($_SERVER['TURNSTILE_SECRET_KEY']) ? "✅ Found" : "❌ Not found") . "</p>";
        
        echo "</div>";
        
        echo "<div class='status info'>";
        echo "<h3>🔧 Laravel Config Test</h3>";
        
        try {
            // Test Laravel config
            $laravelSiteKey = config('services.turnstile.site_key');
            $laravelSecretKey = config('services.turnstile.secret_key');
            
            echo "<p><strong>config('services.turnstile.site_key'):</strong> " . ($laravelSiteKey ? "✅ " . substr($laravelSiteKey, 0, 20) . "..." : "❌ Not found") . "</p>";
            echo "<p><strong>config('services.turnstile.secret_key'):</strong> " . ($laravelSecretKey ? "✅ " . substr($laravelSecretKey, 0, 20) . "..." : "❌ Not found") . "</p>";
        } catch (Exception $e) {
            echo "<p>❌ Laravel config error: " . $e->getMessage() . "</p>";
        }
        
        echo "</div>";
        
        echo "<div class='status info'>";
        echo "<h3>🔧 PHP Configuration</h3>";
        echo "<p><strong>variables_order:</strong> " . ini_get('variables_order') . "</p>";
        echo "<p><strong>auto_globals_jit:</strong> " . (ini_get('auto_globals_jit') ? 'On' : 'Off') . "</p>";
        echo "<p><strong>register_argc_argv:</strong> " . (ini_get('register_argc_argv') ? 'On' : 'Off') . "</p>";
        echo "</div>";
        
        echo "<div class='status warning'>";
        echo "<h3>🚀 Recommended Fixes</h3>";
        echo "<ol>";
        echo "<li><strong>Check .env file location:</strong> Make sure it's in the Laravel root directory</li>";
        echo "<li><strong>Check .env file format:</strong> No spaces around =, no quotes unless needed</li>";
        echo "<li><strong>Clear Laravel cache:</strong> <code>php artisan config:clear</code></li>";
        echo "<li><strong>Restart web server:</strong> <code>sudo systemctl restart nginx php8.1-fpm</code></li>";
        echo "<li><strong>Check file permissions:</strong> <code>chmod 644 .env</code></li>";
        echo "</ol>";
        echo "</div>";
        ?>
    </div>
</body>
</html>
