<?php
session_start();
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$cashierName = $data['cashierName'];
$totalAmount = $data['totalAmount'];
$amountReceived = $data['amountReceived'];
$cartItems = $data['cartItems'];

// Get the cashier's ID (replace this with your actual cashier table)
$cashier_id = getCashierId($cashierName, $pdo);

try {
    $pdo->beginTransaction();

    // Insert transaction record
    $stmt = $pdo->prepare("INSERT INTO transactions (cashier_id, total_amount, amount_received) VALUES (?, ?, ?)");
    $stmt->execute([$cashier_id, $totalAmount, $amountReceived]);
    $transactionId = $pdo->lastInsertId();

    // Insert transaction items
    $stmt = $pdo->prepare("INSERT INTO transactions_items (transaction_id, product_id, quantity) VALUES (?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmt->execute([$transactionId, $item['id'], $item['quantity']]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// Function to get cashier ID (replace with your actual user table query)
function getCashierId($username, $pdo) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}
?>
