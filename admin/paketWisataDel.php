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
    $sql = "DELETE FROM paketwisata WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    // Jalankan pernyataannya
    if ($stmt->execute()) {
       // Redirect ke halaman daftar paket wisata dengan pesan sukses
        echo "<script>alert('Paket Wisata Berhasil Dihapus'); windows</script>";
        header('Location: paketWisata.php');
        exit();
    } else {
        // Redirect ke halaman daftar paket wisata dengan pesan kesalahan
        echo "<script>alert('Gagal menghapus paket Wisata'); windows</script>";
        header('Location: paketWisata.php');
        exit();
    }
    $stmt->close();
} else {
   // Redirect ke halaman daftar paket wisata jika tidak ada id yang diberikan
    echo "<script>alert('Id Paket Wisata tidak ditemukan'); windows</script>";
    header('Location: paketWisata.php');
    exit();
}
?>
