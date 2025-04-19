<?php

namespace App\config;

use App\core\Environment;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class CloudinaryConfig
{
    private static $instance = null;
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            $config = new Configuration([
                'cloud' => [
                    'cloud_name' => Environment::get('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => Environment::get('CLOUDINARY_API_KEY'),
                    'api_secret' => Environment::get('CLOUDINARY_API_SECRET')
                ],
                'url' => [
                    'secure' => true
                ]
            ]);

            self::$instance = new Cloudinary($config);
        }
        
        return self::$instance;
    }
}
