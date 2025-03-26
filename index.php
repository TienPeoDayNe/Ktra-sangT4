<?php
// Start Session
session_start();

// Định nghĩa hằng số cho đường dẫn
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');

// Load Config
require_once 'app/config/config.php';

// Load Helpers
require_once 'app/helpers/session_helper.php';
require_once 'app/helpers/url_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    $paths = [
        'app/libraries/',
        'app/controllers/',
        'app/models/'
    ];
    
    foreach($paths as $path) {
        $file = $path . $className . '.php';
        if(file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Instantiate Core Library
$init = new Core();
