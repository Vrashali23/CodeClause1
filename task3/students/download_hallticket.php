<<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ... rest of your code that generates PDF


session_start();
include '../includes/db.php';

$form_id = $_GET['id'] ?? 0;

$sql = "SELECT users.name, exams.title, exams.exam_date 
        FROM exam_forms 
        JOIN users ON exam_forms.user_id = users.id 
        JOIN exams ON exam_forms.exam_id = exams.id 
        WHERE exam_forms.id = $form_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$dompdf = new Dompdf();
$html = "
    <h1 style='text-align: center;'>Hall Ticket</h1>
    <hr>
    <p><strong>Student Name:</strong> {$row['name']}</p>
    <p><strong>Exam Title:</strong> {$row['title']}</p>
    <p><strong>Exam Date:</strong> {$row['exam_date']}</p>
    <hr>
    <p style='text-align:center;'>Please carry this hall ticket and a valid ID on exam day.</p>
";

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("hallticket.pdf", ["Attachment" => false]);
?>
