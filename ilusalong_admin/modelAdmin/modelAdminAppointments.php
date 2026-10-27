<?php

class ModelAdminAppointments
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT
                appointments.id,
                CONCAT(users.first_name, " ", users.last_name) AS client_name,
                CONCAT(employees.first_name, " ", employees.last_name) AS employee_name,
                CONCAT(services.name_et, " | ", services.name_ru) AS service_name,
                appointments.appointment_date,
                appointments.appointment_time,
                appointments.status,
                appointments.comment
            FROM appointments
            INNER JOIN users
                ON appointments.user_id = users.id
            INNER JOIN employees
                ON appointments.employee_id = employees.id
            INNER JOIN services
                ON appointments.service_id = services.id
            ORDER BY appointments.id ASC'
        );
    }
}