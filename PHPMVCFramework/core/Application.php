<?php

namespace App\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Middleware $middleware;
    public Controller $controller;
    public static Application $app;
    public Database $db;

    public function __construct($rootPath, array $config = [])
    {
        session_start();
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->middleware = new Middleware();
        $this->db = new Database($config['db']);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new Controller();
    }

    public function run()
    {
        
        echo $this->router->resolve();
    }
}