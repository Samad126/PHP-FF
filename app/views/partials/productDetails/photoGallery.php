<!-- Product main img -->
<div class="col-md-5 col-md-push-2">
    <div id="product-main-img">
        <?php foreach($product->images as $image): ?>
        <div class="product-preview">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product->name) ?>">
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Product thumb imgs -->
<div class="col-md-2 col-md-pull-5">
    <div id="product-imgs">
        <?php foreach($product->images as $image): ?>
        <div class="product-preview">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product->name) ?>">
        </div>
        <?php endforeach; ?>
    </div>
</div>
