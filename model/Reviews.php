<?php

class Reviews
{
    public static function getAllReviews()
    {
        $db = new Database();

        $query = "
            SELECT
                reviews.id,
                reviews.user_id,
                reviews.service_id,
                reviews.rating,
                reviews.comment,
                reviews.created_at,
                users.first_name,
                users.last_name,
                services.name_et
            FROM reviews
            JOIN users ON reviews.user_id = users.id
            JOIN services ON reviews.service_id = services.id
            ORDER BY reviews.created_at DESC
        ";

        return $db->getAll($query);
    }

    public static function createReview(
        $userId,
        $serviceId,
        $rating,
        $comment
    ) {

        $db = new Database();

        $query = "
            INSERT INTO reviews
                (user_id, service_id, rating, comment, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ";

        return $db->executePrepared($query, [
            (int) $userId,
            (int) $serviceId,
            (int) $rating,
            $comment
        ]);
    }
}
