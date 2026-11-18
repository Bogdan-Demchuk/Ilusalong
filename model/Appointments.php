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
                services.name_ru,
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
    public static function createAppointment(
        $userId,
        $employeeId,
        $serviceId,
        $date,
        $time,
        $comment
    ) {
        $db = new Database();

        $db->beginTransaction();

        try {
            if (!self::lockAndCheckAvailability(
                $db,
                $employeeId,
                $serviceId,
                $date,
                $time
            )) {
                $db->rollBack();
                return false;
            }

            $query = "
                INSERT INTO appointments
                    (user_id, employee_id, service_id,
                    appointment_date, appointment_time, status, comment)
                VALUES (?, ?, ?, ?, ?, 'pending', ?)
            ";

            $created = $db->executePrepared($query, [
                (int)$userId,
                (int)$employeeId,
                (int)$serviceId,
                $date,
                $time,
                $comment
            ]);

            $db->commit();

            return $created;
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function lockAndCheckAvailability(
        $db,
        $employeeId,
        $serviceId,
        $date,
        $time,
        $excludeAppointmentId = null
    ) {
        $employee = $db->getOne(
            'SELECT id FROM employees WHERE id = ? FOR UPDATE',
            [(int) $employeeId]
        );

        if (!$employee) {
            return false;
        }

        $query = "
            SELECT appointments.id
            FROM appointments
            INNER JOIN services AS booked_service
                ON appointments.service_id = booked_service.id
            INNER JOIN services AS requested_service
                ON requested_service.id = ?
            WHERE appointments.employee_id = ?
                AND appointments.appointment_date = ?
                AND appointments.status IN ('pending', 'confirmed')
                AND TIME_TO_SEC(appointments.appointment_time)
                    < TIME_TO_SEC(?) + requested_service.duration * 60
                AND TIME_TO_SEC(appointments.appointment_time)
                    + booked_service.duration * 60 > TIME_TO_SEC(?)
        ";

        $params = [
            (int) $serviceId,
            (int) $employeeId,
            $date,
            $time,
            $time
        ];

        if ($excludeAppointmentId !== null) {
            $query .= ' AND appointments.id <> ?';
            $params[] = (int) $excludeAppointmentId;
        }

        $query .= ' LIMIT 1';

        return !$db->getOne($query, $params);
    }
    public static function cancelAppointment($appointmentId, $userId)
    {
        $db = new Database();

        $query = "
            UPDATE appointments
            SET status = 'cancelled'
            WHERE id = ?
            AND user_id = ?
            AND status IN ('pending', 'confirmed')
        ";

        return $db->executePrepared($query, [
            (int) $appointmentId,
            (int) $userId
        ]);
    }
}