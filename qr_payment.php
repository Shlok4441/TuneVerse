<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['pending_plan_id'])) {
  header("Location: plans.html");
  exit();
}

$plan_id = $_SESSION['pending_plan_id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // After user confirms payment
  $conn = new mysqli('localhost', 'root', '', 'tuneverse');
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $update = $conn->query("UPDATE users SET plan_id = $plan_id WHERE id = $user_id");

  if ($update) {
    $_SESSION['plan_id'] = $plan_id;
    unset($_SESSION['pending_plan_id']); // remove after use
    header("Location: home.php");
    exit();
  } else {
    $message = "Payment successful, but plan update failed.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>QR Payment - TUNEVERSE</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.9)),
                  url('back.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .qr-container {
      background: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      backdrop-filter: blur(10px);
    }

    .qr-container img {
      width: 250px;
      height: 250px;
      margin-bottom: 20px;
      border: 3px solid #fff;
      border-radius: 10px;
    }

    .qr-container form button {
      padding: 10px 20px;
      background-color: #ffd700;
      color: #000;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .qr-container form button:hover {
      background-color: #ffcc00;
    }

    h2 {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="qr-container">
    <h2>Scan QR to Complete Payment</h2>
    <!-- Replace with your QR code image -->
    <img src="qr_code.jpg" alt="QR Code for Payment">
    <form method="POST">
      <button type="submit">Payment Done</button>
    </form>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
  </div>

</body>
</html>
