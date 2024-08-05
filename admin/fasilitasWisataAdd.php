<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch objek wisata data
$fetchObjekWisataQuery = "SELECT id, nama FROM objekwisata";
$objekWisataResult = $conn->query($fetchObjekWisataQuery);

if (!$objekWisataResult) {
    die("Query failed: " . $conn->error);
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
    <!-- End Favicon -->
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
    <?php include '../templates/header.php'; ?>
    <!-- End Header -->
    <!-- Start Navbar -->
    <?php include '../templates/adminNav.php'; ?>
    <!-- End Navbar -->
    <!-- Start container content -->
    <div class="container content">
        <!-- Start Judul Halaman Tambah Fasilitas Wisata -->
        <div class="row justify-content-center">
            <h2 class="text-center">Tambah Fasilitas Wisata</h2>
        </div>
        <!-- End Judul Halaman Tambah Fasilitas Wisata -->
        <!-- Start form -->
        <form action="fasilitasWisataAddProses.php" method="post" enctype="multipart/form-data">
            <!-- CSRF token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <!-- Start Input nama -->
            <div class="form-group">
                <label for="inputNama">Nama</label>
                <input id="inputNama" class="form-control" type="text" name="nama" placeholder="Nama" required>
            </div>
            <!-- End input nama -->
            <!-- Start input Objek Wisata -->
            <div class="form-group">
                <label for="inputObjekWisata">Objek Wisata</label>
                <select class="form-control" name="objekWisataId" id="inputObjekWisata" required>
                    <option>Pilih Objek Wisata</option>
                    <?php
                    while ($row = $objekWisataResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- End input Objek Wisata -->
            <!-- Start foto -->
            <div class="form-group">
                <label for="inputFoto">Foto</label>
                <input id="inputFoto" class="form-control" type="file" name="foto" required>
            </div>
            <!-- End foto -->
            <!-- Start jenisFasilitas -->
            <div class="form-group">
                <label for="jenisFasilitas">Jenis Fasilitas</label>
                <select class="form-control" name="jenisFasilitas" id="jenisFasilitas">
                    <option>Pilih Jenis Fasilitas</option>
                    <option value="Gratis">Gratis</option>
                    <option value="Berbayar">Berbayar</option>
                </select>
            </div>
            <!-- End jenisFasilitas -->
            <!-- start tombol pesan -->
            <button type="submit" class="btn btn-outline-success">Tambah</button>
            <a href="fasilitasWisata.php" class="btn btn-outline-warning">Kembali</a>
            <!-- end tombol pesan -->
        </form>
        <!-- End Form -->
        <br>
    </div>
    <!-- End container content -->
    <!-- Start Footer -->
    <?php include '../templates/footer.php'; ?>
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
    <!-- End Script JS -->
</body>

</html>