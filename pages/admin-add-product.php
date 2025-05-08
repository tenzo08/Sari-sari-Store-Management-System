<?php
require_once '../includes/db.php';

session_start();

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['product_name']);
    $price = (float)$_POST['product_price'];
    $stock = (int)$_POST['product_quantity'];

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $existingProductCount = $stmt->fetchColumn();

        if ($existingProductCount > 0) {
            $error_message = "Error: Product name already exists!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)");
            $stmt->execute([ ':name' => $name, ':price' => $price, ':stock' => $stock ]);

            $_SESSION['success_message'] = "Product added successfully!";

            header("Location: admin-add-product.php");
            exit();
        }
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
    <title>Sari-Sari Store Cashiering</title>
    <link rel="stylesheet" href="../assets/admin-product-management-style.css">
</head>
<body>
    <a href="admin-product-management.php" class="back-button">Back</a>

    <h1>Add Product</h1>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <p id="success-message" style="color: green;"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <form class="add-product-form" method="POST">
        <label for="product_name">Product Name</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="product_price">Product Price</label>
        <input type="number" id="product_price" name="product_price" step="0.01" required>

        <label for="product_quantity">Product Quantity</label>
        <input type="number" id="product_quantity" name="product_quantity" required>

        <button type="submit">Add Product</button>
    </form>

    <script>
        
        window.onload = function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        };
    </script>
</body>
</html>
