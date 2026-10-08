<?php

$content = '<section class="categories-page">';

$content .= '<h2>Kategooriad</h2>';

if (empty($categories)) {

    $content .= '<p>Kategooriaid ei leitud.</p>';

} else {

    $content .= '<div class="categories-list">';

    foreach ($categories as $category) {

        $content .= '<article class="category-card">';

        $content .= '<h3>
            <a href="/ilusalong/category?id=' . (int)$category['id'] . '">
                ' . htmlspecialchars($category['name_et']) . '
            </a>
        </h3>';

        $content .= '</article>';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';