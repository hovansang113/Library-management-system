<?php
namespace App\controllers;
use App\core\Application;
use App\core\Router;
use App\core\Controller;
use App\core\Request;
use App\core\Middleware;

class SiteController extends Controller{
    public function home(){
 
        $HomeModel = new \App\model\HomeModel();
        $letestBooks = $HomeModel->getLatestBooks(4);
        $params = [
            'books' => $letestBooks
        ];
        return $this->render('home', $params);
    }

    public function contact(){
        return $this->render('contact');
    }

    public function product(){
        return $this->render('product');
    }

    public function bookProcess(){
        Middleware::checkAdmin();

        $categoryModel = new \App\model\CategoryModel();
        $categories = $categoryModel->getAllCategories();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/bookInventory', [
            'categories' => $categories
        ]);
    }


    public function handleContact(Request $request){
        $body = Application::$app->request->getBody();

        return 'Handling submitted data';
    }
}