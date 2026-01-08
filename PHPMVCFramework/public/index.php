<?php
// public/index.php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\core\Application;
use App\controllers\SiteController;
use App\controllers\AuthController;

$app = new Application(dirname(__DIR__));

// Site pages
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);
$app->router->get('/product', [SiteController::class, 'product']);

// Auth pages
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();




