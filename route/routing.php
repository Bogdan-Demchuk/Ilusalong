<?php

$host = explode('?', $_SERVER['REQUEST_URI'])[0];
$num = substr_count($host, '/');
$path = explode('/', $host)[$num];

if ($path == '' || $path == 'index' || $path == 'index.php') {
    $response = Controller::StartSite();
}
elseif ($path == 'services') {
    $response = Controller::Services();
}
elseif ($path == 'service' && isset($_GET['id'])) {
    $response = Controller::Service($_GET['id']);
}
else {
    $response = Controller::error404();
}