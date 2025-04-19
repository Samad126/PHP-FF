<div class="col-md-5">
    <div class="product-details">
        <h2 class="product-name"><?= htmlspecialchars($product['name']) ?></h2>
        <div>
            <div class="product-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fa fa-star<?= $i > ($product['rating'] ?? 0) ? '-o' : '' ?>"></i>
                <?php endfor; ?>
            </div>
            <a class="review-link" href="#reviews">
                <?= $product['review_count'] ?? 0 ?> Review(s) | Add your review
            </a>
        </div>
        <div>
            <h3 class="product-price">
                $<?= number_format($product['price'], 2) ?>
                <?php if (isset($product['old_price']) && $product['old_price'] > $product['price']): ?>
                    <del class="product-old-price">$<?= number_format($product['old_price'], 2) ?></del>
                <?php endif; ?>
            </h3>
            <span class="product-available"><?= $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?></span>
        </div>
        <p><?= htmlspecialchars($product['description']) ?></p>

        <!-- Add to cart form -->
        <div class="add-to-cart">
            <?php if ($product['stock'] > 0): ?>
                <?php if (isset($cartItems) && in_array($product['id'], $cartItems)): ?>
                    <button class="add-to-cart-btn in-cart" disabled>
                        <i class="fa fa-shopping-cart"></i> In Cart
                    </button>
                <?php else: ?>
                    <div class="qty-label">
                        Qty
                        <div class="input-number">
                            <input type="number" value="1" min="1" max="<?= $product['stock'] ?>" id="product-quantity">
                            <span class="qty-up">+</span>
                            <span class="qty-down">-</span>
                        </div>
                    </div>
                    <button class="add-to-cart-btn" onclick="addToCart(<?= $product['id'] ?>)">
                        <i class="fa fa-shopping-cart"></i> Add to Cart
                    </button>
                <?php endif; ?>
            <?php else: ?>
                <button class="add-to-cart-btn out-of-stock" disabled>
                    <i class="fa fa-shopping-cart"></i> Out of Stock
                </button>
            <?php endif; ?>
        </div>

        <ul class="product-btns">
            <li>
                <button class="add-to-wishlist <?= in_array($product['id'], $wishlistItems) ? 'in-wishlist' : '' ?>"
                    onclick="toggleWishlist(<?= $product['id'] ?>)">
                    <i class="fa fa-<?= in_array($product['id'], $wishlistItems) ? 'heart' : 'heart-o' ?>"></i>
                    <span class="tooltipp"><?= in_array($product['id'], $wishlistItems) ? 'remove from wishlist' : 'add to wishlist' ?></span>
                </button>
            </li>
        </ul>

        <ul class="product-links">
            <li>Category:</li>
            <li><a href="/products?category=<?= $product['category_id'] ?>"><?= htmlspecialchars($product['category_name']) ?></a></li>
            <li>Brand:</li>
            <li><a href="/products?brand=<?= $product['brand_id'] ?>"><?= htmlspecialchars($product['brand_name']) ?></a></li>
        </ul>

        <ul class="product-links">
            <li>Share:</li>
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
        </ul>

    </div>
</div>