<?php
// public/index.php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../vendor/autoload.php';
use App\core\Application;
use App\controllers\SiteController;
use App\controllers\AuthController;
use App\controllers\BookInventory;
use App\controllers\UserController;
use App\controllers\LoanController;
use Dotenv\Dotenv;

// Tạm dừng để xem kết quả
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
// public/index.php
$config = [
    'db' => [
        'dsn'      => $_ENV['DB_DSN'] ?? '',
        'user'     => $_ENV['DB_USER'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ]
];

$app = new Application(dirname(__DIR__), $config);
// Site pages
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);


// Auth pages
$app->router->get('/Login', [AuthController::class, 'login']);
$app->router->post('/Login', [AuthController::class, 'processLogin']);


// Site Admin pages
// Book Inventory page
$app->router->get('/admin/bookInventory', [BookInventory::class, 'showCategories']);
$app->router->post('/admin/addCategory', [BookInventory::class, 'addCategory']);
$app->router->post('/admin/deleteCategory', [BookInventory::class, 'deleteCategory']);
$app->router->post('/admin/updateCategory', [BookInventory::class, 'updateCategory']);

// add new book
$app->router->post('/admin/addBook', [BookInventory::class, 'addBook']);
$app->router->post('/admin/updateBook', [BookInventory::class, 'updateBook']);
$app->router->post('/admin/deleteBook', [BookInventory::class, 'deleteBook']);
$app->router->post('/admin/searchBooks', [BookInventory::class, 'searchBooks']);


// User Management
$app->router->get('/admin/userManagement', [UserController::class, 'userManagement']);
$app->router->post('/admin/saveUser', [UserController::class, 'saveUser']);
$app->router->post('/admin/user/block', [UserController::class, 'blockUser']);
$app->router->post('/admin/user/unblock', [UserController::class, 'unblockUser']);

// Loan Management
$app->router->get('/admin/loanManagement', [LoanController::class, 'loanManagement']);
$app->router->post('/admin/loan/Store', [LoanController::class, 'loanProcess']);
$app->router->post('/admin/loan/Return', [LoanController::class, 'returnBook']);
// Logout
$app->router->get('/logout', [AuthController::class, 'logout']);

//catelog
$app->router->get('/catalog', [SiteController::class, 'catalog']);
$app->router->post('/user/searchBooks', [SiteController::class, 'searchBooks']);
$app->router->get('/book', [SiteController::class, 'bookDetail']);


// Admin Dashboard
$app->router->get('/admin/dashboard', [\App\controllers\AdminDashboardController::class, 'dashBoard']);
$app->router->get('/admin/dashboard', [SiteController::class, 'dashboard']);



$app->run();
