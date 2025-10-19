<?php
// Simple test endpoint for Turnstile validation
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get the token from POST data
$token = $_POST['cf-turnstile-response'] ?? null;
$remoteIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;

if (!$token) {
    http_response_code(400);
    echo json_encode(['error' => 'No token provided']);
    exit;
}

// Get secret key from environment
$secretKey = getenv('TURNSTILE_SECRET_KEY');

if (!$secretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Turnstile secret key not configured']);
    exit;
}

// Make request to Cloudflare
$postData = [
    'secret' => $secretKey,
    'response' => $token,
    'remoteip' => $remoteIp,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://challenges.cloudflare.com/turnstile/v0/siteverify');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: NXO-Turnstile-Test/1.0'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'error' => 'CURL error: ' . $curlError,
        'token_length' => strlen($token),
        'token_preview' => substr($token, 0, 20) . '...',
        'remote_ip' => $remoteIp,
    ]);
    exit;
}

if ($httpCode !== 200) {
    http_response_code(500);
    echo json_encode([
        'error' => 'HTTP error: ' . $httpCode,
        'response' => $response,
        'token_length' => strlen($token),
        'token_preview' => substr($token, 0, 20) . '...',
    ]);
    exit;
}

$result = json_decode($response, true);

echo json_encode([
    'success' => $result['success'] ?? false,
    'error_codes' => $result['error-codes'] ?? [],
    'challenge_ts' => $result['challenge_ts'] ?? null,
    'hostname' => $result['hostname'] ?? null,
    'action' => $result['action'] ?? null,
    'cdata' => $result['cdata'] ?? null,
    'token_length' => strlen($token),
    'token_preview' => substr($token, 0, 20) . '...',
    'remote_ip' => $remoteIp,
    'request_hostname' => $_SERVER['HTTP_HOST'] ?? 'unknown',
    'raw_response' => $result,
], JSON_PRETTY_PRINT);
?>
