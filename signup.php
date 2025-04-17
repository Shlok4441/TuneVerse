<?php
$conn = new mysqli('localhost', 'root', '', 'tuneverse');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$plan_id = $_POST['plan_id'];

$sql = "INSERT INTO users (fullname, email, password, plan_id) VALUES ('$fullname', '$email', '$password', '$plan_id')";

if ($conn->query($sql) === TRUE) {
  // Redirect to login page after 2 seconds
  header("Refresh: 2; url=login.html");
  echo "Signup successful. Redirecting to login page...";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();
?>
