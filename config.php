<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "loginsystem"; 

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
