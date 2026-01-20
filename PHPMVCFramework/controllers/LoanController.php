<?php
namespace App\controllers;
use App\core\Controller;
use App\core\Request;

class LoanController extends Controller
{
    public function loanManagement()
    {
        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/loanMangement');
    }
}