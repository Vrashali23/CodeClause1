<?php
session_start();
include '../includes/db.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$form_id = $_GET['id'] ?? 0;

// Approve in DB
$conn->query("UPDATE exam_forms SET status = 'approved' WHERE id = $form_id");

// Fetch details
$sql = "SELECT users.email, users.name, exams.title, exams.exam_date 
        FROM exam_forms 
        JOIN users ON exam_forms.user_id = users.id 
        JOIN exams ON exam_forms.exam_id = exams.id 
        WHERE exam_forms.id = $form_id";
$row = $conn->query($sql)->fetch_assoc();

// Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your@gmail.com';
    $mail->Password = 'your_app_password'; // From Google App Passwords
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your@gmail.com', 'College Exam Dept');
    $mail->addAddress($row['email'], $row['name']);

    $mail->Subject = "Exam Form Approved: " . $row['title'];
    $mail->Body = "Hi {$row['name']},\n\nYour exam form for '{$row['title']}' on {$row['exam_date']} has been approved.\n\nYou can now download your hall ticket.";

    $mail->send();
} catch (Exception $e) {
    echo "Mail could not be sent. Error: {$mail->ErrorInfo}";
}

header("Location: view_forms.php");
exit();
?>
