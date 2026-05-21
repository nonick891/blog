<?php

use App\Controllers\CategoryController;
use App\Controllers\MainController;
use App\Controllers\PostController;
use Core\Router\Routes;

Routes::get('/', MainController::class);

Routes::get('/category/{id}', CategoryController::class);

Routes::get('/category/{categoryId}/post/{postId}', PostController::class);
