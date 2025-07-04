<?php
include 'config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);

  if ($username && $email && $password && $confirm_password) {
    if ($password !== $confirm_password) {
      $message = "Passwords do not match.";
    } else {
      $check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
      $check->bind_param("ss", $username, $email);
      $check->execute();
      $check->store_result();

      if ($check->num_rows > 0) {
        $message = "Username or Email already exists.";
      } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        if ($stmt->execute()) {
          header("Location: login.php");
          exit();
        } else {
          $message = "Something went wrong.";
        }
      }
    }
  } else {
    $message = "All fields are required.";
  }
}
?>

<form method="post" class="container">
  <h2>Sign Up</h2>
  <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
  <button type="submit">Register</button><br>
  <p>Already registered? <a href="login.php">Login here</a></p>
</form>
