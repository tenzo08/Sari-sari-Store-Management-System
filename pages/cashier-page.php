<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "1234") {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Store Cashiering</title>
    <link rel="stylesheet" href="../assets/cashier-page-style.css">
</head>
<body>
    <a href="../index.php" class="back-button">Logout</a>

    <input type="hidden" id="cashier-name" value="<?php echo htmlspecialchars($_SESSION['user']); ?>">
    <div class="main-container">
        <div class="cart-container">
            <div class="cart">
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Total Price</th>
                            <th>Number of Items</th>
                        </tr>
                    </thead>
                    <tbody id = "cart-items">
                        
                    </tbody>
                </table>
            </div>
            <div class="summary-of-items">
                <div class="amount-summary">
                    <div class="total-amount">
                        <h2>Total Amount: </h2><h2 id="total-amount"></h2>
                    </div>
                    <div>
                        <label for="amount-received"><b>Amount: </b></label>
                        <input type="number" id="amount-received" name="amount-received" placeholder="Amount Received" required>
                    </div>
                </div>
                <div class="checkout-button" id="checkout-button">
                    <button type="submit">Checkout</button>
                </div>
            </div>
        </div>
        <div class="inventory-container">
            <div class="inventory-search">
                <input type="text" id="inventory-search-input" placeholder="Search items...">
            </div>

            <div class="inventory-list" id="inventory-list">
                
            </div>
        </div>
    </div>

    <script src="../includes/cashier-page-script.js"></script>
</body>
</html>
