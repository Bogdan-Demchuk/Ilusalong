<?php

class Employees
{
    public static function getAllEmployees()
    {
        $db = new Database();

        $query = "SELECT * FROM employees";

        return $db->getAll($query);
    }
    public static function getEmployeeServices($employeeId)
    {
        $db = new Database();

        return $db->getAll(
            'SELECT
                services.id,
                services.name_et,
                services.name_ru
            FROM employee_services
            INNER JOIN services
                ON employee_services.service_id = services.id
            WHERE employee_services.employee_id = ?',
            [$employeeId]
        );
    }
}