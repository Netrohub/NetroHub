<?php
// Test Turnstile site key validity
header('Content-Type: application/json');

$siteKey = '0x4AAAAAAB7dFU6VMLmS-CiV';
$domain = 'nxoland.com';

// Test if the site key is valid by trying to load Turnstile
?>
<!DOCTYPE html>
<html>
<head>
    <title>Turnstile Site Key Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #1a1a1a; color: white; }
        .container { max-width: 600px; margin: 0 auto; }
        .status { padding: 15px; margin: 10px 0; border-radius: 8px; }
        .success { background: #10b981; }
        .error { background: #ef4444; }
        .warning { background: #f59e0b; }
        .info { background: #3b82f6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Turnstile Site Key Test</h1>
        
        <div class="status info">
            <h3>📋 Test Configuration</h3>
            <p><strong>Site Key:</strong> <?php echo htmlspecialchars($siteKey); ?></p>
            <p><strong>Domain:</strong> <?php echo htmlspecialchars($domain); ?></p>
        </div>
        
        <div class="status info">
            <h3>🧪 Turnstile Widget Test</h3>
            <p>If the widget loads without error 400020, your site key is valid.</p>
            
            <div class="cf-turnstile" 
                 data-sitekey="<?php echo htmlspecialchars($siteKey); ?>" 
                 data-callback="onTsSuccess"
                 data-error-callback="onTsError"
                 data-size="normal"
                 data-theme="auto">
            </div>
            
            <div id="result" class="status info" style="margin-top: 20px;">
                <h3>📊 Test Results</h3>
                <p id="status-text">Waiting for Turnstile to load...</p>
            </div>
        </div>
    </div>

    <script>
        let resultDiv = document.getElementById('result');
        let statusText = document.getElementById('status-text');
        
        window.onTsSuccess = function (token) {
            resultDiv.className = 'status success';
            statusText.innerHTML = '✅ <strong>SUCCESS!</strong> Site key is valid and working. Token received: ' + token.substring(0, 20) + '...';
        };
        
        window.onTsError = function (error) {
            resultDiv.className = 'status error';
            if (error === '400020') {
                statusText.innerHTML = '❌ <strong>ERROR 400020:</strong> Invalid site key. The site key is not valid for this domain or does not exist.';
            } else {
                statusText.innerHTML = '❌ <strong>ERROR:</strong> ' + error;
            }
        };
        
        // Check if Turnstile loads
        setTimeout(() => {
            if (typeof window.turnstile === 'undefined') {
                resultDiv.className = 'status error';
                statusText.innerHTML = '❌ <strong>ERROR:</strong> Turnstile script failed to load.';
            }
        }, 5000);
    </script>
    
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</body>
</html>
