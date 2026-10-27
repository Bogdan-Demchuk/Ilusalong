<?php

class ModelAdminCategory
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM category ORDER BY id ASC'
        );
    }

    public static function getById($id)
    {
        $db = new Database();

        return $db->getOne(
            'SELECT * FROM category WHERE id = ?',
            [$id]
        );
    }

    public static function add($nameEt, $nameRu)
    {
        $db = new Database();

        return $db->executePrepared(
            'INSERT INTO category (name_et, name_ru)
             VALUES (?, ?)',
            [$nameEt, $nameRu]
        );
    }

    public static function update($id, $nameEt, $nameRu)
    {
        $db = new Database();

        return $db->executePrepared(
            'UPDATE category
             SET name_et = ?, name_ru = ?
             WHERE id = ?',
            [$nameEt, $nameRu, $id]
        );
    }

    public static function delete($id)
    {
        $db = new Database();

        return $db->executePrepared(
            'DELETE FROM category WHERE id = ?',
            [$id]
        );
    }
}