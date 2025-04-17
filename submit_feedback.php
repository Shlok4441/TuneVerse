<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $message = trim($_POST["message"]);

  if (!empty($message)) {
    $conn = new mysqli("localhost", "root", "", "tuneverse");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, message, submitted_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $user_id, $message);
    if ($stmt->execute()) {
      echo "<script>alert('Thanks for your feedback!'); window.location.href='home.php';</script>";
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
  } else {
    echo "<script>alert('Feedback message cannot be empty'); window.history.back();</script>";
  }
} else {
  header("Location: feedback.html");
  exit();
}
?>