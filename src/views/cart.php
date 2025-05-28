<?php include __DIR__ . '/partials/header.php'; ?>

<main class="cart-page">
    <h1>Ваша корзина</h1>

    <?php if (empty($items)): ?>
        <p>Корзина пуста.</p>
    <?php else: ?>
        <div class="cart-items">
            <?php foreach($items as $item): ?>
                <div class="cart-item">
                    <img src="/images/products/<?= htmlspecialchars($item['image_url']) ?>" width="80">
                    <div>
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p><?= number_format($item['price'], 2) ?> руб. × <?= $item['quantity'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
