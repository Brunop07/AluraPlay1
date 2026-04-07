<?php

declare(strict_types=1);

use Alura\Mvc\Controller\{
    Controller,
    DeleteVideoController,
    EditVideoController,
    Error404Controller,
    NewVideoController,
    VideoFormController,
    VideoListController,
    LoginController
};
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/criar-banco.php';


$videoRepository = new VideoRepository($pdo);


$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$httpMethod = $_SERVER['REQUEST_METHOD'];

session_start();
$isLoginRoute = $pathInfo === '/login';
        if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
            header('Location: /login');
            return;
            }


$key = "$httpMethod|$pathInfo";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];

  
    if ($controllerClass === LoginController::class) {
        $controller = new $controllerClass($pdo);
    } else {
        $controller = new $controllerClass($videoRepository); 
    }

} else {
    $controller = new Error404Controller();
}

/** @var Controller $controller */
$controller->processaRequisicao();