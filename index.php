<?php
session_start();
$error = "";

require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if($user && $password === $user['password']){
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        if($_SESSION['role'] === 'administrator'){
            header("Location: pages/admin-page.php");
        } elseif($_SESSION['role'] === 'cashier'){
            $user_id = $_SESSION['user_id'];
            $stmt = $pdo->prepare("SELECT c.status FROM cashier_status c JOIN users u ON c.user_id = u.id WHERE u.id = ?");
            $stmt->execute([$user_id]);
            $cashier_status = $stmt->fetchColumn();

            if ($cashier_status) {
                $_SESSION['status'] = $cashier_status;
                if ($cashier_status === 'pending') {
                    header("Location: pages/cashier-status-pending.php");
                } elseif ($cashier_status === 'accepted') {
                    header("Location: pages/cashier-page.php");
                } elseif ($cashier_status === 'rejected') {
                    header("Location: pages/cashier-status-rejected.php");
                }
            }
        }
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
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <h1>Sari-Sari Store<br/>Management System</h1>

    <div class="main-container">
        <form method="POST" action="">
            <fieldset>
                <legend>Login</legend>
                <div class="login-container">
                    <div class="credential-container">
                        <label for="username"><b>Username</b></label>
                        <input type="text" id="username" name="username" placeholder="Enter Username" required>
                    </div>

                    <div class="credential-container">
                        <label for="password"><b>Password</b></label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    </div>

                    <?php if ($error): ?>
                        <p class="error"><?php echo $error; ?></p>
                    <?php endif; ?>

                    <button type="submit">Login</button>

                    <div class="signup-link">
                        <p>Don't have an account? <a href="pages/signup.php">Sign up</a></p>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>
