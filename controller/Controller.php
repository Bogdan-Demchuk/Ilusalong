<?php

class Controller
{
    public static function StartSite()
    {
        include_once 'view/start.php';
    }

    public static function Services()
    {
        $services = Services::getAllServices();

        include_once 'view/services.php';
    }
    public static function Categories()
    {
        $categories = Category::getAllCategory();

        include_once 'view/category.php';
    }
    public static function Employees()
    {
        $employees = Employees::getAllEmployees();

        include_once 'view/employees.php';
    }
    public static function ServicesByCategory($id)
    {
        $services = Services::getServicesByCategory($id);

        include_once 'view/services.php';
    }
    public static function Service($id)
    {
        $service = Services::getServiceById($id);

        if (!$service) {
            return self::error404();
        }

        include_once 'view/service.php';
    }
    
    public static function Appointments()
    {
        $requestedServiceId = filter_input(INPUT_GET, 'service_id', FILTER_VALIDATE_INT);
        $selectedServiceId = $requestedServiceId && $requestedServiceId > 0
            ? (int) $requestedServiceId
            : null;
        $selectedEmployeeId = null;
        $selectedDate = '';
        $selectedTime = '';

        if (!isset($_SESSION['user_id'])) {
            unset($_SESSION['redirect_after_login']);

            if ($selectedServiceId !== null) {
                $_SESSION['redirect_after_login'] =
                    '/ilusalong/appointments?service_id=' . $selectedServiceId;
            }

            header('Location: /ilusalong/login');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceId = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
            $employeeId = filter_input(INPUT_POST, 'employee_id', FILTER_VALIDATE_INT);
            $selectedServiceId = $serviceId && $serviceId > 0
                ? (int) $serviceId
                : null;
            $selectedEmployeeId = $employeeId && $employeeId > 0
                ? (int) $employeeId
                : null;
            $date = $_POST['appointment_date'] ?? '';
            $time = $_POST['appointment_time'] ?? '';
            $selectedDate = is_string($date) ? $date : '';
            $selectedTime = is_string($time) ? $time : '';
            $comment = trim($_POST['comment'] ?? '');

            if (!$serviceId || !$employeeId || $date === '' || $time === '') {
                $error = 'Palun täida kõik kohustuslikud väljad.';
            } elseif ($date < date('Y-m-d')) {
                $error = 'Kuupäev ei saa olla minevikus.';
            } elseif (!Employees::canPerformService($employeeId, $serviceId)) {
                $error = 'Valitud meister ei paku seda teenust.';
            } else {
                try {
                    $result = Appointments::createAppointment(
                        (int) $_SESSION['user_id'],
                        $employeeId,
                        $serviceId,
                        $date,
                        $time,
                        $comment
                    );

                    if ($result) {
                        header('Location: /ilusalong/appointments?booked=1');
                        exit;
                    }

                    $error = 'Valitud aeg pole saadaval. Palun vali teine aeg.';
                } catch (PDOException $e) {
                    $error = 'Broneerimine ebaõnnestus. Kontrolli andmeid ja proovi uuesti.';
                }
            }
        }

        if (isset($_GET['booked']) && $_GET['booked'] === '1') {
            $success = 'Aeg on edukalt broneeritud!';
        }

        $services = Services::getAllServices();
        $employees = Employees::getAllEmployees();

        $employeeServices = [];

        foreach ($employees as $employee) {
            $employeeServices[$employee['id']] = array_map(
                'intval',
                array_column(
                    Employees::getEmployeeServices($employee['id']),
                    'id'
                )
            );
        }

        include 'view/appointments.php';
    }

    public static function AppointmentAvailability()
    {
        header('Content-Type: application/json; charset=UTF-8');

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            return json_encode(['error' => 'Authentication required.']);
        }

        $employeeId = filter_input(INPUT_GET, 'employee_id', FILTER_VALIDATE_INT);
        $serviceId = filter_input(INPUT_GET, 'service_id', FILTER_VALIDATE_INT);
        $date = $_GET['date'] ?? '';
        $dateValue = is_string($date)
            ? DateTime::createFromFormat('!Y-m-d', $date)
            : false;

        if (
            !$employeeId ||
            !$serviceId ||
            $employeeId < 1 ||
            $serviceId < 1 ||
            !$dateValue ||
            $dateValue->format('Y-m-d') !== $date
        ) {
            http_response_code(400);
            return json_encode(['error' => 'Invalid appointment selection.']);
        }

