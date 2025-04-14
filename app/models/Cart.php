<?php

namespace App\models;

use App\core\Auth;
use App\core\Model;

class Cart extends Model
{
    public static function add($productId)
    {
        $stmt = self::db()->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([1, $productId]);
    }

    public static function getItems()
    {
        $stmt = self::db()->prepare("SELECT * FROM cart JOIN products ON cart.product_id = products.id WHERE user_id = ?");
        $stmt->execute([1]);
        return $stmt->fetchAll();
    }

    public static function remove($productId)
    {
        $stmt = self::db()->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([1, $productId]);
    }

    public static function getSubtotal()
    {
        $items = self::getItems();
        return array_reduce($items, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public static function calculateShipping()
    {
        return 0;
    }

    public static function getTotal()
    {
        return self::getSubtotal() + self::calculateShipping();
    }

    public static function clear()
    {
        $stmt = self::db()->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([Auth::user()['id']]);
    }
}
