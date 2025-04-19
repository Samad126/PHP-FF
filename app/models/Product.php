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

    public static function getNewProducts($limit = 8)
    {
        $sql = "SELECT p.*, b.name as brand_name, c.name as category_name,
                pi.image_url as image_url, 
                p.stock > 0 as in_stock
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 0
                ORDER BY p.created_at DESC 
                LIMIT :limit";

        $stmt = self::db()->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function getTopSelling($limit = 5)
    {
        $limit = (int)$limit; // Sanitize the limit
        $stmt = self::db()->prepare(
            "SELECT p.*, b.name as brand_name, c.name as category_name,
             pi.image_url as image_url,
             p.stock > 0 as in_stock
             FROM products p 
             LEFT JOIN brands b ON p.brand_id = b.id 
             LEFT JOIN categories c ON p.category_id = c.id 
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 0
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
            $searchTerm = trim($filters['q']);
            $where[] = "(
                p.name LIKE :search 
                OR p.description LIKE :search
                OR b.name LIKE :search
                OR CONCAT(b.name, ' ', p.name) LIKE :search
                OR CONCAT(p.name, ' ', b.name) LIKE :search
            )";
            $params[':search'] = '%' . $searchTerm . '%';
        }

        if (!empty($filters['category'])) {
            $categories = explode(',', $filters['category']);
            $categoryPlaceholders = array_map(function ($i) {
                return ':category' . $i;
            }, array_keys($categories));
            $where[] = "p.category_id IN (" . implode(',', $categoryPlaceholders) . ")";
            foreach ($categories as $i => $cat) {
                $params[':category' . $i] = $cat;
            }
        }

        if (!empty($filters['brand'])) {
            $brands = explode(',', $filters['brand']);
            $brandPlaceholders = array_map(function ($i) {
                return ':brand' . $i;
            }, array_keys($brands));
            $where[] = "p.brand_id IN (" . implode(',', $brandPlaceholders) . ")";
            foreach ($brands as $i => $brand) {
                $params[':brand' . $i] = $brand;
            }
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
        $orderBy = match ($filters['sort'] ?? 'newest') {
            'price_asc' => 'p.price ASC',
            'price_desc' => 'p.price DESC',
            'name_asc' => 'p.name ASC',
            'name_desc' => 'p.name DESC',
            'newest' => 'p.id DESC',
            default => 'p.id DESC'
        };

        // Get total count for pagination
        $countSql = "SELECT COUNT(DISTINCT p.id) 
                     FROM products p 
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

        // Main query with DISTINCT to avoid duplicates and include review data
        $sql = "SELECT DISTINCT 
            p.*, 
            b.name as brand_name, 
            c.name as category_name, 
            pi.image_url as image_url,
            COALESCE(AVG(r.rating), 0) as rating,
            COUNT(DISTINCT r.id) as review_count
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 0
        LEFT JOIN reviews r ON p.id = r.product_id
        $whereClause 
        GROUP BY p.id, b.name, c.name, pi.image_url
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
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    public static function getPriceRange()
    {
        $stmt = self::db()->prepare("
            SELECT 
                MAX(price) as max_price
            FROM products
            WHERE price > 0
        ");
        $stmt->execute();
        $range = $stmt->fetch(\PDO::FETCH_ASSOC);

        $maxPrice = (int)$range['max_price'];

        // Round up max price to make it more user-friendly
        if ($maxPrice > 10000) {
            // Round to nearest thousand for very high prices
            $maxPrice = ceil($maxPrice / 1000) * 1000;
        } else {
            // Round to nearest hundred for moderate prices
            $maxPrice = ceil($maxPrice / 100) * 100;
        }

        return [
            'min' => 0, // Always start from 0
            'max' => $maxPrice
        ];
    }

    public static function findWithDetails($id)
    {
        $sql = "SELECT p.*, 
                b.name as brand_name, 
                c.name as category_name,
                GROUP_CONCAT(pi.image_url ORDER BY pi.sort_order) as images
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN product_images pi ON p.id = pi.product_id
                WHERE p.id = ?
                GROUP BY p.id";

        $stmt = self::db()->prepare($sql);
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if ($product) {
            // Convert images string to array
            $product['images'] = $product['images'] ? explode(',', $product['images']) : [];
        }

        return $product;
    }
}
