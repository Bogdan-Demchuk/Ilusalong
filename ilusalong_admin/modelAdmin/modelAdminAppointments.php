<?php

class ModelAdminAppointments
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM appointments ORDER BY id DESC'
        );
    }
}