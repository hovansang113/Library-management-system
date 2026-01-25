<?php

namespace App\controllers;

use App\core\Application;
use App\core\Router;
use App\core\Controller;
use App\core\Request;
use App\core\Middleware;

class SiteController extends Controller
{
    public function home()
    {

        $HomeModel = new \App\model\Book();
        $letestBooks = $HomeModel->getLatestBooks(4);
        $params = [
            'books' => $letestBooks
        ];
        
        return $this->render('home', $params);
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function product()
    {
        return $this->render('product');
    }

    public function bookProcess()
    {
        Middleware::checkAdmin();
        $bookModel = new \App\model\Book();
        $categoryModel = new \App\model\Category();
        $categories = $categoryModel->getAllCategories();
        $books = $bookModel->getAllBooks();

        $this->setLayout('admin/mainAdmin');
        return $this->render('admin/BookInventory', [
            'categories' => $categories,
            'books' => $books
        ]);
    }

    public function catalog(Request $request)
    {
        $category = $request->getBody()['category'] ?? '';
        $author   = $request->getBody()['author'] ?? '';

        $Book = new \App\model\Book();

        if (empty($category) && empty($author)) {
            $books = $Book->getAllBooks();   
        } else {
            $books = $Book->filterBooks($category, $author);
        }

        $Category = new \App\model\Category();
        $categories = $Category->getAllCategories();

        $authors = $Book->getAllAuthors();

        return $this->render('catalog', [
            'books' => $books,
            'categories' => $categories,
            'authors' => $authors,
            'selectedCategory' => $category,
            'selectedAuthor' => $author
        ]);

    }


    public function searchBooks(Request $request)
    {

        $keyword = $request->getBody()['keyword'] ?? '';

        if (empty($keyword)) {
            return json_encode(['books' => []]);
        }

        $bookModel = new \App\model\Book();
        $books = $bookModel->searchBooks($keyword);

        header('Content-Type: application/json');
        return json_encode(['books' => $books]);
    }

    public function bookDetail(Request $request)
    {
        $id = $request->getBody()['id'] ?? null;

        if (!$id) {
            return $this->render('404');
        }

        $bookModel = new \App\model\Book();
        $book = $bookModel->getBookById($id);

        if (!$book) {
            return $this->render('404');
        }

        return $this->render('bookDetail', [
            'book' => $book
        ]);
    }




}
