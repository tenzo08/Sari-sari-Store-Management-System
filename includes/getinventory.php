<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db.php'; // this must define $pdo correctly

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, name, price, stock FROM products");
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($inventory);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
