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

