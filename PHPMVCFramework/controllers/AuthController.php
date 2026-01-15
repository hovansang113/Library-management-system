<?php
namespace App\controllers;
use App\core\Controller;
use App\core\Request;
use App\model\UserModel;

class AuthController extends Controller{
    
    // Hiển thị form login
    public function login(){    
        return $this->render('login');
    }
    
    // Xử lý đăng nhập
    public function processLogin(Request $request){
        $errors = [];
        
        if($request->isPost()){
            $email = $request->getBody()['email'] ?? '';
            $password = $request->getBody()['password'] ?? '';
            
            // Validate
            $errors = [];
            if(empty($email)){
                $errors[] = 'Email is required';
            }
            
            if(empty($password)){
                $errors[] = 'Password is required';
            }
            
            if(empty($errors)){
                // Kiểm tra đăng nhập
                $userModel = new UserModel();
                $user = $userModel->verifyUser($email, $password);
                
                if($user){
                    
                    $_SESSION['user_id'] = $user['MemberID'];    
                    $_SESSION['user_email'] = $user['Email'];     
                    $_SESSION['user_name'] = $user['UserName'];   
                    $_SESSION['user_role'] = $user['Role'];       
                    
                    if($user['Role']=='Admin'){
                        header('Location: /admin/dashboard');
                        exit;
                    } else {
                        header('Location: /');
                        exit;
                    }
                    
                } else {
                    $errors[] = 'Invalid email or password';
                }
            }
        }
        
        // Nếu có lỗi, render lại form login với errors
        return $this->render('login', ['errors' => $errors]);
    }
    
    // public function register(Request $request){
    //     $registerModel = new RegisterModel();
    //     if($request->isPost()){
    //         $registerModel->loadData($request->getBody());
    //         if($registerModel->validate() && $registerModel->register()){
    //             return 'Success';
    //         }
    //         echo '<pre>';
    //         var_dump($registerModel->errors);
    //         echo '</pre>';
    //         exit;
    //     }
    //     $this->setLayout('auth');
    //     return $this->render('register');
    // }
}