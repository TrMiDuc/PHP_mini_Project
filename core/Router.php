<?php

class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function resolve($requestMethod, $requestUri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                return $this->callAction($route['controller'], $route['action']);
            }
        }

        throw new Exception('Route not found');
    }


    private function callAction($controller, $action) {
        if (!class_exists($controller)) {
            require_once realpath(__DIR__. "/../app/controllers/" . strtolower($controller) . ".php");
        }
        if (!class_exists($controller) || !method_exists($controller, $action)) {
            throw new Exception('Controller or action not found');
        }
        $controllerInstance = new $controller();
        return $controllerInstance->$action();
    }
}