<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;


class AdminDashboardController extends Controller{
    
    public function dashBoard(){
        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/dashboard');
    }

}