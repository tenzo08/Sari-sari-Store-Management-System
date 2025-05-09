<?php
session_start();

// Database connection
require_once '../includes/db.php';

// Fetch transactions of the day
$date_today = date('Y-m-d');
$query = "SELECT t.transaction_id, t.total_amount, t.amount_received, t.transaction_time, u.username AS cashier
          FROM transactions t
          LEFT JOIN users u ON t.cashier_id = u.id
          WHERE DATE(t.transaction_time) = :date_today
          ORDER BY t.transaction_time DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['date_today' => $date_today]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management - Sari-Sari Store</title>
    <link rel="stylesheet" href="../assets/admin-transaction-style.css">
</head>
<body>
    <a href="admin-page.php" class="back-button">Back</a>

    <h1>Transaction Management</h1>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Cashier</th>
                    <th>Total Amount</th>
                    <th>Transaction Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?= $transaction['transaction_id'] ?></td>
                        <td><?= $transaction['cashier'] ?></td>
                        <td>₱<?= number_format($transaction['total_amount'], 2) ?></td>
                        <td><?= $transaction['transaction_time'] ?></td>
                        <td>
                            <button class="info-button" onclick="showTransactionDetails(<?= $transaction['transaction_id'] ?>)">Info</button>
                            <button class="cancel-button" onclick="cancelTransaction(<?= $transaction['transaction_id'] ?>)">Cancel</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="../includes/transaction-management-script.js"></script>
</body>
</html>
