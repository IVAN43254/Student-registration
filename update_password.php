<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (!empty($token) && !empty($new_pass) && $new_pass === $confirm) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user && (!empty($user['token_expiry']) && strtotime($user['token_expiry']) > time())) {
            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
            $update->execute([$hashed, $user['id']]);
            echo "<script>alert('Password updated successfully! You can now log in.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Invalid or expired token.'); window.location='forgot_password.php';</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match or are empty.'); window.history.back();</script>";
    }
} else {
    header("Location: forgot_password.php");
    exit;
}