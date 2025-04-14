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
}