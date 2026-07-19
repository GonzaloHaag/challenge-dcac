<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = [];

    public function get(string $route, callable $handler): void
    {
        $this->addRoute('GET', $route, $handler);
    }

    public function post(string $route, callable $handler): void
    {
        $this->addRoute('POST', $route, $handler);
    }

    public function put(string $route, callable $handler): void
    {
        $this->addRoute('PUT', $route, $handler);
    }

    public function delete(string $route, callable $handler): void
    {
        $this->addRoute('DELETE', $route, $handler);
    }

    public function resolve(string $requestUri, string $requestMethod): void
    {
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '/';
        $httpMethod = strtoupper($requestMethod);

        foreach ($this->routes[$httpMethod] ?? [] as $route) {

            $params = $this->match(
                $route['pattern'],
                $path
            );

            if ($params !== null) {

                if(isset($params['id'])) {
                    $params['id'] = (int)$params['id'];
                }

                call_user_func_array(
                    $route['handler'],
                    $params
                );

                return;
            }
        }

        Response::json(
            ['error' => 'Ruta no encontrada'],
            404
        );
    }

    private function addRoute(string $method, string $route, callable $handler): void
    {
        $this->routes[$method][] = [
            'pattern' => $this->compileRoute($route),
            'handler' => $handler
        ];
    }


    private function compileRoute(string $route): string
    {
        $pattern = preg_replace(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            '(?P<$1>[^/]+)',
            $route
        );

        return '#^' . $pattern . '$#';
    }

    private function match(
        string $pattern,
        string $path
    ): ?array {
        if (!preg_match(
            $pattern,
            $path,
            $matches
        )) {
            return null;
        }

        return array_filter(
            $matches,
            fn($key) => !is_int($key),
            ARRAY_FILTER_USE_KEY
        );
    }
}
