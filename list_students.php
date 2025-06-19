<?php
require 'config.php';

$stmt = $conn->prepare("SELECT id, student_name, student_age, contact FROM students ORDER BY created_at DESC");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>List of Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }
        h2 {
            text-align: center;
            color: #cc0000;
            margin-bottom: 30px;
        }
        .student-card {
            background-color: #ffe5e5;
            border-radius: 12px;
            padding: 20px;
            margin: 15px auto;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }
        .student-info {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
        .view-button {
            display: inline-block;
            padding: 10px 18px;
            background-color: #cc0000;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }
        .view-button:hover {
            background-color: #990000;
        }
    </style>
</head>
<body>

    <h2>List of Students</h2>

    <?php if (count($students) > 0): ?>
        <?php foreach ($students as $student): ?>
            <div class="student-card">
                <div class="student-info">
                    <span class="label">Name:</span> <?= htmlspecialchars($student['student_name']) ?>
                </div>
                <div class="student-info">
                    <span class="label">Age:</span> <?= htmlspecialchars($student['student_age']) ?>
                </div>
                <div class="student-info">
                    <span class="label">Contact:</span> <?= htmlspecialchars($student['contact']) ?>
                </div>
                <a class="view-button" href="detail.php?id=<?= $student['id'] ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; color:gray;">No students found.</p>
    <?php endif; ?>

</body>
</html>
