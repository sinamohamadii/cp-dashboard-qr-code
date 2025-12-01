<?php
/**
 * Function to generate random string.
 * The function takes an integer n as input and generates a string by concatenating n characters chosen randomly from a domain.

N.B. In our case the integer n is randomly chosen between a range of 5 and 8. I chose this "short" range to not overdo the length of the identifier
 */
function randomString($n) {

	$generated_string = "";

	$domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

	$len = strlen($domain);

	// Loop to create random string
	for ($i = 0; $i < $n; $i++) {
		// Generate a random index to pick characters
		$index = rand(0, $len - 1);

		// Concatenating the character
		// in resultant string
		$generated_string = $generated_string . $domain[$index];
	}

	return $generated_string;
}

/**
 *
 */
function getSecureRandomToken() {
	$token = bin2hex(openssl_random_pseudo_bytes(16));
	return $token;
}

/**
 *
 */
function clean_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function paginationLinks($current_page, $total_pages, $base_url) {

	if ($total_pages <= 1) {
		return false;
	}

	$html = '';

	if (!empty($_GET)) {
		// We must unset $_GET[page] if previously built by http_build_query function
		unset($_GET['page']);
		// To keep the query sting parameters intact while navigating to next/prev page,
		$http_query = "?" . http_build_query($_GET);
	} else {
		$http_query = "?";
	}

	$html = '<nav class="pagination-nav">';

	// Previous link
	if ($current_page == 1) {
		$html .= '<span class="page-link disabled">&lt; Previous</span>';
	} else {
		$prev_page = $current_page - 1;
		$html .= '<a class="page-link" href="' . $base_url . $http_query . '&page=' . $prev_page . '">&lt; Previous</a>';
	}

	// Page number links
	if ($current_page > 5) {
		$i = $current_page - 4;
	} else {
		$i = 1;
	}

	for (; $i <= ($current_page + 4) && ($i <= $total_pages); $i++) {
		$active_class = ($current_page == $i) ? ' active' : '';
		$link = $base_url . $http_query;
		$html .= '<a class="page-link' . $active_class . '" href="' . $link . '&page=' . $i . '">' . $i . '</a>';

		if ($i == $current_page + 4 && $i < $total_pages) {
			$html .= '<span class="page-link disabled">...</span>';
		}
	}

	// Next link
	if ($current_page == $total_pages) {
		$html .= '<span class="page-link disabled">Next &gt;</span>';
	} else {
		$next_page = $current_page + 1;
		$html .= '<a class="page-link" href="' . $base_url . $http_query . '&page=' . $next_page . '">Next &gt;</a>';
	}

	$html = $html . '</nav>';

	return $html;
}

function app_base_path() {
	return APP_BASE_PATH;
}

function base_href() {
	return (APP_BASE_PATH === '/') ? '/' : APP_BASE_PATH . '/';
}

function url($path = '') {
	$normalizedBase = (APP_BASE_PATH === '/') ? '' : APP_BASE_PATH;
	$trimmedPath = ltrim($path, '/');

	if ($trimmedPath === '') {
		return ($normalizedBase === '') ? '/' : $normalizedBase;
	}

	$prefix = ($normalizedBase === '') ? '' : $normalizedBase . '/';

	return $prefix . $trimmedPath;
}

function asset_url($path) {
	return url($path);
}

function absolute_url($path = '') {
	$relative = url($path);
	$base = rtrim(base_url(), '/');

	if ($relative === '/') {
		return $base . '/';
	}

	// Add leading slash if relative doesn't have one
	if ($relative !== '' && $relative[0] !== '/') {
		$relative = '/' . $relative;
	}

	return $base . $relative;
}

function base_url() {
    require_once(__DIR__ . '/../config/environment.php');
    if (defined('BASE_URL') && BASE_URL !== null) {
        return BASE_URL;
    } else {
        return sprintf(
            "%s://%s:%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['SERVER_PORT']
        );
    }
}

/**
 * Get URL for the main dashboard (external Payload CMS dashboard)
 * @param string $path Optional path to append (e.g., 'analytics', 'marketing')
 * @return string Full URL to the dashboard page
 */
function dashboard_url($path = '') {
    $base = DASHBOARD_BASE_URL;
    if ($path === '') {
        return $base . '/dashboard';
    }
    return $base . '/dashboard/' . ltrim($path, '/');
}

/**
 * Get logout URL for the main dashboard
 * @return string Full URL to the logout endpoint
 */
function logout_url() {
    return DASHBOARD_BASE_URL . '/logout';
}

/**
 * Check if user has a specific permission
 * @param string $permission The permission key to check
 * @return bool
 */
function hasPermission($permission) {
    global $payloadUser;
    return isset($payloadUser['permissions'][$permission]) 
        && $payloadUser['permissions'][$permission] === true;
}

/**
 * Get all allowed permissions as array of keys
 * @return array
 */
function getAllowedPermissions() {
    global $payloadUser;
    $allowed = [];
    if (isset($payloadUser['permissions']) && is_array($payloadUser['permissions'])) {
        foreach ($payloadUser['permissions'] as $key => $value) {
            if ($value === true) {
                $allowed[] = $key;
            }
        }
    }
    return $allowed;
}

/**
 * Get user display name
 * @return string
 */
function getUserDisplayName() {
    global $payloadUser;
    if (!$payloadUser) return '';
    
    $firstName = $payloadUser['firstName'] ?? '';
    $lastName = $payloadUser['lastName'] ?? '';
    $name = trim($firstName . ' ' . $lastName);
    
    if (empty($name)) {
        return $payloadUser['email'] ?? 'User';
    }
    return $name;
}

/**
 * Get user role display string
 * @return string
 */
function getUserRole() {
    global $payloadUser;
    if (!$payloadUser || !isset($payloadUser['roles'])) return '';
    
    $roles = $payloadUser['roles'];
    if (is_array($roles) && count($roles) > 0) {
        return ucfirst($roles[0]);
    }
    return '';
}