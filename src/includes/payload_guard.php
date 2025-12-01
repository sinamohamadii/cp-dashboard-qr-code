<?php
/**
 * Payload Guard Middleware
 * 
 * Validates user sessions against Payload CMS via /api/users/me endpoint.
 * Include this file at the top of every protected page.
 * 
 * Usage: require_once __DIR__ . '/includes/payload_guard.php';
 */

require_once __DIR__ . '/../config/config.php';

// Global variable to store authenticated user data
$payloadUser = null;

/**
 * Check if current script should skip authentication
 * @return bool
 */
function isPublicEndpoint(): bool {
    $scriptName = basename($_SERVER['SCRIPT_NAME']);
    $publicEndpoints = ['read.php']; // Add other public endpoints here if needed
    return in_array($scriptName, $publicEndpoints);
}

/**
 * Get the login redirect URL based on environment
 * @return string
 */
function getLoginUrl(): string {
    return PAYLOAD_LOGIN_URL;
}

/**
 * Redirect to login page
 * @return never
 */
function redirectToLogin(): never {
    $loginUrl = getLoginUrl();
    header('Location: ' . $loginUrl);
    exit;
}

/**
 * Show access denied page
 * @param array $user The authenticated user (without qrCodes permission)
 * @return never
 */
function showAccessDenied(array $user): never {
    require_once __DIR__ . '/access_denied.php';
    exit;
}

/**
 * Get the payload-token cookie value
 * @return string|null
 */
function getPayloadToken(): ?string {
    $cookieName = PAYLOAD_COOKIE_NAME;
    return $_COOKIE[$cookieName] ?? null;
}

/**
 * Build the full URL for the /api/users/me endpoint
 * Uses PAYLOAD_API_BASE_URL for server-to-server requests from Docker
 * @return string
 */
function buildUserMeEndpoint(): string {
    return PAYLOAD_API_BASE_URL . '/api/users/me';
}

/**
 * Validate session with Payload CMS
 * @return array|null User data on success, null on failure
 */
function validatePayloadSession(): ?array {
    $token = getPayloadToken();
    
    if ($token === null) {
        return null;
    }
    
    $endpoint = buildUserMeEndpoint();
    
    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 5, // Connection timeout for production reliability
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Cookie: ' . PAYLOAD_COOKIE_NAME . '=' . $token,
        ],
        // SSL verification based on environment
        CURLOPT_SSL_VERIFYPEER => APP_ENV === 'production',
        CURLOPT_SSL_VERIFYHOST => APP_ENV === 'production' ? 2 : 0,
        // Follow redirects if any
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 3,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    // Log errors with endpoint for debugging
    if ($curlError) {
        error_log('Payload Guard cURL Error [' . $endpoint . ']: ' . $curlError);
        return null;
    }
    
    if ($httpCode !== 200) {
        error_log('Payload Guard HTTP Error [' . $endpoint . ']: ' . $httpCode);
        return null;
    }
    
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Payload Guard JSON Error: ' . json_last_error_msg());
        return null;
    }
    
    // Check if user data exists in response
    if (!isset($data['user'])) {
        error_log('Payload Guard: No user in response');
        return null;
    }
    
    return $data['user'];
}

/**
 * Check if user has qrCodes permission
 * @param array $user
 * @return bool
 */
function hasQrCodesPermission(array $user): bool {
    return isset($user['permissions']['qrCodes']) 
        && $user['permissions']['qrCodes'] === true;
}

/**
 * Main guard function - validates session and permissions
 * @return array The validated user data
 */
function requirePayloadAuth(): array {
    global $payloadUser;
    
    // Skip auth for public endpoints
    if (isPublicEndpoint()) {
        return [];
    }
    
    // Check for token
    if (getPayloadToken() === null) {
        redirectToLogin();
    }
    
    // Validate session with Payload
    $user = validatePayloadSession();
    
    if ($user === null) {
        // Session invalid or expired - redirect to login
        redirectToLogin();
    }
    
    // Check qrCodes permission
    if (!hasQrCodesPermission($user)) {
        showAccessDenied($user);
    }
    
    // Store user globally for use in pages
    $payloadUser = $user;
    
    return $user;
}

// Execute guard automatically when this file is included
// (unless we're in a public endpoint)
if (!isPublicEndpoint()) {
    requirePayloadAuth();
}

