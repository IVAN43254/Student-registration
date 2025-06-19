<?php
require 'config.php';
require 'C:\wamp64\www\login\PHPMailer\PHPMailer-master\src\PHPMailer.php';
require 'C:\wamp64\www\login\PHPMailer\PHPMailer-master\src\SMTP.php';
require 'C:\wamp64\www\login\PHPMailer\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $color = $_POST['color'] ?? '';
    $message = '';

    if (!empty($email) && !empty($color)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND fav_color = ?");
        $stmt->execute([$email, $color]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', time() + 1800); // 30 minutes

            $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
            $stmt->execute([$token, $expiry, $email]);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                // $mail->Host       = 'mail.reontechnology.com';
                // $mail->SMTPAuth   = true;
                // $mail->Username   = 'testphp@reontechnology.com';
                // $mail->Password   = 'Reon@123/php';
                // $mail->SMTPSecure = 'ssl';
                // $mail->Port       = 465;
                $mail->Host       = 'mail.reontechnology.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'testphp@reontechnology.com';
$mail->Password   = 'Reon@123/php';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Changed from SMTPS
$mail->Port       = 587; // Changed from 465

                $mail->setFrom('testphp@reontechnology.com', 'Reon Technology');
                $mail->addAddress($email);
                $mail->addReplyTo('support@reontechnology.com', 'Reon Support');

                $mail->isHTML(true);
                $mail->Subject = 'Reset Your Password - Reon Technologies';
                $mail->Body    = "
                    <h3>Hello " . htmlspecialchars($user['name']) . ",</h3>
                    <p>You requested a password reset. Click the button below to proceed:</p>
                    <p><a href='http://localhost/reset_password.php?token=$token' style='padding: 10px 20px; background-color: #cc0000; color: white; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
                    <p>This link will expire in 30 minutes.</p>
                    <p>If you did not request a reset, please ignore this email.</p>
                    <br>— Reon Technologies
                ";

                $mail->send();
                echo "<script>alert('Reset link sent to your email!'); window.location='forgot_password.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Invalid email or favorite color.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please enter both email and favorite color.'); window.history.back();</script>";
    }
} else {
    header("Location: forgot_password.php");
    exit;
}