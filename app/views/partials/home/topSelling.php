<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Top selling</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li class="active"><a href="/products">View All</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <!-- tab -->
                        <div id="tab2" class="tab-pane fade in active">
                            <div class="products-slick" data-nav="#slick-nav-2">
                                <?php foreach ($topSellingProducts as $product): ?>
                                <!-- product -->
                                <div class="product">
                                    <div class="product-img">
                                        <img src="<?= htmlspecialchars($product['image_url'] ?? '/images/placeholder.jpg') ?>" 
                                             alt="<?= htmlspecialchars($product['name']) ?>">
                                        <div class="product-label">
                                            <?php if (isset($product['discount_percentage']) && $product['discount_percentage'] > 0): ?>
                                                <span class="sale">-<?= $product['discount_percentage'] ?>%</span>
                                            <?php endif; ?>
                                            <?php if (!$product['in_stock']): ?>
                                                <span class="out-of-stock">OUT OF STOCK</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="product-body">
                                        <p class="product-category"><?= htmlspecialchars($product['category_name']) ?></p>
                                        <h3 class="product-name">
                                            <a href="/products/<?= $product['id'] ?>"><?= htmlspecialchars($product['name']) ?></a>
                                        </h3>
                                        <h4 class="product-price">
                                            $<?= number_format($product['price'], 2) ?>
                                            <?php if (isset($product['old_price']) && $product['old_price'] > $product['price']): ?>
                                                <del class="product-old-price">$<?= number_format($product['old_price'], 2) ?></del>
                                            <?php endif; ?>
                                        </h4>
                                        <div class="product-rating">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="fa fa-star<?= $i > ($product['rating'] ?? 0) ? '-o' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="product-btns">
                                            <button class="add-to-wishlist <?= in_array($product['id'], $wishlistItems) ? 'in-wishlist' : '' ?>" 
                                                    onclick="toggleWishlist(<?= $product['id'] ?>)">
                                                <i class="fa <?= in_array($product['id'], $wishlistItems) ? 'fa-heart' : 'fa-heart-o' ?>"></i>
                                                <span class="tooltipp"><?= in_array($product['id'], $wishlistItems) ? 'remove from wishlist' : 'add to wishlist' ?></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <?php if (!$product['in_stock']): ?>
                                            <button class="add-to-cart-btn" disabled>
                                                <i class="fa fa-shopping-cart"></i> Out of Stock
                                            </button>
                                        <?php elseif (in_array($product['id'], $cartItems)): ?>
                                            <button class="add-to-cart-btn in-cart" disabled>
                                                <i class="fa fa-shopping-cart"></i> In Cart
                                            </button>
                                        <?php else: ?>
                                            <button class="add-to-cart-btn" onclick="addToCart(<?= $product['id'] ?>)">
                                                <i class="fa fa-shopping-cart"></i> add to cart
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- /product -->
                                <?php endforeach; ?>
                            </div>
                            <div id="slick-nav-2" class="products-slick-nav"></div>
                        </div>
                        <!-- /tab -->
                    </div>
                </div>
            </div>
            <!-- /Products tab & slick -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
