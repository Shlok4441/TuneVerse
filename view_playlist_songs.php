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
$playlist_id = $_GET['playlist_id'];

// Fetch the playlist details
$playlist_sql = "SELECT * FROM playlists WHERE user_id = $user_id AND id = $playlist_id";
$playlist_result = $conn->query($playlist_sql);
$playlist = $playlist_result->fetch_assoc();

// Fetch songs in the playlist
$songs_sql = "SELECT s.title, s.artist, s.url 
              FROM songs s 
              JOIN playlist_songs ps ON s.id = ps.song_id 
              WHERE ps.playlist_id = $playlist_id";
$songs_result = $conn->query($songs_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Playlist Songs - TUNEVERSE</title>
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
      margin: 0;
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
      margin-top: 90px;
      padding: 40px;
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      margin: 40px auto;
      width: 90%;
      max-width: 1200px;
    }

    .main-content h2 {
      font-size: 28px;
      margin-bottom: 30px;
      color: #ffd700;
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
      color: #fff;
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

    @media (max-width: 768px) {
      .main-content {
        padding: 30px 20px;
      }

      .song-card {
        min-width: 180px;
        padding: 15px;
      }
    }
  </style>
</head>
<body>

  <div id="navbar">
    <h1>TUNEVERSE</h1>
    <div>
      <a href="home.php">Home</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="main-content">
    <h2>Songs in Playlist: <?php echo htmlspecialchars($playlist['name']); ?></h2>

    <?php if ($songs_result->num_rows > 0): ?>
      <div class="songs-grid">
        <?php while ($song = $songs_result->fetch_assoc()): ?>
          <div class="song-card">
            <h4><?php echo htmlspecialchars($song['title']); ?></h4>
            <p><?php echo htmlspecialchars($song['artist']); ?></p>
            <audio controls src="<?php echo htmlspecialchars($song['url']); ?>" type="audio/mpeg"></audio>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p>No songs in this playlist yet. Add some songs!</p>
    <?php endif; ?>
  </div>

</body>
</html>
