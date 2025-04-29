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
    <a href="../index.php" class="back-button">Back</a>

    <h1>Administrator</h1>

    <div class="button-container">
        <div class="right-options">
            <button class="role-button" onclick="location.href='admin-user-management.php'" id="adminButton">User<br/>Management</button>
            <button class="role-button" onclick="location.href='admin-sales-report.php'" id="cashierButton">Sales Report</button>
        </div>
        <div class="left-options">
            <button class="role-button" onclick="location.href='admin-product-management.php'" id="adminButton">Product<br/>Management</button>
            <button class="role-button" onclick="location.href='admin-transactions.php'" id="cashierButton">Transactions</button>
        </div>
    </div>
</body>
</html>
