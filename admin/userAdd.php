<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
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
        <!-- Start Judul Halaman Tambah Users -->
        <div class="row justify-content-center">
            <h2 class="text-center">Tambah Users</h2>
        </div>
        <!-- End Judul Halaman Tambah Users -->
        <!-- Start form -->
        <form action="userAddProses.php" method="post">
            <!-- Start Input Username -->
            <div class="form-group">
                <label for="inputUsername">Username</label>
                <input id="inputUsername" class="form-control" type="text" name="username" placeholder="Username" required>
            </div>
            <!-- End input Username -->
            <!-- Start input Password -->
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input id="inputPassword" class="form-control" type="text" name="password" placeholder="Password" required>
            </div>
            <!-- End input Password -->
            <!-- start tombol  -->
            <button type="submit" class="btn btn-outline-success">Tambah</button>
            <a href="artikel.php" class="btn btn-outline-warning">Kembali</a>
            <!-- end tombol -->
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
