<?php

class ModelAdminAppointments
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT
                appointments.id,
                appointments.user_id,
                appointments.employee_id,
                appointments.service_id,
                appointments.appointment_date,
                appointments.appointment_time,
                appointments.status,
                appointments.comment,
                CONCAT(users.first_name, " ", users.last_name) AS client_name,
                CONCAT(employees.first_name, " ", employees.last_name) AS employee_name,
                CONCAT(services.name_et, " / ", services.name_ru) AS service_name
            FROM appointments
            INNER JOIN users
                ON appointments.user_id = users.id
            INNER JOIN employees
                ON appointments.employee_id = employees.id
            INNER JOIN services
                ON appointments.service_id = services.id
            ORDER BY appointments.appointment_date DESC,
                     appointments.appointment_time DESC'
        );
    }

    public static function getById($id)
    {
        $db = new Database();

        return $db->getOne(
            'SELECT * FROM appointments WHERE id = ?',
            [$id]
        );
    }

    public static function getUsers()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT id, first_name, last_name, email
             FROM users
             ORDER BY first_name, last_name'
        );
    }

    public static function getEmployees()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT id, first_name, last_name
             FROM employees
             ORDER BY first_name, last_name'
        );
    }

    public static function getServices()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT id, name_et, name_ru, price, duration
             FROM services
             ORDER BY name_et'
        );
    }

    public static function add(
        $userId,
        $employeeId,
        $serviceId,
        $appointmentDate,
        $appointmentTime,
        $status,
        $comment
    ) {
        $db = new Database();

        return $db->executePrepared(
            'INSERT INTO appointments
                (user_id, employee_id, service_id, appointment_date,
                 appointment_time, status, comment)
             VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                $userId,
                $employeeId,
                $serviceId,
                $appointmentDate,
                $appointmentTime,
                $status,
                $comment
            ]
        );
    }

    public static function update(
        $id,
        $userId,
        $employeeId,
        $serviceId,
        $appointmentDate,
        $appointmentTime,
        $status,
        $comment
    ) {
        $db = new Database();

        return $db->executePrepared(
            'UPDATE appointments
             SET user_id = ?,
                 employee_id = ?,
                 service_id = ?,
                 appointment_date = ?,
                 appointment_time = ?,
                 status = ?,
                 comment = ?
             WHERE id = ?',
            [
                $userId,
                $employeeId,
                $serviceId,
                $appointmentDate,
                $appointmentTime,
                $status,
                $comment,
                $id
            ]
        );
    }

    public static function delete($id)
    {
        $db = new Database();

        return $db->executePrepared(
            'DELETE FROM appointments WHERE id = ?',
            [$id]
        );
    }
}