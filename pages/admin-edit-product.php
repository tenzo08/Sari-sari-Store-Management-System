<?php
require_once '../includes/db.php';

if (isset($_GET['query'])) {
    $q = trim($_GET['query']);
    if ($q !== '') {
        $stmt = $pdo->prepare("SELECT id, name, price, stock FROM products WHERE name LIKE :q LIMIT 5");
        $stmt->execute([':q' => "%$q%"]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if (empty($rows)) {
        echo '<ul><li>No matches</li></ul>';
    } else {
        echo '<ul>';
        foreach ($rows as $r) {
            echo '<li>';
            echo '<span>' . htmlspecialchars($r['name']) . '</span>';
            echo '<form method="POST" action="admin-edit-product.php">';
            echo '<input type="hidden" name="search_name" value="' . htmlspecialchars($r['name']) . '">';
            echo '<button type="submit" name="search">Edit</button>';
            echo '</form>';
            echo '</li>';
        }
        echo '</ul>';

    }
    exit;
}

$error_message = $success_message = "";
$product = null;

if (isset($_POST['search'])) {
    $search_name = trim($_POST['search_name']);

    $stmt = $pdo->prepare("SELECT * FROM products WHERE name = :name");
    $stmt->execute([':name' => $search_name]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        $error_message = "No product found with that name!";
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['product_id'];
    $name = trim($_POST['product_name']);
    $price = (float)$_POST['product_price'];
    $stock = (int)$_POST['product_stock'];

    try {
        $stmt = $pdo->prepare("UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':stock' => $stock,
            ':id' => $id
        ]);
        $success_message = "Product updated successfully!";
        $product = null;
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['product_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $success_message = "Product deleted successfully!";
        $product = null;
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Sari-Sari Store</title>
    <link rel="stylesheet" href="../assets/admin-product-management-style.css">
</head>
<body>
    <a href="admin-product-management.php" class="back-button">Back</a>

    <h1>Edit Product</h1>

    <form method="POST" class="search-product-form">
        <label for="search_name">Search Product by Name</label>

        <div class="search-wrapper">
            <input type="text" id="search_name" name="search_name" required>
            <div id="suggestions" class="suggestions-list"></div>
        </div>

        <button type="submit" name="search" id="search-btn">Search</button>
    </form>

    <?php if ($error_message): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>

    <?php if ($product): ?>
        <form method="POST" class="edit-product-form">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label for="product_price">Product Price</label>
            <input type="number" id="product_price" name="product_price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required>

            <label for="product_stock">Product Quantity</label>
            <input type="number" id="product_stock" name="product_stock" value="<?= htmlspecialchars($product['stock']) ?>" required>

            <button type="submit" name="update">Update Product</button>
        </form>

        <form method="POST" class="delete-product-form">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
            <button type="submit" name="delete" style="background-color: red; color: white;">Delete Product</button>
        </form>
    <?php endif; ?>

    <script src="../includes/admin-page-edit-product.js" defer></script>
</body>
</html>
