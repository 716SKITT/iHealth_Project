<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $config = [
            'host' => 'localhost',
            'port' => '5432',
            'dbname' => 'postgres',
            'user' => 'yuliialex',
            'password' => 'qwerty123'
        ];

        try {
            $this->connection = new PDO(
                "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
                $config['user'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e) {
    echo "<p style='color:red;'>Ошибка подключения к БД: " . $e->getMessage() . "</p>";
    exit;
}
    }

    public static function getConnection() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}