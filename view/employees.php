<?php

$content = '<section class="employees-page">';

$content .= '<h2>Meie töötajad</h2>';

if (empty($employees)) {
    $content .= '<p>Töötajaid ei leitud.</p>';
} else {
    $content .= '<div class="employees-list">';

    foreach ($employees as $employee) {
        $content .= '<article class="employee-card">';

        $employeeServices = Employees::getEmployeeServices($employee['id']);

        $content .= '<div class="employee-services">';
        $content .= '<h4>Teenused</h4>';

        if (empty($employeeServices)) {
            $content .= '<p>Teenused puuduvad.</p>';
        } else {
            $content .= '<ul>';

            foreach ($employeeServices as $service) {
                $content .= '<li>'
                    . htmlspecialchars($service['name_et'])
                    . '</li>';
            }

            $content .= '</ul>';
        }

        $content .= '</div>';
        if (!empty($employee['photo'])) {
            $content .= '<img class="employee-photo" src="/ilusalong/images/'
                . rawurlencode(basename($employee['photo']))
                . '" alt="'
                . htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name'])
                . '">';
        }

        $content .= '<h3>'
            . htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name'])
            . '</h3>';

        $content .= '<p class="employee-position">'
            . htmlspecialchars($employee['position'])
            . '</p>';

        $content .= '<p><strong>Email:</strong> '
            . htmlspecialchars($employee['email'])
            . '</p>';

        $content .= '<p><strong>Telefon:</strong> '
            . htmlspecialchars($employee['phone'])
            . '</p>';

        $content .= '</article>';
    }

    $content .= '</div>';
}

$content .= '</section>';

include 'view/layout.php';