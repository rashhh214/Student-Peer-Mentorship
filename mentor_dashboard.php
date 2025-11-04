<?php
session_start();
include __DIR__ . '/../db_connect.php';;

if (!isset($_SESSION['mentor_id'])) {
  header("Location: mentor_login.php");
  exit();
}

$mentor_id = $_SESSION['mentor_id'];
$mentor_name = $_SESSION['mentor_name'];


$tutorials = $conn->query("SELECT * FROM tutorials WHERE mentor_id = $mentor_id");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mentor Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h2>Welcome, <?php echo $mentor_name; ?>!</h2>
  <a href="create_tutorial.php">Create New Tutorial</a> |
  <a href="logout.php">Logout</a>

  <h3>Your Tutorials</h3>
  <table border="1" cellpadding="5">
    <tr>
      <th>Title</th>
      <th>Topic</th>
      <th>Schedule</th>
      <th>View Students</th>
    </tr>
    <?php while($row = $tutorials->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['topic']; ?></td>
        <td><?php echo $row['schedule']; ?></td>
        <td><a href="view_students.php?tutorial_id=<?php echo $row['id']; ?>">View</a></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
