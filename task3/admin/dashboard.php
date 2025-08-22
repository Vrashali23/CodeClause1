<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Unauthorized access.");
}

$userId = $_SESSION['user']['id'];

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT exam_forms.id AS form_id, users.name, exams.title, exams.exam_date, exam_forms.status
        FROM exam_forms
        JOIN users ON exam_forms.user_id = users.id
        JOIN exams ON exam_forms.exam_id = exams.id";

$result = $conn->query($sql);
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<h2>Exam Applications</h2>
<table border="1">
    <tr>
        <th>Student Name</th>
        <th>Exam Title</th>
        <th>Exam Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['exam_date'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <?php if ($row['status'] == 'pending'): ?>
                <a href="approve_form.php?id=<?= $row['form_id'] ?>">Approve</a>
            <?php else: ?>
                Approved |
                <a href="../generate_pdf.php?id=<?= $row['form_id'] ?>" target="_blank">Download Hall Ticket</a>
            <?php endif; ?>
           

        </td>
    </tr>
    <?php endwhile; ?>
</table>
