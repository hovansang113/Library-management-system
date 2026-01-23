<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\services\DashBoard;



class AdminDashboardController extends Controller{
    
    public function dashBoard(){
        $dashBoardServer = new DashBoard();
        $data = $dashBoardServer->getDashboardData();
        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/dashboard', $data);
    }

}