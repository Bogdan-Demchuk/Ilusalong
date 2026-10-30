<?php

$content = '<section class="categories-page">';

$content .= '<h2>' . t('Категории', 'Kategooriad') . '</h2>';

if (empty($categories)) {

    $content .= '<p>' . t('Категории не найдены.', 'Kategooriaid ei leitud.') . '</p>';

} else {

    $content .= '<div class="categories-list">';

    foreach ($categories as $category) {

        $categoryName = ($_SESSION['lang'] ?? 'ru') === 'et'
            ? $category['name_et']
            : $category['name_ru'];

        $content .= '<article class="category-card">';

        $content .= '<h3>
            <a href="/ilusalong/category?id=' . (int)$category['id'] . '">
                ' . htmlspecialchars($categoryName, ENT_QUOTES, 'UTF-8') . '
            </a>
        </h3>';

        $content .= '</article>';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';
