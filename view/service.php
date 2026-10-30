<?php

$name = ($_SESSION['lang'] ?? 'ru') === 'et'
    ? ($service['name_et'] ?? '')
    : ($service['name_ru'] ?? $service['name_et'] ?? '');

$description = ($_SESSION['lang'] ?? 'ru') === 'et'
    ? ($service['description_et'] ?? '')
    : ($service['description_ru'] ?? $service['description_et'] ?? '');

$content = '<section class="service-page">';

$content .= '<h2>'
    . htmlspecialchars($name, ENT_QUOTES, 'UTF-8')
    . '</h2>';

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

$content .= '<p>
    <a href="/ilusalong/services">← '
    . t('Назад к услугам', 'Tagasi teenuste juurde')
    . '</a>
</p>';

$content .= '</section>';

include 'view/layout.php';