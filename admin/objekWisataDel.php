<?php
session_start();

// Periksa login pengguna
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Koneksi basis data
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ubah id menjadi bilangan bulat untuk keamanan

    // Siapkan pernyataan penghapusan SQL
    $sql = "DELETE FROM objekwisata WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Jalankan pernyataannya
    if ($stmt->execute()) {
        // Redirect ke halaman daftar objek wisata dengan pesan sukses
        echo "<script>alert('Objek Wisata Berhasil Dihapus'); window.location.href='objekWisata.php';</script>";
        exit();
    } else {
        // Redirect ke halaman daftar objek wisata dengan pesan kesalahan
        echo "<script>alert('Gagal menghapus Objek Wisata'); window.location.href='objekWisata.php';</script>";
        exit();
    }
    $stmt->close();
} else {
    // Redirect ke halaman daftar objek wisata jika tidak ada id yang diberikan
    echo "<script>alert('Id Objek Wisata tidak ditemukan'); window.location.href='objekWisata.php';</script>";
    exit();
}
?>