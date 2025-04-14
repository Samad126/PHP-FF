-- First, create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Second, create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    old_price DECIMAL(10,2),
    image VARCHAR(255) NOT NULL,
    image2 VARCHAR(255),
    image3 VARCHAR(255),
    image4 VARCHAR(255),
    category_id INT,
    stock INT DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0,
    review_count INT DEFAULT 0,
    sizes VARCHAR(255),
    colors VARCHAR(255),
    discount INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Third, create reviews table (after both users and products exist)
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Then create other tables...
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample categories
INSERT INTO categories (name, slug) VALUES
('Laptops', 'laptops'),
('Smartphones', 'smartphones'),
('Cameras', 'cameras'),
('Accessories', 'accessories');

-- Insert sample products
INSERT INTO products (name, description, price, old_price, image, image2, image3, image4, category_id, stock, rating, review_count, sizes, colors, discount) VALUES
('MacBook Pro 16"', 'Latest MacBook Pro with M1 chip', 2499.99, 2699.99, '/assets/img/macbook-1.jpg', '/assets/img/macbook-2.jpg', '/assets/img/macbook-3.jpg', '/assets/img/macbook-4.jpg', 1, 50, 4.8, 245, NULL, 'Silver,Space Gray', 7),
('iPhone 13 Pro', 'Apple iPhone 13 Pro with A15 Bionic', 999.99, 1099.99, '/assets/img/iphone-1.jpg', '/assets/img/iphone-2.jpg', '/assets/img/iphone-3.jpg', '/assets/img/iphone-4.jpg', 2, 100, 4.9, 189, '128GB,256GB,512GB', 'Graphite,Gold,Sierra Blue', 9),
('Sony A7 IV', 'Full-frame mirrorless camera', 2499.99, 2699.99, '/assets/img/sony-1.jpg', '/assets/img/sony-2.jpg', '/assets/img/sony-3.jpg', '/assets/img/sony-4.jpg', 3, 25, 4.7, 89, NULL, 'Black', 0),
('AirPods Pro', 'Wireless noise cancelling earbuds', 249.99, 279.99, '/assets/img/airpods-1.jpg', '/assets/img/airpods-2.jpg', '/assets/img/airpods-3.jpg', '/assets/img/airpods-4.jpg', 4, 200, 4.6, 567, NULL, 'White', 11);

-- Insert sample user
INSERT INTO users (name, email, password) VALUES
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password

-- Insert sample reviews
INSERT INTO reviews (product_id, user_id, rating, comment) VALUES
(1, 1, 5, 'Amazing laptop! The M1 chip is incredibly fast.'),
(1, 1, 4, 'Great build quality but a bit expensive.'),
(2, 1, 5, 'Best iPhone ever! Camera quality is outstanding.'),
(3, 1, 4, 'Professional grade camera with excellent features.');

-- Add indexes for better performance
ALTER TABLE products ADD INDEX idx_category (category_id);
ALTER TABLE reviews ADD INDEX idx_product (product_id);
ALTER TABLE cart ADD INDEX idx_user_product (user_id, product_id);
ALTER TABLE wishlist ADD INDEX idx_user_product (user_id, product_id);
