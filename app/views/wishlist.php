<h1>Your Wishlist</h1>
<?php foreach ($items as $item): ?>
    <div><?= $item['name'] ?> - $<?= $item['price'] ?></div>
<?php endforeach; ?>