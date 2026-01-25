<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\services\DashBoard;
use App\model\Loan;
use App\model\Category;



class AdminDashboardController extends Controller{
    
    public function dashBoard(){
        $dashBoardServer = new DashBoard();
        $loanModel = new Loan();
        $categoryModel = new Category();
        $borrowReturnStatus = $loanModel->getMonthlyBorrowReturn();
        $categoryStats = $categoryModel->getCategoryStats();

        $data = $dashBoardServer->getDashboardData();
        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/dashboard', array_merge([
            'borrowReturnStats' => $borrowReturnStatus,
            'categoryStats' => $categoryStats
        ], $data));
    }
}