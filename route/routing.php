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
else {
    $response = Controller::error404();
}