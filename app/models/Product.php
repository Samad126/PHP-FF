<?php

namespace App\models;

use App\core\Model;

class Product extends Model
{
    public static function all()
    {
        $stmt = self::db()->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getFeatured()
    {
        $stmt = self::db()->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getRelated($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM products WHERE id != ? ORDER BY RAND() LIMIT 4");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public static function getNewProducts($limit = 5)
    {
        $limit = (int)$limit; // Sanitize the limit by casting to integer
        $stmt = self::db()->prepare(
            "SELECT p.*, b.name as brand_name, c.name as category_name 
             FROM products p 
             LEFT JOIN brands b ON p.brand_id = b.id 
             LEFT JOIN categories c ON p.category_id = c.id 
             ORDER BY p.id DESC 
             LIMIT $limit"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
