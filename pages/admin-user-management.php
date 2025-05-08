<?php
require_once '../includes/db.php';

$stmt = $pdo->query("SELECT u.id, u.username, u.email, c.status 
                     FROM users u 
                     JOIN cashier_status c ON c.user_id = u.id 
                     WHERE c.status IN ('pending', 'accepted')");
$cashiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cashier_id = $_POST['cashier_id'];
    $action = $_POST['action'];

    try {
        if ($action == 'retire') {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("DELETE FROM cashier_status WHERE user_id = :id");
            $stmt->execute([':id' => $cashier_id]);

            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $cashier_id]);

            $pdo->commit();
        } else {
            $new_status = ($action == 'accept') ? 'accepted' : 'rejected';
            $stmt = $pdo->prepare("UPDATE cashier_status SET status = :status WHERE user_id = :id");
            $stmt->execute([':status' => $new_status, ':id' => $cashier_id]);
        }

        header("Location: admin-user-management.php");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Store Cashiering</title>
    <link rel="stylesheet" href="../assets/admin-page-style.css">
</head>
<body>
    <!-- Back Button -->
    <a href="admin-page.php" class="back-button">Back</a>

    <h1>Cashier Management</h1>

    <?php if (empty($cashiers)): ?>
        <p>No cashiers with pending or accepted status.</p>
    <?php else: ?>
        <div class="cashier-list">
            <table>
                <thead>
                    <tr>
                        <th>Cashier Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cashiers as $cashier): ?>
                        <tr>
                            <td><?= htmlspecialchars($cashier['username']) ?></td>
                            <td><?= htmlspecialchars($cashier['email']) ?></td>
                            <td><?= htmlspecialchars($cashier['status']) ?></td>
                            <td>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="cashier_id" value="<?= $cashier['id'] ?>">
                                    <?php if ($cashier['status'] == 'pending'): ?>
                                        <button type="submit" name="action" value="accept" class="accept-btn">Accept</button>
                                        <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
                                    <?php elseif ($cashier['status'] == 'accepted'): ?>
                                        <button type="submit" name="action" value="retire" class="retire-btn">Retire</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>
