<?php

class Appointments
{
    public static function getAllAppointments()
    {
        $db = new Database();

        $query = "
            SELECT
                appointments.*,
                services.name_et,
                employees.first_name,
                employees.last_name,
                users.first_name AS user_first_name,
                users.last_name AS user_last_name
            FROM appointments
            JOIN services
                ON appointments.service_id = services.id
            JOIN employees
                ON appointments.employee_id = employees.id
            JOIN users
                ON appointments.user_id = users.id
            ORDER BY
                appointments.appointment_date,
                appointments.appointment_time
        ";

        return $db->getAll($query);
    }

    public static function getAppointmentsByUser($userId)
    {
        $db = new Database();

        $query = "
            SELECT
                appointments.*,
                services.name_et,
                employees.first_name,
                employees.last_name
            FROM appointments
            JOIN services
                ON appointments.service_id = services.id
            JOIN employees
                ON appointments.employee_id = employees.id
            WHERE appointments.user_id = ?
            ORDER BY
                appointments.appointment_date DESC,
                appointments.appointment_time DESC
        ";

        return $db->getAll($query, [(int)$userId]);
    }
}