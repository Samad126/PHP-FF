USE ecommerce;

-- iPhone 14 Pro (ID: 1)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(1, 1, 5, 'Best iPhone Ever!', 'The camera system is incredible. Dynamic Island is a game changer. Battery life exceeds expectations.', '2023-11-15 10:30:00'),
(1, 2, 4, 'Great but Pricey', 'Amazing phone overall, but the price point is a bit high. The Pro features are worth it if you use them.', '2023-11-20 15:45:00'),
(1, 3, 5, 'Camera is Phenomenal', 'As a photography enthusiast, this phone has replaced my DSLR for most casual shoots.', '2023-12-01 09:15:00'),
(1, 4, 3, 'Good but Heavy', 'Great features but noticeably heavier than my previous iPhone. Takes time getting used to.', '2023-12-05 14:20:00'),
(1, 5, 4, 'Solid Upgrade', 'Upgraded from iPhone 12. The improvements in camera and performance are noticeable.', '2023-12-10 11:30:00'),
(1, 6, 5, 'Worth Every Penny', 'The display is gorgeous and the A16 chip handles everything I throw at it.', '2023-12-15 16:45:00'),
(1, 7, 4, 'Almost Perfect', 'Great phone but USB-C would have made it perfect. Looking forward to future models.', '2023-12-20 13:25:00');

-- Galaxy S23 Ultra (ID: 2)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(2, 3, 5, 'Android at its Best', 'The S-Pen integration is fantastic. Samsung has really perfected the formula.', '2023-11-10 09:00:00'),
(2, 1, 4, 'Great Battery Life', 'The battery easily lasts two days. Screen is gorgeous but phone is quite large.', '2023-11-25 14:30:00'),
(2, 2, 5, 'Camera King', 'The 200MP camera is not just marketing. The zoom capabilities are incredible.', '2023-12-02 11:20:00'),
(2, 4, 4, 'Premium Android Experience', 'OneUI has come a long way. Very refined experience overall.', '2023-12-07 16:15:00'),
(2, 5, 3, 'Mixed Feelings', 'Great hardware but software can be overwhelming with too many features.', '2023-12-12 10:45:00'),
(2, 6, 5, 'Productivity Beast', 'Perfect for work and play. The S-Pen is a game changer for note-taking.', '2023-12-17 13:30:00'),
(2, 7, 4, 'Solid Flagship', 'Everything you expect from a flagship. The size might be too much for some.', '2023-12-22 15:40:00');

-- Pixel 7 Pro (ID: 3)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(3, 2, 5, 'Clean Android Experience', 'Pure Android as Google intended. The AI features are truly useful.', '2023-11-12 10:20:00'),
(3, 1, 4, 'Great Value Flagship', 'Cheaper than competitors while offering similar features. Camera is outstanding.', '2023-11-27 15:30:00'),
(3, 3, 5, 'Camera Magic', 'The computational photography is amazing. Night shots are incredible.', '2023-12-03 12:45:00'),
(3, 4, 4, 'Smart Features', 'Call screening and other Pixel features make this phone unique.', '2023-12-08 09:15:00'),
(3, 5, 5, 'Perfect Daily Driver', 'Smooth performance and regular updates make this a great choice.', '2023-12-13 14:20:00'),
(3, 6, 4, 'Almost Perfect', 'Great phone but battery life could be better. Otherwise fantastic.', '2023-12-18 11:30:00'),
(3, 7, 5, 'Photography Champion', 'Best point-and-shoot camera in any smartphone. Period.', '2023-12-23 16:45:00');

-- OnePlus 11 (ID: 4)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(4, 4, 5, 'Speed Demon', 'Incredibly fast charging and smooth performance. Great value.', '2023-11-14 11:15:00'),
(4, 1, 4, 'Flagship Killer Returns', 'OnePlus is back to its roots. Great performance at a good price.', '2023-11-29 16:20:00'),
(4, 2, 5, 'Charging Champion', 'The fast charging is game-changing. Never worry about battery.', '2023-12-04 13:30:00'),
(4, 3, 4, 'Smooth Experience', 'OxygenOS is clean and fast. Hardware is top-notch.', '2023-12-09 10:45:00'),
(4, 5, 4, 'Great Value', 'Offers flagship features at a lower price. Camera has improved.', '2023-12-14 15:15:00'),
(4, 6, 5, 'Performance Beast', 'Everything is fast and smooth. Great gaming phone.', '2023-12-19 12:30:00'),
(4, 7, 4, 'Solid Choice', 'Good all-rounder with some standout features like charging.', '2023-12-24 17:45:00');

