<?php

class Services
{
    public static function getAllServices()
    {
        $db = new database();

        $query = "
            SELECT
                id,
                category_id,
                name_et,
                name_ru,
                description_et,
                description_ru,
                price,
                duration
            FROM services
            ORDER BY name_et
        ";

        return $db->getAll($query);
    }
    public static function getServiceById($id)
    {
        $db = new database();

        $id = (int)$id;

        $query = "
            SELECT
                id,
                name_et,
                name_ru,
                description_et,
                description_ru,
                price,
                duration
            FROM services
            WHERE id = $id
        ";

        return $db->getOne($query);
    }
    public static function getServicesByCategory($categoryId)
    {
        $db = new Database();

        $categoryId = (int)$categoryId;

        $query = "
            SELECT
                id,
                category_id,
                name_et,
                name_ru,
                description_et,
                description_ru,
                price,
                duration
            FROM services
            WHERE category_id = $categoryId
            ORDER BY name_et
        ";

        return $db->getAll($query);
    }
}