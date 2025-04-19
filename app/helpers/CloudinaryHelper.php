<?php

namespace App\helpers;

use App\config\CloudinaryConfig;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryHelper
{
    private static $uploadApi = null;
    
    private static function getUploadApi()
    {
        if (self::$uploadApi === null) {
            self::$uploadApi = new UploadApi(CloudinaryConfig::getInstance()->configuration);
        }
        return self::$uploadApi;
    }

    public static function upload($file, $options = [])
    {
        try {
            $defaultOptions = [
                'folder' => 'products', // Default folder for products
                'resource_type' => 'auto'
            ];
            
            $options = array_merge($defaultOptions, $options);
            
            return self::getUploadApi()->upload($file, $options);
        } catch (\Exception $e) {
            // Log error and return null or handle as needed
            error_log("Cloudinary upload error: " . $e->getMessage());
            return null;
        }
    }

    public static function destroy($publicId, $options = [])
    {
        try {
            $defaultOptions = [
                'resource_type' => 'image'
            ];
            
            $options = array_merge($defaultOptions, $options);
            
            return self::getUploadApi()->destroy($publicId, $options);
        } catch (\Exception $e) {
            error_log("Cloudinary delete error: " . $e->getMessage());
            return null;
        }
    }
}