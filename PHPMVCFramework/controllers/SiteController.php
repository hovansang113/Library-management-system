<?php
namespace App\controllers;
use App\core\Application;
use App\core\Router;
use App\core\Controller;
use App\core\Request;

class SiteController extends Controller{
    public function home(){
        $params = [
            'name' => "thecodeholic"
        ];
        return $this->render('home', $params);
    }
    public function contact(){
        return $this->render('contact');
    }

    public function product(){
        return $this->render('product');
    }



    public function handleContact(Request $request){
        $body = Application::$app->request->getBody();

        return 'Handling submitted data';
    }
}