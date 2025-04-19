USE ecommerce;

-- Users
INSERT INTO
    users (
        email,
        password_hash,
        fullname,
        created_at
    )
VALUES
    (
        'john.doe@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'John Doe',
        NOW()
    ),
    (
        'jane.smith@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Jane Smith',
        NOW()
    ),
    (
        'mike.wilson@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Mike Wilson',
        NOW()
    );

-- Categories (with parent-child relationships)
INSERT INTO
    categories (name, parent_id)
VALUES
    ('Electronics', NULL),
    ('Smartphones', 1),
    ('Laptops', 1),
    ('Gaming', 1),
    ('Audio', 1),
    ('Cameras', 1),
    ('TV & Home Theater', 1),
    ('Accessories', 1),
    ('Mobile Accessories', 2),
    ('Laptop Accessories', 3),
    ('Gaming Accessories', 4);

-- Brands
INSERT INTO
    brands (name, category_id)
VALUES
    -- Smartphone brands
    ('Apple', 2),
    ('Samsung', 2),
    ('Google', 2),
    ('OnePlus', 2),
    -- Laptop brands
    ('Dell', 3),
    ('HP', 3),
    ('Lenovo', 3),
    ('ASUS', 3),
    -- Gaming brands
    ('Sony', 4),
    ('Microsoft', 4),
    ('Nintendo', 4),
    -- Audio brands
    ('Bose', 5),
    ('Sony', 5),
    ('JBL', 5),
    ('Sennheiser', 5),
    -- Camera brands
    ('Canon', 6),
    ('Nikon', 6),
    ('Sony', 6),
    ('Fujifilm', 6);

-- Products (without image_url column)
INSERT INTO
    products (
        name,
        description,
        price,
        brand_id,
        category_id
    )
VALUES
    -- Smartphones
    (
        'iPhone 14 Pro',
        '6.1" Super Retina XDR display, A16 Bionic',
        999.99,
        1,
        2
    ),
    (
        'Galaxy S23 Ultra',
        '6.8" Dynamic AMOLED, S Pen support',
        1199.99,
        2,
        2
    ),
    (
        'Pixel 7 Pro',
        '6.7" OLED, Google Tensor G2',
        899.99,
        3,
        2
    ),
    (
        'OnePlus 11',
        '6.7" AMOLED, Snapdragon 8 Gen 2',
        699.99,
        4,
        2
    ),
    -- Laptops
    (
        'Dell XPS 15',
        '15" 4K OLED, Intel i9, RTX 3050 Ti',
        1999.99,
        5,
        3
    ),
    (
        'HP Spectre x360',
        '14" 3K2K OLED, Intel i7, 32GB RAM',
        1699.99,
        6,
        3
    ),
    (
        'ThinkPad X1 Carbon',
        '14" 2.8K OLED, Intel i7, 16GB RAM',
        1599.99,
        7,
        3
    ),
    (
        'ASUS ROG Zephyrus',
        '16" QHD, Ryzen 9, RTX 4090',
        2499.99,
        8,
        3
    ),
    -- Gaming
    (
        'PS5',
        'PlayStation 5 Console',
        499.99,
        9,
        4
    ),
    (
        'Xbox Series X',
        'Xbox Series X Console',
        499.99,
        10,
        4
    ),
    (
        'Nintendo Switch OLED',
        '7" OLED Display',
        349.99,
        11,
        4
    ),
    -- Audio
    (
        'Bose QC45',
        'QuietComfort 45 Wireless ANC',
        329.99,
        12,
        5
    ),
    (
        'Sony WH-1000XM5',
        'Wireless Noise Cancelling',
        399.99,
        13,
        5
    ),
    (
        'JBL Flip 6',
        'Portable Bluetooth Speaker',
        129.99,
        14,
        5
    ),
    (
        'Sennheiser HD 660S',
        'Open-back Headphones',
        499.99,
        15,
        5
    ),
    -- Cameras
    (
        'Canon EOS R5',
        'Full-frame Mirrorless, 45MP',
        3899.99,
        16,
        6
    ),
    (
        'Nikon Z6 II',
        'Full-frame Mirrorless, 24.5MP',
        1999.99,
        17,
        6
    ),
    (
        'Sony A7 IV',
        'Full-frame Mirrorless, 33MP',
        2499.99,
        18,
        6
    ),
    (
        'Fujifilm X-T5',
        'APS-C Mirrorless, 40MP',
        1699.99,
        19,
        6
    );

-- Product Images (multiple images per product)
INSERT INTO
    product_images (product_id, image_url, sort_order)
