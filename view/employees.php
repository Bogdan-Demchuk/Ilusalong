<?php

$content = '
<section class="catalog-page">

    <div class="catalog-heading">
        <span class="section-eyebrow">' . t('НАША КОМАНДА', 'MEIE MEESKOND') . '</span>
        <h2>' . t('Наши мастера', 'Meie meistrid') . '</h2>
        <p>' . t('Профессионалы, которым можно доверить свою красоту.', 'Professionaalid, kelle hoolde saad usaldada oma ilu.') . '</p>
    </div>
';

if (empty($employees)) {
    $content .= '<p class="empty-message">' . t('Сотрудники не найдены.', 'Töötajaid ei leitud.') . '</p>';
} else {
    $content .= '<div class="employee-grid">';

    $employeePhotos = [
        1 => 'kadriorg.jpg',
        2 => 'marina.jpg',
        3 => 'liis.jpg',
        4 => 'anna.jpg',
        5 => 'kristina.jpg'
    ];

    foreach ($employees as $employee) {
        $employeeId = (int) $employee['id'];
        $employeeServices = Employees::getEmployeeServices($employeeId);

        $fullName = $employee['first_name'] . ' ' . $employee['last_name'];

        $positionTranslations = [
            'Juuksur' => 'Парикмахер',
            'Kosmeetik' => 'Косметолог',
            'Maniküürija' => 'Мастер маникюра',
            'Meikar' => 'Визажист',
            'Massöör' => 'Массажист'
        ];

        $position = $employee['position'] ?? '';

        if (($_SESSION['lang'] ?? 'ru') === 'ru') {
            $position = $positionTranslations[$position] ?? $position;
        }

        $photoFile = $employeePhotos[$employeeId] ?? '';

        if (!empty($employee['photo'])) {
            $photoFile = basename($employee['photo']);
        }

        if ($photoFile !== '') {
            $photo = '<img class="employee-photo"
                src="/ilusalong/public/images/employees/' .
                rawurlencode($photoFile) .
                '"
                alt="' . htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') . '"
                loading="lazy">';
        } else {
            $photo = '<div class="employee-photo-placeholder">✿</div>';
        }

        $content .= '
            <article class="employee-card">

                <div class="employee-photo-wrap">
                    ' . $photo . '
                </div>

                <div class="employee-card-content">

                    <span class="section-eyebrow">' .
                        t('НАШ СПЕЦИАЛИСТ', 'MEIE SPETSIALIST') .
                    '</span>

                    <h3>' . htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') . '</h3>

                    <p class="employee-position">' .
                        htmlspecialchars($position, ENT_QUOTES, 'UTF-8') .
                    '</p>

                    <div class="employee-services">
                        <h4>' . t('Специализация', 'Spetsialiseerumine') . '</h4>
        ';

        if (empty($employeeServices)) {
            $content .= '<p>' . t('Информация пока отсутствует.', 'Info puudub.') . '</p>';
        } else {
            $content .= '<div class="employee-service-tags">';

            foreach ($employeeServices as $service) {
                $serviceName = ($_SESSION['lang'] ?? 'ru') === 'et'
                    ? ($service['name_et'] ?? '')
                    : ($service['name_ru'] ?? $service['name_et'] ?? '');

                $serviceId = (int) $service['id'];

                $content .= '
                    <a href="/ilusalong/appointments?service_id=' . $serviceId . '&employee_id=' . $employeeId . '">
                        ' . htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8') . '
                    </a>
                ';
            }

            $content .= '</div>';
        }

        $content .= '
                    </div>

                    <div class="employee-contact">
                        <p>' . t('Телефон', 'Telefon') . ': ' .
                            htmlspecialchars($employee['phone'] ?? '', ENT_QUOTES, 'UTF-8') .
                        '</p>
                    </div>

                    <a class="button button-primary employee-book-button"
                       href="/ilusalong/appointments?employee_id=' . $employeeId . '">
                        ' . t('Записаться к мастеру', 'Broneeri aeg meistri juurde') . '
                    </a>

                </div>
            </article>
        ';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';
