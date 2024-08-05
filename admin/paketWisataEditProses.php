<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    // Validate input
    if (empty($nama) || empty($harga)) {
        echo "Both fields are required.";
    } else {
        // Prepare an update statement
        $sql = "UPDATE paketwisata SET nama = ?, harga = ?, updated_at = NOW()  WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $nama, $harga, $id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "<script>alert('Paket Wisata Berhasil Diupdate'); window.location.href='paketWisata.php';</script>";
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