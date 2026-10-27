<?php

class ModelAdminCategory
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM category ORDER BY id DESC'
        );
    }
}