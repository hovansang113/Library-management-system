<?php
    namespace App\core;
    class Application
    // the purpore of this class is coordination request and reponse
    {
        public static string $ROOT_DIR; // Root path = the folder that contains the entire project
        public Router $router;
        public Request $request;
        public Response $response;
        public Controller $controller;
        public static Application $app;
        public function __construct($rootPath)
        {
            self::$ROOT_DIR = $rootPath;
            self::$app = $this; // self này dùng đẻ truy cập các thuộc tính thuộc về lớp
            $this->request = new Request();
            $this->response = new Response(); // this trong này dùng để truy cập các thuộc tính của object 
            $this->router = new Router($this->request, $this->response);
            $this->controller = new Controller(); // Initialize default controller
        }

        public function run()
        {
           echo $this->router->resolve();
        }
    }
;?>