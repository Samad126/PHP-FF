-- Create the database
CREATE DATABASE IF NOT EXISTS `ecommerce` CHARACTER
SET
    = utf8mb4 COLLATE = utf8mb4_unicode_ci;

USE `ecommerce`;

-- Users table
CREATE TABLE
    `users` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password_hash` CHAR(60) NOT NULL,
        `fullname` VARCHAR(100) NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE = InnoDB;

-- Categories table
CREATE TABLE
    `categories` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL UNIQUE,
        `parent_id` INT UNSIGNED NULL,
        FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
    ) ENGINE = InnoDB;

-- Brands table (each brand belongs to a category)
CREATE TABLE
    `brands` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `category_id` INT UNSIGNED NOT NULL,
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
        UNIQUE KEY `uniq_brand_in_category` (`category_id`, `name`)
    ) ENGINE = InnoDB;

-- Products table (with image URLs)
CREATE TABLE
    `products` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `price` DECIMAL(10, 2) NOT NULL,
        `brand_id` INT UNSIGNED NOT NULL,
        `category_id` INT UNSIGNED NOT NULL,
        `image_url` VARCHAR(512),
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE RESTRICT,
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
    ) ENGINE = InnoDB;

-- Wishlist table
CREATE TABLE
    `wishlists` (
        `user_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `added_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`user_id`, `product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Cart table
CREATE TABLE
    `carts` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

CREATE TABLE
    `cart_items` (
        `cart_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        PRIMARY KEY (`cart_id`, `product_id`),
        FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Addresses table
CREATE TABLE
    `addresses` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `line1` VARCHAR(255) NOT NULL,
        `line2` VARCHAR(255),
        `city` VARCHAR(100) NOT NULL,
        `state` VARCHAR(100),
        `postal_code` VARCHAR(20) NOT NULL,
        `country` VARCHAR(100) NOT NULL,
        `is_default` TINYINT (1) NOT NULL DEFAULT 0,
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Orders and Order Items
CREATE TABLE
    `orders` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `address_id` INT UNSIGNED NOT NULL,
        `status` ENUM (
            'pending',
            'paid',
            'shipped',
            'completed',
            'cancelled'
        ) NOT NULL DEFAULT 'pending',
        `total_amount` DECIMAL(10, 2) NOT NULL,
        `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE RESTRICT
    ) ENGINE = InnoDB;

CREATE TABLE
    `order_items` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `order_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL,
        `unit_price` DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT
    ) ENGINE = InnoDB;

ALTER TABLE products
ADD COLUMN stock INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN in_stock BOOLEAN AS (stock > 0) STORED;

CREATE TABLE
    reviews (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        product_id INT UNSIGNED NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        rating TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
        title VARCHAR(255),
        comment TEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
        UNIQUE KEY one_review_per_product_user (product_id, user_id)
    ) ENGINE = InnoDB;

ALTER TABLE products
ADD COLUMN rating_avg DECIMAL(3, 2) NOT NULL DEFAULT 0,
ADD COLUMN rating_count INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN rating_1_count INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN rating_2_count INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN rating_3_count INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN rating_4_count INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN rating_5_count INT UNSIGNED NOT NULL DEFAULT 0;