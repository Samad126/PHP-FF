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

    public static function getTopSelling($limit = 5)
    {
        $limit = (int)$limit; // Sanitize the limit
        $stmt = self::db()->prepare(
            "SELECT p.*, b.name as brand_name, c.name as category_name 
             FROM products p 
             LEFT JOIN brands b ON p.brand_id = b.id 
             LEFT JOIN categories c ON p.category_id = c.id 
             ORDER BY p.sales_count DESC 
             LIMIT $limit"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getFiltered($filters)
    {
        $where = [];
        $params = [];
        
        if (!empty($filters['q'])) {
            $where[] = "(p.name LIKE :search OR p.description LIKE :search)";
            $params[':search'] = '%' . $filters['q'] . '%';
        }
        
        if (!empty($filters['category'])) {
            $where[] = "p.category_id = :category";
            $params[':category'] = $filters['category'];
        }
        
        if (!empty($filters['brand'])) {
            $where[] = "p.brand_id = :brand";
            $params[':brand'] = $filters['brand'];
        }
        
        if (!empty($filters['price_min'])) {
            $where[] = "p.price >= :price_min";
            $params[':price_min'] = $filters['price_min'];
        }
        
        if (!empty($filters['price_max'])) {
            $where[] = "p.price <= :price_max";
            $params[':price_max'] = $filters['price_max'];
        }
        
        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
        
        // Define the ORDER BY clause based on sort parameter
        $orderBy = match($filters['sort'] ?? 'newest') {
            'price_asc' => 'p.price ASC',
            'price_desc' => 'p.price DESC',
            'name_asc' => 'p.name ASC',
            'name_desc' => 'p.name DESC',
            'newest' => 'p.id DESC',
            default => 'p.id DESC'
        };
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(DISTINCT p.id) FROM products p 
                     LEFT JOIN brands b ON p.brand_id = b.id 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     $whereClause";
        
        $countStmt = self::db()->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetchColumn();
        
        // Pagination
        $page = max(1, (int)($filters['page'] ?? 1));
        $perPage = (int)($filters['per_page'] ?? 20);
        $offset = ($page - 1) * $perPage;
        
        // Main query
        $sql = "SELECT p.*, b.name as brand_name, c.name as category_name 
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                $whereClause 
                ORDER BY $orderBy 
                LIMIT :offset, :per_page";
        
        $stmt = self::db()->prepare($sql);
        
        // Bind all parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $perPage, \PDO::PARAM_INT);
        
        $stmt->execute();
        
        return [
            'items' => $stmt->fetchAll(),
            'total' => $total,
            'showing_start' => $total > 0 ? $offset + 1 : 0,
            'showing_end' => min($offset + $perPage, $total)
        ];
    }
}
