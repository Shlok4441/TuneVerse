<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $plan_id = $_POST['plan_id'];
  $_SESSION['pending_plan_id'] = $plan_id; // store plan temporarily for QR payment

  header("Location: qr_payment.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Plan Upgrade - TUNEVERSE</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('back.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #fff;
    }

    #navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100px;
      background-color: rgba(0, 0, 0, 0.3);
      border-bottom: 1px solid #ccc;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      box-sizing: border-box;
      z-index: 1000;
      backdrop-filter: blur(6px);
    }

    #navbar h1 {
      margin: 0;
      color: #fff;
    }

    #navbar div a {
      margin-left: 20px;
      text-decoration: none;
      color: #fff;
      font-weight: bold;
    }

    #navbar div a:hover {
      color: #ffd700;
    }

    .content {
      margin-top: 120px;
      padding: 40px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 10px;
      backdrop-filter: blur(5px);
      text-align: center;
    }

    .content h2 {
      color: #ffd700;
    }

    .plan-options {
      margin-top: 20px;
    }

    .plan-options form {
      margin-bottom: 20px;
    }

    .plan-options button {
      padding: 10px 20px;
      background-color: #ffd700;
      color: black;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .plan-options button:hover {
      background-color: #ffcc00;
    }

  </style>
</head>
<body>

  <div id="navbar">
    <h1>TUNEVERSE</h1>
    <div>
      <a href="home.php">Home</a>
      <a href="add_song.php">Add Song</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="content">
    <h2>Choose a Plan to Upgrade</h2>

    <div class="plan-options">
      <!-- Example Plan Buttons -->
      <form method="POST">
        <input type="hidden" name="plan_id" value="1">
        <button type="submit">Basic Plan - ₹99/month</button>
      </form>

      <form method="POST">
        <input type="hidden" name="plan_id" value="2">
        <button type="submit">Premium Plan - ₹199/month</button>
      </form>

      <form method="POST">
        <input type="hidden" name="plan_id" value="3">
        <button type="submit">Platinum Plan - ₹299/month</button>
      </form>
    </div>
  </div>

</body>
</html>
