<div id="aside" class="col-md-3">
    <!-- aside Widget -->
    <div class="aside">
        <h3 class="aside-title">Categories</h3>
        <div class="checkbox-filter">

            <div class="input-checkbox">
                <input type="checkbox" id="category-1">
                <label for="category-1">
                    <span></span>
                    Laptops
                    <small>(120)</small>
                </label>
            </div>

            <div class="input-checkbox">
                <input type="checkbox" id="category-2">
                <label for="category-2">
                    <span></span>
                    Smartphones
                    <small>(740)</small>
                </label>
            </div>

            <div class="input-checkbox">
                <input type="checkbox" id="category-3">
                <label for="category-3">
                    <span></span>
                    Cameras
                    <small>(1450)</small>
                </label>
            </div>

            <div class="input-checkbox">
                <input type="checkbox" id="category-4">
                <label for="category-4">
                    <span></span>
                    Accessories
                    <small>(578)</small>
                </label>
            </div>

            <div class="input-checkbox">
                <input type="checkbox" id="category-5">
                <label for="category-5">
                    <span></span>
                    Laptops
                    <small>(120)</small>
                </label>
            </div>

            <div class="input-checkbox">
                <input type="checkbox" id="category-6">
                <label for="category-6">
                    <span></span>
                    Smartphones
                    <small>(740)</small>
                </label>
            </div>
        </div>
    </div>
    <!-- /aside Widget -->

    <!-- aside Widget -->
    <div class="aside">
        <h3 class="aside-title">Price</h3>
        <div class="price-filter">
            <div id="price-slider"></div>
            <div class="input-number price-min">
                <input id="price-min" type="number">
                <span class="qty-up">+</span>
                <span class="qty-down">-</span>
            </div>
            <span>-</span>
            <div class="input-number price-max">
                <input id="price-max" type="number">
                <span class="qty-up">+</span>
                <span class="qty-down">-</span>
            </div>
        </div>
    </div>
    <!-- /aside Widget -->

    <!-- aside Widget -->
    <div class="aside">
        <h3 class="aside-title">Brand</h3>
        <div class="checkbox-filter">
            <div class="input-checkbox">
                <input type="checkbox" id="brand-1">
                <label for="brand-1">
                    <span></span>
                    SAMSUNG
                    <small>(578)</small>
                </label>
            </div>
            <div class="input-checkbox">
                <input type="checkbox" id="brand-2">
                <label for="brand-2">
                    <span></span>
                    LG
                    <small>(125)</small>
                </label>
            </div>
            <div class="input-checkbox">
                <input type="checkbox" id="brand-3">
                <label for="brand-3">
                    <span></span>
                    SONY
                    <small>(755)</small>
                </label>
            </div>
            <div class="input-checkbox">
                <input type="checkbox" id="brand-4">
                <label for="brand-4">
                    <span></span>
                    SAMSUNG
                    <small>(578)</small>
                </label>
            </div>
            <div class="input-checkbox">
                <input type="checkbox" id="brand-5">
                <label for="brand-5">
                    <span></span>
                    LG
                    <small>(125)</small>
                </label>
            </div>
            <div class="input-checkbox">
                <input type="checkbox" id="brand-6">
                <label for="brand-6">
                    <span></span>
                    SONY
                    <small>(755)</small>
                </label>
            </div>
        </div>
    </div>
    <!-- /aside Widget -->

    <!-- aside Widget -->
    <div class="aside">
        <h3 class="aside-title">Top selling</h3>
        <?php foreach ($topSellingProducts as $product): ?>
        <div class="product-widget">
            <div class="product-img">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
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
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- /aside Widget -->
</div>
