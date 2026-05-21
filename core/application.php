<?php

use Core\Router\Router;
use Core\Router\Routes;

require_once __DIR__ . '/../app/routes/web.php';

$router = new Router(Routes::$routes);

$router->dispatch();
