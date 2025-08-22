<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Prevent SQL injection
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else if ($user['role'] === 'student') {
                header("Location: student/dashboard.php");
            } else {
                echo "Unknown role. Contact admin.";
            }
            exit;
        } else {
            echo "❌ Invalid password.";
        }
    } else {
        echo "❌ User not found.";
    }
}
?>

<form method="POST">
  <input type="email" name="email" required placeholder="Email">
  <input type="password" name="password" required placeholder="Password">
  <button type="submit">Login</button>
</form>
