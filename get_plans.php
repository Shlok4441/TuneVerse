<?php
$conn = new mysqli('localhost', 'root', '', 'tuneverse');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM plans");
$plans = [];

while ($row = $result->fetch_assoc()) {
  $plans[] = $row;
}

header('Content-Type: application/json');
echo json_encode($plans);
?>
