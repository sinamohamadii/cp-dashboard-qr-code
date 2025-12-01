# Payload Guard Middleware Implementation Guide

This document provides step-by-step instructions for implementing authentication middleware that validates user sessions against the Payload CMS host via the `/api/users/me` endpoint.

---

## Overview

The Payload Guard middleware:
- Checks for the `payload-token` cookie on every protected request
- Validates the session via same-origin `/api/users/me` endpoint (routed through reverse proxy)
- Enforces `permissions.qrCodes === true` for access to the QR module
- Excludes `read.php` (public QR redirect endpoint) from authentication
- Redirects unauthenticated users to the appropriate login URL based on environment

---

## 1. Environment Variables

Add the following environment variables to your Docker configuration and update `src/config/environment.php`.

### Docker Environment Variables

**docker-compose.yml (local):**
```yaml
environment:
  - APP_ENV=local
  - PAYLOAD_LOGIN_URL=http://localhost:3100/
```

**docker-compose.prod.yml (production):**
```yaml
environment:
  - APP_ENV=production
  - PAYLOAD_LOGIN_URL=https://dashboard.caesar-projects.com/
```

### Update `src/config/environment.php`

Add these lines after the existing configuration:

```php
// Payload Authentication Configuration
define('APP_ENV', getenv('APP_ENV') ?: 'local');
define('PAYLOAD_LOGIN_URL', getenv('PAYLOAD_LOGIN_URL') ?: (
    APP_ENV === 'production' 
        ? 'https://dashboard.caesar-projects.com/' 
        : 'http://localhost:3100/'
));
define('PAYLOAD_COOKIE_NAME', getenv('PAYLOAD_COOKIE_NAME') ?: 'payload-token');
```

---

## 2. Middleware Implementation

Create the file `src/includes/payload_guard.php`:

```php
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
 * Uses same-origin request (routed through reverse proxy)
 * @return string
 */
function buildUserMeEndpoint(): string {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . '://' . $host . '/api/users/me';
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
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Cookie: ' . PAYLOAD_COOKIE_NAME . '=' . $token,
        ],
        // For local development with self-signed certs
        CURLOPT_SSL_VERIFYPEER => APP_ENV === 'production',
        CURLOPT_SSL_VERIFYHOST => APP_ENV === 'production' ? 2 : 0,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    // Log errors for debugging (in production, use proper logging)
    if ($curlError) {
        error_log('Payload Guard cURL Error: ' . $curlError);
        return null;
    }
    
    if ($httpCode !== 200) {
        error_log('Payload Guard HTTP Error: ' . $httpCode);
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
```

---

## 3. Access Denied Page

Create the file `src/includes/access_denied.php`:

```php
<?php
/**
 * Access Denied Page
 * 
 * Displayed when a user is authenticated but lacks qrCodes permission.
 * This file is included by payload_guard.php - do not include directly.
 */

// Set proper HTTP status
http_response_code(403);

// Get user info if available
$userName = '';
if (isset($user)) {
    $userName = trim(($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? ''));
    if (empty($userName)) {
        $userName = $user['email'] ?? 'User';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - QR Code Generator</title>
    <link rel="stylesheet" href="<?php echo absolute_url('plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo absolute_url('dist/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo absolute_url('dist/css/custom.css'); ?>">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .access-denied-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 3rem;
            text-align: center;
            max-width: 480px;
            width: 90%;
        }
        .access-denied-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }
        .access-denied-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
        }
        .access-denied-message {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .access-denied-user {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: #495057;
        }
        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="access-denied-card">
        <div class="access-denied-icon">
            <i class="fas fa-lock"></i>
        </div>
        <h1 class="access-denied-title">Access Denied</h1>
        <p class="access-denied-message">
            You don't have permission to access the QR Code Generator module.
            Please contact your administrator to request access.
        </p>
        <?php if (!empty($userName)): ?>
        <div class="access-denied-user">
            <i class="fas fa-user mr-2"></i>
            Logged in as: <strong><?php echo htmlspecialchars($userName); ?></strong>
        </div>
        <?php endif; ?>
        <a href="<?php echo getLoginUrl(); ?>" class="btn-back">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
        </a>
    </div>
</body>
</html>
```

---

## 4. Integration Points

### Files That Need the Guard

Add this line at the top of each protected file (after any `<?php` tag but before other logic):

```php
require_once __DIR__ . '/includes/payload_guard.php';
```

**Main Pages:**
- `src/index.php`
- `src/dynamic_qrcodes.php`
- `src/dynamic_qrcode.php`
- `src/static_qrcodes.php`
- `src/static_qrcode.php`
- `src/bulk_action.php`

