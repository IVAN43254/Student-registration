<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_name = $_POST['student_name'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $father_age = $_POST['father_age'];
    $mother_age = $_POST['mother_age'];
    $student_age = $_POST['student_age'];
    $tenth_mark = $_POST['tenth_mark'];
    $twelfth_mark = $_POST['twelfth_mark'];
    $cgpa = $_POST['cgpa'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo_name);

    move_uploaded_file($photo_tmp, $target_file);

    $stmt = $conn->prepare("INSERT INTO students (student_name, father_name, father_age, mother_name, mother_age, student_age, tenth_mark, twelfth_mark, cgpa, address, contact, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$student_name, $father_name, $father_age, $mother_name, $mother_age, $student_age, $tenth_mark, $twelfth_mark, $cgpa, $address, $contact, $photo_name]);

    header("Location: list_students.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Registration</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        padding: 20px;
    }

    form {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        width: 100%;
        max-width: 600px;
        margin: auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #cc0000;
        text-align: center;
    }

    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    button {
        margin-top: 20px;
        width: 100%;
        padding: 12px;
        background-color: #cc0000;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #990000;
    }
    </style>
</head>

<body>

    <form method="POST" enctype="multipart/form-data">
        <h2>Register Student</h2>

        <label>Student Name</label>
        <input type="text" name="student_name" required>

        <label>Father's Name</label>
        <input type="text" name="father_name" required>

        <label>Father's Age</label>
        <input type="number" name="father_age" required>

        <label>Mother's Name</label>
        <input type="text" name="mother_name" required>

        <label>Mother's Age</label>
        <input type="number" name="mother_age" required>

        <label>Student Age</label>
        <input type="number" name="student_age" required>

        <label>10th Mark (%)</label>
        <input type="text" name="tenth_mark" required>

        <label>12th Mark (%)</label>
        <input type="text" name="twelfth_mark" required>

        <label>CGPA in College</label>
        <input type="text" name="cgpa" required>

        <label>Address</label>
        <textarea name="address" rows="3" required></textarea>

        <label>Contact Number</label>
        <input type="text" name="contact" required>

        <label>Upload Student Photo</label>
        <input type="file" name="photo" accept="image/*" required>

        <button type="submit">Register Student</button>
    </form>

</body>

</html>