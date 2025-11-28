# Step-by-Step Guide: Removing Authentication & Opening the Project

This guide details how to completely remove the user authentication system and make the QR Code Generator open to all users. It also addresses the critical dependency issues we identified.

## Phase 1: Preparation & Backup

1.  **Backup your Database**: Export your current database to a `.sql` file just in case.
2.  **Git Branch**: Create a new branch for this work if you haven't already.
    ```bash
    git checkout -b remove-auth-open-access
    ```

## Phase 3: Database Cleanup

We need to remove the `users` table and references to it.

1.  **Execute SQL Commands**:
    Run these SQL commands in your database (via Adminer, phpMyAdmin, or command line):

    ```sql
    -- Drop the users table
    DROP TABLE IF EXISTS users;

    -- Remove user_id column from dynamic_qrcodes
    ALTER TABLE dynamic_qrcodes DROP COLUMN user_id;

    -- Remove user_id column from static_qrcodes
    ALTER TABLE static_qrcodes DROP COLUMN user_id;
    ```

## Phase 4: Codebase Refactoring - Removing Auth Logic

We will now go through the code and remove all login checks and user-specific logic.

### 1. Remove Auth Files
Delete the following files that are no longer needed:
*   `src/login.php`
*   `src/logout.php`
*   `src/authenticate.php`
*   `src/users.php`
*   `src/user.php`
*   `src/includes/auth_validate.php`
*   `src/forms/form_users.php`
*   `src/forms/table_users.php`
*   `src/lib/Users/` (Directory)

### 2. Update `src/includes/header.php` & `src/includes/navbar.php`
*   **Remove** any "Login", "Logout", or "Profile" links.
*   **Remove** any PHP checks like `if(isset($_SESSION['user_logged_in']))`.
*   Ensure the navigation menu is visible to everyone.

### 3. Update `src/helpers/helpers.php`
*   **Remove** the `is_logged_in()` function (or make it always return `true` temporarily, but better to remove usages).
*   **Remove** `get_user_id()` function.
*   **Remove** `check_user_permissions()` or similar functions.

### 4. Update `src/config/config.php`
*   Remove any settings related to authentication (e.g., `REQUIRE_AUTH`, `ENABLE_REGISTRATION`).

### 5. Update Entry Points (`index.php`, `dynamic_qrcodes.php`, `static_qrcodes.php`)
*   **Remove** the `require_once 'authenticate.php';` line from the top of these files.
*   **Remove** any code that redirects the user to `login.php` if they are not logged in.
*   **Update SQL Queries**: Change queries like `SELECT * FROM dynamic_qrcodes WHERE user_id = ?` to `SELECT * FROM dynamic_qrcodes` (remove the `WHERE` clause).

## Phase 5: Preparing for External Auth Middleware

Since we are replacing the local auth with an external container validation:

1.  **Create Middleware File**: We will create `src/includes/AuthMiddleware.php`.
2.  **Define Logic**: This middleware will:
    *   Check for specific cookies (e.g., `auth_token`).
    *   Send a request to the Main Container to validate the token.
    *   If valid, allow access.
    *   If invalid, redirect to the external login page.
3.  **Integration**: We will include this middleware in `src/includes/header.php` or at the top of protected pages instead of the old `authenticate.php`.


## Phase 6: Testing & Verification

After making these changes, perform the following tests:

1.  **Access the Site**: Go to `http://localhost:8081`. You should see the dashboard/index immediately without logging in.
2.  **List QR Codes**: Go to "Dynamic QR Codes" and "Static QR Codes". You should see **ALL** existing QR codes.
3.  **Generate PNG**: Create a new Static QR Code (Format: PNG).
    *   **Verify**: It creates successfully (no errors).
    *   **Verify**: The image is black and white and sharp (not blurry/grayscale).
    *   **Verify**: You can download it.
4.  **Generate JPEG/GIF**: Create codes in these formats.
    *   **Verify**: They create successfully (no "scaleImage" error).
5.  **Generate SVG**: Create an SVG code with colors.
    *   **Verify**: It has the correct colors.

## Summary of Critical "Gotchas"
*   **Composer Version**: You MUST use `chillerlan/php-qrcode: ^5.0`.
*   **EccLevel**: The code uses `EccLevel` class, which confirms v5.0 is required.
*   **Imagick**: v5.0 returns a string, not an object. You must use `readImageBlob`.
*   **PNG Colors**: Do not set `moduleValues` for PNGs in v5.0; let it use defaults.
