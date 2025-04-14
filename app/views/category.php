<h1>Category: <?= $category ?></h1>
<?php foreach ($products as $product): ?>
    <div><?= $product['name'] ?> - $<?= $product['price'] ?></div>
<?php endforeach; ?>