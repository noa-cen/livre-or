<?php

class DatabaseConnection {
    protected $pdo;
    protected $host;
    protected $dbname;
    protected $user;
    protected $password;

    public function __construct($host = "localhost", $dbname = "livreor", $user = "root", $password = "")
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}