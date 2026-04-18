<?php

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions([
    PDO::class => function (): PDO {
        return new PDO(
            'mysql:host=localhost;dbname=Aluraplay1;charset=utf8mb4',
        'root',
        'Testealuraplay',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    },

    \League\Plates\Engine::class => function () {
        $templatePath = __DIR__ . '/../Views';
        return new \League\Plates\Engine($templatePath);
    },
]);

$container = $builder->build();

return $container;