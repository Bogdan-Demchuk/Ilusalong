<?php

class Employees
{
    public static function getAllEmployees()
    {
        $db = new Database();

        return $db->getAll("SELECT * FROM employees");
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
            [(int)$employeeId]
        );
    }

    public static function canPerformService($employeeId, $serviceId)
    {
        $db = new Database();

        $result = $db->getOne(
            'SELECT id
             FROM employee_services
             WHERE employee_id = ?
             AND service_id = ?',
            [(int)$employeeId, (int)$serviceId]
        );

        return !empty($result);
    }
}
