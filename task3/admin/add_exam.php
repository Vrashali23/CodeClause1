<?php
include '../includes/db.php';
include '../includes/auth.php';

if ($_SESSION['user']['role'] !== 'admin') die("Unauthorized");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $exam_date = $_POST['exam_date'];

  $conn->query("INSERT INTO exams (title, description, exam_date) VALUES ('$title', '$description', '$exam_date')");
  echo "Exam created!";
}
?>

<h2>Add Exam</h2>
<form method="POST">
  <input type="text" name="title" required placeholder="Exam Title">
  <textarea name="description" placeholder="Description"></textarea>
  <input type="date" name="exam_date" required>
  <button type="submit">Add Exam</button>
</form>
