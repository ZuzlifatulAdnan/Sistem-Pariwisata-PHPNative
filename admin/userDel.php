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
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Jalankan pernyataannya
    if ($stmt->execute()) {
        // Redirect ke halaman daftar Users dengan pesan sukses
        echo "<script>alert('Users Berhasil Dihapus'); window.location.href='user.php';</script>";
        exit();
    } else {
        // Redirect ke halaman daftar Users dengan pesan kesalahan
        echo "<script>alert('Gagal menghapus Users'); window.location.href='user.php';</script>";
        exit();
    }
    $stmt->close();
} else {
    // Redirect ke halaman daftar Users jika tidak ada id yang diberikan
    echo "<script>alert('Id Users tidak ditemukan'); window.location.href='user.php';</script>";
    exit();
}
?>
