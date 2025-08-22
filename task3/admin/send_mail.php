<?php
session_start();
include '../includes/db.php';

require '../vendor/autoload.php';  // Load PHPMailer classes

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$form_id = $_GET['id'] ?? 0;

// Update form status to approved
$conn->query("UPDATE exam_forms SET status = 'approved' WHERE id = $form_id");

// Fetch user email and exam details
$sql = "SELECT users.email, users.name, exams.title, exams.exam_date 
        FROM exam_forms 
        JOIN users ON exam_forms.user_id = users.id 
        JOIN exams ON exam_forms.exam_id = exams.id 
        WHERE exam_forms.id = $form_id";

$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    die("Invalid form ID or no data found.");
}

$row = $result->fetch_assoc();
$to = $row['email'];
$name = $row['name'];
$subject = "Exam Form Approved: " . $row['title'];
$body = "
    Hi $name,<br><br>
    Your exam form for <strong>'" . $row['title'] . "'</strong> on <strong>" . $row['exam_date'] . "</strong> has been approved.<br><br>
    You can now <a href='http://localhost/exam_management/student/dashboard.php'>download your hall ticket</a> from your student dashboard.<br><br>
    Good luck!<br><br>
    Regards,<br>
    Exam Cell
";

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vrashalikodgire2104@gmail.com';          // ✅ your Gmail
    $mail->Password   = 'nnadqsbeefovqtjv';             // ✅ 16-char app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('your_email@gmail.com', 'Exam Cell');
    $mail->addAddress($to, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    // Optional: echo "Mail sent successfully.";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}

// Redirect back
header("Location: view_forms.php");
exit;
?>
