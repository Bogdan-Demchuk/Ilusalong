<?php

class ModelAdminEmployees
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM employees ORDER BY id DESC'
        );
    }
}