-- Dell XPS 15 (ID: 5)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(5, 5, 5, 'Perfect for Pros', 'Amazing build quality and performance. Screen is gorgeous.', '2023-11-16 12:30:00'),
(5, 1, 4, 'Premium Experience', 'Great laptop but runs hot under heavy load. Otherwise perfect.', '2023-11-30 17:15:00'),
(5, 2, 5, 'Desktop Replacement', 'Powerful enough to replace a desktop. Great for content creation.', '2023-12-05 14:20:00'),
(5, 3, 4, 'Almost Perfect', 'Beautiful screen and build. Battery life could be better.', '2023-12-10 11:30:00'),
(5, 4, 5, 'Workstation Beast', 'Handles everything from coding to video editing with ease.', '2023-12-15 16:45:00'),
(5, 6, 4, 'Premium Windows', 'The Windows equivalent of a MacBook Pro. Great machine.', '2023-12-20 13:20:00'),
(5, 7, 5, 'Content Creator Dream', 'Perfect for photo and video editing. Screen is incredible.', '2023-12-25 18:30:00');

-- HP Spectre x360 (ID: 6)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(6, 6, 5, 'Versatile Convertible', 'Perfect blend of laptop and tablet. Build quality is excellent.', '2023-11-18 13:45:00'),
(6, 1, 4, 'Premium 2-in-1', 'Great for both work and entertainment. Pen support is good.', '2023-12-01 18:20:00'),
(6, 2, 5, 'Beautiful Design', 'One of the best-looking laptops. Performance matches the looks.', '2023-12-06 15:30:00'),
(6, 3, 4, 'Flexible Powerhouse', 'Great for artists and note-takers. Battery life is impressive.', '2023-12-11 12:45:00'),
(6, 4, 5, 'Premium Experience', 'Everything feels high-end. Screen is gorgeous.', '2023-12-16 17:30:00'),
(6, 5, 4, 'Solid Convertible', 'Good performance and build quality. Bit pricey though.', '2023-12-21 14:15:00'),
(6, 7, 5, 'Perfect Travel Companion', 'Light enough to carry, powerful enough for work.', '2023-12-26 19:20:00');

-- ThinkPad X1 Carbon (ID: 7)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(7, 7, 5, 'Business Excellence', 'Best keyboard on a laptop. Build quality is legendary.', '2023-11-20 14:30:00'),
(7, 1, 4, 'Professional Choice', 'Great for business use. TrackPoint is still useful.', '2023-12-02 19:15:00'),
(7, 2, 5, 'Reliable Workhorse', 'Perfect for productivity. Battery life is excellent.', '2023-12-07 16:20:00'),
(7, 3, 4, 'Business Standard', 'The keyboard is amazing. Everything else is solid.', '2023-12-12 13:30:00'),
(7, 4, 5, 'Durable and Powerful', 'Can take a beating while looking professional.', '2023-12-17 18:45:00'),
(7, 5, 4, 'Classic ThinkPad', 'Everything you expect from a ThinkPad. Built to last.', '2023-12-22 15:30:00'),
(7, 6, 5, 'Productivity King', 'Perfect for office work and travel. Great battery life.', '2023-12-27 20:15:00');

