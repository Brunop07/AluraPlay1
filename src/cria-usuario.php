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

    $email = $argv[1];
    $password = $argv[2];
    $hash = password_hash($password, PASSWORD_ARGON2ID);

    $sql = 'INSERT INTO users (email, password) VALUES (?, ?);';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $email);
    $statement->bindValue(2, $hash);
    $statement->execute();

    echo "Usuário criado com sucesso!" . PHP_EOL;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage() . PHP_EOL;
}