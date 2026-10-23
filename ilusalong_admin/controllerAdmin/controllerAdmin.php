<?php

class ControllerAdmin
{
    public static function startAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        if (!Auth::isAdmin()) {
            http_response_code(403);
            return '<h1>403 — Juurdepääs keelatud</h1>
                    <p>Sellele lehele pääseb ainult administraator.</p>';
        }

        ob_start();
        include __DIR__ . '/../viewAdmin/startAdmin.php';
        return ob_get_clean();
    }

    public static function error404()
    {
        ob_start();
        include __DIR__ . '/../viewAdmin/error404.php';
        return ob_get_clean();
    }
}