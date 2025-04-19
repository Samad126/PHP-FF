<?php

namespace App\core;

use Dotenv\Dotenv;

class Environment
{
    public static function load()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        // Required variables
        $dotenv->required([
            'DB_HOST',
            'DB_NAME',
            'DB_USER',
            'CLOUDINARY_CLOUD_NAME',
            'CLOUDINARY_API_KEY',
            'CLOUDINARY_API_SECRET'
        ]);
    }

    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}