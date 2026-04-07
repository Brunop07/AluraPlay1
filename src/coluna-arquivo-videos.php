<?php

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=Aluraplay1;charset=utf8mb4',
        'root',
        'Testealuraplay',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $pdo->exec('ALTER TABLE videos ADD COLUMN image_path TEXT;');

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}