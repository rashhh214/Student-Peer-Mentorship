<?php
session_start();
include __DIR__ . '/../db_connect.php';

if (!isset($_SESSION['mentor_id'])) {
  header("Location: mentor_login.php");
  exit();
}

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $topic = $_POST['topic'];
  $schedule = $_POST['schedule'];
  $duration = $_POST['duration'];
  $is_public = isset($_POST['is_public']) ? 1 : 0;
  $mentor_id = $_SESSION['mentor_id'];

  $sql = "INSERT INTO tutorials (mentor_id, title, description, topic, schedule, duration, is_public) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("isssssi", $mentor_id, $title, $desc, $topic, $schedule, $duration, $is_public);

  if ($stmt->execute()) {
    $message = "Tutorial created successfully!";
  } else {
    $message = "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Tutorial</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h2>Create Tutorial Session</h2>
  <form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br>
    <label>Description:</label><br>
    <textarea name="description" required></textarea><br>
    <label>Topic:</label><br>
    <input type="text" name="topic" required><br>
    <label>Schedule:</label><br>
    <input type="datetime-local" name="schedule" required><br>
    <label>Duration:</label><br>
    <input type="text" name="duration" required><br>
    <label><input type="checkbox" name="is_public" checked> Public</label><br><br>
    <input type="submit" value="Create Tutorial">
  </form>
  <p><?php echo $message; ?></p>
  <p><a href="mentor_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
