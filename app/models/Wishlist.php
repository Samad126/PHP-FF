<?php

namespace App\models;

use App\core\Model;
use App\core\Auth;

class Wishlist extends Model
{
    public static function add($productId)
    {
        if (!Auth::check()) {
            throw new \Exception('Please login to add items to wishlist');
        }

        $userId = Auth::user()['id'];
        $stmt = self::db()->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$userId, $productId]);
    }

    public static function getItems()
    {
        if (!Auth::check()) {
            return [];
        }

        $userId = Auth::user()['id'];
        $stmt = self::db()->prepare("SELECT * FROM wishlists JOIN products ON wishlists.product_id = products.id WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function remove($productId)
    {
        if (!Auth::check()) {
            throw new \Exception('Please login to remove items from wishlist');
        }

        $userId = Auth::user()['id'];
        $stmt = self::db()->prepare("DELETE FROM wishlists WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
    }
}
