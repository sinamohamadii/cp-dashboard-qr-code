<?php
/**
 * Caesar Dashboard Header
 * Matches the design from dashboard-layout-template.html
 */

$userName = getUserDisplayName();
$userRole = getUserRole();

// Get page title based on current page
function getPageTitle() {
    $page = CURRENT_PAGE;
    
    if (strpos($page, 'index.php') === 0) {
        return 'QR Generator';
    } elseif (strpos($page, 'dynamic_qrcodes.php') === 0) {
        return 'Dynamic QR Codes';
    } elseif (strpos($page, 'dynamic_qrcode.php') === 0) {
        return isset($_GET['edit']) ? 'Edit Dynamic QR Code' : 'Create Dynamic QR Code';
    } elseif (strpos($page, 'static_qrcodes.php') === 0) {
        return 'Static QR Codes';
    } elseif (strpos($page, 'static_qrcode.php') === 0) {
        return isset($_GET['edit']) ? 'Edit Static QR Code' : 'Create Static QR Code';
    }
    
    return 'QR Generator';
}

$pageTitle = getPageTitle();
?>

<header class="caesar-header">
    <div>
        <p class="page-title"><?php echo htmlspecialchars($pageTitle); ?></p>
    </div>
    <div class="header-right">
        <!-- Back to Dashboard -->
        <a href="<?php echo dashboard_url(); ?>" class="header-icon-btn" title="Back to Dashboard">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="7" height="7" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <rect x="3" y="14" width="7" height="7" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <rect x="14" y="14" width="7" height="7" rx="2" stroke="currentColor" stroke-width="1.5"/>
                <rect x="14" y="3" width="7" height="7" rx="2" stroke="currentColor" stroke-width="1.5"/>
            </svg>
        </a>
        
        <!-- Notifications -->
        <div class="header-icon-btn" title="Notifications">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M13.73 21C13.5542 21.3031 13.3019 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <!-- Help -->
        <div class="header-icon-btn" title="Help">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                <path d="M9.09 9C9.3251 8.33167 9.78915 7.76811 10.4 7.40913C11.0108 7.05016 11.7289 6.91894 12.4272 7.03871C13.1255 7.15849 13.7588 7.52152 14.2151 8.06353C14.6713 8.60553 14.9211 9.29152 14.92 10C14.92 12 11.92 13 11.92 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="17" r="1" fill="currentColor"/>
            </svg>
        </div>
        
        <!-- User info -->
        <div class="user-info">
            <p class="user-name"><?php echo htmlspecialchars($userName); ?></p>
            <?php if ($userRole): ?>
            <p class="user-role"><?php echo htmlspecialchars($userRole); ?></p>
            <?php endif; ?>
        </div>
    </div>
</header>
