<?php

namespace App\models;

use App\core\Model;

class Wishlist extends Model
{
    public static function add($productId)
    {
        $stmt = self::db()->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([1, $productId]);
    }

    public static function getItems()
    {
        $stmt = self::db()->prepare("SELECT * FROM wishlist JOIN products ON wishlist.product_id = products.id WHERE user_id = ?");
        $stmt->execute([1]);
        return $stmt->fetchAll();
    }

    public static function remove($productId)
    {
        $stmt = self::db()->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([1, $productId]);
    }
}
