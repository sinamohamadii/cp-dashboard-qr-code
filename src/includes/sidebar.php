<?php
/**
 * Caesar Dashboard Sidebar
 * Matches the design from dashboard-layout-template.html
 */

// Get allowed permissions
$allowed = getAllowedPermissions();

// Helper to check active state
function isNavActive($page, $exact = false) {
    $current = CURRENT_PAGE;
    if ($exact) {
        return strpos($current, $page) === 0;
    }
    return strpos($current, $page) !== false;
}
?>

<aside class="caesar-sidebar">
    <div class="sidebar-top">
        <!-- Logo -->
        <div class="sidebar-logo">
            <p class="sidebar-title">Caesar Project</p>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- MENU Section -->
            <div class="nav-section">
                <div class="nav-section-title">
                    <p>MENU</p>
                </div>
                <div class="nav-links">
                    <!-- Dashboard (Main) -->
                    <a href="<?php echo dashboard_url(); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="3" width="7" height="7" rx="2.5" stroke="currentColor" stroke-width="1.5"/>
                            <rect x="3" y="14" width="7" height="7" rx="2.5" stroke="currentColor" stroke-width="1.5"/>
                            <rect x="14" y="14" width="7" height="7" rx="2.5" stroke="currentColor" stroke-width="1.5"/>
                            <rect x="14" y="3" width="7" height="7" rx="2.5" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        Dashboard
                    </a>

                    <?php if (in_array('analytics', $allowed)): ?>
                    <a href="<?php echo dashboard_url('analytics'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 13.9999C18.5523 13.9999 19.0064 14.4494 18.9376 14.9973C18.7832 16.2262 18.3449 17.4072 17.6518 18.4445C16.7727 19.7601 15.5233 20.7855 14.0615 21.391C12.5997 21.9965 10.9911 22.1549 9.43928 21.8462C7.88743 21.5375 6.46197 20.7756 5.34315 19.6568C4.22433 18.538 3.4624 17.1125 3.15372 15.5606C2.84504 14.0088 3.00347 12.4003 3.60897 10.9385C4.21447 9.47665 5.23985 8.22722 6.55544 7.34817C7.59276 6.65506 8.77376 6.21675 10.0026 6.06234C10.5506 5.99348 11 6.44764 11 6.99993V12.9999C11 13.5522 11.4477 13.9999 12 13.9999H18Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14 3.99993C14 3.44764 14.4494 2.99349 14.9974 3.06235C15.7053 3.15129 16.3996 3.33472 17.0615 3.60889C18.0321 4.01093 18.914 4.6002 19.6569 5.34307C20.3997 6.08594 20.989 6.96785 21.391 7.93846C21.6652 8.60035 21.8486 9.29465 21.9376 10.0025C22.0064 10.5505 21.5523 10.9999 21 10.9999L15 10.9999C14.4477 10.9999 14 10.5522 14 9.99993V3.99993Z" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        Analytics
                    </a>
                    <?php endif; ?>

                    <?php if (in_array('campaigns', $allowed)): ?>
                    <a href="<?php echo dashboard_url('marketing'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 18C20.2091 18 22 14.4183 22 10C22 5.58172 20.2091 2 18 2C15.7909 2 14 5.58172 14 10C14 14.4183 15.7909 18 18 18Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M18 2C14.897 2 8.465 4.378 4.771 5.854C3.079 6.53 2 8.178 2 10C2 11.822 3.08 13.47 4.771 14.146C8.465 15.622 14.897 18 18 18" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M11.0001 22L9.05709 20.93C8.01978 20.3559 7.17835 19.4841 6.64145 18.427C6.10455 17.37 5.89683 16.1763 6.04509 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Marketing Campaigns
                    </a>
                    <?php endif; ?>

                    <?php if (in_array('leads', $allowed)): ?>
                    <a href="<?php echo dashboard_url('lead-list'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.99999 14C5.57878 14 3.55952 15.721 3.09872 18.0064C2.98956 18.5478 3.44771 19 3.99999 19H4.99999M17 7.5C17 8.88071 15.8807 10 14.5 10C13.1193 10 12 8.88071 12 7.5C12 6.11929 13.1193 5 14.5 5C15.8807 5 17 6.11929 17 7.5ZM9.99999 10C9.99999 11.1046 9.10456 12 7.99999 12C6.89543 12 5.99999 11.1046 5.99999 10C5.99999 8.89543 6.89543 8 7.99999 8C9.10456 8 9.99999 8.89543 9.99999 10ZM8.08896 18.005C8.60249 15.1648 11.2774 13 14.5 13C17.7226 13 20.3975 15.1648 20.911 18.005C21.0093 18.5485 20.5523 19 20 19H8.99999C8.44771 19 7.9907 18.5485 8.08896 18.005Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Lead List
                    </a>
                    <?php endif; ?>

                    <?php if (in_array('digitalAccounts', $allowed)): ?>
                    <a href="<?php echo dashboard_url('digital-accounts'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.26367 3.5C6.53917 2.488 7.40867 1.757 8.50017 1.6785C9.77817 1.5865 11.6677 1.5 14.2502 1.5C16.8167 1.5 18.6987 1.5855 19.9762 1.677C21.2552 1.768 22.2322 2.745 22.3232 4.024C22.4147 5.3015 22.5002 7.184 22.5002 9.75C22.5002 12.3325 22.4137 14.222 22.3217 15.5C22.2432 16.5915 21.5117 17.461 20.5002 17.7365" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.823 8.5235C17.732 7.245 16.755 6.2685 15.476 6.177C14.1985 6.085 12.316 6 9.75 6C7.1835 6 5.3015 6.0855 4.024 6.177C2.745 6.268 1.768 7.245 1.677 8.524C1.585 9.801 1.5 11.6835 1.5 14.25C1.5 16.8165 1.5855 18.6985 1.677 19.9765C1.768 21.255 2.745 22.2315 4.024 22.323C5.3015 22.4145 7.184 22.5 9.75 22.5C12.3165 22.5 14.1985 22.4145 15.476 22.323C16.755 22.232 17.732 21.255 17.823 19.976C17.9145 18.6985 18 16.816 18 14.25C18 11.6835 17.9145 9.8015 17.823 8.5235Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.0132 15.3635C12.6214 14.9359 13.0776 14.3258 13.3158 13.6216C13.554 12.9174 13.5617 12.1556 13.3379 11.4467C13.1142 10.7377 12.6705 10.1185 12.0712 9.67863C11.4718 9.23877 10.748 9.00117 10.0046 9.00025C9.26121 8.99933 8.53682 9.23514 7.93641 9.67351C7.33601 10.1119 6.89078 10.73 6.66524 11.4384C6.4397 12.1468 6.44558 12.9086 6.68201 13.6134C6.91844 14.3182 7.37314 14.9294 7.98023 15.3585C6.73223 15.825 5.73773 16.713 5.23023 17.8185C4.90723 18.521 5.31023 19.362 6.08223 19.4085L6.10423 19.41C7.39824 19.4735 8.69367 19.5035 9.98923 19.5C11.6437 19.5 12.9262 19.4595 13.8742 19.41L13.8967 19.4085C14.6682 19.362 15.0717 18.521 14.7487 17.8185C14.2427 16.717 13.2542 15.8315 12.0132 15.3635Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Digital Accounts
                    </a>
                    <?php endif; ?>

                    <?php if (in_array('reviews', $allowed)): ?>
                    <a href="<?php echo dashboard_url('reviews'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.5 3.75C6.117 3.75 3.25 6.259 3.25 9.5C3.25283 10.6988 3.65304 11.8629 4.388 12.81L3.776 15.053C3.616 15.643 4.224 16.178 4.788 15.943L7.588 14.776C7.77166 14.6995 7.91741 14.5531 7.99317 14.3692C8.06894 14.1852 8.06851 13.9787 7.992 13.795C7.91549 13.6113 7.76914 13.4656 7.58517 13.3898C7.4012 13.3141 7.19466 13.3145 7.011 13.391L5.627 13.968L5.937 12.831C5.96985 12.7108 5.97224 12.5843 5.94396 12.463C5.91567 12.3417 5.85761 12.2293 5.775 12.136C5.127 11.405 4.75 10.49 4.75 9.5C4.75 7.218 6.808 5.25 9.5 5.25C11.58 5.25 13.291 6.433 13.954 8.022C10.814 8.275 8.25 10.685 8.25 13.75C8.25 16.991 11.117 19.5 14.5 19.5C15.266 19.5 16.003 19.373 16.684 19.14L19.212 20.192C19.776 20.428 20.384 19.892 20.224 19.302L19.612 17.06C20.347 16.1129 20.7472 14.9488 20.75 13.75C20.75 10.853 18.46 8.542 15.559 8.083C14.865 5.553 12.375 3.75 9.5 3.75ZM9.75 13.75C9.75 11.469 11.808 9.5 14.5 9.5C17.192 9.5 19.25 11.469 19.25 13.75C19.25 14.739 18.873 15.655 18.225 16.386C18.1424 16.4793 18.0843 16.5917 18.056 16.713C18.0278 16.8343 18.0301 16.9608 18.063 17.081L18.373 18.218L16.989 17.641C16.8084 17.5661 16.6057 17.5646 16.424 17.637C15.8114 17.8787 15.1585 18.0019 14.5 18C11.808 18 9.75 16.032 9.75 13.75Z" fill="currentColor"/>
                        </svg>
                        Reviews
                    </a>
                    <?php endif; ?>
                </div>
                <div class="nav-divider"></div>
            </div>

            <?php if (in_array('resources', $allowed) || in_array('events', $allowed)): ?>
            <!-- Management & Logistics Section -->
            <div class="nav-section">
                <div class="nav-section-title">
                    <p>Management & Logistics</p>
                </div>
                <div class="nav-links">
                    <?php if (in_array('resources', $allowed)): ?>
                    <a href="<?php echo dashboard_url('depo-resources'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5 10.25L21 12.5L12 17L3 12.5L7.5 10.25M16.5 15.25L21 17.5L12 22L3 17.5L7.5 15.25M12 3L21 7.5L12 12L3 7.5L12 3Z" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        Depo / Resources
                    </a>
                    <?php endif; ?>

                    <?php if (in_array('events', $allowed)): ?>
                    <a href="<?php echo dashboard_url('events'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.885 18C14.3003 18 13.8017 17.7934 13.389 17.38C12.9763 16.9667 12.7697 16.4684 12.769 15.885C12.7683 15.3017 12.975 14.8027 13.389 14.388C13.803 13.9734 14.3017 13.767 14.885 13.769C15.4683 13.771 15.967 13.9777 16.381 14.389C16.795 14.8004 17.0013 15.299 17 15.885C16.9987 16.471 16.792 16.9697 16.38 17.381C15.968 17.7924 15.4697 17.9987 14.885 18ZM5.615 21C5.155 21 4.771 20.846 4.463 20.538C4.155 20.23 4.00067 19.8457 4 19.385V6.61502C4 6.15502 4.15433 5.77102 4.463 5.46302C4.77167 5.15502 5.156 5.00069 5.616 5.00002H7.385V2.77002H8.462V5.00002H15.616V2.77002H16.616V5.00002H18.385C18.845 5.00002 19.2293 5.15435 19.538 5.46302C19.8467 5.77169 20.0007 6.15602 20 6.61602V19.385C20 19.845 19.846 20.2294 19.538 20.538C19.23 20.8467 18.8453 21.0007 18.384 21H5.615ZM5.615 20H18.385C18.5383 20 18.6793 19.936 18.808 19.808C18.9367 19.68 19.0007 19.5387 19 19.384V10.616H5V19.385C5 19.5384 5.064 19.6794 5.192 19.808C5.32 19.9367 5.461 20.0007 5.615 20ZM5 9.61502H19V6.61502C19 6.46169 18.936 6.32069 18.808 6.19202C18.68 6.06335 18.5387 5.99935 18.384 6.00002H5.616C5.462 6.00002 5.32067 6.06402 5.192 6.19202C5.06333 6.32002 4.99933 6.46135 5 6.61602V9.61502Z" fill="currentColor"/>
                        </svg>
                        Events
                    </a>
                    <?php endif; ?>
                </div>
                <div class="nav-divider"></div>
            </div>
            <?php endif; ?>

            <!-- Tools Section -->
            <div class="nav-section">
                <div class="nav-section-title">
                    <p>Tools</p>
                </div>
                <div class="nav-links">
                    <?php if (in_array('qrCodes', $allowed)): 
                        // Determine which section is active
                        $isDynamicSection = strpos(CURRENT_PAGE, 'dynamic_qrcode') !== false;
                        $isStaticSection = strpos(CURRENT_PAGE, 'static_qrcode') !== false;
                        $isDynamicList = CURRENT_PAGE === 'dynamic_qrcodes.php';
                        $isDynamicAdd = CURRENT_PAGE === 'dynamic_qrcode.php' && !isset($_GET['edit']);
                        $isStaticList = CURRENT_PAGE === 'static_qrcodes.php';
                        $isStaticAdd = CURRENT_PAGE === 'static_qrcode.php' && !isset($_GET['edit']);
                    ?>
                    <!-- QR Generator (Current Module - Always Active) -->
                    <a href="<?php echo url('index.php'); ?>" class="nav-link active">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 10.192V4.808C4 4.57934 4.07734 4.38734 4.232 4.232C4.38667 4.07667 4.57867 3.99934 4.808 4H10.192C10.4207 4 10.6127 4.07734 10.768 4.232C10.9233 4.38667 11.0007 4.57867 11 4.808V10.192C11 10.4213 10.9227 10.6133 10.768 10.768C10.6133 10.9227 10.4213 11 10.192 11H4.808C4.57934 11 4.38734 10.9227 4.232 10.768C4.07667 10.6133 3.99934 10.4213 4 10.192ZM5 10H10V5H5V10ZM4 19.192V13.808C4 13.5787 4.07734 13.3867 4.232 13.232C4.38667 13.0773 4.57867 13 4.808 13H10.192C10.4207 13 10.6127 13.0773 10.768 13.232C10.9233 13.3867 11.0007 13.5787 11 13.808V19.192C11 19.4207 10.9227 19.6127 10.768 19.768C10.6133 19.9233 10.4213 20.0007 10.192 20H4.808C4.57934 20 4.38734 19.9227 4.232 19.768C4.07667 19.6133 3.99934 19.4213 4 19.192ZM5 19H10V14H5V19ZM13 10.192V4.808C13 4.57934 13.0773 4.38734 13.232 4.232C13.3867 4.07667 13.5787 3.99934 13.808 4H19.192C19.4213 4 19.6133 4.07734 19.768 4.232C19.9227 4.38667 20 4.57867 20 4.808V10.192C20 10.4213 19.9227 10.6133 19.768 10.768C19.6133 10.9227 19.4213 11 19.192 11H13.808C13.5787 11 13.3867 10.9227 13.232 10.768C13.0773 10.6133 13 10.4213 13 10.192ZM14 10H19V5H14V10ZM18.25 20V18.25H20V20H18.25ZM13 14.75V13H14.75V14.75H13ZM14.75 16.5V14.75H16.5V16.5H14.75ZM13 18.25V16.5H14.75V18.25H13ZM14.75 20V18.25H16.5V20H14.75ZM16.5 18.25V16.5H18.25V18.25H16.5ZM16.5 14.75V13H18.25V14.75H16.5ZM18.25 16.5V14.75H20V16.5H18.25Z" fill="currentColor"/>
                        </svg>
                        QR Generator
                        <svg class="nav-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    
                    <!-- QR Generator Sub-menu -->
                    <div class="nav-submenu">
                        <!-- Dynamic QR Codes -->
                        <div class="nav-submenu-item<?php echo $isDynamicSection ? ' expanded' : ''; ?>">
                            <a href="#" class="nav-submenu-toggle" onclick="toggleSubmenu(this); return false;">
                                <span>Dynamic QR Codes</span>
                                <svg class="submenu-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <div class="nav-submenu-children">
                                <a href="<?php echo url('dynamic_qrcodes.php'); ?>" class="nav-submenu-link<?php echo $isDynamicList ? ' active' : ''; ?>">
                                    <span class="submenu-dot"></span>
                                    List All
                                </a>
                                <a href="<?php echo url('dynamic_qrcode.php'); ?>" class="nav-submenu-link<?php echo $isDynamicAdd ? ' active' : ''; ?>">
                                    <span class="submenu-dot"></span>
                                    Add New
                                </a>
                            </div>
                        </div>
                        
                        <!-- Static QR Codes -->
                        <div class="nav-submenu-item<?php echo $isStaticSection ? ' expanded' : ''; ?>">
                            <a href="#" class="nav-submenu-toggle" onclick="toggleSubmenu(this); return false;">
                                <span>Static QR Codes</span>
                                <svg class="submenu-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                            <div class="nav-submenu-children">
                                <a href="<?php echo url('static_qrcodes.php'); ?>" class="nav-submenu-link<?php echo $isStaticList ? ' active' : ''; ?>">
                                    <span class="submenu-dot"></span>
                                    List All
                                </a>
                                <a href="<?php echo url('static_qrcode.php'); ?>" class="nav-submenu-link<?php echo $isStaticAdd ? ' active' : ''; ?>">
                                    <span class="submenu-dot"></span>
                                    Add New
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (in_array('settings', $allowed)): ?>
                    <a href="<?php echo dashboard_url('settings'); ?>" class="nav-link">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.5167 3.29205C11.2131 2.21613 12.7873 2.21613 13.4837 3.29205L14.1164 4.26968C14.515 4.88553 15.2527 5.19107 15.97 5.03744L17.1087 4.79357C18.3619 4.52518 19.475 5.63833 19.2066 6.89152L18.9628 8.03023C18.8091 8.74754 19.1147 9.48517 19.7305 9.88376L20.7082 10.5165C21.7841 11.2129 21.7841 12.7871 20.7082 13.4835L19.7305 14.1162C19.1147 14.5148 18.8091 15.2524 18.9628 15.9697L19.2066 17.1084C19.475 18.3616 18.3619 19.4748 17.1087 19.2064L15.97 18.9625C15.2527 18.8089 14.515 19.1144 14.1164 19.7303L13.4837 20.7079C12.7873 21.7838 11.2131 21.7838 10.5168 20.7079L9.884 19.7303C9.48542 19.1144 8.74778 18.8089 8.03047 18.9625L6.89176 19.2064C5.63857 19.4748 4.52542 18.3616 4.79381 17.1084L5.03769 15.9697C5.19131 15.2524 4.88577 14.5148 4.26993 14.1162L3.29229 13.4835C2.21637 12.7871 2.21637 11.2129 3.29229 10.5165L4.26993 9.88376C4.88577 9.48517 5.19131 8.74754 5.03769 8.03023L4.79381 6.89152C4.52542 5.63833 5.63857 4.52518 6.89176 4.79357L8.03047 5.03744C8.74778 5.19107 9.48542 4.88553 9.884 4.26968L10.5167 3.29205Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M15.0002 12C15.0002 13.6568 13.6571 15 12.0002 15C10.3434 15 9.00022 13.6568 9.00022 12C9.00022 10.3431 10.3434 8.99998 12.0002 8.99998C13.6571 8.99998 15.0002 10.3431 15.0002 12Z" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        Settings
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>

    <!-- Logout -->
    <div class="sidebar-bottom">
        <div class="nav-links">
            <a href="<?php echo logout_url(); ?>" class="nav-link nav-link-logout">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2.75C14.4142 2.75 14.75 2.41421 14.75 2C14.75 1.58579 14.4142 1.25 14 1.25V2V2.75ZM2 2V1.25C1.58579 1.25 1.25 1.58579 1.25 2H2ZM2 22H1.25C1.25 22.4142 1.58579 22.75 2 22.75V22ZM14 22.75C14.4142 22.75 14.75 22.4142 14.75 22C14.75 21.5858 14.4142 21.25 14 21.25V22V22.75ZM6 11.25C5.58579 11.25 5.25 11.5858 5.25 12C5.25 12.4142 5.58579 12.75 6 12.75V12V11.25ZM22.5303 12.5303C22.8232 12.2374 22.8232 11.7626 22.5303 11.4697L17.7574 6.6967C17.4645 6.40381 16.9896 6.40381 16.6967 6.6967C16.4038 6.98959 16.4038 7.46447 16.6967 7.75736L20.9393 12L16.6967 16.2426C16.4038 16.5355 16.4038 17.0104 16.6967 17.3033C16.9896 17.5962 17.4645 17.5962 17.7574 17.3033L22.5303 12.5303ZM14 2V1.25H2V2V2.75H14V2ZM2 2H1.25V22H2H2.75V2H2ZM2 22V22.75H14V22V21.25H2V22ZM6 12V12.75H22V12V11.25H6V12Z" fill="#DC2626"/>
                </svg>
                Logout
            </a>
        </div>
    </div>
</aside>

<script>
function toggleSubmenu(element) {
    var parent = element.parentElement;
    parent.classList.toggle('expanded');
}
</script>
