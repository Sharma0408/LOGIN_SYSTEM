<?php
session_start();
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username_email = trim($_POST['username_email']);
  $password = trim($_POST['password']);

  if ($username_email && $password) {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
      $stmt->bind_result($id, $hashed_password);
      $stmt->fetch();
      if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: dashboard.php");
        exit();
      } else {
        $message = "Incorrect password.";
      }
    } else {
      $message = "User does not exist.";
    }
  } else {
    $message = "All fields are required.";
  }
}
?>

<form method="post" class="container">
  <h2>Login</h2>
  <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
  <input type="text" name="username_email" placeholder="Username or Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit">Login</button><br>
  <p>Don't have an account? <a href="register.php">Sign up</a></p>
</form>
