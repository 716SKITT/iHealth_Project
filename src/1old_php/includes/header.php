<?php
require_once __DIR__ . '/../config/db.php';

// Функция для получения категорий
function getCategories() {
    try {
        $db = Database::getConnection();
        
        $db->query("SELECT 1 FROM categories LIMIT 1");
        
        $stmt = $db->query("
            SELECT slug, name 
            FROM categories 
            WHERE type IN ('основная', 'тематическая')
            ORDER BY name
        ");
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($result)) {
            throw new Exception("Нет категорий в БД");
        }
        
        return $result;
    } catch(Exception $e) {
        error_log("Database error: " . $e->getMessage());
        return getFallbackCategories();
    }
}

// Функция для резервных данных
function getFallbackCategories() {
    $products = require __DIR__ . '/../data/products.php';
    return array_map(
        fn($slug, $data) => ['slug' => $slug, 'name' => $data['name']],
        array_keys($products),
        $products
    );
}

$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iHealth - Магазин витаминов</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .dropdown-menu {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-item {
            display: block;
            padding: 8px 16px;
            color: #333;
            text-decoration: none;
        }
        .dropdown-item:hover {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <img src="images/logo.png" alt="iHealth" class="logo">
            
            <div class="catalog-container">
                <button class="catalog-btn" id="catalogBtn">
                    Каталог
                </button>
                
                <div class="dropdown-menu" id="categoriesDropdown">
                    <?php if (!empty($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <?php if (is_array($category) && isset($category['slug']) && isset($category['name'])): ?>
                                        <a href="/category.php?category=<?= htmlspecialchars($category['slug']) ?>"
                                   class="dropdown-item">
                                    <?= htmlspecialchars($category['name']) ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="dropdown-item">Категории временно недоступны</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

       <div class="icons">
    <a href="/wishlist.php" class="icon-link" title="Избранное">
        <img src="/images/icons/heart.png" alt="Избранное" class="header-icon">
        <span class="icon-badge" id="wishlistCounter">0</span>
    </a>
    
    <a href="/cart class="icon-link" title="Корзина">
        <img src="/images/icons/cart.png" alt="Корзина" class="header-icon">
        <span class="icon-badge" id="cartCounter">0</span>
    </a>
    
    <a href="/account.php" class="icon-link" title="Мой аккаунт">
        <img src="/images/icons/user.png" alt="Аккаунт" class="header-icon">
    </a>
</div>
    </div>
    
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