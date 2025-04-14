<h1>Your Cart</h1>
<?php foreach ($cart as $item): ?>
    <div><?= $item['name'] ?> - $<?= $item['price'] ?></div>
<?php endforeach; ?>