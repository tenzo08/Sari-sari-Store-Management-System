<?php
session_start();
$error = "";

require_once '../includes/db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = trim($_POST['password_confirm']);

    if(empty($username) || empty($email) || empty($password) || empty($password_confirm)){
        $error = "All fields are required.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format.";
    } elseif($password !== $password_confirm){
        $error = "Passwords do not match.";
    } elseif(strlen($password) < 4){
        $error = "Password must be at least 4 caharacters.";
    } else{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? or EMAIL = ?");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetch();

        if($existingUser){
            $error = "Username or email already exists.";
        } else{
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'administrator')");
            $stmt->execute([$username, $email, $password]);

            header("Location: ../index.php");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Store Cashiering</title>
    <link rel="stylesheet" href="../assets/signup-style.css">
</head>
<body>
    <a href="signup.php" class="back-button">Back</a>

    <h1>Administrator</h1>

    <div class="main-container">
        <form method="POST" action="">
            <fieldset>
                <div class="signup-container">
                    <div class="signup-credential-container">
                        <label for="username"><b>Name</b></label>
                        <input type="text" id="username" name="username" placeholder="Enter Name" required>
                    </div>
                    
                    <div class="signup-credential-container">
                        <label for="email"><b>Email</b></label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    </div>

                    <div class="signup-credential-container">
                        <label for="password"><b>Password</b></label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    </div>

                    <div class="signup-credential-container">
                        <label for="password_confirm"><b>Re-type Password</b></label>
                        <input type="password" id="password_confirm" name="password_confirm" placeholder="Re-enter Password" required>
                    </div>

                    <div class="error-container">
                        <?php if ($error): ?>
                            <p class="error"><?php echo $error; ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit">Sign Up</button>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>
