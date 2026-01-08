<?php

namespace App\core;

class Router{
    public Request $request;
    public Response $response;
    protected array $router = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    // use register router get and see page, acsses link
    public function get($path, $callback){
        $this->router['GET'][$path] = $callback;

    // the function to use register router post and send form, send data
    }
    public function post($path, $callback){
        $this->router['POST'][$path] = $callback;
    }


    // the function is used to displauy interface in folder view 
    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->method();
        
        // get the callback from the router array
        $callback = $this->router[$method][$path] ?? false;

        // check if route don't found 
        if($callback === false){
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }

        if(is_string($callback)){
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request);
       
    }
    // the function is used to display view and layout of interface
    public function renderView($view, $params = []){
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    // the function is used to display layout
    public function renderContent($viewContent){
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }


    // use ob_start() helps capture all the HTML from a view file into a single string, so we can insert it into a layout or process it before displaying
    // if you don't use it the MVC structure wouldn't work correctly
    protected function layoutContent(){
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/view/layouts/$layout.php";
        return ob_get_clean();    
    }

    protected function renderOnlyView($view, $params){
        foreach ($params as $key => $value){
            $$key = $value;
        }
        
        ob_start();
        include_once Application::$ROOT_DIR."/view/$view.php";
        return ob_get_clean();  
    }

}


