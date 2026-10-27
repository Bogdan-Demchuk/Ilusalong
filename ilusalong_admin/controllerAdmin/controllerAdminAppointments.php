<?php

class ControllerAdminAppointments
{
    public static function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /ilusalong/login');
            exit;
        }

        if (!Auth::isAdmin()) {
            http_response_code(403);
            return '403 — Juurdepääs keelatud';
        }

        $appointments = ModelAdminAppointments::getAll();

        ob_start();
        include __DIR__ . '/../viewAdmin/appointmentsList.php';
        return ob_get_clean();
    }
}