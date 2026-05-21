<?php

namespace Core\Router;

use Core\Request;

readonly class Router
{
    /**
     * @param array<string, list<array{0: string, 1: array{0: class-string, 1: string}|callable|class-string}>> $routes
     */
    public function __construct(private array $routes = [])
    {
    }

    public function dispatch(): void
    {
        $request = new Request();
        $requestMethod = is_string($_SERVER['REQUEST_METHOD'] ?? null) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $requestUri = is_string($_SERVER['REQUEST_URI'] ?? null) ? $_SERVER['REQUEST_URI'] : '/';
        $uri = '/' . trim(is_string($path = parse_url($requestUri, PHP_URL_PATH)) ? $path : '', '/');

        /** @var list<array{0: string, 1: array{0: class-string, 1: string}|callable|class-string}> $routeGroup */
        $routeGroup = $this->routes[$requestMethod] ?? [];

        foreach ($routeGroup as [$path, $handler]) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches) === 1) {
                /** @var array<string, string> $params */
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if (is_string($handler)) {
                    $controller = new $handler($request);
                    /** @phpstan-ignore method.notFound */
                    $controller->__invoke(...$params);
                    return;
                }

                if (is_array($handler)) {
                    $controller = new $handler[0]($request);
                    $controller->{$handler[1]}(...$params);
                    return;
                }

                $handler($params);
                return;
            }
        }

        http_response_code(404);
        echo "404 – No route matched";
    }
}
