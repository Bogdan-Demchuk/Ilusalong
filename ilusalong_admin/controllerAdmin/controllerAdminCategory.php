<?php

class ControllerAdminCategory
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

        $categories = ModelAdminCategory::getAll();

        ob_start();
        include __DIR__ . '/../viewAdmin/categoryList.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }

    public static function add()
    {
        self::checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameEt = trim($_POST['name_et'] ?? '');
            $nameRu = trim($_POST['name_ru'] ?? '');

            if ($nameEt !== '' && $nameRu !== '') {
                ModelAdminCategory::add($nameEt, $nameRu);

                header('Location: /ilusalong/ilusalong_admin/categories');
                exit;
            }
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/categoryAddForm.php';
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
            header('Location: /ilusalong/ilusalong_admin/categories');
            exit;
        }

        $category = ModelAdminCategory::getById($id);

        if (!$category) {
            http_response_code(404);
            return 'Kategooriat ei leitud.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameEt = trim($_POST['name_et'] ?? '');
            $nameRu = trim($_POST['name_ru'] ?? '');

            if ($nameEt !== '' && $nameRu !== '') {
                ModelAdminCategory::update($id, $nameEt, $nameRu);

                header('Location: /ilusalong/ilusalong_admin/categories');
                exit;
            }
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/categoryEditForm.php';
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
            header('Location: /ilusalong/ilusalong_admin/categories');
            exit;
        }

        $category = ModelAdminCategory::getById($id);

        if (!$category) {
            http_response_code(404);
            return 'Kategooriat ei leitud.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ModelAdminCategory::delete($id);

            header('Location: /ilusalong/ilusalong_admin/categories');
            exit;
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/categoryDeleteForm.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }
}