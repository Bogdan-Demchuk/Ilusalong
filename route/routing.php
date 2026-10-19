<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($uri, '/');

$path = preg_replace('#^ilusalong/?#', '', $path);
$path = trim($path, '/');

if ($path === '' || $path === 'index' || $path === 'index.php') {
    $response = Controller::StartSite();
}
elseif ($path === 'services') {
    $response = Controller::Services();
}
elseif ($path === 'service' && isset($_GET['id'])) {
    $response = Controller::Service($_GET['id']);
}
elseif ($path === 'category' && isset($_GET['id'])) {
    $response = Controller::ServicesByCategory($_GET['id']);
}
elseif ($path === 'category') {
    $response = Controller::Categories();
}
elseif ($path === 'employees') {
    $response = Controller::Employees();
}
elseif ($path === 'appointments') {
    $response = Controller::Appointments();
}
elseif ($path === 'login') {
    $response = Controller::Login();
}
elseif ($path === 'register') {
    $response = Controller::Register();
}
elseif ($path === 'logout') {
    $response = Controller::Logout();
}
else {
    $response = Controller::error404();
}