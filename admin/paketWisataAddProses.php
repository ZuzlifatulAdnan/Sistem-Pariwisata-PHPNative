<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // validasi input
    if (empty($nama) || empty($harga)) {
        echo "Both fields are required.";
    } else {
        // persiapan input statment
        $sql = "INSERT INTO paketwisata (nama, harga, created_at) VALUES (?, ?, NOW())";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $nama, $harga);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "<script>alert('Paket Wisata Berhasil Ditambah'); window.location.href='paketWisata.php';</script>";
                exit();
            } else {
                echo "ERROR: Could not execute query: $sql. " . $conn->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "ERROR: Could not prepare query: $sql. " . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
?>