<?php

class ControllerAdminEmployees
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

    public static function index()
    {
        self::checkAdmin();

        $employees = ModelAdminEmployees::getAll();

        ob_start();
        include __DIR__ . '/../viewAdmin/employeesList.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }

    public static function add()
    {
        self::checkAdmin();

        $employee = [
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
            'email' => '',
            'position' => '',
            'photo' => ''
        ];

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employee = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'position' => trim($_POST['position'] ?? ''),
                'photo' => trim($_POST['photo'] ?? '')
            ];

            if (
                $employee['first_name'] !== '' &&
                $employee['last_name'] !== '' &&
                filter_var($employee['email'], FILTER_VALIDATE_EMAIL)
            ) {
                ModelAdminEmployees::add(
                    $employee['first_name'],
                    $employee['last_name'],
                    $employee['phone'],
                    $employee['email'],
                    $employee['position'],
                    $employee['photo']
                );

                header('Location: /ilusalong/ilusalong_admin/employees');
                exit;
            }

            $error = 'Palun sisesta ees- ja perekonnanimi ning korrektne e-posti aadress.';
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/employeesAddForm.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }

    public static function edit()
    {
        self::checkAdmin();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /ilusalong/ilusalong_admin/employees');
            exit;
        }

        $employee = ModelAdminEmployees::getById($id);

        if (!$employee) {
            http_response_code(404);
            return 'Töötajat ei leitud.';
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updatedEmployee = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'position' => trim($_POST['position'] ?? ''),
                'photo' => trim($_POST['photo'] ?? '')
            ];

            if (
                $updatedEmployee['first_name'] !== '' &&
                $updatedEmployee['last_name'] !== '' &&
                filter_var($updatedEmployee['email'], FILTER_VALIDATE_EMAIL)
            ) {
                ModelAdminEmployees::update(
                    $id,
                    $updatedEmployee['first_name'],
                    $updatedEmployee['last_name'],
                    $updatedEmployee['phone'],
                    $updatedEmployee['email'],
                    $updatedEmployee['position'],
                    $updatedEmployee['photo']
                );

                header('Location: /ilusalong/ilusalong_admin/employees');
                exit;
            }

            $error = 'Palun sisesta ees- ja perekonnanimi ning korrektne e-posti aadress.';
            $employee = array_merge($employee, $updatedEmployee);
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/employeesEditForm.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }

    public static function delete()
    {
        self::checkAdmin();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /ilusalong/ilusalong_admin/employees');
            exit;
        }

        $employee = ModelAdminEmployees::getById($id);

        if (!$employee) {
            http_response_code(404);
            return 'Töötajat ei leitud.';
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                ModelAdminEmployees::delete($id);

                header('Location: /ilusalong/ilusalong_admin/employees');
                exit;
            } catch (PDOException $e) {
                $error = 'Töötajat ei saa kustutada, sest temaga võivad olla seotud broneeringud või teenused.';
            }
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/employeesDeleteForm.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }
}