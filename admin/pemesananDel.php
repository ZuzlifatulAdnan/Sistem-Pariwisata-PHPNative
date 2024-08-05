<?php
session_start();

// Check user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Database connection
include '../config/db.php';

// Check if the ID is set and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM pemesanan WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Data pemesanan berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus data pemesanan.";
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['message'] = "ID pemesanan tidak valid.";
}

// Redirect to the booking list page
header('Location: pemesanan.php');
exit();
?>
