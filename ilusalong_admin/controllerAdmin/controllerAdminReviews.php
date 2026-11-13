<?php

class ControllerAdminReviews
{
    public static function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        if (!Auth::isAdmin()) {
            http_response_code(403);

            $content = '<h2>403 — Juurdepääs keelatud</h2>';

            ob_start();
            include __DIR__ . '/../viewAdmin/templates/layout.php';
            return ob_get_clean();
        }

        $reviews = ModelAdminReviews::getAll();

        ob_start();
        include __DIR__ . '/../viewAdmin/reviewsList.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }
}
