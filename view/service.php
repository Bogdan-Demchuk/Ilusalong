<?php

$isEt = ($_SESSION['lang'] ?? 'ru') === 'et';

$name = $isEt
    ? ($service['name_et'] ?? '')
    : ($service['name_ru'] ?? $service['name_et'] ?? '');

$description = $isEt
    ? ($service['description_et'] ?? '')
    : ($service['description_ru'] ?? $service['description_et'] ?? '');

$id = (int) $service['id'];

$content = '
<section class="service-detail-page">

    <a class="back-link" href="/ilusalong/services">
        ← ' . t('Все услуги', 'Kõik teenused') . '
    </a>

    <div class="service-detail-card">
        <span class="section-eyebrow">' . t('ILUSALONG / УСЛУГИ', 'ILUSALONG / TEENUSED') . '</span>

        <div class="service-detail-symbol">✿</div>

        <h2>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</h2>

        <p class="service-detail-description">' .
            htmlspecialchars($description, ENT_QUOTES, 'UTF-8') .
        '</p>

        <div class="service-detail-meta">
            <div>
                <small>' . t('СТОИМОСТЬ', 'HIND') . '</small>
                <strong>' . htmlspecialchars((string)$service['price'], ENT_QUOTES, 'UTF-8') . ' €</strong>
            </div>
            <div>
                <small>' . t('ПРОДОЛЖИТЕЛЬНОСТЬ', 'KESTUS') . '</small>
                <strong>' . htmlspecialchars((string)$service['duration'], ENT_QUOTES, 'UTF-8') . ' ' . t('мин.', 'min') . '</strong>
            </div>
        </div>

        <a class="button button-primary service-detail-button"
           href="/ilusalong/appointments?service_id=' . $id . '">
            ' . t('Записаться на эту услугу', 'Broneeri see teenus') . '
        </a>
    </div>
</section>
';

include 'view/layout.php';
