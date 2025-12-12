<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct()
    {
        $config = [];
        if (file_exists(__DIR__ . '/config.php')) {
            $config = require __DIR__ . '/config.php';
        }

        $this->host = $config['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
        $this->db_name = $config['DB_NAME'] ?? getenv('DB_NAME') ?: 'yoga_studio';
        $this->username = $config['DB_USER'] ?? getenv('DB_USER') ?: 'root';
        $this->password = $config['DB_PASS'] ?? getenv('DB_PASS') ?: '';
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 5, // 5 seconds timeout
            ];
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $exception) {
            // In produzione non mostrare l'errore completo all'utente
            error_log("Connection error: " . $exception->getMessage());
            echo "Errore di connessione al database.";
        }

        return $this->conn;
    }

    public function checkInstallation()
    {
        if ($this->conn === null) {
            $this->getConnection();
        }
        if ($this->conn === null) {
            return false;
        }
        try {
            $result = $this->conn->query("SHOW TABLES LIKE 'users'");
            return $result->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function install()
    {
        if ($this->conn === null) {
            $this->getConnection();
        }
        if ($this->conn === null) {
            return false;
        }
        $sql = file_get_contents(__DIR__ . '/../database/init.sql');
        try {
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
        }
    }

    public function getTables()
    {
        if ($this->conn === null)
            $this->getConnection();
        $stmt = $this->conn->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function dropTable($tableName)
    {
        if ($this->conn === null)
            $this->getConnection();
        // Basic validation: table name should be alphanumeric/underscore
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName))
            return false;

        try {
            $this->conn->exec("DROP TABLE IF EXISTS `$tableName`");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function dropAllTables()
    {
        if ($this->conn === null)
            $this->getConnection();

        try {
            $this->conn->exec("SET FOREIGN_KEY_CHECKS = 0");
            $tables = $this->getTables();
            foreach ($tables as $table) {
                $this->conn->exec("DROP TABLE IF EXISTS `$table`");
            }
            $this->conn->exec("SET FOREIGN_KEY_CHECKS = 1");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
