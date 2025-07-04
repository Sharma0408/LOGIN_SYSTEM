<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<div class="container">
  <h2>Welcome to the Dashboard</h2>
  <p>You are successfully logged in.</p>
  <a href="logout.php" class="btn">Logout</a>
</div>
