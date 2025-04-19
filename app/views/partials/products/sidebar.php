<div id="aside" class="col-md-3">
    <!-- aside Widget -->
    <div class="aside">
        <h3 class="aside-title">Categories</h3>
        <div class="checkbox-filter">
            <?php foreach ($categories as $category): ?>
            <div class="input-checkbox">
                <input type="checkbox" 
                       id="category-<?= $category['id'] ?>" 
                       value="<?= $category['id'] ?>"
                       <?= ($filters['category'] == $category['id']) ? 'checked' : '' ?>
                       onchange="updateFilters('category', this.checked ? this.value : '')">
                <label for="category-<?= $category['id'] ?>">
                    <span></span>
                    <?= htmlspecialchars($category['name']) ?>
                    <small>(<?= $category['product_count'] ?>)</small>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- /aside Widget -->

    <!-- aside Widget -->
    <div class="aside">
        <h3 class="aside-title">Price</h3>
        <div class="price-filter">
            <div id="price-slider"></div>
            <div class="input-number price-min">
                <input id="price-min" type="number" value="<?= $filters['price_min'] ?? '' ?>"
                       onchange="updateFilters('price_min', this.value)">
                <span class="qty-up">+</span>
                <span class="qty-down">-</span>
            </div>
            <span>-</span>
            <div class="input-number price-max">
                <input id="price-max" type="number" value="<?= $filters['price_max'] ?? '' ?>"
                       onchange="updateFilters('price_max', this.value)">
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
            <?php foreach ($brands as $brand): ?>
            <div class="input-checkbox">
                <input type="checkbox" 
                       id="brand-<?= $brand['id'] ?>" 
                       value="<?= $brand['id'] ?>"
                       <?= ($filters['brand'] == $brand['id']) ? 'checked' : '' ?>
                       onchange="updateFilters('brand', this.checked ? this.value : '')">
                <label for="brand-<?= $brand['id'] ?>">
                    <span></span>
                    <?= htmlspecialchars($brand['name']) ?>
                    <small>(<?= $brand['product_count'] ?>)</small>
                </label>
            </div>
            <?php endforeach; ?>
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
