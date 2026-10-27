<?php

class ModelAdminServices
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM services ORDER BY id DESC'
        );
    }
}