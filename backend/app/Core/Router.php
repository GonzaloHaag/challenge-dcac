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
            if (!isset($this->routes[$httpMethod][$path])) {
                Response::json(['error' => 'Route not found'], 404);
                return;
            }
            $handler = $this->routes[$httpMethod][$path];
            $this->callAction($handler);
    }

    private function callAction(callable $handler): void
    {
       call_user_func($handler);
    }

    private function addRoute(string $method, string $route, callable $handler): void
    {
        $this->routes[$method][$route] = $handler;
    }
}
