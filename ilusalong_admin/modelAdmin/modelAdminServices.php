<?php

class ModelAdminServices
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT
                services.id,
                CONCAT(category.name_et, " / ", category.name_ru) AS category_name,
                services.name_et,
                services.name_ru,
                services.description_et,
                services.description_ru,
                CONCAT(services.price, " €") AS price,
                CONCAT(services.duration, " min") AS duration
            FROM services
            INNER JOIN category
                ON services.category_id = category.id
            ORDER BY services.id ASC'
        );
    }
}