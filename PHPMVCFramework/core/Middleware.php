<?php
namespace App\core;

class Middleware {

    public static function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function checkAdmin() {
        self::checkLogin();

        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
            header('Location: /404');
            exit;
        }
    }

    public static function checkUser() {
        self::checkLogin();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'User') {
            header('Location: /');
            exit;
        }
    }
}
