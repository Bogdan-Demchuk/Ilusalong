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
        $excludeAppointmentId = null,
        $enforceBusinessHours = true
    ) {
        $employee = $db->getOne(
            'SELECT id FROM employees WHERE id = ? FOR UPDATE',
            [(int) $employeeId]
        );

        if (!$employee) {
            return false;
        }

        $service = $db->getOne(
            'SELECT duration FROM services WHERE id = ?',
            [(int) $serviceId]
        );
        $startSeconds = self::timeToSeconds($time);

        if (
            !$service ||
            (int) $service['duration'] < 1 ||
            $startSeconds === null
        ) {
            return false;
        }

        if ($enforceBusinessHours) {
            $businessHours = self::getBusinessHours($date);

            if (
                !$businessHours ||
                $startSeconds < $businessHours[0] ||
                $startSeconds + (int) $service['duration'] * 60 > $businessHours[1] ||
                ($startSeconds - $businessHours[0]) % (15 * 60) !== 0 ||
                $date < date('Y-m-d') ||
                (
                    $date === date('Y-m-d') &&
                    $startSeconds <= self::timeToSeconds(date('H:i'))
                )
            ) {
                return false;
            }
        }

        $bookedAppointments = self::getBookedAppointments(
            $db,
            $employeeId,
            $date,
            $excludeAppointmentId
        );

        return !self::hasOverlappingAppointment(
            $bookedAppointments,
            $startSeconds,
            (int) $service['duration'] * 60
        );
    }

    public static function getAvailableTimeSlots($employeeId, $serviceId, $date)
    {
        $businessHours = self::getBusinessHours($date);

        if (!$businessHours) {
            return [];
        }

        $db = new Database();
        $service = $db->getOne(
            'SELECT duration FROM services WHERE id = ?',
            [(int) $serviceId]
        );

        if (!$service || (int) $service['duration'] < 1) {
            return [];
        }

        $durationSeconds = (int) $service['duration'] * 60;
        $bookedAppointments = self::getBookedAppointments(
            $db,
            $employeeId,
            $date
        );
        $nowSeconds = self::timeToSeconds(date('H:i'));
        $slots = [];

        for (
            $startSeconds = $businessHours[0];
            $startSeconds + $durationSeconds <= $businessHours[1];
            $startSeconds += 15 * 60
        ) {
            $available = !(
                $date < date('Y-m-d') ||
                (
                    $date === date('Y-m-d') &&
                    $startSeconds <= $nowSeconds
                ) ||
                self::hasOverlappingAppointment(
                    $bookedAppointments,
                    $startSeconds,
                    $durationSeconds
                )
            );

            $slots[] = [
                'time' => gmdate('H:i', $startSeconds),
                'available' => $available
            ];
        }

        return $slots;
    }

    private static function getBusinessHours($date)
    {
        if (!is_string($date)) {
            return null;
        }

        $dateValue = DateTime::createFromFormat('!Y-m-d', $date);

        if (!$dateValue || $dateValue->format('Y-m-d') !== $date) {
            return null;
        }

        switch ((int) $dateValue->format('N')) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                return [9 * 60 * 60, 18 * 60 * 60];

            case 6:
                return [12 * 60 * 60, 17 * 60 * 60];

            default:
                return null;
        }
    }

    private static function timeToSeconds($time)
    {
        if (!is_string($time)) {
            return null;
        }

        $timeValue = DateTime::createFromFormat('!H:i', $time);

        if (!$timeValue || $timeValue->format('H:i') !== $time) {
            return null;
        }

        return ((int) $timeValue->format('H') * 60 + (int) $timeValue->format('i')) * 60;
    }

    private static function getBookedAppointments(
        $db,
        $employeeId,
        $date,
        $excludeAppointmentId = null
    ) {
        $query = "
            SELECT
                TIME_TO_SEC(appointments.appointment_time) AS start_seconds,
                services.duration
            FROM appointments
            INNER JOIN services
                ON appointments.service_id = services.id
            WHERE appointments.employee_id = ?
                AND appointments.appointment_date = ?
                AND appointments.status IN ('pending', 'confirmed')
        ";

        $params = [(int) $employeeId, $date];

        if ($excludeAppointmentId !== null) {
            $query .= ' AND appointments.id <> ?';
            $params[] = (int) $excludeAppointmentId;
        }

        return $db->getAll($query, $params);
    }

    private static function hasOverlappingAppointment(
        $appointments,
        $startSeconds,
        $durationSeconds
    ) {
        $endSeconds = $startSeconds + $durationSeconds;

        foreach ($appointments as $appointment) {
            $bookedStart = (int) $appointment['start_seconds'];
            $bookedEnd = $bookedStart + (int) $appointment['duration'] * 60;

            if ($startSeconds < $bookedEnd && $endSeconds > $bookedStart) {
                return true;
            }
        }

        return false;
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