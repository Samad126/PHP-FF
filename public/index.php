<?php

// Send non-PHP/static files directly (required for PHP built-in server)
if (php_sapi_name() === 'cli-server') {
    $path = __DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if (is_file($path)) {
        return false;
    }
}

require_once __DIR__ . '/../vendor/autoload.php';

// Load routes
require_once __DIR__ . '/../routes/web.php';

// Resolve the current route
echo App\core\Router::resolve();
