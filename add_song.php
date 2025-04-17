<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}

$conn = new mysqli('localhost', 'root', '', 'tuneverse');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $url = $_POST['url'];

  $sql = "INSERT INTO songs (title, artist, url) VALUES ('$title', '$artist', '$url')";
  
  if ($conn->query($sql) === TRUE) {
    echo "Song added successfully!";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Song - TUNEVERSE</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)),
                  url('back.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    #navbar {
      width: 100%;
      background-color: rgba(0, 0, 0, 0.3);
      padding: 15px 40px;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      backdrop-filter: blur(10px);
      z-index: 1000;
    }

    #navbar h1 a {
      color: #fff;
      text-decoration: none;
      font-size: 24px;
      font-weight: bold;
    }

    #navbar a {
      color: #fff;
      text-decoration: none;
      margin: 0 15px;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    #navbar a:hover {
      color: #ffd700;
    }

    .container {
      background: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 16px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      margin-top: 60px;
    }

    form h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 26px;
      color: #ffd700;
    }

    label {
      font-size: 16px;
      display: block;
      margin-bottom: 6px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-radius: 8px;
      outline: none;
      font-size: 15px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
    }

    input[type="submit"] {
      background-color: #ffd700;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #ffcc00;
    }

    textarea::placeholder, input::placeholder {
      color: #eee;
    }

    @media (max-width: 600px) {
      .container {
        margin: 100px 20px 20px 20px;
        padding: 30px 20px;
      }

      #navbar {
        flex-direction: column;
        gap: 10px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <div id="navbar">
    <h1><a href="index.html">TUNEVERSE</a></h1>
    <div>
      <a href="home.php">Home</a>
      <a href="plans.html">Upgrade Plan</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <form action="add_song.php" method="POST">
      <h2>Add a New Song</h2>

      <label for="title">Song Title:</label>
      <input type="text" id="title" name="title" placeholder="Enter song title" required>

      <label for="artist">Artist:</label>
      <input type="text" id="artist" name="artist" placeholder="Enter artist name" required>

      <label for="url">Song URL (MP3 or YouTube):</label>
      <input type="text" id="url" name="url" placeholder="Enter song URL" required>

      <input type="submit" value="Add Song">
    </form>
  </div>

</body>
</html>
