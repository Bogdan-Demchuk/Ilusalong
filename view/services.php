<?php

$content = '<section class="catalog-page">';

$content .= '
    <div class="catalog-heading">
        <span class="section-eyebrow">' . t('ЗАБОТА О СЕБЕ', 'HOOLITSE ENDA EEST') . '</span>
        <h2>' . t('Наши услуги', 'Meie teenused') . '</h2>
        <p>' . t('Выберите процедуру и доверьте свою красоту профессионалам.', 'Vali protseduur ja usalda oma ilu professionaalidele.') . '</p>
    </div>
';

if (empty($services)) {
    $content .= '<p class="empty-message">' . t('Услуги пока не добавлены.', 'Teenuseid pole veel lisatud.') . '</p>';
} else {
    $content .= '<div class="service-grid">';

    foreach ($services as $service) {
        $isEt = ($_SESSION['lang'] ?? 'ru') === 'et';

        $name = $isEt
            ? ($service['name_et'] ?? '')
            : ($service['name_ru'] ?? $service['name_et'] ?? '');

        $description = $isEt
            ? ($service['description_et'] ?? '')
            : ($service['description_ru'] ?? $service['description_et'] ?? '');

        $id = (int) $service['id'];

        $content .= '
            <article class="service-card">
                <div class="service-card-top">
                    <span class="service-number">ILU / ' . str_pad((string)$id, 2, '0', STR_PAD_LEFT) . '</span>
                    <span class="service-symbol">✿</span>
                </div>

                <h3>' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</h3>

                <p class="service-description">' .
                    htmlspecialchars($description, ENT_QUOTES, 'UTF-8') .
                '</p>

                <div class="service-meta">
                    <span>
                        <small>' . t('СТОИМОСТЬ', 'HIND') . '</small>
                        <strong>' . htmlspecialchars((string)$service['price'], ENT_QUOTES, 'UTF-8') . ' €</strong>
                    </span>
                    <span>
                        <small>' . t('ВРЕМЯ', 'KESTUS') . '</small>
                        <strong>' . htmlspecialchars((string)$service['duration'], ENT_QUOTES, 'UTF-8') . ' ' . t('мин.', 'min') . '</strong>
                    </span>
                </div>

                <div class="service-actions">
                    <a class="button button-outline" href="/ilusalong/service?id=' . $id . '">
                        ' . t('Подробнее', 'Loe lähemalt') . '
                    </a>
                    <a class="button button-primary" href="/ilusalong/appointments?service_id=' . $id . '">
                        ' . t('Записаться', 'Broneeri') . '
                    </a>
                </div>
            </article>
        ';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';