-- ASUS ROG Zephyrus (ID: 8)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(8, 1, 5, 'Gaming Powerhouse', 'Incredible performance in a relatively slim package.', '2023-11-22 15:45:00'),
(8, 2, 4, 'Desktop Replacement', 'Handles any game you throw at it. Runs hot though.', '2023-12-03 20:30:00'),
(8, 3, 5, 'Perfect Gaming Laptop', 'Great screen, great performance, decent battery life.', '2023-12-08 17:15:00'),
(8, 4, 4, 'Beast Mode', 'Incredible performance but fans get loud under load.', '2023-12-13 14:20:00'),
(8, 5, 5, 'Gaming Excellence', 'Best gaming laptop I\'ve owned. Worth the premium.', '2023-12-18 19:30:00'),
(8, 6, 4, 'Powerful but Loud', 'Amazing performance but cooling fans are noisy.', '2023-12-23 16:45:00'),
(8, 7, 5, 'No Compromises', 'Everything a gamer needs in a portable package.', '2023-12-28 21:20:00');

-- PS5 (ID: 9)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(9, 1, 5, 'Next-Gen Gaming', 'The DualSense controller is revolutionary. Load times are incredible.', '2023-11-23 10:15:00'),
(9, 2, 4, 'Great Console', 'Amazing graphics but still limited game library. SSD is super fast.', '2023-11-28 14:30:00'),
(9, 3, 5, 'Worth The Wait', 'Finally got one and it exceeds expectations. Ray tracing is amazing.', '2023-12-03 09:45:00'),
(9, 4, 5, 'True Next-Gen', 'The haptic feedback and adaptive triggers are game-changing.', '2023-12-08 16:20:00'),
(9, 5, 4, 'Solid Console', 'Great performance but the size is quite large. Games look stunning.', '2023-12-13 11:30:00'),
(9, 6, 5, 'Gaming Excellence', 'The speed and graphics are incredible. No more loading screens!', '2023-12-18 15:45:00'),
(9, 7, 4, 'Future of Gaming', 'Amazing hardware but needs more exclusive games.', '2023-12-23 13:15:00');

-- Xbox Series X (ID: 10)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(10, 2, 5, 'Power House', 'Most powerful console. Game Pass is incredible value.', '2023-11-24 11:20:00'),
(10, 3, 4, 'Great Value', 'Game Pass makes this a must-buy. Quick Resume is fantastic.', '2023-11-29 15:30:00'),
(10, 4, 5, 'Perfect Console', 'Backward compatibility is amazing. Very quiet operation.', '2023-12-04 10:45:00'),
(10, 5, 4, 'Solid Choice', 'Great performance but needs more exclusive games.', '2023-12-09 17:20:00'),
(10, 6, 5, 'Xbox Best Box', 'Quick resume feature is game-changing. Super quiet.', '2023-12-14 12:30:00'),
(10, 7, 4, 'Great Hardware', 'Powerful and quiet but waiting for more next-gen games.', '2023-12-19 16:45:00'),
(10, 1, 5, 'Perfect Design', 'Compact, powerful, and runs cool. Game Pass is unbeatable.', '2023-12-24 14:15:00');

-- Nintendo Switch OLED (ID: 11)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(11, 3, 5, 'Perfect Hybrid', 'OLED screen is gorgeous. Best portable gaming device.', '2023-11-25 12:30:00'),
(11, 4, 4, 'Great Upgrade', 'Screen is beautiful but Joy-Con drift still exists.', '2023-11-30 16:45:00'),
(11, 5, 5, 'Worth The Upgrade', 'OLED makes a huge difference. Better build quality.', '2023-12-05 11:20:00'),
(11, 6, 4, 'Solid Improvement', 'Great screen but same internal hardware.', '2023-12-10 18:30:00'),
(11, 7, 5, 'Perfect Portable', 'The OLED screen makes games look amazing.', '2023-12-15 13:45:00'),
(11, 1, 4, 'Nice Upgrade', 'Better screen and kickstand. Battery life is good.', '2023-12-20 17:20:00'),
(11, 2, 5, 'Best Switch Yet', 'OLED screen is worth the upgrade. Great build quality.', '2023-12-25 15:30:00');

