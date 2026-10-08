<?php

class Controller
{
    public static function StartSite()
    {
        include_once 'view/start.php';
    }

    public static function Services()
    {
        $services = Services::getAllServices();

        include_once 'view/services.php';
    }

    public static function error404()
    {
        include_once 'view/error404.php';
    }
}