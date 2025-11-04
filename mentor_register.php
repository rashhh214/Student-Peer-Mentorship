<?php
include __DIR__ . '/../db_connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO mentors (name, email, password) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $name, $email, $password);

  if ($stmt->execute()) {
    $message = "Mentor account created successfully! <a href='mentor_login.php'>Login here</a>";
  } else {
    $message = "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Mentor Registration</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h2>Mentor Registration</h2>
  <form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br>
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
  </form>
  <p><?php echo $message; ?></p>
  <p><a href="../index.php">Back to Home</a></p>
</body>
</html>
