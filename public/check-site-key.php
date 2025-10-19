<?php
// Simple tool to check Turnstile site key configuration
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Turnstile Site Key Check</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #1a1a1a; color: white; }
        .container { max-width: 800px; margin: 0 auto; }
        .status { padding: 15px; margin: 10px 0; border-radius: 8px; }
        .success { background: #10b981; }
        .error { background: #ef4444; }
        .warning { background: #f59e0b; }
        .info { background: #3b82f6; }
        .code { background: #2d2d2d; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
        .highlight { background: #4f46e5; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Turnstile Site Key Configuration Check</h1>
        
        <?php
        $siteKey = getenv('TURNSTILE_SITE_KEY');
        $secretKey = getenv('TURNSTILE_SECRET_KEY');
        $domain = $_SERVER['HTTP_HOST'] ?? 'unknown';
        
        echo "<div class='status info'>";
        echo "<h3>📋 Current Configuration</h3>";
        echo "<p><strong>Domain:</strong> <span class='highlight'>{$domain}</span></p>";
        echo "<p><strong>Site Key Present:</strong> " . ($siteKey ? "✅ Yes" : "❌ No") . "</p>";
        echo "<p><strong>Secret Key Present:</strong> " . ($secretKey ? "✅ Yes" : "❌ No") . "</p>";
        echo "</div>";
        
        if ($siteKey) {
            echo "<div class='status info'>";
            echo "<h3>🔑 Site Key Details</h3>";
            echo "<p><strong>Length:</strong> " . strlen($siteKey) . " characters</p>";
            echo "<p><strong>Format:</strong> " . (str_starts_with($siteKey, '0x4AAAAAAA') ? "✅ Correct format" : "❌ Wrong format") . "</p>";
            echo "<p><strong>Preview:</strong> <span class='code'>" . substr($siteKey, 0, 20) . "...</span></p>";
            echo "</div>";
            
            if (!str_starts_with($siteKey, '0x4AAAAAAA')) {
                echo "<div class='status error'>";
                echo "<h3>❌ Site Key Format Issue</h3>";
                echo "<p>Your site key doesn't start with <code>0x4AAAAAAA</code>. This is likely the cause of error 400020.</p>";
                echo "<p><strong>Expected format:</strong> <span class='code'>0x4AAAAAAA...</span></p>";
                echo "<p><strong>Your format:</strong> <span class='code'>" . substr($siteKey, 0, 20) . "...</span></p>";
                echo "</div>";
            }
        } else {
            echo "<div class='status error'>";
            echo "<h3>❌ No Site Key Found</h3>";
            echo "<p>TURNSTILE_SITE_KEY is not set in your environment variables.</p>";
            echo "</div>";
        }
        
        echo "<div class='status info'>";
        echo "<h3>🔧 How to Fix Error 400020</h3>";
        echo "<ol>";
        echo "<li><strong>Check Cloudflare Dashboard:</strong> Go to <a href='https://dash.cloudflare.com/profile/api-tokens' target='_blank' style='color: #60a5fa;'>Cloudflare Turnstile</a></li>";
        echo "<li><strong>Verify Site Key:</strong> Copy the exact site key from your dashboard</li>";
        echo "<li><strong>Check Domain:</strong> Ensure <strong>{$domain}</strong> is listed in allowed domains</li>";
        echo "<li><strong>Update .env:</strong> Set <code>TURNSTILE_SITE_KEY=0x4AAAAAAA...</code></li>";
        echo "<li><strong>Restart Server:</strong> Restart your web server to reload environment variables</li>";
        echo "</ol>";
        echo "</div>";
        
        echo "<div class='status warning'>";
        echo "<h3>⚠️ Common Issues</h3>";
        echo "<ul>";
        echo "<li><strong>Wrong Site Key:</strong> Copied from wrong Turnstile site</li>";
        echo "<li><strong>Domain Mismatch:</strong> Site key not registered for {$domain}</li>";
        echo "<li><strong>Deleted Site Key:</strong> Site key was deleted from Cloudflare</li>";
        echo "<li><strong>Environment Mismatch:</strong> Using test keys in production</li>";
        echo "</ul>";
        echo "</div>";
        ?>
        
        <div class="status info">
            <h3>🧪 Test Your Fix</h3>
            <p>After updating your site key:</p>
            <ol>
                <li>Visit: <a href="/turnstile-debug.html" style="color: #60a5fa;">/turnstile-debug.html</a></li>
                <li>Check if error 400020 is gone</li>
                <li>Try the Turnstile widget</li>
            </ol>
        </div>
    </div>
</body>
</html>
