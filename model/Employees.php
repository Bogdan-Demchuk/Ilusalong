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

        $employeeId = (int)$employeeId;

        $query = "
            SELECT s.name_et
            FROM employee_services es
            JOIN services s ON es.service_id = s.id
            WHERE es.employee_id = $employeeId
            ORDER BY s.name_et
        ";

        return $db->getAll($query);
    }
}