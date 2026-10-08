<?php

$content = '<section class="services-page">';

$content .= '<h2>Teenused</h2>';

if (empty($services)) {

    $content .= '<p>Teenuseid ei leitud.</p>';

} else {

    $content .= '<div class="services-list">';

    foreach ($services as $service) {

        $content .= '<article class="service-card">';

        $content .= '<h3>' . htmlspecialchars($service['name_et']) . '</h3>';

        $content .= '<p>'
            . htmlspecialchars($service['description_et'])
            . '</p>';

        $content .= '<p><strong>Hind:</strong> '
            . htmlspecialchars($service['price'])
            . ' €</p>';

        $content .= '<p><strong>Kestus:</strong> '
            . htmlspecialchars($service['duration'])
            . ' min</p>';

        $content .= '</article>';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';