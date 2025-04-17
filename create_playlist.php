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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $playlist_name = $_POST['playlist_name'];
  $songs_selected = isset($_POST['songs']) ? $_POST['songs'] : [];

  if ($playlist_name && !empty($songs_selected)) {
    $stmt = $conn->prepare("INSERT INTO playlists (user_id, name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $playlist_name);
    $stmt->execute();
    $playlist_id = $stmt->insert_id;
    $stmt->close();

    foreach ($songs_selected as $song_id) {
      $stmt = $conn->prepare("INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $playlist_id, $song_id);
      $stmt->execute();
      $stmt->close();
    }

    echo "<p style='text-align:center;color:yellow;margin-top:20px;'>Playlist created successfully! <a href='home.php' style='color: #ffd700;'>Go to Home</a></p>";
  } else {
    echo "<p style='text-align:center;color:red;margin-top:20px;'>Please select songs to add to the playlist.</p>";
  }
}

$songs_sql = "SELECT * FROM songs";
$songs_result = $conn->query($songs_sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Playlist - TUNEVERSE</title>
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
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 100px;
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

    .container {
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(8px);
      padding: 40px 30px;
      border-radius: 16px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      margin: auto;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 26px;
      color: #ffd700;
    }

    .container label {
      color: #fff;
      font-weight: 500;
      display: block;
      margin-top: 15px;
      margin-bottom: 8px;
    }

    .container input[type="text"] {
      width: 100%;
      padding: 12px;
      background-color: #222;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      margin-bottom: 20px;
    }

    .songs-checkbox label {
      display: block;
      margin-bottom: 10px;
      color: #fff;
      font-weight: 400;
    }

    .container button {
      width: 100%;
      padding: 12px;
      background-color: #ffd700;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
      margin-top: 20px;
    }

    .container button:hover {
      background-color: #ffcc00;
    }

    @media (max-width: 500px) {
      .container {
        padding: 30px 20px;
      }

      #navbar {
        flex-direction: column;
        height: auto;
        padding: 10px 20px;
        gap: 10px;
        text-align: center;
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

  <div class="container">
    <form method="POST">
      <h2>Create Your Playlist</h2>

      <label for="playlist_name">Playlist Name:</label>
      <input type="text" id="playlist_name" name="playlist_name" required>

      <div class="songs-checkbox">
        <label><strong>Select Songs to Add:</strong></label>
        <?php while ($row = $songs_result->fetch_assoc()): ?>
          <label>
            <input type="checkbox" name="songs[]" value="<?php echo $row['id']; ?>">
            <?php echo htmlspecialchars($row['title']) . ' - ' . htmlspecialchars($row['artist']); ?>
          </label>
        <?php endwhile; ?>
      </div>

      <button type="submit">Create Playlist</button>
    </form>
  </div>

</body>
</html>
