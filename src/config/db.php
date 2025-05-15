<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
    $config = [
        'host' => 'db', 
        'dbname' => 'ihealth',
        'user' => 'ihealth_user',
        'password' => 'ihealth_pass',
        'port' => '5432'
    ];

    try {
        $this->connection = $this->tryConnect($config);
    } catch(PDOException $e) {
        error_log("Connection failed: " . $e->getMessage());
        throw new Exception("Не удалось подключиться к БД в Docker");
    }
}

    private function tryConnect($config) {
        return new PDO(
            "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}