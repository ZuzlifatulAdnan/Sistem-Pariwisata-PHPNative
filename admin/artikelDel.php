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
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT); // Ubah id menjadi bilangan bulat untuk keamanan

    if ($id === false) {
        echo "<script>alert('ID tidak valid.'); window.location.href='artikel.php';</script>";
        exit();
    }

    // Siapkan pernyataan penghapusan SQL
    $sql = "DELETE FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $id);

        // Jalankan pernyataannya
        if ($stmt->execute()) {
            // Redirect ke halaman daftar artikel dengan pesan sukses
            echo "<script>alert('Artikel berhasil dihapus.'); window.location.href='artikel.php';</script>";
        } else {
            // Redirect ke halaman daftar artikel dengan pesan kesalahan
            echo "<script>alert('Gagal menghapus artikel.'); window.location.href='artikel.php';</script>";
        }

        $stmt->close();
    } else {
        // Redirect ke halaman daftar artikel jika pernyataan gagal disiapkan
        echo "<script>alert('Gagal menyiapkan penghapusan artikel.'); window.location.href='artikel.php';</script>";
    }
} else {
    // Redirect ke halaman daftar artikel jika tidak ada id yang diberikan
    echo "<script>alert('ID artikel tidak ditemukan.'); window.location.href='artikel.php';</script>";
}

$conn->close();
?>
