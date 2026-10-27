<?php

class ModelAdminEmployees
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT * FROM employees ORDER BY id ASC'
        );
    }

    public static function getById($id)
    {
        $db = new Database();

        return $db->getOne(
            'SELECT * FROM employees WHERE id = ?',
            [$id]
        );
    }

    public static function add($firstName, $lastName, $phone, $email, $position, $photo)
    {
        $db = new Database();

        return $db->executePrepared(
            'INSERT INTO employees
                (first_name, last_name, phone, email, position, photo)
             VALUES (?, ?, ?, ?, ?, ?)',
            [$firstName, $lastName, $phone, $email, $position, $photo]
        );
    }

    public static function update($id, $firstName, $lastName, $phone, $email, $position, $photo)
    {
        $db = new Database();

        return $db->executePrepared(
            'UPDATE employees
             SET first_name = ?,
                 last_name = ?,
                 phone = ?,
                 email = ?,
                 position = ?,
                 photo = ?
             WHERE id = ?',
            [$firstName, $lastName, $phone, $email, $position, $photo, $id]
        );
    }

    public static function delete($id)
    {
        $db = new Database();

        return $db->executePrepared(
            'DELETE FROM employees WHERE id = ?',
            [$id]
        );
    }
}