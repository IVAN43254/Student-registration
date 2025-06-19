<?php
require 'config.php';

if (!isset($_GET['id'])) {
    echo "No student ID provided.";
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Student not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Full Profile</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f9f9f9;
        padding: 40px;
    }

    .container {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        max-width: 700px;
        margin: auto;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #cc0000;
        margin-bottom: 25px;
    }

    .profile-photo {
        display: block;
        margin: 0 auto 25px auto;
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #cc0000;
    }

    .detail {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .label {
        font-weight: bold;
        color: #333;
    }

    .back-button {
        display: block;
        text-align: center;
        margin-top: 25px;
        padding: 12px 20px;
        background-color: #cc0000;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    }

    .back-button:hover {
        background-color: #990000;
    }

    .action-buttons {
        text-align: center;
        margin-top: 30px;
    }

    .action-buttons button {
        padding: 10px 15px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .print-btn {
        background-color: #28a745;
        color: white;
    }

    .pdf-btn {
        background-color: #007bff;
        color: white;
    }

    .excel-btn {
        background-color: #ffc107;
        color: black;
    }
    </style>
</head>

<body>

    <div class="container" id="profile-content">
        <h2>Student Profile</h2>

        <?php if (!empty($student['photo'])): ?>
        <img class="profile-photo" src="uploads/<?= htmlspecialchars($student['photo']) ?>" alt="Student Photo">
        <?php endif; ?>

        <div class="detail"><span class="label">Student Name:</span> <?= htmlspecialchars($student['student_name']) ?>
        </div>
        <div class="detail"><span class="label">Student Age:</span> <?= htmlspecialchars($student['student_age']) ?>
        </div>
        <div class="detail"><span class="label">Father's Name:</span> <?= htmlspecialchars($student['father_name']) ?>
        </div>
        <div class="detail"><span class="label">Father's Age:</span> <?= htmlspecialchars($student['father_age']) ?>
        </div>
        <div class="detail"><span class="label">Mother's Name:</span> <?= htmlspecialchars($student['mother_name']) ?>
        </div>
        <div class="detail"><span class="label">Mother's Age:</span> <?= htmlspecialchars($student['mother_age']) ?>
        </div>
        <div class="detail"><span class="label">10th Mark:</span> <?= htmlspecialchars($student['tenth_mark']) ?></div>
        <div class="detail"><span class="label">12th Mark:</span> <?= htmlspecialchars($student['twelfth_mark']) ?>
        </div>
        <div class="detail"><span class="label">CGPA:</span> <?= htmlspecialchars($student['cgpa']) ?></div>
        <div class="detail"><span class="label">Address (College):</span> <?= htmlspecialchars($student['address']) ?>
        </div>
        <div class="detail"><span class="label">Contact:</span> <?= htmlspecialchars($student['contact']) ?></div>
        <div class="detail"><span class="label">Registered At:</span> <?= htmlspecialchars($student['created_at']) ?>
        </div>

        <a class="back-button" href="list_students.php">← Back to Student List</a>

        <div class="action-buttons">
            <button class="print-btn" onclick="window.print()">🖨️ Print</button>
            <button class="pdf-btn" onclick="downloadPDF()">📄 Download PDF</button>
            <button class="excel-btn" onclick="exportToExcel()">📊 Export to Excel</button>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
    // Download PDF using html2canvas
    async function downloadPDF() {
        const profile = document.getElementById("profile-content");
        const canvas = await html2canvas(profile, {
            scale: 2
        });
        const imgData = canvas.toDataURL("image/png");

        const {
            jsPDF
        } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save("student_profile.pdf");
    }

    // Export specific fields to Excel
    function exportToExcel() {
        const data = [
            ["Field", "Value"],
            ["Student Name", "<?= $student['student_name'] ?>"],
            ["Father Name", "<?= $student['father_name'] ?>"],
            ["College", "<?= $student['address'] ?>"],
            ["CGPA", "<?= $student['cgpa'] ?>"],
            ["Age", "<?= $student['student_age'] ?>"],
            ["Phone", "<?= $student['contact'] ?>"]
        ];

        const ws = XLSX.utils.aoa_to_sheet(data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Student Profile");
        XLSX.writeFile(wb, "student_profile.xlsx");
    }
    </script>

</body>

</html>