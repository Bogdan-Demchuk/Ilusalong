<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($uri, '/');

$path = preg_replace(
    '#^ilusalong_admin/?#',
    '',
    $path
);

$path = trim($path, '/');

switch ($path) {
    case '':
    case 'dashboard':
        $response = ControllerAdmin::startAdmin();
        break;

    default:
        http_response_code(404);
        $response = ControllerAdmin::error404();
        break;
}