<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, string $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        // Strip query string from URI
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'] ?? '/';

        // Normalize trailing slashes (except for exact '/')
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            $this->executeHandler($handler);
            return;
        }

        // 404 Fallback
        $this->render404();
    }

    private function executeHandler(string $handler): void
    {
        [$controllerName, $action] = explode('@', $handler);
        $fullControllerName = "App\\Controllers\\" . $controllerName;

        if (class_exists($fullControllerName)) {
            $controller = new $fullControllerName();
            if (method_exists($controller, $action)) {
                $controller->$action();
                return;
            }
        }

        // If class or method not found, treat it as 500 or 404 error
        $this->render404();
    }

    private function render404(): void
    {
        http_response_code(404);
        require_once __DIR__ . '/../Views/layouts/header.php';
        require_once __DIR__ . '/../Views/errors/404.php';
        require_once __DIR__ . '/../Views/layouts/footer.php';
        exit;
    }
}
