<?php
session_start();
include '../config/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $user_id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputs
    if (empty($username)) {
        die("Please fill all fields");
    }

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL based on whether password is provided
    if (empty($password)) {
        // Update only username
        $stmt = $conn->prepare("UPDATE users SET username = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $username, $user_id);
    } else {
        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Update username and password
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("ssi", $username, $hashedPassword, $user_id);
    }

    // Execute and check
    if ($stmt->execute()) {
        echo "<script>
                alert('User updated successfully');
                window.location.href = 'user.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
