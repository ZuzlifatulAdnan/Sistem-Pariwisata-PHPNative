<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Artikel not found.";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Start Title -->
    <title>Pariwisata Lampung</title>
    <!-- End Title -->
    <!-- Start Favicon -->
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <!-- EndFavicon -->
    <!-- Start SEO -->
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <!-- End SEO -->
    <!-- Start Style -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="../assets/css/styles2.css" rel="stylesheet">
    <!-- End Style -->
</head>

<body>
    <!-- Start Header -->
    <?php
    include '../templates/header.php';
    ?>
    <!-- End Header -->
    <!-- Start Navbar -->
    <?php
    include '../templates/adminNav.php';
    ?>
    <!-- End Navbar -->
    <!-- Start container content -->
    <div class="container content">
        <!-- Start Judul Halaman Tambah Artikel -->
        <div class="row justify-content-center">
            <h2 class="text-center">Edit Artikel</h2>
        </div>
        <!-- End Judul Halaman Tambah Artikel -->
        <!-- Start form -->
        <form action="artikelEditProses.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <!-- Start Input judul -->
            <div class="form-group">
                <label for="inputNama">Judul :</label>
                <input id="inputNama" class="form-control" type="text" name="judul" value="<?php echo $row['judul']; ?>"
                    required>
            </div>
            <!-- End input judul -->
            <!-- Start input deskripsi -->
            <div class="form-group">
                <label for="inputDeskripsi">Deskripsi :</label>
                <textarea id="inputDeskripsi" class="form-control" name="deskripsi" rows="3" required><?php echo $row['deskripsi']; ?>
                </textarea>
            </div>
            <!-- End input deskripsi -->
            <div class="form-group">
                <label for="foto">Foto:</label><br>
                <img id="foto" src="<?php echo $row['foto']; ?>" alt="Foto"
                    style="max-width: 200px; max-height: 200px;"><br><br>
                <input id="foto" class="form-control" type="file" name="foto" />
            </div>
            <!-- End foto -->
            <!-- start tombol pesan -->
            <button type="submit" class="btn btn-outline-success">Ubah</button>
            <a href="artikel.php" class="btn btn-outline-warning">Kembali</a>
            <!-- end tombol pesan -->
        </form>
        <!-- End Form -->
         <br>
    </div>
    <!-- End container content -->
    <!-- Start Footer -->
    <?php
    include '../templates/footer.php';
    ?>
    <!-- End Footer -->
    <!-- Start Script JS -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table-1').DataTable();
        });
    </script>
    <!-- Start Script JS -->
</body>

</html>

<!-- End Form -->
<br>