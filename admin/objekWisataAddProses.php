<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    // Pastikan direktori upload ada
    $target_dir = "objekWisata/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Hasilkan nama file unik untuk mencegah penimpaan
    $target_file = $target_dir . uniqid() . "-" . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file gambar adalah gambar asli atau gambar palsu
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('Fila bukan gambar '); windows</script>";
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($_FILES["foto"]["size"] > 500000) {
        echo "<script>alert('Maaf file kamu besar '); windows</script>";
    }

    // Izinkan format file tertentu
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "<script>alert('Maaf hanya file JPG, JPEG, PNG & GIF yang diizinkan '); windows</script>";
        $uploadOk = 0;
    }

    // Periksa apakah $uploadOk disetel ke 0 karena kesalahan
    if ($uploadOk == 0) {
        echo "<script>alert('Maaf file kamu gagal diupload'); windows</script>";
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Gunakan pernyataan yang telah disiapkan untuk mencegah injeksi SQL
            $stmt = $conn->prepare("INSERT INTO objekWisata (nama, deskripsi, foto, tglUpload, created_at) VALUES (?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("sss", $nama, $deskripsi, $target_file);

            if ($stmt->execute()) {
                echo "<script>alert('Objek Wisata Berhasil Ditambah'); window.location.href='objekWisata.php';</script>";
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "<script>alert('Maaf  upload file gagal'); window.location.href='objekWisata.php';</script>";
        }

        $conn->close();
    }
}
?>