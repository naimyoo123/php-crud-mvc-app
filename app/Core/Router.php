<?php

namespace App\Core;

class Router
{
    private $routes = [];
    private $notFound;

    public function __construct()
    {
        $this->notFound = function () {
            http_response_code(404);
            echo "404 - Page Not Found";
        };
    }

    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function get($path, $handler)
    {
        $this->add('GET', $path, $handler);
    }

    public function post($path, $handler)
    {
        $this->add('POST', $path, $handler);
    }

    public function put($path, $handler)
    {
        $this->add('PUT', $path, $handler);
    }

    public function delete($path, $handler)
    {
        $this->add('DELETE', $path, $handler);
    }

    public function setNotFound($handler)
    {
        $this->notFound = $handler;
    }

    public function run()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = rtrim($requestUri, '/') ?: '/';

        // Handle PUT/PATCH/DELETE methods with _method parameter
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            $pattern = $this->buildPattern($route['path']);
            
            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                $handler = $route['handler'];
                
                if (is_callable($handler)) {
                    return call_user_func_array($handler, $matches);
                } elseif (is_string($handler)) {
                    return $this->callController($handler, $matches);
                }
            }
        }

        call_user_func($this->notFound);
    }

    private function buildPattern($path)
    {
        $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function callController($handler, $params)
    {
        list($controller, $method) = explode('@', $handler);
        $controller = "App\\Controllers\\" . $controller;
        
        if (class_exists($controller)) {
            $controllerInstance = new $controller();
            
            if (method_exists($controllerInstance, $method)) {
                return call_user_func_array([$controllerInstance, $method], $params);
            }
        }
        
        call_user_func($this->notFound);
    }
}