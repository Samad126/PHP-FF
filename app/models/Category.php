<?php

namespace App\models;

use App\core\Model;

class Category extends Model
{
    public static function getProductsByName($name)
    {
        $stmt = self::db()->prepare("SELECT * FROM products WHERE category_id = (SELECT id FROM categories WHERE name = ?)");
        $stmt->execute([$name]);
        return $stmt->fetchAll();
    }
}