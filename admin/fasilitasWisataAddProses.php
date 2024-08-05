<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Validate CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token");
}

// Process form data
$nama = $_POST['nama'];
$objekWisataId = $_POST['objekWisataId'];
$jenisFasilitas = $_POST['jenisFasilitas'];

// Handle file upload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $foto = $_FILES['foto']['name'];
    $tmpName = $_FILES['foto']['tmp_name'];
    $uploadDir = 'fasilitas/';
    $uploadFile = $uploadDir . basename($foto);

    if (move_uploaded_file($tmpName, $uploadFile)) {
        // File upload successful, insert into database
        $insertQuery = "INSERT INTO fasilitaswisata (nama, objekWisataId, foto, jenisFasilitas, created_at) VALUES (?, ?, ?, ?, NOw())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("siss", $nama, $objekWisataId, $foto, $jenisFasilitas);

        if ($stmt->execute()) {
            // Redirect to the listing page
            echo "<script>alert('Fasilitas Wisata successfully added.'); window.location.href='fasilitasWisata.php';</script>";
            exit();
        } else {
            die("Database insert failed: " . $stmt->error);
        }
    } else {
        die("File upload failed");
    }
} else {
    die("No file uploaded or file upload error");
}
?>
