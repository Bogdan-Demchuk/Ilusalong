<?php

class ControllerAdminServices
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

    public static function index()
    {
        self::checkAdmin();

        $services = ModelAdminServices::getAll();

        return self::render('servicesList.php', [
            'services' => $services
        ]);
    }

    public static function add()
    {
        self::checkAdmin();

        $categories = ModelAdminServices::getCategories();
        $error = '';

        $service = [
            'category_id' => '',
            'name_et' => '',
            'name_ru' => '',
            'description_et' => '',
            'description_ru' => '',
            'price' => '',
            'duration' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($service as $key => $value) {
                $service[$key] = trim((string) ($_POST[$key] ?? ''));
            }

            if (
                $service['category_id'] === '' ||
                !ctype_digit($service['category_id']) ||
                $service['name_et'] === '' ||
                $service['name_ru'] === '' ||
                $service['price'] === '' ||
                !is_numeric($service['price']) ||
                (float) $service['price'] < 0 ||
                $service['duration'] === '' ||
                !ctype_digit($service['duration']) ||
                (int) $service['duration'] < 1
            ) {
                $error = 'Palun täida kohustuslikud väljad ning sisesta korrektne hind ja kestus.';
            } else {
                $categoryExists = false;

                foreach ($categories as $category) {
                    if ((int) $category['id'] === (int) $service['category_id']) {
                        $categoryExists = true;
                        break;
                    }
                }

                if (!$categoryExists) {
                    $error = 'Palun vali kehtiv kategooria.';
                } else {
                    ModelAdminServices::add(
                        (int) $service['category_id'],
                        $service['name_et'],
                        $service['name_ru'],
                        $service['description_et'],
                        $service['description_ru'],
                        (float) $service['price'],
                        (int) $service['duration']
                    );

                    header('Location: /ilusalong/ilusalong_admin/services');
                    exit;
                }
            }
        }

        return self::render('servicesAddForm.php', [
            'service' => $service,
            'categories' => $categories,
            'error' => $error
        ]);
    }

    public static function edit()
    {
        self::checkAdmin();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            header('Location: /ilusalong/ilusalong_admin/services');
            exit;
        }

        $service = ModelAdminServices::getById($id);

        if (!$service) {
            http_response_code(404);
            return self::render('error404.php');
        }

        $categories = ModelAdminServices::getCategories();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updatedService = [
                'category_id' => trim((string) ($_POST['category_id'] ?? '')),
                'name_et' => trim((string) ($_POST['name_et'] ?? '')),
                'name_ru' => trim((string) ($_POST['name_ru'] ?? '')),
                'description_et' => trim((string) ($_POST['description_et'] ?? '')),
                'description_ru' => trim((string) ($_POST['description_ru'] ?? '')),
                'price' => trim((string) ($_POST['price'] ?? '')),
                'duration' => trim((string) ($_POST['duration'] ?? ''))
            ];

            $valid = (
                $updatedService['category_id'] !== '' &&
                ctype_digit($updatedService['category_id']) &&
                $updatedService['name_et'] !== '' &&
                $updatedService['name_ru'] !== '' &&
                $updatedService['price'] !== '' &&
                is_numeric($updatedService['price']) &&
                (float) $updatedService['price'] >= 0 &&
                $updatedService['duration'] !== '' &&
                ctype_digit($updatedService['duration']) &&
                (int) $updatedService['duration'] >= 1
            );

            if (!$valid) {
                $error = 'Palun täida kohustuslikud väljad ning sisesta korrektne hind ja kestus.';
                $service = array_merge($service, $updatedService);
            } else {
                $categoryExists = false;

                foreach ($categories as $category) {
                    if ((int) $category['id'] === (int) $updatedService['category_id']) {
                        $categoryExists = true;
                        break;
                    }
                }

                if (!$categoryExists) {
                    $error = 'Palun vali kehtiv kategooria.';
                    $service = array_merge($service, $updatedService);
                } else {
                    ModelAdminServices::update(
                        $id,
                        (int) $updatedService['category_id'],
                        $updatedService['name_et'],
                        $updatedService['name_ru'],
                        $updatedService['description_et'],
                        $updatedService['description_ru'],
                        (float) $updatedService['price'],
                        (int) $updatedService['duration']
                    );

                    header('Location: /ilusalong/ilusalong_admin/services');
                    exit;
                }
            }
        }

        return self::render('servicesEditForm.php', [
            'service' => $service,
            'categories' => $categories,
            'error' => $error
        ]);
    }

    public static function delete()
    {
        self::checkAdmin();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            header('Location: /ilusalong/ilusalong_admin/services');
            exit;
        }

        $service = ModelAdminServices::getById($id);

        if (!$service) {
            http_response_code(404);
            return self::render('error404.php');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                ModelAdminServices::delete($id);

                header('Location: /ilusalong/ilusalong_admin/services');
                exit;
            } catch (PDOException $e) {
                $error = 'Teenust ei saa kustutada, sest sellega võivad olla seotud broneeringud või töötajad.';
            }
        }

        return self::render('servicesDeleteForm.php', [
            'service' => $service,
            'error' => $error
        ]);
    }
}