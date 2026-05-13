<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\PostsController;
use Core\Router;

$router = new Router();

$router->get('/', [PostsController::class, 'mainPage']);

$router->get('/category/{id}', function (array $params) {
    $id = is_string($params['id'] ?? null) ? $params['id'] : '';
    echo 'category: ' . $id;
});

$router->dispatch();