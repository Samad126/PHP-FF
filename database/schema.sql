-- 1) Create the database
CREATE DATABASE IF NOT EXISTS `ecommerce` CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `ecommerce`;

-- 2) Users
CREATE TABLE
    `users` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE = InnoDB;

-- 3) Categories
CREATE TABLE
    `categories` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL UNIQUE,
        `description` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = InnoDB;

-- 4) Brands (belong to categories)
CREATE TABLE
    `brands` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `category_id` INT UNSIGNED NOT NULL,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `ux_brands_category_name` (`category_id`, `name`),
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB;

-- 5) Products
CREATE TABLE
    `products` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `category_id` INT UNSIGNED NOT NULL,
        `brand_id` INT UNSIGNED NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `price` DECIMAL(10, 2) NOT NULL,
        `stock` INT UNSIGNED NOT NULL DEFAULT 0,
        `status` ENUM ('active', 'inactive') NOT NULL DEFAULT 'active',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (`category_id`),
        INDEX (`brand_id`),
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
        FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE = InnoDB;

-- 6) Addresses
CREATE TABLE
    `addresses` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` BIGINT UNSIGNED NOT NULL,
        `address_line1` VARCHAR(255) NOT NULL,
        `address_line2` VARCHAR(255),
        `city` VARCHAR(100) NOT NULL,
        `state` VARCHAR(100),
        `postal_code` VARCHAR(20),
        `country` VARCHAR(100) NOT NULL,
        `phone` VARCHAR(20),
        `is_default` TINYINT (1) NOT NULL DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (`user_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB;

-- 7) Wishlist (one row per user–product)
CREATE TABLE
    `wishlist` (
        `user_id` BIGINT UNSIGNED NOT NULL,
        `product_id` BIGINT UNSIGNED NOT NULL,
        `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`user_id`, `product_id`),
        INDEX (`product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB;

-- 8) Cart (one row per user–product, with quantity)
CREATE TABLE
    `cart` (
        `user_id` BIGINT UNSIGNED NOT NULL,
        `product_id` BIGINT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`user_id`, `product_id`),
        INDEX (`product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB;

-- 9) Orders
CREATE TABLE
    `orders` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` BIGINT UNSIGNED NOT NULL,
        `address_id` BIGINT UNSIGNED NOT NULL,
        `total_amount` DECIMAL(10, 2) NOT NULL,
        `status` ENUM ('pending', 'processing', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (`user_id`),
        INDEX (`address_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB;

-- 10) Order Items
CREATE TABLE
    `order_items` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `order_id` BIGINT UNSIGNED NOT NULL,
        `product_id` BIGINT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `price` DECIMAL(10, 2) NOT NULL, -- snapshot of price at purchase time
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (`order_id`),
        INDEX (`product_id`),
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE = InnoDB;