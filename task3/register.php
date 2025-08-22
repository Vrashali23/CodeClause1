<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = 'student';

  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
  if ($conn->query($sql)) {
    echo "Registration successful! <a href='login.php'>Login Now</a>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>

<h2>Student Registration</h2>
<form method="POST">
  <input type="text" name="name" placeholder="Full Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Register</button>
</form>
