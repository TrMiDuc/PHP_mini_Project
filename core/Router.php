<?php

class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function resolve($requestMethod, $requestUri) {
        $requestMethod = strtoupper($requestMethod);
        $parsedUrl = parse_url($requestUri);
        $path = $parsedUrl['path'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $routePattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $route['path']);
            $routePattern = '#^' . $routePattern . '$#';

            if (preg_match($routePattern, $path, $matches)) {
                array_shift($matches);
                return $this->callAction($route['controller'], $route['action'], $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found: Route not matched.";
    }

    private function callAction($controller, $action, $params = []) {
        $controllerFile = realpath(__DIR__ . "/../app/controllers/" . strtolower($controller) . ".php");

        if (!class_exists($controller)) {
            if (!file_exists($controllerFile)) {
                throw new Exception("Controller file not found: $controllerFile");
            }
            require_once $controllerFile;
        }

        if (!class_exists($controller)) {
            throw new Exception("Controller class not found: $controller");
        }

        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Action method not found: $action");
        }

        return call_user_func_array([$controllerInstance, $action], $params);
    }
}
