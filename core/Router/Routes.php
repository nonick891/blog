<?php

namespace Core\Router;

class Routes
{
    /**
     * @var array<string, list<array{0: string, 1: array{0: class-string, 1: string}|callable|class-string}>>
     */
    public static array $routes = [];

    /**
     * @param string $path
     * @param array{class-string, string}|callable|class-string $handler
     * @return void
     */
    public static function get(string $path, array|callable|string $handler): void
    {
        self::$routes['GET'][] = [$path, $handler];
    }

    /**
     * @param string $path
     * @param array{class-string, string}|callable|class-string $handler
     * @return void
     */
    public static function post(string $path, array|callable|string $handler): void
    {
        self::$routes['POST'][] = [$path, $handler];
    }
}
