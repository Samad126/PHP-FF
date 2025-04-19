<div class="row">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $index => $product): ?>
            <!-- product -->
            <div class="col-md-4 col-xs-6">
                <div class="product">
                    <div class="product-img">
                        <?php
                        $imageUrl = $product['image_url'] ?? '';
                        if ($imageUrl) {
                            $imageUrl = str_replace('/upload/', '/upload/f_auto,w_400/', $imageUrl);
                        }
                        ?>
                        <img src="<?= htmlspecialchars($imageUrl) ?>"
                            alt="<?= htmlspecialchars($product['name'] ?? '') ?>"
                            style="min-height: 280px; object-fit: contain; object-position: center;"
                            loading="lazy">

                        <div class="product-label">
                            <?php if (isset($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                                <span class="sale">-<?= $product['discount_percentage'] ?>%</span>
                            <?php endif; ?>
                            <?php if (isset($product['is_new']) && $product['is_new']): ?>
                                <span class="new">NEW</span>
                            <?php endif; ?>
                            <?php if ($product['stock'] <= 0): ?>
                                <span class="out-of-stock">OUT OF STOCK</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="product-body">
                        <p class="product-category"><?= htmlspecialchars($product['category_name'] ?? '') ?></p>
                        <h3 class="product-name">
                            <a href="/products/<?= $product['id'] ?>"><?= htmlspecialchars($product['name'] ?? '') ?></a>
                        </h3>
                        <h4 class="product-price">
                            $<?= number_format($product['price'] ?? 0, 2) ?>
                            <?php if (isset($product['old_price']) && $product['old_price'] > ($product['price'] ?? 0)): ?>
                                <del class="product-old-price">$<?= number_format($product['old_price'], 2) ?></del>
                            <?php endif; ?>
                        </h4>
                        <div class="product-rating">
                            <?php 
                            $rating = round($product['rating'] ?? 0);
                            for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="fa fa-star<?= $i > $rating ? '-o' : '' ?>"></i>
                            <?php endfor; ?>
                            <span class="review-count">(<?= (int)($product['review_count'] ?? 0) ?>)</span>
                        </div>
                        <div class="product-btns">
                            <button class="add-to-wishlist <?= in_array($product['id'], $wishlistItems) ? 'in-wishlist' : '' ?>"
                                onclick="toggleWishlist(<?= $product['id'] ?>)">
                                <i class="fa fa-<?= in_array($product['id'], $wishlistItems) ? 'heart' : 'heart-o' ?>"></i>
                                <span class="tooltipp"><?= in_array($product['id'], $wishlistItems) ? 'remove from wishlist' : 'add to wishlist' ?></span>
                            </button>
                            <button class="add-to-compare">
                                <i class="fa fa-exchange"></i>
                                <span class="tooltipp">add to compare</span>
                            </button>
                            <button class="quick-view">
                                <i class="fa fa-eye"></i>
                                <span class="tooltipp">quick view</span>
                            </button>
                        </div>
                    </div>
                    <div class="add-to-cart">
                        <?php if (isset($cartItems) && is_array($cartItems) && in_array($product['id'], $cartItems)): ?>
                            <button class="add-to-cart-btn in-cart" disabled>
                                <i class="fa fa-shopping-cart"></i> In Cart
                            </button>
                        <?php elseif ($product['stock'] <= 0): ?>
                            <button class="add-to-cart-btn out-of-stock" disabled>
                                <i class="fa fa-shopping-cart"></i> Out of Stock
                            </button>
                        <?php else: ?>
                            <button class="add-to-cart-btn" onclick="addToCart(<?= $product['id'] ?>)">
                                <i class="fa fa-shopping-cart"></i> add to cart
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- /product -->
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <p>No products found.</p>
        </div>
    <?php endif; ?>
</div>
