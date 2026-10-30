<?php

$content = '<section class="services-page">';

$content .= '<h2>' . t('Услуги', 'Teenused') . '</h2>';

if (empty($services)) {

    $content .= '<p>' . t('Услуги не найдены.', 'Teenuseid ei leitud.') . '</p>';

} else {

    $content .= '<div class="services-list">';

    foreach ($services as $service) {

        $name = ($_SESSION['lang'] ?? 'ru') === 'et'
            ? ($service['name_et'] ?? '')
            : ($service['name_ru'] ?? $service['name_et'] ?? '');

        $description = ($_SESSION['lang'] ?? 'ru') === 'et'
            ? ($service['description_et'] ?? '')
            : ($service['description_ru'] ?? $service['description_et'] ?? '');

        $content .= '<article class="service-card">';

        $content .= '<h3>
            <a href="/ilusalong/service?id=' . (int)$service['id'] . '">
                ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '
            </a>
        </h3>';

        $content .= '<p>'
            . htmlspecialchars($description, ENT_QUOTES, 'UTF-8')
            . '</p>';

        $content .= '<p><strong>'
            . t('Цена', 'Hind')
            . ':</strong> '
            . htmlspecialchars((string)$service['price'], ENT_QUOTES, 'UTF-8')
            . ' €</p>';

        $content .= '<p><strong>'
            . t('Продолжительность', 'Kestus')
            . ':</strong> '
            . htmlspecialchars((string)$service['duration'], ENT_QUOTES, 'UTF-8')
            . ' min</p>';

        $content .= '</article>';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';