-- Bose QC45 (ID: 12)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(12, 4, 5, 'Perfect ANC', 'Best noise cancelling. Very comfortable for long sessions.', '2023-11-26 13:45:00'),
(12, 5, 4, 'Great Comfort', 'Excellent sound and ANC. Battery life is impressive.', '2023-12-01 17:20:00'),
(12, 6, 5, 'Amazing Quality', 'Perfect for travel. Noise cancelling is best in class.', '2023-12-06 12:30:00'),
(12, 7, 4, 'Solid Choice', 'Very comfortable but app could be better.', '2023-12-11 19:45:00'),
(12, 1, 5, 'Travel Essential', 'Great sound and amazing noise cancellation.', '2023-12-16 14:20:00'),
(12, 2, 4, 'Quality Product', 'Comfortable and great sound. Bit pricey though.', '2023-12-21 18:30:00'),
(12, 3, 5, 'Worth Every Penny', 'Best noise cancelling headphones I\'ve owned.', '2023-12-26 16:45:00');

-- Sony WH-1000XM5 (ID: 13)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(13, 5, 5, 'Best ANC', 'Superior noise cancelling. Amazing sound quality.', '2023-11-27 14:20:00'),
(13, 6, 4, 'Sound King', 'Excellent sound but touch controls take time to master.', '2023-12-02 18:30:00'),
(13, 7, 5, 'Perfect Sound', 'Best noise cancelling and sound quality combination.', '2023-12-07 13:45:00'),
(13, 1, 4, 'Great Update', 'Better ANC than XM4. New design is nice.', '2023-12-12 20:20:00'),
(13, 2, 5, 'Audio Excellence', 'The sound quality is unmatched. Great battery life.', '2023-12-17 15:30:00'),
(13, 3, 4, 'Almost Perfect', 'Amazing sound but miss the folding design.', '2023-12-22 19:45:00'),
(13, 4, 5, 'Best in Class', 'The noise cancelling is incredible. Worth the price.', '2023-12-27 17:20:00');

-- JBL Flip 6 (ID: 14)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(14, 6, 5, 'Perfect Portable', 'Great sound in a compact package. Very durable.', '2023-11-28 15:30:00'),
(14, 7, 4, 'Solid Speaker', 'Good sound and battery life. Water resistance is great.', '2023-12-03 19:45:00'),
(14, 1, 5, 'Beach Ready', 'Perfect for outdoors. Surprisingly loud for its size.', '2023-12-08 14:20:00'),
(14, 2, 4, 'Great Update', 'Better than Flip 5. Bass is impressive.', '2023-12-13 21:30:00'),
(14, 3, 5, 'Portable Power', 'Amazing sound for the size. Very rugged.', '2023-12-18 16:45:00'),
(14, 4, 4, 'Reliable Speaker', 'Great for travel. Battery life could be better.', '2023-12-23 20:20:00'),
(14, 5, 5, 'Perfect Travel Speaker', 'Durable and sounds great. Love the PartyBoost feature.', '2023-12-28 18:30:00');

-- Bose SoundLink Flex (ID: 15)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(15, 7, 5, 'Amazing Sound', 'Best sounding portable speaker. Very durable.', '2023-11-29 16:45:00'),
(15, 1, 4, 'Great Quality', 'Excellent sound and build quality. Good battery life.', '2023-12-04 20:20:00'),
(15, 2, 5, 'Perfect Portable', 'Amazing bass for the size. Water resistance is great.', '2023-12-09 15:30:00'),
(15, 3, 4, 'Solid Choice', 'Great sound but wish it had USB-C charging.', '2023-12-14 22:45:00'),
(15, 4, 5, 'Best Portable', 'The sound quality is incredible for its size.', '2023-12-19 17:20:00'),
(15, 5, 4, 'Quality Speaker', 'Very durable and sounds great. Bit pricey.', '2023-12-24 21:30:00'),
(15, 6, 5, 'Worth It', 'Best sounding portable speaker I\'ve owned.', '2023-12-29 19:45:00');

