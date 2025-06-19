<?php
require 'config.php';

$token = $_GET['token'] ?? '';
$valid = false;
$message = '';

if ($token) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user && (!empty($user['token_expiry']) && strtotime($user['token_expiry']) > time())) {
        $valid = true;
    } else {
        $message = "<p style='color:red;'>Invalid or expired token.</p>";
    }
} else {
    $message = "<p style='color:red;'>No token provided.</p>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password - Reon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        background: url('reon-logo.jpg.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: Arial;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        text-align: center;
    }

    h2 {
        color: #cc0000;
    }

    input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    button {
        background: #cc0000;
        color: white;
        padding: 12px;
        width: 100%;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #990000;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?= $message ?>
        <?php if ($valid): ?>
        <form method="POST" action="update_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Update Password</button>
        </form>
        <?php endif; ?>
    </div>
</body>

</html>