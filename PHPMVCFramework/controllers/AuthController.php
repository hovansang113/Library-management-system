<?php
namespace App\controllers;
use App\core\Controller;
use App\core\Request;
use App\model\RegisterModel;
class AuthController extends Controller{
    public function login(){
        $this->setLayout('auth');
        return $this->render('login');

    }
    public function register(Request $request){
        $registerModel = new RegisterModel();
        if($request->isPost()){
            $registerModel->loadData($request->getBody());
            
            if($registerModel->validate() && $registerModel->register()){
                return 'success';
            }
            return $this->render('register',[
                'model' => $registerModel
            ]);

        }
        $this->setLayout('auth');
        return $this->render('register');
    }
}