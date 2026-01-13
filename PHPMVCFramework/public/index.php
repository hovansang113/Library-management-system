<?php
// public/index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\core\Application;
use App\controllers\SiteController;
use App\controllers\AuthController;
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
$app->router->get('/product', [SiteController::class, 'product']);

// Auth pages
$app->router->get('/Login', [AuthController::class, 'Login']);
$app->router->post('/Login', [AuthController::class, 'processLogin']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();




