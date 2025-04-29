<?php
require_once 'db.php';
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['name']) || !isset($data['stock'])) {
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE products SET stock = :stock WHERE name = :name");
    $stmt->execute([
        ':stock' => $data['stock'],
        ':name' => $data['name']
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
