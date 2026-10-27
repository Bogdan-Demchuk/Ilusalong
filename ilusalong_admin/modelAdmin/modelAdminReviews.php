<?php

class ModelAdminReviews
{
    public static function getAll()
    {
        $db = new Database();

        return $db->getAll(
            'SELECT
                reviews.id,
                CONCAT(users.first_name, " ", users.last_name) AS client_name,
                CONCAT(services.name_et, " | ", services.name_ru) AS service_name,
                CONCAT(reviews.rating, " ⭐ ") AS rating,
                reviews.comment,
                reviews.created_at
            FROM reviews
            INNER JOIN users
                ON reviews.user_id = users.id
            INNER JOIN services
                ON reviews.service_id = services.id
            ORDER BY reviews.id ASC'
        );
    }
}