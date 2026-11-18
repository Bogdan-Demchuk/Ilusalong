<?php

class Auth
{
    public static function getUserByEmail($email)
    {
        $db = new Database();

        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $users = $db->getAll($sql, [$email]);

        return $users[0] ?? null;
    }

    public static function registerUser(
        $firstName,
        $lastName,
        $email,
        $password
    ) {
        $db = new Database();

        $sql = "INSERT INTO users
            (first_name, last_name, email, password, role, created_at)
            VALUES (?, ?, ?, ?, 'user', NOW())";

        return $db->executePrepared($sql, [
            $firstName,
            $lastName,
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public static function loginUser($email, $password)
    {
        $user = self::getUserByEmail($email);

        if (!$user) {
            return false;
        }

        $storedPassword = $user['password'];

        if (password_verify($password, $storedPassword)) {
            return $user;
        }

        // Поддержка старых аккаунтов с паролями в открытом виде.
        if (hash_equals($storedPassword, $password)) {
            $db = new Database();

            $db->executePrepared(
                "UPDATE users SET password = ? WHERE id = ?",
                [
                    password_hash($password, PASSWORD_DEFAULT),
                    (int) $user['id']
                ]
            );

            return $user;
        }

        return false;
    }
    public static function isAdmin()
    {
        return isset($_SESSION['user_id'])
            && isset($_SESSION['user_role'])
            && $_SESSION['user_role'] === 'admin';
    }
    public static function deleteUser($userId)
    {
        $db = new Database();

        try {
            // Проверяем, что существует именно обычный пользователь
            $user = $db->getOne(
                "SELECT id FROM users WHERE id = ? AND role = 'user'",
                [$userId]
            );

            if (!$user) {
                return false;
            }

            $db->beginTransaction();

            // Удаляем записи пользователя
            $db->executePrepared(
                "DELETE FROM appointments WHERE user_id = ?",
                [$userId]
            );

            // Удаляем отзывы пользователя
            $db->executePrepared(
                "DELETE FROM reviews WHERE user_id = ?",
                [$userId]
            );

            // Удаляем аккаунт
            $db->executePrepared(
                "DELETE FROM users WHERE id = ? AND role = 'user'",
                [$userId]
            );

            $db->commit();

            return true;

        } catch (PDOException $e) {
            $db->rollBack();
            return false;
        }
    }
}
