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

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }
}
