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

$user_id = $_SESSION['user_id'];

$playlists_sql = "SELECT * FROM playlists WHERE user_id = $user_id";
$playlists_result = $conn->query($playlists_sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Playlists - TUNEVERSE</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.9)),
                  url('back.jpg.') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
    }

    #navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 70px;
      background-color: rgba(0, 0, 0, 0.4);
      border-bottom: 1px solid #444;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      backdrop-filter: blur(10px);
      z-index: 1000;
    }

    #navbar h1 {
      font-size: 24px;
    }

    #navbar div a {
      margin-left: 20px;
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      transition: color 0.3s;
    }

    #navbar div a:hover {
      color: #ffd700;
    }

    .main-content {
      margin-top: 100px;
      padding: 40px 20px;
      max-width: 1000px;
      margin-left: auto;
      margin-right: auto;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 16px;
      backdrop-filter: blur(8px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    .main-content h2 {
      text-align: center;
      font-size: 28px;
      color: #ffd700;
      margin-bottom: 30px;
    }

    .playlist-card {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      text-align: center;
      backdrop-filter: blur(6px);
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    .playlist-card h4 {
      font-size: 20px;
      color: #fff;
      margin-bottom: 10px;
    }

    .playlist-card a {
      color: #ffd700;
      text-decoration: none;
      font-weight: 600;
      font-size: 16px;
    }

    .playlist-card a:hover {
      text-decoration: underline;
    }

    p {
      text-align: center;
      font-size: 18px;
      color: #ccc;
    }

    @media (max-width: 600px) {
      .main-content {
        padding: 30px 15px;
      }

      #navbar {
        flex-direction: column;
        height: auto;
        gap: 10px;
        padding: 10px 20px;
      }

      #navbar h1 {
        font-size: 20px;
      }

      #navbar div a {
        margin: 0 10px;
      }
    }
  </style>
</head>
<body>

  <div id="navbar">
    <h1>TUNEVERSE</h1>
    <div>
      <a href="home.php">Home</a>
      <a href="plans.html">Upgrade Plan</a>
      <a href="feedback.html">Feedback</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="main-content">
    <h2>Your Playlists</h2>
    
    <?php if ($playlists_result->num_rows > 0): ?>
      <?php while ($row = $playlists_result->fetch_assoc()): ?>
        <div class="playlist-card">
          <h4><?php echo htmlspecialchars($row['name']); ?></h4>
          <a href="view_playlist_songs.php?playlist_id=<?php echo $row['id']; ?>">View Songs</a>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No playlists found. Start creating one!</p>
    <?php endif; ?>

  </div>

</body>
</html>
