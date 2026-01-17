<?php

namespace App\core;

use PDO;

class Database
{
    public $pdo;
    private static $instance = null; 

    public function __construct(array $config) {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        if (empty($dsn)) {
            throw new \Exception('Error: DB_DSN is empty. Check your .env file.');
        }

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Lưu instance khi khởi tạo lần đầu
        self::$instance = $this;
    }

    // Thêm hàm này để hết báo đỏ ở UserModel
    public static function getInstance()
    {
        if (self::$instance === null) {
            // Lưu ý: Thông thường Application sẽ khởi tạo Database trước
            // Nếu gọi trực tiếp mà chưa khởi tạo sẽ báo lỗi
            return null; 
        }
        return self::$instance->pdo;
    }

    public function query(string $sql): bool|\PDOStatement
    {
        return $this->pdo->query($sql);
    }
}