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
    <link rel="stylesheet" href="../assets/style.css">
</head>
    
<body>
    <a href="../index.php" class="back-button">Logout</a>

    <h1>Cashier</h1>
    <h2>
        <div class="rejected">
            Your signup status is<br/>rejected.
        </div>
    </h2>
</body>
</html>
