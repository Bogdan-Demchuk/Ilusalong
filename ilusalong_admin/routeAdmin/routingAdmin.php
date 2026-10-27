<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/ilusalong/ilusalong_admin';

if (strpos($uri, $basePath) === 0) {
    $path = substr($uri, strlen($basePath));
} else {
    $path = $uri;
}

$path = trim($path, '/');

switch ($path) {
    case '':
    case 'index.php':
    case 'dashboard':
        $response = ControllerAdmin::startAdmin();
        break;

    case 'appointments':
        $response = ControllerAdminAppointments::index();
        break;

    case 'services/add':
    $response = ControllerAdminServices::add();
    break;

    case 'services/edit':
        $response = ControllerAdminServices::edit();
        break;

    case 'services/delete':
        $response = ControllerAdminServices::delete();
        break;

    case 'services':
        $response = ControllerAdminServices::index();
        break;

    case 'categories/add':
    $response = ControllerAdminCategory::add();
    break;

    case 'categories/edit':
        $response = ControllerAdminCategory::edit();
        break;

    case 'categories/delete':
        $response = ControllerAdminCategory::delete();
        break;
    
    case 'categories':
        $response = ControllerAdminCategory::index();
        break;

    case 'employees/add':
        $response = ControllerAdminEmployees::add();
        break;

    case 'employees/edit':
        $response = ControllerAdminEmployees::edit();
        break;

    case 'employees/delete':
        $response = ControllerAdminEmployees::delete();
        break;

    case 'employees':
        $response = ControllerAdminEmployees::index();
        break;

    case 'reviews':
        $response = ControllerAdminRevies::index();
        break;

    default:
        $response = ControllerAdmin::error404();
        break;
}