VALUES
    -- iPhone 14 Pro images
    (1, '/images/iphone14pro/main.jpg', 0),
    (1, '/images/iphone14pro/angle.jpg', 1),
    (1, '/images/iphone14pro/back.jpg', 2),
    -- Galaxy S23 Ultra images
    (2, '/images/s23ultra/main.jpg', 0),
    (2, '/images/s23ultra/angle.jpg', 1),
    (2, '/images/s23ultra/back.jpg', 2),
    -- Pixel 7 Pro images
    (3, '/images/pixel7pro/main.jpg', 0),
    (3, '/images/pixel7pro/angle.jpg', 1),
    (3, '/images/pixel7pro/back.jpg', 2),
    -- OnePlus 11 images
    (4, '/images/oneplus11/main.jpg', 0),
    (4, '/images/oneplus11/angle.jpg', 1),
    (4, '/images/oneplus11/back.jpg', 2),
    -- Dell XPS 15 images
    (5, '/images/xps15/main.jpg', 0),
    (5, '/images/xps15/angle.jpg', 1),
    (5, '/images/xps15/keyboard.jpg', 2),
    -- Other products' main images
    (6, '/images/spectre.jpg', 0),
    (7, '/images/x1carbon.jpg', 0),
    (8, '/images/zephyrus.jpg', 0),
    (9, '/images/ps5.jpg', 0),
    (10, '/images/xboxseriesx.jpg', 0),
    (11, '/images/switch.jpg', 0),
    (12, '/images/qc45.jpg', 0),
    (13, '/images/wh1000xm5.jpg', 0),
    (14, '/images/flip6.jpg', 0),
    (15, '/images/hd660s.jpg', 0),
    (16, '/images/eosr5.jpg', 0),
    (17, '/images/z6ii.jpg', 0),
    (18, '/images/a7iv.jpg', 0),
    (19, '/images/xt5.jpg', 0);

-- Addresses
INSERT INTO
    addresses (
        user_id,
        line1,
        line2,
        city,
        state,
        postal_code,
        country,
        is_default
    )
VALUES
    (
        1,
        '123 Tech Street',
        'Apt 4B',
        'San Francisco',
        'CA',
        '94105',
        'USA',
        1
    ),
    (
        1,
        '456 Work Avenue',
        'Suite 100',
        'San Francisco',
        'CA',
        '94107',
        'USA',
        0
    ),
    (
        2,
        '789 Innovation Drive',
        NULL,
        'Austin',
        'TX',
        '78701',
        'USA',
        1
    ),
    (
        3,
        '321 Digital Lane',
        'Unit 5',
        'Seattle',
        'WA',
        '98101',
        'USA',
        1
    );

-- Carts
INSERT INTO
    carts (user_id)
VALUES
    (1),
    (2),
    (3);

-- Cart Items
INSERT INTO
    cart_items (cart_id, product_id, quantity)
VALUES
    (1, 1, 1), -- User 1: iPhone 14 Pro
    (1, 13, 1), -- User 1: Sony WH-1000XM5
    (2, 5, 1), -- User 2: Dell XPS 15
    (2, 12, 1), -- User 2: Bose QC45
    (3, 10, 1), -- User 3: Xbox Series X
    (3, 14, 2);

-- User 3: 2x JBL Flip 6
-- Wishlists
INSERT INTO
    wishlists (user_id, product_id)
VALUES
    (1, 3), -- User 1: Pixel 7 Pro
    (1, 5), -- User 1: Dell XPS 15
    (1, 16), -- User 1: Canon EOS R5
    (2, 8), -- User 2: ASUS ROG Zephyrus
    (2, 9), -- User 2: PS5
    (3, 18), -- User 3: Sony A7 IV
    (3, 19);

-- User 3: Fujifilm X-T5
-- Orders
INSERT INTO
    orders (user_id, address_id, status, total_amount)
VALUES
    (1, 1, 'completed', 1399.98), -- iPhone 14 Pro + Sony WH-1000XM5
    (2, 3, 'processing', 2329.98), -- Dell XPS 15 + Bose QC45
    (3, 4, 'pending', 759.97);

-- Xbox Series X + JBL Flip 6
-- Order Items
INSERT INTO
    order_items (order_id, product_id, quantity, unit_price)
VALUES
    (1, 1, 1, 999.99), -- iPhone 14 Pro
    (1, 13, 1, 399.99), -- Sony WH-1000XM5
    (2, 5, 1, 1999.99), -- Dell XPS 15
    (2, 12, 1, 329.99), -- Bose QC45
    (3, 10, 1, 499.99), -- Xbox Series X
    (3, 14, 2, 129.99); -- 2x JBL Flip 6

-- Remove this line as the column already exists in the schema:
-- ALTER TABLE products ADD COLUMN sales_count INT DEFAULT 0;


