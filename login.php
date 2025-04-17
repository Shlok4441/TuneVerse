<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'tuneverse');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user from DB
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $user = $result->fetch_assoc();

  if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['fullname'] = $user['fullname'];
    $_SESSION['plan_id'] = $user['plan_id'];
    header("Location: home.php");
    exit();
  } else {
    echo "Incorrect password.";
  }
} else {
  echo "User not found.";
}

$conn->close();
?>