-- Canon EOS R5 (ID: 16)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(16, 1, 5, 'Pro Level', 'Amazing autofocus. Image quality is outstanding.', '2023-11-30 17:20:00'),
(16, 2, 4, 'Nearly Perfect', 'Great camera but runs hot in 8K. Stills are amazing.', '2023-12-05 21:30:00'),
(16, 3, 5, 'Game Changer', 'Best mirrorless camera. Autofocus is incredible.', '2023-12-10 16:45:00'),
(16, 4, 4, 'Professional Tool', 'Excellent for both photo and video. Battery life could be better.', '2023-12-15 23:20:00'),
(16, 5, 5, 'Worth Every Penny', 'The image quality and features are outstanding.', '2023-12-20 18:30:00'),
(16, 6, 4, 'Amazing Camera', 'Great features but expensive. Perfect for professionals.', '2023-12-25 22:45:00'),
(16, 7, 5, 'Photography Dream', 'The autofocus and image quality are unmatched.', '2023-12-30 20:20:00');

-- Nike Air Max (ID: 17)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(17, 2, 5, 'Classic Comfort', 'Most comfortable Air Max yet. Great style.', '2023-12-01 18:30:00'),
(17, 3, 4, 'Stylish Choice', 'Very comfortable but runs slightly small.', '2023-12-06 22:45:00'),
(17, 4, 5, 'Perfect Fit', 'Great comfort and style. Worth the price.', '2023-12-11 17:20:00'),
(17, 5, 4, 'Solid Sneaker', 'Comfortable for all-day wear. Good looking.', '2023-12-16 23:30:00'),
(17, 6, 5, 'Best Air Max', 'Most comfortable Nike shoes I\'ve owned.', '2023-12-21 19:45:00'),
(17, 7, 4, 'Great Design', 'Stylish and comfortable. Size up half size.', '2023-12-26 23:20:00'),
(17, 1, 5, 'Classic Updated', 'Perfect blend of style and comfort.', '2023-12-31 21:30:00');

-- Sony A7 IV (ID: 18)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(18, 3, 5, 'Perfect Hybrid', 'Amazing for both photo and video. Great autofocus.', '2023-12-02 19:45:00'),
(18, 4, 4, 'Solid Upgrade', 'Better than A7 III in every way. Great image quality.', '2023-12-07 23:20:00'),
(18, 5, 5, 'Professional Choice', 'Perfect for professional work. Reliable performer.', '2023-12-12 18:30:00'),
(18, 6, 4, 'Great Camera', 'Excellent image quality. Menu system improved.', '2023-12-17 23:45:00'),
(18, 7, 5, 'Worth The Wait', 'Significant upgrade from A7 III. Great features.', '2023-12-22 20:20:00'),
(18, 1, 4, 'Reliable Tool', 'Perfect for professional use. Battery life is good.', '2023-12-27 23:30:00'),
(18, 2, 5, 'Amazing Update', 'The improvements over A7 III are worth it.', '2024-01-01 21:45:00');

-- Fujifilm X-T5 (ID: 19)
INSERT INTO reviews (product_id, user_id, rating, title, comment, created_at) VALUES
(19, 4, 5, 'Retro Perfect', 'Beautiful design with modern features. Great image quality.', '2023-12-03 20:20:00'),
(19, 5, 4, 'Photography Joy', 'Dial controls are perfect. JPEG colors are amazing.', '2023-12-08 23:30:00'),
(19, 6, 5, 'Best Fuji Yet', 'Perfect size and weight. Image quality is outstanding.', '2023-12-13 19:45:00'),
(19, 7, 4, 'Great Camera', 'Love the analog controls. IBIS works well.', '2023-12-18 23:20:00'),
(19, 1, 5, 'Photography Dream', 'The colors and handling are incredible.', '2023-12-23 21:30:00'),
(19, 2, 4, 'Classic Feel', 'Modern features with retro handling. Love it.', '2023-12-28 23:45:00'),
(19, 3, 5, 'Perfect Size', 'Just right for travel and everyday use.', '2024-01-02 22:20:00');

-- Update product rating statistics
UPDATE products p
SET 
    rating_count = (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id),
    rating_avg = (SELECT AVG(rating) FROM reviews r WHERE r.product_id = p.id),
    rating_1_count = (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id AND r.rating = 1),
    rating_2_count = (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id AND r.rating = 2),
    rating_3_count = (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id AND r.rating = 3),
    rating_4_count = (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id AND r.rating = 4),
    rating_5_count = (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id AND r.rating = 5)
WHERE id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19);

