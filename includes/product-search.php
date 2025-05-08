<?php
require_once 'db.php';

if (isset($_GET['query'])) {
    $q = trim($_GET['query']);
    $stmt = $pdo->prepare("SELECT id, name FROM products WHERE name LIKE :q LIMIT 5");
    $stmt->execute([':q' => "%$q%"]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($rows)) {
        echo '<ul><li>No matches</li></ul>';
    } else {
        echo '<ul>';
        foreach ($rows as $r) {
            echo '<li>';
            echo '<span>' . htmlspecialchars($r['name']) . '</span>';
            echo ' <a href="../pages/admin-edit-product.php?id=' . $r['id'] . '">Edit</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
