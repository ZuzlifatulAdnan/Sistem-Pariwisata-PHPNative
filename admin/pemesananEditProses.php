<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Retrieve form data
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$tanggalBerangkat = $_POST['tanggalBerangkat'];
$objekWisataId = $_POST['objekWisataId'];
$jenisKelamin = $_POST['jekel'];
$jumlahPeserta = $_POST['jumlahPeserta'];
$paket = isset($_POST['paket']) ? $_POST['paket'] : [];
$totalHarga = $_POST['totalHarga'];
$noTelephone = $_POST['noTelephone'];

// Validate input
if (
    empty($nama) || empty($alamat) || empty($tanggalBerangkat) || empty($objekWisataId)
    || empty($jenisKelamin) || empty($jumlahPeserta) || empty($totalHarga) || empty($noTelephone)
) {
    echo "<script>alert('Semua field harus diisi.'); window.location.href='pemesananEdit.php?id=$noPemesanan';</script>";
    exit();
}

// Prepare SQL statement
$sql = "UPDATE pemesanan SET nama=?, alamat=?, tanggalBerangkat=?, jenisKelamin=?, objekWisataId=?, 
jumlahPeserta=?, paket=?, totalHarga=?, noTelephone=? WHERE noPemesanan=?";

if ($stmt = $conn->prepare($sql)) {
    // Convert paket array to a comma-separated string
    $paketString = implode(',', $paket);

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ssssisssss", $nama, $alamat, $tanggalBerangkat, $jenisKelamin, $objekWisataId, $jumlahPeserta, $paketString, $totalHarga, $noTelephone, $noPemesanan);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        echo "<script>alert('Paket Wisata Berhasil Diperbarui'); window.location.href='pemesanan.php';</script>";
        exit();
    } else {
        // Log error to a file or handle it gracefully
        error_log("ERROR: Could not execute query: $sql. " . $conn->error);
        echo "An error occurred. Please try again later.";
    }

    // Close statement
    $stmt->close();
} else {
    // Log error to a file or handle it gracefully
    error_log("ERROR: Could not prepare query: $sql. " . $conn->error);
    echo "An error occurred. Please try again later.";
}

// Close connection
$conn->close();
?>
