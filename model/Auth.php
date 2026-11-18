<?php

class Auth
{
    private const LOGIN_WINDOW_MINUTES = 15;
    private const LOGIN_EMAIL_ATTEMPT_LIMIT = 5;
    private const LOGIN_IP_ATTEMPT_LIMIT = 20;

    public static function canAttemptLogin($email, $ipAddress)
    {
        $keys = self::getLoginRateLimitKeys($email, $ipAddress);
        $db = new Database();

        $rows = $db->getAll(
            'SELECT
                bucket_key,
                attempts,
                (window_started_at > DATE_SUB(NOW(), INTERVAL '
                . self::LOGIN_WINDOW_MINUTES . ' MINUTE)) AS in_window,
                (blocked_until > NOW()) AS is_blocked
             FROM login_rate_limits
             WHERE bucket_key IN (?, ?)',
            [$keys['email'], $keys['ip']]
        );

        foreach ($rows as $row) {
            $limit = $row['bucket_key'] === $keys['email']
                ? self::LOGIN_EMAIL_ATTEMPT_LIMIT
                : self::LOGIN_IP_ATTEMPT_LIMIT;

            if (
                (int) $row['is_blocked'] === 1 ||
                (
                    (int) $row['in_window'] === 1 &&
                    (int) $row['attempts'] >= $limit
                )
            ) {
                return false;
            }
        }

        return true;
    }

    public static function recordFailedLogin($email, $ipAddress)
    {
        $db = new Database();
        $keys = self::getLoginRateLimitKeys($email, $ipAddress);

        $db->beginTransaction();

        try {
            $db->executePrepared(
                'DELETE FROM login_rate_limits
                 WHERE window_started_at < DATE_SUB(NOW(), INTERVAL 1 DAY)
                    AND (blocked_until IS NULL OR blocked_until <= NOW())'
            );

            $windowExpired = 'window_started_at <= DATE_SUB(NOW(), INTERVAL '
                . self::LOGIN_WINDOW_MINUTES . ' MINUTE)';

            foreach ([
                [$keys['email'], self::LOGIN_EMAIL_ATTEMPT_LIMIT],
                [$keys['ip'], self::LOGIN_IP_ATTEMPT_LIMIT]
            ] as $bucket) {
                $db->executePrepared(
                    'INSERT INTO login_rate_limits
                        (bucket_key, attempts, window_started_at, blocked_until)
                     VALUES (?, 1, NOW(), NULL)
                     ON DUPLICATE KEY UPDATE
                        blocked_until = IF(' . $windowExpired . ',
                            NULL,
                            IF(attempts + 1 >= ?,
                                DATE_ADD(NOW(), INTERVAL '
                                . self::LOGIN_WINDOW_MINUTES . ' MINUTE),
                                blocked_until)),
                        attempts = IF(' . $windowExpired . ', 1, attempts + 1),
                        window_started_at = IF(' . $windowExpired . ',
                            NOW(),
                            window_started_at)',
                    [$bucket[0], $bucket[1]]
                );
            }

            $db->commit();
        } catch (Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public static function clearLoginFailures($email)
    {
        $keys = self::getLoginRateLimitKeys($email, '');
        $db = new Database();

        return $db->executePrepared(
            'DELETE FROM login_rate_limits WHERE bucket_key = ?',
            [$keys['email']]
        );
    }

    private static function getLoginRateLimitKeys($email, $ipAddress)
    {
        $normalizedEmail = mb_strtolower(trim((string) $email), 'UTF-8');
        $ipAddress = trim((string) $ipAddress);

        return [
            'email' => hash('sha256', 'email:' . $normalizedEmail),
            'ip' => hash('sha256', 'ip:' . $ipAddress)
        ];
    }

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
