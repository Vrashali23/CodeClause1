<?php
require '../includes/sendMail.php';  // if your sendEmail function is there

$to = "kodgirevipul@gmail.com";  // your test email
$subject = "Test Mail";
$body = "This is a test email from PHP.";

if (sendEmail($to, $subject, $body)) {
    echo "Mail sent successfully.";
} else {
    echo "Failed to send mail.";
}
?>
