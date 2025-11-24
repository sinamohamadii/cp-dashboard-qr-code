# Payload-Authenticated QR Module – Integration Guide

This repository acts as a self-contained QR code module that the Payload CMS host loads through a reverse proxy. The host application owns all login, session, and access-control logic; this module must only render UI for already authenticated users. Follow the steps below whenever you adapt or redeploy the module.

## 1. Bootstrap the module
1. Clone the repo or scaffold a clean workspace.
2. Keep the provided `Dockerfile` and `docker-compose.yml`. They already ship PHP 8.3, all required extensions, and a MySQL container seeded with sample data.
3. Add a `/healthz` endpoint (or reuse one from the host) so the main Payload project can probe the module.
4. Treat `/src` as the web root when serving the module behind the reverse proxy.

## 2. Remove legacy local authentication
1. Delete or ignore legacy pages: `src/login.php`, `src/authenticate.php`, `src/logout.php`, and any routes referencing `includes/auth_validate.php`.
2. Drop the `users` table from the module database or leave it unused; it should never be referenced.
3. Remove calls to `session_start()` that were only used for local login. Only keep session usage if you need to store cached user info returned by the host.
4. Replace every `require_once './includes/auth_validate.php';` with the new middleware described below.

## 3. Configure shared secrets and environment
1. Inject the following via environment variables (never commit secrets):
   - `PAYLOAD_BASE_URL`: the root URL for the host project (e.g., `https://app.example.com`).
   - `PAYLOAD_SESSION_CHECK_ROUTE`: host endpoint that validates cookies (e.g., `/api/session/status`).
   - `PAYLOAD_SHARED_SECRET` or JWKS URL, depending on whether you verify signed cookies yourself or rely on the host endpoint response.
   - `PAYLOAD_COOKIE_DOMAIN`, `PAYLOAD_COOKIE_NAME`, and any additional headers you expect to forward.
2. Ensure the reverse proxy forwards the visitor’s cookies to this module. Without the cookies, the host cannot validate the session.
3. Store these settings in `src/config/environment.php` (using `getenv(...) ?: 'default'` like the existing DB settings).

## 4. Implement the Payload guard middleware
Create a new include, for example `src/includes/payload_guard.php`, and load it at the top of every page that should be protected.

**Responsibilities**
1. Read the cookies (`$_SERVER['HTTP_COOKIE']`) and the visitor’s IP/user agent for auditing.
2. Send a server-to-server request to `PAYLOAD_BASE_URL . PAYLOAD_SESSION_CHECK_ROUTE`:
   - Use cURL or Guzzle from PHP.
   - Forward the cookie header unchanged so the host can parse the session.
   - Include an internal API key or shared secret header (`X-Module-Secret`) if the host expects it.
3. Handle responses:
   - `200`: Parse JSON with user info, permissions, and expiry. Store it in `$payloadUser` (global) or `$_SESSION['payload_user']`.
   - `401/403`: Immediately return a 401 to the reverse proxy so it can redirect to the Payload login page.
   - `>=500`: log the failure and return a 503 so the host knows the module could not verify the request.
4. Cache success responses briefly (e.g., 30 seconds) if you need to reduce host calls. Use `apcu` or PHP sessions, but always re-validate after cache expiry.
5. Expose helper functions such as `requirePermission('qr:write')` so pages can enforce fine-grained access using the data sent from Payload.

**Example skeleton**
```php
<?php
require_once __DIR__.'/../config/config.php';

function verifyPayloadSession(): array {
    $cookies = $_SERVER['HTTP_COOKIE'] ?? '';
    if ($cookies === '') {
        http_response_code(401);
        exit('Missing auth context');
    }

    $ch = curl_init(PAYLOAD_BASE_URL . PAYLOAD_SESSION_CHECK_ROUTE);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Cookie: ' . $cookies,
            'X-Module-Secret: ' . PAYLOAD_SHARED_SECRET,
        ],
    ]);
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status !== 200) {
        http_response_code($status === 401 ? 401 : 503);
        exit('Unauthorized');
    }

    return json_decode($response, true);
}

$payloadUser = verifyPayloadSession();
```

Include this guard instead of the legacy `auth_validate.php` in every page (`index.php`, `dynamic_qrcodes.php`, etc.).

## 5. Update application code to use Payload-provided context
1. Replace `$_SESSION['type']`, `$_SESSION['user_id']`, and similar fields with data from `$payloadUser`. For example:
   - `$_SESSION['type']` → `$payloadUser['role']`.
   - `$_SESSION['user_id']` → `$payloadUser['id']`.
2. Where the code checks `$_SESSION['type'] !== 'super'`, swap in an appropriate host permission (e.g., `!in_array('qr:admin', $payloadUser['permissions'])`).
3. Remove UI elements (user management pages, login links) that no longer apply.
4. Keep the existing QR logic (dynamic/static forms, bulk actions) unchanged except for the owner resolution logic that now relies on host user info.

## 6. Styling customization
1. Central entry points:
   - `src/includes/head.php`: add new fonts, CSS, or meta tags injected by the host.
   - `src/dist/css/custom.css`: place all module-specific overrides here so Payload can version-control them.
   - `src/includes/navbar.php` and `src/includes/sidebar.php`: replace the standalone branding with components the host expects (logo, breadcrumbs, etc.).
2. Match the host theme variables (colors, font stacks) by exposing CSS custom properties. Consider loading a host-provided stylesheet via the reverse proxy.
3. For deeper structural changes, edit the AdminLTE layout (cards, info boxes) but keep IDs/hooks intact if the host injects data via JS.
4. Provide a short checklist to designers:
   - Update favicon and logos.
   - Align typography with Payload CMS.
   - Verify dark mode / high-contrast needs if the main project supports them.

## 7. Testing checklist
1. Start the Docker stack (`docker compose up`) and verify the module boots without local auth routes.
2. Through the reverse proxy, access the module as:
   - an authenticated Payload user,
   - an unauthenticated visitor (cookies removed),
   - a user without QR permissions.
3. Confirm the middleware logs each verification attempt and that failures produce the expected HTTP codes.
4. Exercise dynamic/static QR creation, bulk download/delete, and the public `read.php` endpoint.
5. Run front-end smoke tests for the customized styles (responsive breakpoints, dark mode if applicable).

## 8. Operational notes
1. Log validation failures and forward them to the host observability stack.
2. Serve everything over HTTPS. Ensure `SameSite=None; Secure` cookies pass through the proxy untouched.
3. Monitor middleware latency; if host validation is slow, add retries with exponential backoff.
4. Keep the module stateless apart from cached validation responses so it scales horizontally behind the reverse proxy.

Following this guide keeps the module lightweight, fully dependent on the main Payload CMS for authentication, and visually aligned with the host experience.
