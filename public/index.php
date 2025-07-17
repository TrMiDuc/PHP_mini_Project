<?php
require_once realpath(__DIR__ . '/../core/Controller.php');
require_once realpath(__DIR__ . '/../core/Router.php');
require_once realpath(__DIR__ . '/../core/Token.php');

require_once realpath(__DIR__ . '/../app/controllers/pageController.php');
require_once realpath(__DIR__ . '/../app/controllers/authController.php');
require_once realpath(__DIR__ . '/../app/controllers/postController.php');

define('BASE_PATH', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

$access_token = $_COOKIE['access_token'] ?? null;
$username = 'Guest';
if ($access_token) {
    $payload = Token::decode($access_token);
    if ($payload && isset($payload['username'])) {
        $username = $payload['username'];
    }
}

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if (strpos($url, '?') !== false) {
    $url = strstr($url, '?', true);
}

if (strpos($url, $basePath) === 0) {
    $url = substr($url, strlen($basePath));
}

if ($url === '' || $url === false) {
    $url = '/';
}

$router = new Router();
$router->addRoute('GET', '/', 'PageController', 'index');
$router->addRoute('GET', '/index.php', 'PageController', 'index');

$router->addRoute('GET', '/auth/login', 'AuthController', 'showLogin');
$router->addRoute('POST', '/auth/login', 'AuthController', 'handleLogin');
$router->addRoute('GET', '/auth/signup', 'AuthController', 'showSignup');
$router->addRoute('POST', '/auth/signup', 'AuthController', 'handleSignup');
$router->addRoute('GET', '/auth/logout', 'AuthController', 'logout');

$router->addRoute('GET', '/posts/index', 'PostController', 'index');
$router->addRoute('GET', '/posts/create', 'PostController', 'create');

try {
    $router->resolve($method, $url);
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error: ' . $e->getMessage();
}
