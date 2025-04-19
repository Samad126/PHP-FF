<?php

use App\core\Environment;

return [
    'db' => [
        'host' => Environment::get('DB_HOST', 'localhost'),
        'dbname' => Environment::get('DB_NAME', 'ecommerce'),
        'user' => Environment::get('DB_USER', 'root'),
        'pass' => Environment::get('DB_PASS', '')
    ]
];
