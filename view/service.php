<?php

$content = '<section class="service-page">';

$content .= '<h2>' . htmlspecialchars($service['name_et']) . '</h2>';

$content .= '<p>'
    . htmlspecialchars($service['description_et'])
    . '</p>';

$content .= '<p><strong>Hind:</strong> '
    . htmlspecialchars($service['price'])
    . ' €</p>';

$content .= '<p><strong>Kestus:</strong> '
    . htmlspecialchars($service['duration'])
    . ' min</p>';

$content .= '<p>
    <a href="/ilusalong/services">← Tagasi teenuste juurde</a>
</p>';

$content .= '</section>';

include 'view/layout.php';