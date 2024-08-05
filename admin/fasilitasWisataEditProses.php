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
$id = $_POST['id'];
$nama = $_POST['nama'];
$objekWisataId = $_POST['objekWisataId'];
$jenisFasilitas = $_POST['jenisFasilitas'];

// Handle file upload
$foto = $_FILES['foto']['name'];
$tmpName = $_FILES['foto']['tmp_name'];
$uploadDir = 'fasilitas/';
$uploadFile = $uploadDir . basename($foto);

if (!empty($foto) && move_uploaded_file($tmpName, $uploadFile)) {
    // File upload successful, update the database
    $updateQuery = "UPDATE fasilitaswisata SET nama = ?, objekWisataId = ?, foto = ?, jenisFasilitas = ?, updated_at=NOW() WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sissi", $nama, $objekWisataId, $foto, $jenisFasilitas, $id);
} else {
    // If no new file is uploaded, update the other fields only
    $updateQuery = "UPDATE fasilitaswisata SET nama = ?, objekWisataId = ?, jenisFasilitas = ?, updated_at=NOW() WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sisi", $nama, $objekWisataId, $jenisFasilitas, $id);
}

if ($stmt->execute()) {
    echo "<script>alert('Fasilitas Wisata successfully Update.'); window.location.href='fasilitasWisata.php';</script>";
    exit();
} else {
    die("Database update failed: " . $stmt->error);
}
?>
