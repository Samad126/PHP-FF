<h1>New Products</h1>
<div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?= $product['image'] ?>" alt="">
            <h3><?= $product['name'] ?></h3>
            <p>$<?= $product['price'] ?></p>
            <a href="/product/show/<?= $product['id'] ?>">View</a>
        </div>
    <?php endforeach; ?>
</div>