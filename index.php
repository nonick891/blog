<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\CategoryController;
use App\Controllers\MainController;
use App\Controllers\PostController;
use Core\Router;

$router = new Router();

$router->get('/', MainController::class);

$router->get('/category/{id}', CategoryController::class);

$router->get('/category/{categoryId}/post/{postId}', PostController::class);

$router->dispatch();