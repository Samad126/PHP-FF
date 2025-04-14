<?php

namespace App\models;

use App\core\Model;

class Review extends Model
{
    public static function forProduct($productId)
    {
        $stmt = self::db()->prepare("SELECT * FROM reviews WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }
}