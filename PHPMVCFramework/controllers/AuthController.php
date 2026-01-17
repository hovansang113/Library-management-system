<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\model\UserModel;

class AuthController extends Controller
{

    
    public function login()
    {
        return $this->render('login');
    }

    public function processLogin(Request $request)
    {


        $errors = [];

        if ($request->isPost()) {
            $data = $request->getBody();
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if (empty($email)) {
                $errors[] = 'Email is required';
            }

            if (empty($password)) {
                $errors[] = 'Password is required';
            }

            if (empty($errors)) {
                $userModel = new UserModel();
                $user = $userModel->verifyUser($email, $password);

                if ($user) {
                    $_SESSION['user_id'] = $user['MemberID'];
                    $_SESSION['user_email'] = $user['Email'];
                    $_SESSION['user_name'] = $user['UserName'];
                    $_SESSION['user_role'] = $user['Role'];
                    // echo '<pre>';
                    // var_dump($_SESSION);
                    // echo '</pre>';
                    // die();


                    if ($user['Role'] === 'Admin') {
                        header('Location: /admin/bookInventory');
                    } else {
                        header('Location: /');
                    }
                    exit;
                } else {
                    $errors[] = 'Invalid email or password';
                }
            }
        }

        return $this->render('login', ['errors' => $errors]);
    }
    

    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
