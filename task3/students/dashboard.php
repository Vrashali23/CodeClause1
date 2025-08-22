<?php
session_start();
include '../includes/db.php';
if ($_SESSION['user']['role'] !== 'student') die("Unauthorized");

$userId = $_SESSION['user']['id'];

// Fetch exams from DB only once
$exams = $conn->query("SELECT * FROM exams");
?>

<h2>Available Exams</h2>
<form method="POST">
    <select name="exam_id" required>
        <option value="" disabled selected>Select an Exam</option>
        <?php
        while ($row = mysqli_fetch_assoc($exams)) {
            echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
        }
        ?>
    </select>
    <input type="submit" name="submit_form" value="Submit Exam Form">
</form>

<?php
// Check if form was submitted
if (isset($_POST['submit_form']) && isset($_POST['exam_id'])) {
    $examId = $_POST['exam_id'];

    // Check if already submitted
    $check = $conn->query("SELECT * FROM exam_forms WHERE user_id = $userId AND exam_id = $examId");
    if ($check->num_rows > 0) {
        echo "<p>You have already submitted the form for this exam.</p>";
    } else {
        $conn->query("INSERT INTO exam_forms (user_id, exam_id, status) VALUES ($userId, $examId, 'pending')");
        echo "<p>Form submitted successfully and is pending approval.</p>";
    }
}

// Check for approved form to show download option
$result = $conn->query("SELECT exam_forms.id 
                        FROM exam_forms 
                        JOIN exams ON exam_forms.exam_id = exams.id 
                        WHERE exam_forms.user_id = $userId AND exam_forms.status = 'approved' 
                        LIMIT 1");
if ($row = $result->fetch_assoc()) {
    $form_id = $row['id'];
    echo "<br><a href='download_hallticket.php?id=$form_id' target='_blank' 
             style='padding:10px 20px; background-color:#28a745; color:white; text-decoration:none; border-radius:5px;'>
             Download Hall Ticket
          </a>";
} else {
    echo "<p>Your hall ticket will appear here once approved by the admin.</p>";
}
?>
