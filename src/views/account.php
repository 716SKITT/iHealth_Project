<?php include __DIR__ . '/partials/header.php'; ?>

<main class="account-page">
    <h1>Личный кабинет</h1>
    <p>Имя: <?= htmlspecialchars($user['full_name']) ?></p>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <a href="/logout">Выйти</a>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
