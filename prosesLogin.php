<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Use prepared statements to avoid SQL injection
  $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['username'] = $user['username'];
      header('Location: dashboard.php');
      exit();
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "No user found with that username.";
  }

  $stmt->close();
  $conn->close();
} else {
  header('Location: login.php');
  exit();
}
?>