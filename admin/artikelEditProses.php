<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $target_dir = "artikel/";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $newFile = false;

    // Periksa apakah file baru telah diunggah
    if ($_FILES["foto"]["tmp_name"] != "") {
        $newFile = true;
        $target_file = $target_dir . uniqid() . "-" . basename($_FILES["foto"]["name"]);

        // Periksa apakah file gambar adalah gambar asli atau gambar palsu
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('Fila bukan gambar '); windows</script>";
            $uploadOk = 0;
        }

        // Periksa ukuran file
        if ($_FILES["foto"]["size"] > 500000) {
            echo "<script>alert('Maaf file kamu besar '); windows</script>";
            $uploadOk = 0;
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
            exit();
        }
    }

    if ($newFile && $uploadOk == 1) {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Hapus file lama jika file baru diunggah
            $sql = "SELECT foto FROM artikel WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $old_file = $row['foto'];
            if (file_exists($old_file)) {
                unlink($old_file);
            }
            $stmt->close();

            // Perbarui dengan file baru
            $sql = "UPDATE artikel SET judul = ?, deskripsi = ?, foto = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $judul, $deskripsi, $target_file, $id);
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        // Perbarui tanpa mengubah file
        $sql = "UPDATE artikel SET judul = ?, deskripsi = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $judul, $deskripsi, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Artikel successfully update.'); window.location.href='artikel.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
