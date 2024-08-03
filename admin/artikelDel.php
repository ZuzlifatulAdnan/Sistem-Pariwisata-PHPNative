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
    $sql = "DELETE FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Jalankan pernyataannya
    if ($stmt->execute()) {
       // Redirect ke halaman daftar artikel dengan pesan sukses
        echo "<script>alert('Artikel Berhasil Dihapus'); windows</script>";
        header('Location: artikel.php');
        exit();
    } else {
        // Redirect ke halaman daftar artikel dengan pesan kesalahan
        echo "<script>alert('Gagal menghapu Artikel'); windows</script>";
        header('Location: artikel.php');
        exit();
    }
    $stmt->close();
} else {
   // Redirect ke halaman daftar artikel jika tidak ada id yang diberikan
    echo "<script>alert('Id Artikel tidak ditemukan'); windows</script>";
    header('Location: artikel.php');
    exit();
}
?>
