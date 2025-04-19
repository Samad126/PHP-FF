<?php

namespace App\models;

use App\core\Auth;
use App\core\Model;

class Cart extends Model
{
    public static function add($productId, $quantity = 1)
    {
        if (!Auth::check()) {
            throw new \Exception('Please login to add items to cart');
        }

        $db = self::db();

        try {
            $db->beginTransaction();

            $quantity = max(1, intval($quantity));

            // Check product stock
            $stmt = $db->prepare("SELECT stock FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();

            if (!$product) {
                throw new \Exception('Product not found');
            }

            if ($product['stock'] <= 0) {
                throw new \Exception('This item is out of stock');
            }

            if ($quantity > $product['stock']) {
                throw new \Exception('Requested quantity exceeds available stock');
            }

            $userId = Auth::user()['id'];

            // Get or create cart
            $stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ?");
            $stmt->execute([$userId]);
            $cartId = $stmt->fetchColumn();

            if (!$cartId) {
                $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
                $stmt->execute([$userId]);
                $cartId = $db->lastInsertId();
            }

            // Check if product already exists in cart
            $stmt = $db->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->execute([$cartId, $productId]);
            $item = $stmt->fetch();

            if ($item) {
                throw new \Exception('This item is already in your cart');
            }

            // Insert new cart item
            $stmt = $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$cartId, $productId, $quantity]);

            $db->commit();
        } catch (\Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }

    public static function getItems()
    {
        if (!Auth::check()) {
            return [];
        }

        $userId = Auth::user()['id'];

        $stmt = self::db()->prepare(
            "SELECT p.id, p.name, p.price, ci.quantity 
             FROM carts c 
             JOIN cart_items ci ON c.id = ci.cart_id 
             JOIN products p ON ci.product_id = p.id 
             WHERE c.user_id = ?"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function remove($productId)
    {
        if (!Auth::check()) {
            throw new \Exception('Please login to remove items from cart');
        }

        $userId = Auth::user()['id'];

        $stmt = self::db()->prepare(
            "DELETE ci 
             FROM cart_items ci 
             JOIN carts c ON ci.cart_id = c.id 
             WHERE c.user_id = ? AND ci.product_id = ?"
        );
        $stmt->execute([$userId, $productId]);
    }
}
