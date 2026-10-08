<?php

class Category
{
    public static function getAllCategory()
    {
        $db = new Database();

        $query = "SELECT * FROM category";

        return $db->getAll($query);
    }
}