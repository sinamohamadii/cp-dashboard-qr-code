<?php
/*
|--------------------------------------------------------------------------
| UNIFIED ENVIRONMENT CONFIGURATION
|--------------------------------------------------------------------------
*/

define('DATABASE_HOST', getenv('DATABASE_HOST') ?: 'localhost');
define('DATABASE_PORT', filter_var(getenv('DATABASE_PORT'), FILTER_VALIDATE_INT) ?: 3306);
define('DATABASE_NAME', getenv('DATABASE_NAME') ?: 'qrcode');
define('DATABASE_USER', getenv('DATABASE_USER') ?: 'root');
define('DATABASE_PASSWORD', getenv('DATABASE_PASSWORD') ?: 'root');
define('DATABASE_PREFIX', getenv('DATABASE_PREFIX') !== false ? getenv('DATABASE_PREFIX') : 'qr_');
define('DATABASE_CHARSET', getenv('DATABASE_CHARSET') ?: 'utf8');

define('TYPE', getenv('TYPE') ?: 'local');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost');
define('QRCODE_GENERATOR', getenv('QRCODE_GENERATOR') ?: 'external-api.qrserver.com'); // opties: external-api.qrserver.com of internal-chillerlan.qrcode

$appBasePath = getenv('APP_BASE_PATH');
if ($appBasePath === false || $appBasePath === null || $appBasePath === '') {
    $appBasePath = '/';
}
$appBasePath = '/' . ltrim($appBasePath, '/');
$appBasePath = rtrim($appBasePath, '/');
if ($appBasePath === '') {
    $appBasePath = '/';
}

define('APP_BASE_PATH', $appBasePath);

// Payload Authentication Configuration
define('APP_ENV', getenv('APP_ENV') ?: 'local');
define('PAYLOAD_LOGIN_URL', getenv('PAYLOAD_LOGIN_URL') ?: (
    APP_ENV === 'production' 
        ? 'https://dashboard.caesar-projects.com/' 
        : 'http://localhost:3100/'
));
define('PAYLOAD_COOKIE_NAME', getenv('PAYLOAD_COOKIE_NAME') ?: 'payload-token');
// Internal API URL for server-to-server requests from Docker container
// Use host.docker.internal to reach host machine from inside Docker on Windows/Mac
define('PAYLOAD_API_BASE_URL', getenv('PAYLOAD_API_BASE_URL') ?: 'http://host.docker.internal:3100');
