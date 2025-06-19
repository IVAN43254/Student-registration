<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Reon</title>
    <style>
    body {
        font-family: Arial;
        background: url('reon-logo.jpg.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
    }

    .container {
        background: rgba(255, 255, 255, 0.9);
        margin: 10% auto;
        padding: 30px;
        border-radius: 15px;
        width: 80%;
        max-width: 600px;
        text-align: center;
        color: #cc0000;
    }

    h1 {
        font-size: 28px;
    }

    p {
        font-size: 16px;
        margin-bottom: 25px;
    }

    a {
        display: inline-block;
        background-color: #cc0000;
        color: white;
        padding: 10px 20px;
        margin: 10px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        background-color: #990000;
    }

    @media (max-width: 600px) {
        .container {
            width: 95%;
            padding: 20px;
        }

        h1 {
            font-size: 22px;
        }

        p {
            font-size: 14px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome, <?= htmlspecialchars($userName); ?>!</h1>
        <p>Thank you for being a part of Reon Technologies. We’re committed to your journey of innovation and success.
            Dive into your dashboard and explore the best of tech and growth opportunities. Welcome aboard!</p>
        <a href="student.php">Student Registration</a>
        <a href="list_students.php">View Student List</a>
        <a href="logout.php">Logout</a>
    </div>
</body>

</html>