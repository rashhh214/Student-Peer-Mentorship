<?php
session_start();
include __DIR__ . '/../db_connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM mentors WHERE email=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $mentor = $result->fetch_assoc();
    if (password_verify($password, $mentor['password'])) {
      $_SESSION['mentor_id'] = $mentor['id'];
      $_SESSION['mentor_name'] = $mentor['name'];
      header("Location: mentor_dashboard.php");
      exit();
    } else {
      $message = "Invalid password.";
    }
  } else {
    $message = "No account found with that email.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mentor Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h2>Mentor Login</h2>
  <form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
  </form>
  <p><?php echo $message; ?></p>
  <p><a href="mentor_register.php">Create account</a></p>
  <p><a href="../index.php">Back to Home</a></p>
</body>
</html>
