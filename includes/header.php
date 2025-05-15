<!-- header.php -->
<?php
// Подключение данных
require_once __DIR__ . '/../config/db.php';

$categories = [];

try {
    // Пытаемся загрузить из базы данных
    $db = Database::getConnection();
    $stmt = $db->query("SELECT slug, name FROM categories");
    $categories = $stmt->fetchAll();
    
    // Если в базе нет категорий, загружаем из файла
    if(empty($categories)) {
        throw new Exception('No categories in database');
    }
    
} catch(Exception $db_ex) {
    // Логируем ошибку базы данных
    error_log("Database error: " . $db_ex->getMessage());
    
    try {
        // Пробуем загрузить из файла
        require_once __DIR__ . '/../data/products.php';
        
        // Преобразуем структуру файла к нужному формату
        $categories = [];
        foreach($products as $slug => $data) {
            $categories[] = [
                'slug' => $slug,
                'name' => $data['name']
            ];
        }
        
    } catch(Exception $file_ex) {
        // Логируем ошибку файла
        error_log("File error: " . $file_ex->getMessage());
        $categories = [];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iHealth - Магазин витаминов</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <!-- Хедер -->
    <div class="header">
        <div class="header-left">
            <img src="images/logo.png" alt="iHealth" class="logo">
            
                        <!-- Контейнер выпадающего списка -->
            <div class="catalog-container">
                <button class="catalog-btn" id="catalogBtn">
                    Каталог
                </button>
                
                <!-- Список категорий -->
                <div class="dropdown-menu" id="categoriesDropdown">
                    <?php foreach($categories as $slug => $category): ?>
                        <a href="category.php?category=<?= $slug ?>" 
                           class="dropdown-item">
                            <?= htmlspecialchars($category['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> <!-- Закрываем header-left -->

        <div class="icons">
            <a href="#">
                <img src="images/icons/user.png" alt="Профиль">
                Профиль
            </a>
            <a href="#">
                <img src="images/icons/package.png" alt="Заказы">
                Заказы
            </a>
            <a href="#">
                <img src="images/icons/heart.png" alt="Избранное">
                Избранное
            </a>
            <a href="#">
                <img src="images/icons/cart.png" alt="Корзина">
                Корзина
            </a>
        </div>
    </div>
    <!-- Поиск -->
    <div class="search-bar">
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Поиск витаминов и добавок...">
            <button type="submit" class="search-btn">Найти</button>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const catalogBtn = document.getElementById('catalogBtn');
    const dropdownMenu = document.getElementById('categoriesDropdown');

    catalogBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!dropdownMenu.contains(e.target) && !catalogBtn.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});
    </script>
</body>
</html>