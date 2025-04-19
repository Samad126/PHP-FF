<?php

namespace App\models;

use App\core\Model;

class Brand extends Model
{
    public static function all()
    {
        $stmt = self::db()->prepare("SELECT * FROM brands");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllWithCount()
    {
        $sql = "SELECT b.*, COUNT(p.id) as product_count 
                FROM brands b 
                LEFT JOIN products p ON b.id = p.brand_id 
                GROUP BY b.id";
        
        $stmt = self::db()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM brands WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getByCategory($categoryId)
    {
        $stmt = self::db()->prepare("SELECT * FROM brands WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
}