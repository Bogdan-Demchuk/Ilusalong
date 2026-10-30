<?php

class ControllerAdminAppointments
{
    private static function checkAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        if (!Auth::isAdmin()) {
            http_response_code(403);
            exit('403 — Juurdepääs keelatud');
        }
    }

    private static function render($view, $data = [])
    {
        extract($data, EXTR_SKIP);

        ob_start();
        include __DIR__ . '/../viewAdmin/' . $view;
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';

        return ob_get_clean();
    }

    private static function getFormData()
    {
        return [
            'user_id' => trim((string) ($_POST['user_id'] ?? '')),
            'employee_id' => trim((string) ($_POST['employee_id'] ?? '')),
            'service_id' => trim((string) ($_POST['service_id'] ?? '')),
            'appointment_date' => trim((string) ($_POST['appointment_date'] ?? '')),
            'appointment_time' => trim((string) ($_POST['appointment_time'] ?? '')),
            'status' => trim((string) ($_POST['status'] ?? 'pending')),
            'comment' => trim((string) ($_POST['comment'] ?? ''))
        ];
    }

    private static function validate($appointment, $users, $employees, $services)
    {
        if (
            !ctype_digit($appointment['user_id']) ||
            !ctype_digit($appointment['employee_id']) ||
            !ctype_digit($appointment['service_id'])
        ) {
            return 'Palun vali klient, töötaja ja teenus.';
        }

        $userExists = false;
        foreach ($users as $user) {
            if ((int) $user['id'] === (int) $appointment['user_id']) {
                $userExists = true;
                break;
            }
        }

        $employeeExists = false;
        foreach ($employees as $employee) {
            if ((int) $employee['id'] === (int) $appointment['employee_id']) {
                $employeeExists = true;
                break;
            }
        }

        $serviceExists = false;
        foreach ($services as $service) {
            if ((int) $service['id'] === (int) $appointment['service_id']) {
                $serviceExists = true;
                break;
            }
        }

        if (!$userExists || !$employeeExists || !$serviceExists) {
            return 'Valitud klient, töötaja või teenus ei ole korrektne.';
        }

        $date = DateTime::createFromFormat('!Y-m-d', $appointment['appointment_date']);
        if (
            !$date ||
            $date->format('Y-m-d') !== $appointment['appointment_date']
        ) {
            return 'Palun sisesta korrektne kuupäev.';
        }

        $time = DateTime::createFromFormat('!H:i', $appointment['appointment_time']);
        if (
            !$time ||
            $time->format('H:i') !== $appointment['appointment_time']
        ) {
            return 'Palun sisesta korrektne kellaaeg.';
        }

        if ($appointment['status'] === '') {
            return 'Palun sisesta broneeringu staatus.';
        }

        return '';
    }

    public static function index()
    {
        self::checkAdmin();

        $appointments = ModelAdminAppointments::getAll();

        return self::render('appointmentsList.php', [
            'appointments' => $appointments
        ]);
    }

    public static function add()
    {
        self::checkAdmin();

        $users = ModelAdminAppointments::getUsers();
        $employees = ModelAdminAppointments::getEmployees();
        $services = ModelAdminAppointments::getServices();

        $appointment = [
            'user_id' => '',
            'employee_id' => '',
            'service_id' => '',
            'appointment_date' => '',
            'appointment_time' => '',
            'status' => 'pending',
            'comment' => ''
        ];

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment = self::getFormData();

            $error = self::validate(
                $appointment,
                $users,
                $employees,
                $services
            );

            if ($error === '') {
                try {
                    ModelAdminAppointments::add(
                        (int) $appointment['user_id'],
                        (int) $appointment['employee_id'],
                        (int) $appointment['service_id'],
                        $appointment['appointment_date'],
                        $appointment['appointment_time'],
                        $appointment['status'],
                        $appointment['comment']
                    );

                    header('Location: /ilusalong/ilusalong_admin/appointments');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Broneeringu salvestamine ebaõnnestus. Kontrolli sisestatud andmeid.';
                }
            }
        }

        return self::render('appointmentsAddForm.php', [
            'appointment' => $appointment,
            'users' => $users,
            'employees' => $employees,
            'services' => $services,
            'error' => $error
        ]);
    }

    public static function edit()
    {
        self::checkAdmin();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            header('Location: /ilusalong/ilusalong_admin/appointments');
            exit;
        }

        $appointment = ModelAdminAppointments::getById($id);

        if (!$appointment) {
            http_response_code(404);
            return '<h2>Broneeringut ei leitud</h2>';
        }

        $users = ModelAdminAppointments::getUsers();
        $employees = ModelAdminAppointments::getEmployees();
        $services = ModelAdminAppointments::getServices();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updatedAppointment = self::getFormData();

            $error = self::validate(
                $updatedAppointment,
                $users,
                $employees,
                $services
            );

            if ($error === '') {
                try {
                    ModelAdminAppointments::update(
                        $id,
                        (int) $updatedAppointment['user_id'],
                        (int) $updatedAppointment['employee_id'],
                        (int) $updatedAppointment['service_id'],
                        $updatedAppointment['appointment_date'],
                        $updatedAppointment['appointment_time'],
                        $updatedAppointment['status'],
                        $updatedAppointment['comment']
                    );

                    header('Location: /ilusalong/ilusalong_admin/appointments');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Broneeringu muutmine ebaõnnestus. Kontrolli sisestatud andmeid.';
                }
            }

            $appointment = array_merge($appointment, $updatedAppointment);
        }

        return self::render('appointmentsEditForm.php', [
            'appointment' => $appointment,
            'users' => $users,
            'employees' => $employees,
            'services' => $services,
            'error' => $error
        ]);
    }

    public static function delete()
    {
        self::checkAdmin();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            header('Location: /ilusalong/ilusalong_admin/appointments');
            exit;
        }

        $appointment = ModelAdminAppointments::getById($id);

        if (!$appointment) {
            http_response_code(404);
            return '<h2>Broneeringut ei leitud</h2>';
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                ModelAdminAppointments::delete($id);

                header('Location: /ilusalong/ilusalong_admin/appointments');
                exit;
            } catch (PDOException $e) {
                $error = 'Broneeringut ei saa kustutada.';
            }
        }

        return self::render('appointmentsDeleteForm.php', [
            'appointment' => $appointment,
            'error' => $error
        ]);
    }
}