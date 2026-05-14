<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\CategoryController;
use App\Controllers\MainController;
use Core\Router;

$router = new Router();

$router->get('/', MainController::class);

$router->get('/category/{id}', CategoryController::class);

$router->dispatch();