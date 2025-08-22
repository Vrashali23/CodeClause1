<?php
session_start();
include '../includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SESSION['user']['role'] !== 'admin') die("Unauthorized");

// Approve logic with email
if (isset($_GET['approve_id'])) {
    $formId = $_GET['approve_id'];

    // Approve in DB
    $conn->query("UPDATE exam_forms SET status='approved' WHERE id=$formId");

    // Fetch student details
    $res = $conn->query("SELECT users.name, users.email, exams.title 
                         FROM exam_forms 
                         JOIN users ON exam_forms.user_id = users.id 
                         JOIN exams ON exam_forms.exam_id = exams.id 
                         WHERE exam_forms.id = $formId");
    $student = $res->fetch_assoc();

    // Send Email
    $mail = new PHPMailer(true);
    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'vrashalikodgire2104@gmail.com'; // ✅ Your Gmail address
        $mail->Password = 'nnadqsbeefovqtjv';    // ✅ App password from Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email
        $mail->setFrom('your_email@gmail.com', 'Exam Department');
        $mail->addAddress($student['email'], $student['name']);
        $mail->Subject = "Your Exam Form has been Approved!";
        $mail->Body = "Dear {$student['name']},\n\nYour form for the exam \"{$student['title']}\" has been approved.\n\nYou can now download your hall ticket from the student dashboard.\n\nRegards,\nExam Department";

        $mail->send();
        echo "<p style='color:green;'>Form ID $formId approved and email sent to student.</p>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>Form approved, but email failed: {$mail->ErrorInfo}</p>";
    }
}
