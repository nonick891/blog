<?php

namespace Core;

class Router
{
    /** @var array<string, list<array{0: string, 1: array{0: class-string, 1: string}|callable}>> */
    private array $routes = [];

    /**
     * @param array{0: class-string, 1: string}|callable $handler
     */
    public function get(string $path, array|callable $handler): void
    {
        $this->routes['GET'][] = [$path, $handler];
    }

    /**
     * @param array{0: class-string, 1: string}|callable $handler
     */
    public function post(string $path, array|callable $handler): void
    {
        $this->routes['POST'][] = [$path, $handler];
    }

    public function dispatch(): void
    {
        $requestMethod = is_string($_SERVER['REQUEST_METHOD'] ?? null) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $requestUri = is_string($_SERVER['REQUEST_URI'] ?? null) ? $_SERVER['REQUEST_URI'] : '/';
        $uri = '/' . trim(is_string($path = parse_url($requestUri, PHP_URL_PATH)) ? $path : '', '/');

        /** @var list<array{0: string, 1: array{0: class-string, 1: string}|callable}> $routeGroup */
        $routeGroup = $this->routes[$requestMethod] ?? [];

        foreach ($routeGroup as [$path, $handler]) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches) === 1) {
                /** @var array<string, string> $params */
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (is_callable($handler)) {
                    $handler($params);
                    return;
                }

                $controller = new $handler[0]();
                $controller->{$handler[1]}($params);
                return;
            }
        }

        http_response_code(404);
        echo "404 – No route matched";
    }
}
