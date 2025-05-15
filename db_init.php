<?php
// Правильный путь к файлу db.php (из корня проекта)
require_once __DIR__ . '/config/db.php';

$products = [
    'omega3' => ['name' => 'Омега-3', 'type' => 'основная'],
    'zhelezo' => ['name' => 'Железо', 'type' => 'основная'],
    'calcium' => ['name' => 'Кальций', 'type' => 'основная'],
    'collagen' => ['name' => 'Коллаген', 'type' => 'тематическая'],
    'hialuron' => ['name' => 'Гиалуроновая кислота', 'type' => 'тематическая'],
    'yod' => ['name' => 'Йод', 'type' => 'основная'],
    'cink' => ['name' => 'Цинк', 'type' => 'основная'],
    'selen' => ['name' => 'Селен', 'type' => 'основная'],
    'taurine' => ['name' => 'Таурин', 'type' => 'тематическая'],
    'coenzin' => ['name' => 'Коэнзим', 'type' => 'тематическая'],
    'magnesium' => ['name' => 'Магний', 'type' => 'основная'],
    'a' => ['name' => 'Витамин А', 'type' => 'основная'],
    'vitamin-d' => ['name' => 'Витамин D', 'type' => 'основная'],
    'vitamin-c' => ['name' => 'Витамин C', 'type' => 'основная'],
    'b' => ['name' => 'Витамины группы B', 'type' => 'основная'],
    'forwoman' => ['name' => 'Комплекс для женщин', 'type' => 'тематическая'],
    'forman' => ['name' => 'Комплекс для мужчин', 'type' => 'тематическая'],
    'forhair' => ['name' => 'Комплекс для волос', 'type' => 'тематическая']
];

try {
    $db = Database::getConnection();
    
    // Отключаем проверку внешних ключей для очистки
    $db->exec("SET session_replication_role = 'replica'");
    $db->exec("TRUNCATE TABLE product_category, categories RESTART IDENTITY CASCADE");
    $db->exec("SET session_replication_role = 'origin'");
    
    $stmt = $db->prepare("INSERT INTO categories (slug, name, type) VALUES (:slug, :name, :type)");
    
    foreach ($products as $slug => $data) {
        $stmt->execute([
            ':slug' => $slug,
            ':name' => $data['name'],
            ':type' => $data['type']
        ]);
    }
    
    echo "База данных успешно инициализирована! Добавлено " . count($products) . " категорий.";
    
} catch(Exception $e) {
    echo "Ошибка: " . $e->getMessage();
    error_log("DB init error: " . $e->getMessage());
}