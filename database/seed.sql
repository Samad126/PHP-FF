-- Clear existing data (if any)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE order_items;
TRUNCATE TABLE orders;
TRUNCATE TABLE cart;
TRUNCATE TABLE wishlist;
TRUNCATE TABLE products;
TRUNCATE TABLE brands;
TRUNCATE TABLE categories;
TRUNCATE TABLE addresses;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Categories for electronics store
INSERT INTO categories (name, description) VALUES
('Smartphones', 'Mobile phones and accessories'),
('Laptops', 'Notebooks and laptops for all purposes'),
('Audio', 'Headphones, speakers and sound equipment'),
('Gaming', 'Gaming consoles and accessories'),
('Cameras', 'Digital cameras and photography equipment'),
('Tablets', 'Tablets and e-readers'),
('Wearables', 'Smartwatches and fitness trackers'),
('TV & Home Theater', 'Television sets and home theater systems');

-- Brands for each category
INSERT INTO brands (category_id, name, description) VALUES
-- Smartphones (1)
(1, 'Apple', 'Premium smartphones and mobile devices'),
(1, 'Samsung', 'Leading manufacturer of smartphones and electronics'),
(1, 'Google', 'Android smartphones with advanced AI features'),

-- Laptops (2)
(2, 'Dell', 'Business and consumer laptops'),
(2, 'HP', 'Wide range of computing solutions'),
(2, 'Lenovo', 'Innovative laptop designs and technology'),

-- Audio (3)
(3, 'Sony', 'High-quality audio equipment'),
(3, 'Bose', 'Premium audio solutions'),
(3, 'JBL', 'Popular audio accessories'),

-- Gaming (4)
(4, 'Microsoft', 'Xbox gaming consoles and accessories'),
(4, 'Sony PlayStation', 'Leading gaming console manufacturer'),
(4, 'Nintendo', 'Innovative gaming systems'),

-- Cameras (5)
(5, 'Canon', 'Professional photography equipment'),
(5, 'Nikon', 'High-end cameras and lenses'),
(5, 'Sony Alpha', 'Mirrorless cameras and accessories'),

-- Tablets (6)
(6, 'Apple', 'Premium tablets and accessories'),
(6, 'Samsung', 'Android tablets and accessories'),
(6, 'Microsoft', 'Windows tablets and 2-in-1 devices');

-- Sample products
INSERT INTO products (category_id, brand_id, name, description, price, stock, status) VALUES
-- Smartphones
(1, 1, 'iPhone 14 Pro', '6.1-inch Super Retina XDR display, A16 Bionic chip', 999.99, 50, 'active'),
(1, 2, 'Samsung Galaxy S23 Ultra', '6.8-inch Dynamic AMOLED display, S Pen support', 1199.99, 40, 'active'),
(1, 3, 'Google Pixel 7 Pro', '6.7-inch OLED display, Advanced AI camera features', 899.99, 30, 'active'),

-- Laptops
(2, 4, 'Dell XPS 13', '13-inch 4K display, Intel i7, 16GB RAM, 512GB SSD', 1299.99, 25, 'active'),
(2, 5, 'HP Spectre x360', '14-inch 2-in-1 laptop, Intel i7, 16GB RAM', 1399.99, 20, 'active'),
(2, 6, 'Lenovo ThinkPad X1 Carbon', '14-inch business laptop, Intel i7, 1TB SSD', 1499.99, 15, 'active'),

-- Audio
(3, 7, 'Sony WH-1000XM4', 'Wireless noise-canceling headphones', 349.99, 60, 'active'),
(3, 8, 'Bose QuietComfort 45', 'Premium noise-canceling headphones', 329.99, 45, 'active'),
(3, 9, 'JBL Flip 6', 'Portable Bluetooth speaker, Waterproof', 129.99, 75, 'active'),

-- Gaming
(4, 10, 'Xbox Series X', 'Next-gen gaming console, 4K gaming', 499.99, 30, 'active'),
(4, 11, 'PlayStation 5', 'Next-gen gaming console with DualSense controller', 499.99, 25, 'active'),
(4, 12, 'Nintendo Switch OLED', '7-inch OLED display, Enhanced audio', 349.99, 40, 'active'),

-- Cameras
(5, 13, 'Canon EOS R5', 'Full-frame mirrorless camera, 8K video', 3899.99, 10, 'active'),
(5, 14, 'Nikon Z6 II', 'Full-frame mirrorless camera, 4K video', 1999.99, 15, 'active'),
(5, 15, 'Sony A7 IV', 'Full-frame mirrorless camera, Advanced AF', 2499.99, 12, 'active');

-- Sample users
INSERT INTO users (name, email, password) VALUES
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Bob Wilson', 'bob@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Sample addresses
INSERT INTO addresses (user_id, address_line1, address_line2, city, state, postal_code, country, phone, is_default) VALUES
(1, '123 Main St', 'Apt 4B', 'New York', 'NY', '10001', 'USA', '1234567890', 1),
(1, '456 Work Ave', 'Suite 100', 'New York', 'NY', '10002', 'USA', '1234567890', 0),
(2, '789 Park Ave', NULL, 'Los Angeles', 'CA', '90001', 'USA', '0987654321', 1),
(3, '321 Oak St', NULL, 'Chicago', 'IL', '60601', 'USA', '5555555555', 1);

-- Sample wishlist items
INSERT INTO wishlist (user_id, product_id) VALUES
(1, 1), -- John wants iPhone 14 Pro
(1, 4), -- John wants Dell XPS 13
(2, 7), -- Jane wants Sony headphones
(2, 11), -- Jane wants PS5
(3, 13); -- Bob wants Canon EOS R5

-- Sample cart items
INSERT INTO cart (user_id, product_id, quantity) VALUES
(1, 2, 1), -- John has Samsung Galaxy in cart
(1, 8, 1), -- John has Bose headphones in cart
(2, 12, 1), -- Jane has Nintendo Switch in cart
(3, 9, 2); -- Bob has two JBL speakers in cart

-- Sample orders
INSERT INTO orders (user_id, address_id, total_amount, status) VALUES
(1, 1, 1529.98, 'completed'), -- John's first order
(1, 1, 499.99, 'processing'), -- John's second order
(2, 3, 849.98, 'completed'), -- Jane's order
(3, 4, 4399.98, 'pending'); -- Bob's order

-- Sample order items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
-- John's first order: iPhone 14 Pro + Bose headphones
(1, 1, 1, 999.99),
(1, 8, 1, 329.99),

-- John's second order: Xbox Series X
(2, 10, 1, 499.99),

-- Jane's order: Nintendo Switch + JBL speaker
(3, 12, 1, 349.99),
(3, 9, 1, 129.99),

-- Bob's order: Canon EOS R5 + Sony headphones
(4, 13, 1, 3899.99),
(4, 7, 1, 349.99);

