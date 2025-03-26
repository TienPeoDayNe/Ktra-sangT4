<?php
// URL Helper functions

// Get base URL
function base_url($path = '') {
    return '/webbanhang/' . $path;
}

// Get current URL
function current_url() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
           "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

// Check if current page matches given URL
function is_current_page($url) {
    return strpos(current_url(), $url) !== false;
} 