<?php
session_start();
?>

<h1>Welcome to Examination Management System</h1>

<?php if (isset($_SESSION['user'])): ?>
  <p>Hello, <?= $_SESSION['user']['name'] ?>!</p>
  <a href="<?= $_SESSION['user']['role'] == 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php' ?>">Go to Dashboard</a>
  <br><a href="logout.php">Logout</a>
<?php else: ?>
  <a href="login.php">Login</a> | <a href="register.php">Register</a>
<?php endif; ?>
