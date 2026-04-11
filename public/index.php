<?php

declare(strict_types=1);

use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/criar-banco.php';

$videoRepository = new VideoRepository($pdo);

$container = [
    VideoRepository::class => $videoRepository,
    PDO::class => $pdo,
];

$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

session_start();
session_regenerate_id();

$isLoginRoute = $pathInfo === '/login';

if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}

$key = "$httpMethod|$pathInfo";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];

    $reflection = new ReflectionClass($controllerClass);
    $constructor = $reflection->getConstructor();

    if ($constructor === null) {
        $controller = new $controllerClass();
    } else {
        $dependencies = [];

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if (!$type instanceof ReflectionNamedType) {
                throw new RuntimeException("Tipo inválido no parâmetro");
            }

            $typeName = $type->getName();

            if (!array_key_exists($typeName, $container)) {
                throw new RuntimeException("Dependência não encontrada: $typeName");
            }

            $dependencies[] = $container[$typeName];
        }

        $controller = $reflection->newInstanceArgs($dependencies);
    }

} else {
    $controller = new Error404Controller();
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
    $psr17Factory,
);

$request = $creator->fromGlobals();

/** @var \Psr\Http\Server\RequestHandlerInterface $controller */
$response = $controller->handle($request);

// 🔹 Envia resposta
http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();