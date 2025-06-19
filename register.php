<?php
require 'config.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $mobile     = trim($_POST['mobile']);
    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];
    $fav_color  = trim($_POST['fav_color']);

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR mobile = ?");
        $stmt->execute([$email, $mobile]);

        if ($stmt->fetch()) {
            $error = "Email or mobile number already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, mobile, password, fav_color) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $mobile, $hashedPassword, $fav_color]);
            $success = "Registration successful! You can now <a href='login.php'>Login</a>.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register - Reon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        background: url('reon-logo.jpg.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: Arial;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background: rgba(255, 230, 230, 0.96);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 400px;
    }

    h2 {
        text-align: center;
        color: #cc0000;
        margin-bottom: 20px;
    }

    input {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        background: #cc0000;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #990000;
    }

    .message {
        text-align: center;
        margin: 10px 0;
        font-size: 14px;
    }

    .message.error {
        color: red;
    }

    .message.success {
        color: green;
    }

    a {
        color: #cc0000;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Register at Reon</h2>
        <?php if ($error): ?>
        <div class="message error"><?= $error ?></div>
        <?php elseif ($success): ?>
        <div class="message success"><?= $success ?></div>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="mobile" placeholder="Mobile Number" required pattern="[0-9]{10}">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="text" name="fav_color" placeholder="Your Favorite Color" required>

        <button type="submit">Register</button>
        <p class="message">Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>

</html>