        try {
            if (!Employees::canPerformService($employeeId, $serviceId)) {
                http_response_code(400);
                return json_encode(['error' => 'Invalid appointment selection.']);
            }

            return json_encode([
                'slots' => Appointments::getAvailableTimeSlots(
                    $employeeId,
                    $serviceId,
                    $date
                )
            ]);
        } catch (PDOException $e) {
            error_log('Appointment availability lookup failed: ' . $e->getMessage());
            http_response_code(500);

            return json_encode(['error' => 'Availability could not be loaded.']);
        }
    }

    public static function MyAppointments()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        $appointments = Appointments::getAppointmentsByUser(
            (int) $_SESSION['user_id']
        );

        include 'view/my-appointments.php';
    }

    public static function CancelAppointment()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ilusalong/my-appointments');
            exit;
        }

        $appointmentId = filter_input(
            INPUT_POST,
            'appointment_id',
            FILTER_VALIDATE_INT
        );

        if ($appointmentId) {
            Appointments::cancelAppointment(
                $appointmentId,
                (int) $_SESSION['user_id']
            );
        }

        header('Location: /ilusalong/my-appointments');
        exit;
    }

    public static function Reviews()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /ilusalong/login');
                exit;
            }

            $serviceId = filter_input(
                INPUT_POST,
                'service_id',
                FILTER_VALIDATE_INT
            );

            $rating = filter_input(
                INPUT_POST,
                'rating',
                FILTER_VALIDATE_INT
            );

            $comment = trim($_POST['comment'] ?? '');

            if (!$serviceId || !$rating || $rating < 1 || $rating > 5 || $comment === '') {
                $error = 'Palun vali teenus, hinnang ja kirjuta kommentaar.';
            } else {
                $created = Reviews::createReview(
                    (int) $_SESSION['user_id'],
                    $serviceId,
                    $rating,
                    $comment
                );

                if ($created) {
                    header('Location: /ilusalong/reviews?submitted=1');
                    exit;
                }

                $error = 'Arvustuse lisamine ebaõnnestus.';
            }
        }

        if (isset($_GET['submitted']) && $_GET['submitted'] === '1') {
            $success = 'Aitäh! Sinu arvustus on lisatud.';
        }

        $reviews = Reviews::getAllReviews();
        $services = Services::getAllServices();

        include 'view/reviews.php';
    }

    public static function Login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
                $error = 'Palun sisesta korrektne email ja parool.';
            } else {
                $user = Auth::loginUser($email, $password);

                if ($user) {
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = (int) $user['id'];
                    $_SESSION['user_name'] = $user['first_name'];
                    $_SESSION['user_role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        unset($_SESSION['redirect_after_login']);
                        header('Location: /ilusalong/ilusalong_admin/');
                    } else {
                        $redirect = $_SESSION['redirect_after_login']
                            ?? '/ilusalong/index';
                        unset($_SESSION['redirect_after_login']);
                        header('Location: ' . $redirect);
                    }
                    exit;
                }

                $error = 'Vale email või parool.';
            }
        }

        include 'view/login.php';
    }

    public static function Register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if (
                $firstName === '' ||
                $lastName === '' ||
                !filter_var($email, FILTER_VALIDATE_EMAIL)
            ) {
                $error = 'Palun täida kõik väljad õigesti.';
            } elseif (strlen($password) < 8) {
                $error = 'Parool peab olema vähemalt 8 märki pikk.';
            } elseif ($password !== $confirm) {
                $error = 'Paroolid ei kattu.';
            } elseif (Auth::getUserByEmail($email)) {
                $error = 'Selle emailiga kasutaja on juba olemas.';
            } else {
                $result = Auth::registerUser(
                    $firstName,
                    $lastName,
                    $email,
                    $password
                );

                if ($result) {
                    header('Location: /ilusalong/login');
                    exit;
                }

                $error = 'Registreerimine ebaõnnestus.';
            }
        }

        include 'view/register.php';
    }

    public static function Logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /ilusalong/');
        exit;
    }
    public static function DeleteAccount()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        // Администратор не может удалить аккаунт через эту функцию
        if (($_SESSION['user_role'] ?? '') !== 'user') {
            header('Location: /ilusalong/index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ilusalong/index');
            exit;
        }

        // Проверка CSRF-токена
        if (
            empty($_SESSION['delete_account_token']) ||
            !isset($_POST['delete_account_token']) ||
            !hash_equals(
                $_SESSION['delete_account_token'],
                $_POST['delete_account_token']
            )
        ) {
            header('Location: /ilusalong/index');
            exit;
        }

        $userId = (int) $_SESSION['user_id'];

        if (Auth::deleteUser($userId)) {
            // Удаляем сессию после успешного удаления аккаунта
            $_SESSION = [];

            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
            }

            session_destroy();

            header('Location: /ilusalong/');
            exit;
        }

        // Если удаление не удалось, аккаунт и сессия сохраняются
        header('Location: /ilusalong/index');
        exit;
    }

    public static function error404()
    {
        include 'view/error404.php';
    }

}