<?php
namespace App\controllers;
use App\core\Application;
use App\core\Router;
use App\core\Controller;
use App\core\Request;
use App\core\Middleware;

class SiteController extends Controller{
    public function home(){
 
        $HomeModel = new \App\model\Book();
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
        $bookModel = new \App\model\Book();
        $categoryModel = new \App\model\Category();
        $categories = $categoryModel->getAllCategories();
        $books = $bookModel->getAllBooks();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/BookInventory', [
            'categories' => $categories
            ,'books' => $books
        ]);
    }

    public function catalog(){
        $Book= new \App\model\Book();
        $books = $Book->getAllBooks();
        $params = [
            'books' => $books
        ];
        return $this->render('catalog', $params);
    }

    public function searchBooks(Request $request){

        $keyword = $request->getBody()['keyword'] ?? '';
        
        if (empty($keyword)) {
            return json_encode(['books' => []]);
        }

        $bookModel = new \App\model\Book();
        $books = $bookModel->searchBooks($keyword);

        header('Content-Type: application/json');
        return json_encode(['books' => $books]);
    }
    

    public function handleContact(Request $request){
        $body = Application::$app->request->getBody();

        return 'Handling submitted data';
    }


}