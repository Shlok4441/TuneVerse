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
$name = $_SESSION['fullname'];
$plan_id = $_SESSION['plan_id'];

$plan_sql = "SELECT * FROM plans WHERE id = $plan_id";
$plan_result = $conn->query($plan_sql);
$plan = $plan_result->fetch_assoc();

$songs_sql = "SELECT * FROM songs";
$songs_result = $conn->query($songs_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to TUNEVERSE</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)),
                  url('back.jpg') no-repeat center center fixed;
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

    .layout {
      display: flex;
      margin-top: 80px;
      min-height: calc(100vh - 70px);
      padding: 30px;
    }

    .sidebar {
      display: none;
    }

    .main-content {
      flex: 1;
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    .main-content h2 {
      font-size: 28px;
      margin-bottom: 10px;
      color: #ffd700;
    }

    .main-content p {
      font-size: 16px;
      margin-bottom: 20px;
    }

    .songs-grid {
      display: flex;
      overflow-x: auto;
      gap: 20px;
      padding: 20px 0;
    }

    .song-card {
      min-width: 220px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(6px);
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }

    .song-card:hover {
      transform: translateY(-5px);
    }

    .song-card h4 {
      font-size: 18px;
      margin-bottom: 8px;
    }

    .song-card p {
      font-size: 14px;
      color: #ccc;
      margin-bottom: 12px;
    }

    .song-card audio {
      width: 100%;
      outline: none;
      border-radius: 6px;
    }

    .songs-grid::-webkit-scrollbar {
      height: 8px;
    }

    .songs-grid::-webkit-scrollbar-thumb {
      background: #aaa;
      border-radius: 4px;
    }

    .songs-grid::-webkit-scrollbar-track {
      background: transparent;
    }

    .library-section {
      margin-top: 40px;
    }

    .library-section h3 {
      font-size: 24px;
      margin-bottom: 10px;
      color: #ffd700;
    }

    .library-section h5 {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .create-playlist-btn,
    .view-playlist-btn {
      padding: 10px 20px;
      background-color: #ffd700;
      color: #000;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-right: 10px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .create-playlist-btn:hover,
    .view-playlist-btn:hover {
      background-color: #ffcc00;
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 20px;
      }

      .song-card {
        min-width: 180px;
        padding: 15px;
      }

      .library-section {
        text-align: center;
      }

      .create-playlist-btn,
      .view-playlist-btn {
        width: 100%;
        margin-top: 10px;
      }
    }
  </style>
</head>
<body>

  <div id="navbar">
    <h1>TUNEVERSE</h1>
    <div>
      <a href="plans.html">Upgrade Plan</a>
      <a href="feedback.html">Feedback</a>
      <a href="add_song.php">Add Song</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="layout">
    <div class="main-content">
      <h2>Hi, <?php echo htmlspecialchars($name); ?>! 👋</h2>
      <p>Your Current Plan: <strong><?php echo $plan['name']; ?></strong> – ₹<?php echo $plan['price']; ?></p>

      <h3>Songs Available:</h3>
      <div class="songs-grid">
        <?php while ($row = $songs_result->fetch_assoc()): ?>
          <div class="song-card">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <p><?php echo htmlspecialchars($row['artist']); ?></p>
            <audio controls src="<?php echo htmlspecialchars($row['url']); ?>" type="audio/mpeg"></audio>
          </div>
        <?php endwhile; ?>
      </div>

      <div class="library-section">
        <h3>Your Library</h3>
        <h5>Create Your Playlist!</h5>
        <a href="create_playlist.php">
          <button class="create-playlist-btn">Create Playlist</button>
        </a>
        <a href="view_playlists.php">
          <button class="view-playlist-btn">View Playlist</button>
        </a>
      </div>
    </div>
  </div>

</body>
</html>
