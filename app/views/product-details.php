<h1><?= $product['name'] ?></h1>
<img src="<?= $product['image'] ?>" alt="">
<p><?= $product['description'] ?></p>
<p>$<?= $product['price'] ?></p>

<h2>Related Products</h2>
<div class="related-products">
    <?php foreach ($related as $p): ?>
        <div class="related-card">
            <img src="<?= $p['image'] ?>" alt="">
            <p><?= $p['name'] ?> - $<?= $p['price'] ?></p>
        </div>
    <?php endforeach; ?>
</div>