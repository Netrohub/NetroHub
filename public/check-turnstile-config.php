<?php
// Simple PHP script to check Turnstile configuration
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$config = [
    'turnstile_configured' => false,
    'site_key_present' => false,
    'secret_key_present' => false,
    'site_key_value' => null,
    'secret_key_value' => null,
    'environment' => app()->environment(),
    'debug_mode' => config('app.debug'),
];

// Check if Turnstile is configured
$siteKey = config('services.turnstile.site_key');
$secretKey = config('services.turnstile.secret_key');

if ($siteKey && $secretKey) {
    $config['turnstile_configured'] = true;
    $config['site_key_present'] = true;
    $config['secret_key_present'] = true;
    $config['site_key_value'] = $siteKey;
    $config['secret_key_value'] = $secretKey ? '***configured***' : null;
} else {
    if ($siteKey) {
        $config['site_key_present'] = true;
        $config['site_key_value'] = $siteKey;
    }
    if ($secretKey) {
        $config['secret_key_present'] = true;
        $config['secret_key_value'] = '***configured***';
    }
}

echo json_encode($config, JSON_PRETTY_PRINT);
?>
