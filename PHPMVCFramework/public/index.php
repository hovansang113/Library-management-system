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
use App\controllers\CategoryController;
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
$app->router->get('/Login', [AuthController::class, 'Login']);
$app->router->post('/Login', [AuthController::class, 'processLogin']);


// Site Admin pages
// Book Inventory page
$app->router->get('/admin/bookInventory', [CategoryController::class, 'showCategories']);
$app->router->post('/admin/addCategory', [CategoryController::class, 'addCategory']);
$app->router->post('/admin/deleteCategory', [CategoryController::class, 'deleteCategory']);
$app->router->post('/admin/updateCategory', [CategoryController::class, 'updateCategory']);
$app->run();




