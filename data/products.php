<?php
$categories = [
    'omega3' => ['name' => 'Омега-3'],
    'zhelezo' => ['name' => 'Железо'],
    'calcium' => ['name' => 'Кальций'],
    'collagen' => ['name' => 'Коллаген'],
    'hialuron' => ['name' => 'Гиалуроновая кислота'],
    'yod' => ['name' => 'Йод'],
    'cink' => ['name' => 'Цинк'],
    'selen' => ['name' => 'Селен'],
    'Taurine' => ['name' => 'Таурин'],
    'coenzin' => ['name' => 'Коэнзим'],
    'magnesium' => ['name' => 'Магний'],
    'a' => ['name' => 'Витамин А'],
    'vitamin-d' => ['name' => 'Витамин D'],
    'vitamin-c' => ['name' => 'Витамин C'],
    'b' => ['name' => 'Витамины группы B'],
    'forwoman' => ['name' => 'Комплекс для женщин'],
    'forman' => ['name' => 'Комплекс для мужчин'],
    'for hair' => ['name' => 'Комплекс для волос']
];
$categories = [];
foreach($products as $slug => $data) {
    $categories[] = [
        'slug' => $slug,
        'name' => $data['name']
    ];
}
?>