**Form Files (in `src/forms/`):**
- `form_dynamic_add.php`
- `form_dynamic_edit.php`
- `form_static_add.php`
- `form_static_edit.php`
- `filters.php`
- `logo.php`
- `qrcode_options.php`
- `table_dynamic.php`
- `table_static.php`

**Static Type Forms (in `src/forms/static/`):**
- All files (`2fa.php`, `bitcoin.php`, `email.php`, etc.) - if accessed directly

### Files Explicitly EXCLUDED (Public)

- `src/read.php` - Public QR code redirect endpoint (must remain accessible for QR codes to work)

---

## 5. User Context Mapping

Once authenticated, the user data is available via the global `$payloadUser` variable:

```php
// Access user information anywhere in the page
global $payloadUser;

// User ID
$userId = $payloadUser['id'];

// User email
$email = $payloadUser['email'];

// User name
$firstName = $payloadUser['firstName'];
$lastName = $payloadUser['lastName'];
$fullName = trim($firstName . ' ' . $lastName);

// User roles (array)
$roles = $payloadUser['roles']; // e.g., ['admin', 'user']
$isAdmin = in_array('admin', $roles);

// Permissions (object)
$permissions = $payloadUser['permissions'];
$canAccessQr = $permissions['qrCodes'] ?? false;
$canAccessLeads = $permissions['leads'] ?? false;
// etc.
```

### Example: Display User in Navbar

```php
<?php global $payloadUser; ?>
<span class="user-name">
    <?php echo htmlspecialchars($payloadUser['firstName'] ?? 'User'); ?>
</span>
```

### Example: Check Admin Role

```php
<?php 
global $payloadUser;
$isAdmin = in_array('admin', $payloadUser['roles'] ?? []);
?>

<?php if ($isAdmin): ?>
    <!-- Admin-only content -->
<?php endif; ?>
```

---

## 6. API Request Details

### Request Format

The middleware sends a same-origin GET request:

```
GET /api/users/me HTTP/1.1
Host: localhost:3100 (or dashboard.caesar-projects.com)
Content-Type: application/json
Cookie: payload-token=<jwt-token>
```

### Expected Response (200 OK)

```json
{
    "user": {
        "id": 1,
        "firstName": "Sina",
        "lastName": "Mohamadi",
        "roles": ["admin", "user"],
        "permissions": {
            "leads": true,
            "campaigns": true,
            "analytics": true,
            "digitalAccounts": true,
            "events": true,
            "resources": true,
            "qrCodes": true,
            "reviews": true,
            "settings": true
        },
        "email": "user@example.com",
        "collection": "users"
    },
    "collection": "users",
    "strategy": "local-jwt"
}
```

### Permission Check

The middleware specifically checks:
```php
$response['user']['permissions']['qrCodes'] === true
```

---

## 7. Testing Checklist

### Authentication Flow

- [ ] User without `payload-token` cookie → Redirected to login URL
- [ ] User with invalid/expired token → Redirected to login URL
- [ ] User with valid token but `qrCodes: false` → Access Denied page (403)
- [ ] User with valid token and `qrCodes: true` → Access granted

### Environment-Specific

- [ ] Local: Redirects to `http://localhost:3100/`
- [ ] Production: Redirects to `https://dashboard.caesar-projects.com/`

### Public Endpoints

- [ ] `read.php` accessible without authentication
- [ ] QR code redirects work for anonymous users

### User Context

- [ ] `$payloadUser` contains correct user data after auth
- [ ] User name displays correctly in UI
- [ ] Role checks work as expected

---

## 8. Troubleshooting

### Common Issues

**1. Redirect loop to login page**
- Check that `payload-token` cookie is being forwarded by the reverse proxy
- Verify the cookie domain matches the module's domain

**2. cURL errors**
- Check that the PHP container can reach the Payload host
- For local dev, SSL verification is disabled; ensure `APP_ENV=local`

**3. 401 from `/api/users/me`**
- Token may be expired - user needs to re-login
- Check Payload logs for session validation errors

**4. Access Denied shown incorrectly**
- Verify the user has `qrCodes: true` in their permissions
- Check Payload user configuration

### Debug Mode

Add this to `payload_guard.php` temporarily for debugging:

```php
// Add after validatePayloadSession() call
error_log('Payload Guard Debug: ' . print_r($user, true));
```

---

## 9. Security Considerations

1. **Cookie Security**: Ensure cookies are set with `SameSite=None; Secure` for cross-origin requests in production

2. **HTTPS**: Always use HTTPS in production to protect tokens in transit

3. **Token Expiry**: The middleware relies on Payload's token expiration; no additional expiry logic needed

4. **Error Messages**: Production error messages should be generic to avoid information disclosure

5. **Logging**: Log authentication failures for security monitoring but avoid logging tokens

