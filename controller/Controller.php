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
    public static function Categories()
    {
        $categories = Category::getAllCategory();

        include_once 'view/category.php';
    }
    public static function Employees()
    {
        $employees = Employees::getAllEmployees();

        include_once 'view/employees.php';
    }
    public static function ServicesByCategory($id)
    {
        $services = Services::getServicesByCategory($id);

        include_once 'view/services.php';
    }
    public static function Service($id)
    {
        $service = Services::getServiceById($id);

        if (!$service) {
            return self::error404();
        }

        include_once 'view/service.php';
    }
    public static function error404()
    {
        include_once 'view/error404.php';
    }
}