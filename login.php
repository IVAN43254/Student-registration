<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: welcome.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Reon Technologies</title>
    <style>
        body {
            font-family: Arial;
            background: url('reon-logo.jpg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            width: 320px;
            margin: 10% auto;
            padding: 30px 25px;
            border-radius: 20px;
            text-align: center;
            color: #cc0000;
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #cc0000;
            border-radius: 9px;
            background: #f0f8ff;
        }
        button {
            width: 95%;
            padding: 12px;
            margin-top: 10px;
            background-color: #cc0000;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #990000;
        }
        .links {
            margin-top: 15px;
            font-size: 14px;
        }
        .links a {
            display: block;
            color: #cc0000;
            text-decoration: none;
            margin-top: 6px;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        @media (max-width: 500px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <input type="password" name="password" placeholder="Enter your password" required><br>
            <button type="submit">Login</button>
        </form>
        <div class="links">
            <a href="register.php">New Registration</a>
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
