<?php

namespace App\models;

use App\core\Model;

class Review extends Model
{
    public static function forProduct($productId)
    {
        $sql = "SELECT r.*, u.fullname as user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = ? 
                ORDER BY r.created_at DESC";
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public static function getProductStats($productId)
    {
        $sql = "SELECT 
                    COUNT(*) as total_reviews,
                    COALESCE(AVG(rating), 0) as avg_rating,
                    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as 5_star,
                    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as 4_star,
                    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as 3_star,
                    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as 2_star,
                    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as 1_star
                FROM reviews 
                WHERE product_id = ?";
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$productId]);
        $result = $stmt->fetch();
        
        // Ensure all star counts are at least 0
        for ($i = 1; $i <= 5; $i++) {
            $key = $i . '_star';
            $result[$key] = (int)($result[$key] ?? 0);
        }
        
        return $result;
    }

    public static function create($data)
    {
        $db = self::db();
        
        try {
            $db->beginTransaction();
            
            // If user is not logged in, create temporary user
            if (!$data['user_id']) {
                // First check if user with this email exists
                $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$data['user_email']]);
                $user = $stmt->fetch();
                
                if ($user) {
                    $data['user_id'] = $user['id'];
                } else {
                    // Create new user
                    $stmt = $db->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
                    $stmt->execute([$data['user_name'], $data['user_email'], password_hash(uniqid(), PASSWORD_DEFAULT)]);
                    $data['user_id'] = $db->lastInsertId();
                }
            }
            
            $stmt = $db->prepare("
                INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $data['product_id'],
                $data['user_id'],
                $data['rating'],
                $data['title'],
                $data['comment']
            ]);
            
            $reviewId = $db->lastInsertId();
            
            $db->commit();
            return $reviewId;
            
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function findUserReview($productId, $userId)
    {
        $sql = "SELECT r.*, u.fullname as user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = ? AND r.user_id = ?";
        $stmt = self::db()->prepare($sql);
        $stmt->execute([$productId, $userId]);
        return $stmt->fetch();
    }

    public static function update($reviewId, $userId, $data)
    {
        $sql = "UPDATE reviews 
                SET rating = ?, title = ?, comment = ? 
                WHERE id = ? AND user_id = ?";
        $stmt = self::db()->prepare($sql);
        return $stmt->execute([
            $data['rating'],
            $data['title'],
            $data['comment'],
            $reviewId,
            $userId
        ]);
    }
}
