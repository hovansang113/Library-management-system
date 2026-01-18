<?php

namespace App\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public static Application $app;
    public Database $db;

    public function __construct($rootPath, array $config = [])
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->db = new Database($config['db']);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new Controller();
    }

    public function run()
    {
        try {
            // Thực hiện một truy vấn đơn giản nhất
            $statement = $this->db->pdo->query("SELECT DATABASE()");
            $dbName = $statement->fetchColumn();
            
            // Bạn có thể tạm thời echo ra để thấy tận mắt
            // echo "Kết nối thành công đến database: " . $dbName; 
            
        } catch (\Exception $e) {
            die("Lỗi kết nối database: " . $e->getMessage());
        }
        
        echo $this->router->resolve();
    }
}