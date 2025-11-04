<?php
session_start();
include '../db_connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM students WHERE email=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    if (password_verify($password, $student['password'])) {
      $_SESSION['student_id'] = $student['id'];
      $_SESSION['student_name'] = $student['name'];
      header("Location: student_dashboard.php");
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
  <title>Student Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h2>Student Login</h2>
  <form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
  </form>
  <p><?php echo $message; ?></p>
  <p><a href="student_register.php">Create account</a></p>
  <p><a href="../index.php">Back to Home</a></p>
</body>
</html>
