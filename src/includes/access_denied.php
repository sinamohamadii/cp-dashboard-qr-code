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
    <title>Access Denied - Caesar Project</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo absolute_url('plugins/fontawesome-free/css/all.min.css'); ?>">
    <style>
        :root {
            --primary-color: #F7CC40;
            --color-base-10: #191919;
            --color-base-50: #59595A;
            --color-base-70: #98989A;
            --color-base-80: #E6E6E6;
            --color-base-90: #F7F7F7;
            --color-error: #DC2626;
            --color-white: #FFFFFF;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            background: var(--color-base-90);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        
        .access-denied-card {
            background: var(--color-white);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            border: 1px solid var(--color-base-80);
            padding: 48px;
            text-align: center;
            max-width: 460px;
            width: 100%;
        }
        
        .access-denied-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        
        .access-denied-icon i {
            font-size: 32px;
            color: var(--color-error);
        }
        
        .access-denied-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-base-10);
            margin-bottom: 12px;
        }
        
        .access-denied-message {
            color: var(--color-base-50);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        
        .access-denied-user {
            background: var(--color-base-90);
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 14px;
            color: var(--color-base-50);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .access-denied-user strong {
            color: var(--color-base-10);
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary-color);
            border: none;
            color: var(--color-base-10);
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        
        .btn-back:hover {
            background: #D4AF37;
            color: var(--color-base-10);
            text-decoration: none;
            transform: translateY(-1px);
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
            <i class="fas fa-user"></i>
            Logged in as: <strong><?php echo htmlspecialchars($userName); ?></strong>
        </div>
        <?php endif; ?>
        <a href="<?php echo getLoginUrl(); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>
</body>
</html>
