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

// Generate unique ID
$prefix = "PM-";
$uniqueId = strtoupper($prefix . bin2hex(random_bytes(8)));

// Validate input
if (
    empty($nama) || empty($alamat) || empty($tanggalBerangkat) || empty($objekWisataId)
    || empty($jenisKelamin) || empty($jumlahPeserta) || empty($totalHarga) || empty($noTelephone)
) {
    echo "<script>alert('Semua field harus diisi.'); window.location.href='pemesananAdd.php';</script>";
    exit();
}

// Prepare SQL statement
$sql = "INSERT INTO pemesanan (noPemesanan,nama, alamat, tanggalBerangkat, jenisKelamin, objekWisataId, 
jumlahPeserta, paket, totalHarga, noTelephone, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

if ($stmt = $conn->prepare($sql)) {

    // Convert paket array to a comma-separated string
    $paketString = implode(',', $paket);

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("sssssissss", $uniqueId, $nama, $alamat, $tanggalBerangkat, $jenisKelamin, $objekWisataId, $jumlahPeserta, $paketString, $totalHarga, $noTelephone);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        echo "<script>alert('Paket Wisata Berhasil Ditambah'); window.location.href='pemesanan.php';</script>";
        exit();
    } else {
        echo "ERROR: Could not execute query: $sql. " . $conn->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "ERROR: Could not prepare query: $sql. " . $conn->error;
}

// Close connection
$conn->close();
?>
