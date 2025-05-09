<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['transaction_id'])) {
    $transaction_id = intval($_GET['transaction_id']);

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Delete transaction items
        $stmt = $pdo->prepare("DELETE FROM transactions_items WHERE transaction_id = :transaction_id");
        $stmt->execute(['transaction_id' => $transaction_id]);

        // Delete transaction
        $stmt = $pdo->prepare("DELETE FROM transactions WHERE transaction_id = :transaction_id");
        $stmt->execute(['transaction_id' => $transaction_id]);

        // Commit transaction
        $pdo->commit();

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // Rollback on error
        $pdo->rollBack();
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
