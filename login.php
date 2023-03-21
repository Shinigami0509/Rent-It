<?php
// Set up database connection
$host = "localhost";
$dbname = "rentit";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve email and password from database based on email
$email = $_POST["email"];
$stmt = $conn->prepare("SELECT email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($email_db, $password_hash);
$stmt->fetch();

// Verify password and log in user if authentication succeeds
if (password_verify($_POST["password"], $password_hash)) {
  session_start();
  $_SESSION["email"] = $email_db;
  header("Location: dashboard.php");
  exit;
} else {
  echo "Invalid email or password.";
}

// Close database connection
$conn->close();
?>