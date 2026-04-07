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

    $sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id;';
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':url' => 'https://youtube.com/video123',
        ':title' => 'Novo título',
        ':id' => 1
    ]);

    echo "Atualizado com sucesso!";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}