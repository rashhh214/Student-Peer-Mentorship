<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['student_id'])) {
  header("Location: student_login.php");
  exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];


if (isset($_GET['join'])) {
  $tutorial_id = $_GET['join'];
  $check = $conn->query("SELECT * FROM tutorial_signups WHERE student_id=$student_id AND tutorial_id=$tutorial_id");
  if ($check->num_rows == 0) {
    $conn->query("INSERT INTO tutorial_signups (tutorial_id, student_id) VALUES ($tutorial_id, $student_id)");
  }
} elseif (isset($_GET['withdraw'])) {
  $tutorial_id = $_GET['withdraw'];
  $conn->query("DELETE FROM tutorial_signups WHERE student_id=$student_id AND tutorial_id=$tutorial_id");
}


$tutorials = $conn->query("SELECT t.*, m.name AS mentor_name FROM tutorials t JOIN mentors m ON t.mentor_id = m.id WHERE t.is_public=1");
$my_signups = $conn->query("SELECT tutorial_id FROM tutorial_signups WHERE student_id=$student_id");
$signed_ids = [];
while($row = $my_signups->fetch_assoc()) {
  $signed_ids[] = $row['tutorial_id'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h2>Welcome, <?php echo $student_name; ?>!</h2>
  <a href="logout.php">Logout</a>
  <h3>Available Tutorials</h3>
  <table border="1" cellpadding="5">
    <tr>
      <th>Title</th>
      <th>Topic</th>
      <th>Mentor</th>
      <th>Schedule</th>
      <th>Duration</th>
      <th>Action</th>
    </tr>
    <?php while($row = $tutorials->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['topic']; ?></td>
        <td><?php echo $row['mentor_name']; ?></td>
        <td><?php echo $row['schedule']; ?></td>
        <td><?php echo $row['duration']; ?></td>
        <td>
          <?php if (in_array($row['id'], $signed_ids)): ?>
            <a href="?withdraw=<?php echo $row['id']; ?>">Withdraw</a>
          <?php else: ?>
            <a href="?join=<?php echo $row['id']; ?>">Join</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
