<?php

class ModelAdminReviews
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM reviews ORDER BY id DESC'
        );
    }
}