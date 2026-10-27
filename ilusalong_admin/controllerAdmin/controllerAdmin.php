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

            $content = '
                <h1>403 — Juurdepääs keelatud</h1>
                <p>Sellele lehele pääseb ainult administraator.</p>
                <p><a href="/ilusalong/index">Tagasi avalehele</a></p>
            ';

            ob_start();
            include __DIR__ . '/../viewAdmin/templates/layout.php';
            return ob_get_clean();
        }

        $stats = ModelAdmin::getStatistics();

        ob_start();
        include __DIR__ . '/../viewAdmin/startAdmin.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }

    public static function error404()
    {
        http_response_code(404);

        ob_start();
        include __DIR__ . '/../viewAdmin/error404.php';
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . '/../viewAdmin/templates/layout.php';
        return ob_get_clean();
    }
}
