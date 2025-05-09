<?php
require_once 'db.php';

if (isset($_GET['transaction_id'])) {
    $transaction_id = intval($_GET['transaction_id']);

    // Fetch transaction items
    $query = "SELECT ti.product_id, p.name, ti.quantity, (p.price * ti.quantity) AS total_price
              FROM transactions_items ti
              JOIN products p ON ti.product_id = p.id
              WHERE ti.transaction_id = :transaction_id";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['transaction_id' => $transaction_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($items) {
        $details = "";
        foreach ($items as $item) {
            $details .= "Item: " . $item['name'] . " | Quantity: " . $item['quantity'] . " | Total: ₱" . number_format($item['total_price'], 2) . "\n";
        }

        echo json_encode(["success" => true, "details" => $details]);
    } else {
        echo json_encode(["success" => false, "details" => "No items found for this transaction."]);
    }
} else {
    echo json_encode(["success" => false, "details" => "Transaction ID not provided."]);
}
