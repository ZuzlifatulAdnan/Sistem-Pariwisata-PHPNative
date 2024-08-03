<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ?page=login');
    exit();
}

// Include database connection if needed
require 'config/db.php'; // Adjust path as needed
$page = $_GET['page'] ?? "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pariwisata Lampung</title>
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <img src="assets/image/1.jpeg" alt="Pariwisata Lampung" width="100%" height="50%">
        <div class="header-text">

            <h1>Pariwisata Lampung</h1>
            <p>Wisata Alam dan Budaya Tradisi</p>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Pariwisata Lampung</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="?page=artikels">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=objekWisatas">Obyek Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=fasilitasWisatas">Fasilitas Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=paketWisatas">Paket Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=users">User</a>
                    <li class="nav-item"><a class="nav-link" href="?page=pemesanans">Pemesanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=gallerys">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container content">
        <?php
        //kodisi ketika objekWisata aktif
        if ($page == "objekWisatas") {
            require "objekWisata.php";
        } elseif ($page == "fasilitasWisatas") {
            require "fasilitasWisata.php";
        } elseif ($page == "paketWisatas") {
            require "paketWisata.php";
        } elseif ($page == "users") {
            require "user.php";
        } elseif ($page == "pemesanans") {
            require "pemesanan.php";
        } elseif ($page == "gallerys") {
            require "gallery.php";
        }
        //kondisi ketika artikel aktif 
        else {
            ?>
            <?php
            if ($page == "addArtikels") {
                require "artikelAdd.php";
            } elseif ($page == "editArtikels") {
                require "artikelEdit.php";
            } elseif ($page == "delArtikels") {
                require "artikelDell.php";
            } elseif ($page == "detailArtikels") {
                require "artikelDetail.php";
            } else {
                ?>
                <div class="row justify-content-center">
                    <h2 class="text-center">Artikel</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <a href="?page=addArtikels" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <table class="table table-bordered" id="table-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Foto</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function fetchArtikelFromDatabase()
                                {
                                    global $conn; // Access the database connection variable
                        
                                    $sql = "SELECT id, judul, foto, tglUpload FROM artikel";
                                    $result = $conn->query($sql);
                                    $articles = [];
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $articles[] = $row;
                                        }
                                    }

                                    return $articles;
                                }
                                $articles = fetchArtikelFromDatabase();
                                foreach ($articles as $article) {
                                    echo "<tr>";
                                    echo "<td>{$article['id']}</td>";
                                    echo "<td>{$article['judul']}</td>";
                                    echo "<td><img src='upload/{$article['foto']}' width='50px'></td>";
                                    echo "<td>{$article['tglUpload']}</td>";
                                    echo "<td>
                                <a href='?page=detailArtikels?id={$article['id']}' class='btn btn-info btn-sm'>Detail</a>
                                <a href='?page=editArtikels?id={$article['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='?page=delArtikels?id={$article['id']}' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php
        }
        ?>
        <br>
    </div>
    <!-- Start Footer -->
    <footer class="footer">
        <div class="text-center">
            <p>&copy;
                <script>document.write(new Date().getFullYear());</script> Pariwisata Lampung. All rights reserved.
            </p>
        </div>
    </footer>
    <!-- End Footer -->
    <!-- Start Script JS -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table-1').DataTable();
        });
    </script>
    <!-- Start Script JS -->
</body>

</html>