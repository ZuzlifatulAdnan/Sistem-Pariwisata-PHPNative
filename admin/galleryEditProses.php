<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']); // Prevent XSS

    $target_dir = "gallery/";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
    $newFile = false;

    // Check if a new file has been uploaded
    if ($_FILES["foto"]["tmp_name"] != "") {
        $newFile = true;
        $target_file = $target_dir . uniqid() . "-" . basename($_FILES["foto"]["name"]);

        // Check if file is an actual image or fake image
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.history.back();</script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["foto"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.'); window.history.back();</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('Sorry, your file was not uploaded.'); window.history.back();</script>";
            exit();
        }
    }

    if ($newFile && $uploadOk == 1) {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Remove old file if a new file is uploaded
            $sql = "SELECT foto FROM galeri WHERE id = ?";
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

            // Update with the new file
            $sql = "UPDATE galeri SET nama = ?, foto = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $nama, $target_file, $id);
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
            exit();
        }
    } else {
        // Update without changing the file
        $sql = "UPDATE galeri SET nama = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nama, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Gallery successfully updated.'); window.location.href = 'gallery.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>