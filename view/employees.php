<?php

$content = '<section class="employees-page">';

$content .= '<h2>' . t('Наши сотрудники', 'Meie töötajad') . '</h2>';

if (empty($employees)) {

    $content .= '<p>' . t('Сотрудники не найдены.', 'Töötajaid ei leitud.') . '</p>';

} else {

    $content .= '<div class="employees-list">';

    foreach ($employees as $employee) {

        $content .= '<article class="employee-card">';

        $employeeServices = Employees::getEmployeeServices($employee['id']);

        $content .= '<div class="employee-services">';
        $content .= '<h4>' . t('Услуги', 'Teenused') . '</h4>';

        if (empty($employeeServices)) {

            $content .= '<p>' . t('Услуги отсутствуют.', 'Teenused puuduvad.') . '</p>';

        } else {

            $content .= '<ul>';

            foreach ($employeeServices as $service) {

                $serviceName = ($_SESSION['lang'] ?? 'ru') === 'et'
                    ? $service['name_et']
                    : $service['name_ru'];

                $content .= '<li>'
                    . htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8')
                    . '</li>';
            }

            $content .= '</ul>';
        }

        $content .= '</div>';

        if (!empty($employee['photo'])) {

            $content .= '<img class="employee-photo" src="/ilusalong/images/'
                . rawurlencode(basename($employee['photo']))
                . '" alt="'
                . htmlspecialchars(
                    $employee['first_name'] . ' ' . $employee['last_name'],
                    ENT_QUOTES,
                    'UTF-8'
                )
                . '">';
        }

        $content .= '<h3>'
            . htmlspecialchars(
                $employee['first_name'] . ' ' . $employee['last_name'],
                ENT_QUOTES,
                'UTF-8'
            )
            . '</h3>';

        $positionTranslations = [
            'Juuksur' => 'Парикмахер',
            'Kosmeetik' => 'Косметолог',
            'Maniküürija' => 'Мастер маникюра',
            'Meikar' => 'Визажист',
            'Massöör' => 'Массажист'
        ];

        $position = $employee['position'];

        if (($_SESSION['lang'] ?? 'ru') === 'ru') {
            $position = $positionTranslations[$position] ?? $position;
        }

        $content .= '<p class="employee-position">'
            . htmlspecialchars($position, ENT_QUOTES, 'UTF-8')
            . '</p>';
            
        $content .= '<p><strong>Email:</strong> '
            . htmlspecialchars($employee['email'], ENT_QUOTES, 'UTF-8')
            . '</p>';

        $content .= '<p><strong>'
            . t('Телефон', 'Telefon')
            . ':</strong> '
            . htmlspecialchars($employee['phone'], ENT_QUOTES, 'UTF-8')
            . '</p>';

        $content .= '</article>';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';