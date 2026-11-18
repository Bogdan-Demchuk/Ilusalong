<?php

class database {
    private $conn;
    private $host;
    private $user;
    private $password;
    private $baseName;

    function __construct() {
        $this->host = 'db';
        $this->user = 'root';
        $this->password = 'root';
        $this->baseName = 'ilusalong';
        $this->connect();
    }

    function __destruct() {
        $this->disconnect();
    }

    function connect() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO(
                    'mysql:host=' . $this->host . ';dbname=' . $this->baseName,
                    $this->user,
                    $this->password,
                    [
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ]
                );
            } catch (Exception $e) {
                die('Connection failed : ' . $e->getMessage());
            }
        }

        return $this->conn;
    }

    function disconnect() {
        if ($this->conn) {
            $this->conn = null;
        }
    }

    function getOne($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetch();
    }

    function getAll($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    function executePrepared($query, $params = []) {
        $stmt = $this->conn->prepare($query);

        return $stmt->execute($params);
    }

    function executeRun($query) {
        return $this->conn->exec($query);
    }

    // Начало транзакции
    function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    // Подтверждение транзакции
    function commit() {
        return $this->conn->commit();
    }

    // Отмена транзакции
    function rollBack() {
        if ($this->conn->inTransaction()) {
            return $this->conn->rollBack();
        }

        return false;
    }
}
