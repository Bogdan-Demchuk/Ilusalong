<?php

class ModelAdmin
{
    private static function countTable($table)
    {
        $allowedTables = [
            'services',
            'category',
            'categories',
            'employees',
            'appointments',
            'reviews'
        ];

        if (!in_array($table, $allowedTables, true)) {
            return 0;
        }

        try {
            $db = new Database();
            $result = $db->getOne(
                "SELECT COUNT(*) AS total FROM `$table`"
            );

            return (int) ($result['total'] ?? 0);
        } catch (PDOException $e) {
            return 0;
        }
    }

    public static function getStatistics()
    {
        return [
            'services' => self::countTable('services'),
            'categories' => self::countTable('category'),
            'employees' => self::countTable('employees'),
            'appointments' => self::countTable('appointments'),
            'reviews' => self::countTable('reviews')
        ];
    }
}
