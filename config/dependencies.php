<?php

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        return new PDO('mysql:' . __DIR__ . '/../criar-banco.php');
    },
    \league\Plates\Engine::class => function () {
        $templatePath = __DIR__ . '/../../Views';
        return new \league\Plates\Engine($templatePath);
    },
]);

$container = $builder->build();

return $container;
