<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Signup successful. <a href='login.php'>Login here</a>";
    } else {
        echo "Error: Email might already exist.";
    }
    $stmt->close();
}
?>

<!-- HTML Signup Form -->
<form method="post">
  <input type="text" name="username" required placeholder="Username"><br>
  <input type="email" name="email" required placeholder="Email"><br>
  <input type="password" name="password" required placeholder="Password"><br>
  <button type="submit">Sign Up</button>
</form>
