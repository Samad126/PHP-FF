-- Create and select the database
CREATE DATABASE IF NOT EXISTS `ecommerce` DEFAULT CHARACTER
SET
    = utf8mb4 DEFAULT COLLATE = utf8mb4_unicode_ci;

USE `ecommerce`;

-- Users table
CREATE TABLE
    `users` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `first_name` VARCHAR(50),
        `last_name` VARCHAR(50),
        `email` VARCHAR(100) NOT NULL UNIQUE,
        `password_hash` VARCHAR(255) NOT NULL,
        `phone` VARCHAR(20),
        `is_active` TINYINT (1) NOT NULL DEFAULT 1,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB;

-- Categories (supporting hierarchical categories)
CREATE TABLE
    `categories` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(100) NOT NULL,
        `description` TEXT,
        `parent_id` INT UNSIGNED DEFAULT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
    ) ENGINE = InnoDB;

-- Brands (each brand belongs to a category)
CREATE TABLE
    `brands` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(100) NOT NULL,
        `category_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Products
CREATE TABLE
    `products` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(150) NOT NULL,
        `description` TEXT,
        `price` DECIMAL(10, 2) NOT NULL,
        `stock` INT UNSIGNED NOT NULL DEFAULT 0,
        `category_id` INT UNSIGNED NOT NULL,
        `brand_id` INT UNSIGNED DEFAULT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
        FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL
    ) ENGINE = InnoDB;

-- Wishlist (many-to-many between users and products)
CREATE TABLE
    `wishlists` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `ux_user_product` (`user_id`, `product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Cart (many-to-many with quantity)
CREATE TABLE
    `carts` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `ux_cart_user_product` (`user_id`, `product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Addresses (billing/shipping)
CREATE TABLE
    `addresses` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT UNSIGNED NOT NULL,
        `address_line1` VARCHAR(255) NOT NULL,
        `address_line2` VARCHAR(255),
        `city` VARCHAR(100) NOT NULL,
        `state` VARCHAR(100) NOT NULL,
        `postal_code` VARCHAR(20) NOT NULL,
        `country` VARCHAR(100) NOT NULL,
        `phone` VARCHAR(20),
        `is_default` TINYINT (1) NOT NULL DEFAULT 0,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE = InnoDB;

-- Orders
CREATE TABLE
    `orders` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `user_id` INT UNSIGNED NOT NULL,
        `order_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `status` VARCHAR(50) NOT NULL DEFAULT 'pending',
        `total_amount` DECIMAL(10, 2) NOT NULL,
        `shipping_address_id` INT UNSIGNED NOT NULL,
        `billing_address_id` INT UNSIGNED NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
        FOREIGN KEY (`shipping_address_id`) REFERENCES `addresses` (`id`) ON DELETE RESTRICT,
        FOREIGN KEY (`billing_address_id`) REFERENCES `addresses` (`id`) ON DELETE RESTRICT
    ) ENGINE = InnoDB;

-- Order Items
CREATE TABLE
    `order_items` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `order_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `unit_price` DECIMAL(10, 2) NOT NULL,
        `total_price` DECIMAL(10, 2) NOT NULL AS (quantity * unit_price) PERSISTENT,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT
    ) ENGINE = InnoDB;