<?php

namespace App\models;

use App\core\Model;

class Order extends Model
{
    public static function create($data)
    {
        $stmt = self::db()->prepare("
            INSERT INTO orders (
                user_id, 
                shipping_address, 
                payment_id, 
                subtotal, 
                shipping, 
                total
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['user_id'],
            json_encode($data['shipping_address']),
            $data['payment_id'],
            $data['subtotal'],
            $data['shipping'],
            $data['total']
        ]);

        $orderId = self::db()->lastInsertId();

        // Store order items
        foreach ($data['items'] as $item) {
            $stmt = self::db()->prepare("
                INSERT INTO order_items (
                    order_id, 
                    product_id, 
                    quantity, 
                    price
                ) VALUES (?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $orderId,
                $item['product_id'],
                $item['quantity'],
                $item['price']
            ]);
        }

        return self::find($orderId);
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("
            SELECT orders.*, 
                   users.email as user_email,
                   users.name as user_name
            FROM orders 
            JOIN users ON orders.user_id = users.id 
            WHERE orders.id = ?
        ");
        
        $stmt->execute([$id]);
        $order = $stmt->fetch();

        if ($order) {
            // Get order items
            $stmt = self::db()->prepare("
                SELECT order_items.*, products.name as product_name 
                FROM order_items 
                JOIN products ON order_items.product_id = products.id 
                WHERE order_id = ?
            ");
            
            $stmt->execute([$id]);
            $order['items'] = $stmt->fetchAll();
        }

        return $order;
    }
}