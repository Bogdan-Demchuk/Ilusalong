<?php

class ModelAdminServices
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT
                services.id,
                services.category_id,
                CONCAT(category.name_et, " / ", category.name_ru) AS category_name,
                services.name_et,
                services.name_ru,
                services.description_et,
                services.description_ru,
                services.price,
                services.duration
            FROM services
            INNER JOIN category
                ON services.category_id = category.id
            ORDER BY services.id ASC'
        );
    }

    public static function getById($id)
    {
        $db = new Database();

        return $db->getOne(
            'SELECT * FROM services WHERE id = ?',
            [$id]
        );
    }

    public static function getCategories()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT id, name_et, name_ru
             FROM category
             ORDER BY name_et ASC'
        );
    }

    public static function add(
        $categoryId,
        $nameEt,
        $nameRu,
        $descriptionEt,
        $descriptionRu,
        $price,
        $duration
    ) {
        $db = new Database();

        return $db->executePrepared(
            'INSERT INTO services
                (category_id, name_et, name_ru, description_et,
                 description_ru, price, duration)
             VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                $categoryId,
                $nameEt,
                $nameRu,
                $descriptionEt,
                $descriptionRu,
                $price,
                $duration
            ]
        );
    }

    public static function update(
        $id,
        $categoryId,
        $nameEt,
        $nameRu,
        $descriptionEt,
        $descriptionRu,
        $price,
        $duration
    ) {
        $db = new Database();

        return $db->executePrepared(
            'UPDATE services
             SET category_id = ?,
                 name_et = ?,
                 name_ru = ?,
                 description_et = ?,
                 description_ru = ?,
                 price = ?,
                 duration = ?
             WHERE id = ?',
            [
                $categoryId,
                $nameEt,
                $nameRu,
                $descriptionEt,
                $descriptionRu,
                $price,
                $duration,
                $id
            ]
        );
    }

    public static function delete($id)
    {
        $db = new Database();

        return $db->executePrepared(
            'DELETE FROM services WHERE id = ?',
            [$id]
        );
    }
}