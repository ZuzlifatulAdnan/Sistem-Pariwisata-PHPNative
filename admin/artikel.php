<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Koneksi database
include '../config/db.php';

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
        <!-- Start H2 Center -->
        <div class="row justify-content-center">
            <h2 class="text-center">Artikel</h2>
        </div>
        <!-- End H2 Center -->
        <!-- Start Row justify content Center -->
        <div class="row justify-content-center">
            <!-- Start col-md-12 -->
            <div class="col-md-12">
                <!-- Start Button Tambah Data -->
                <div class="mb-3">
                    <a href="artikelAdd.php" class="btn btn-primary">Tambah Data</a>
                </div>
                <!-- End Button Tambah Data -->
                <!-- Start Tabel -->
                <table class="table table-bordered" id="table-1">
                    <!-- Start Header Tabel -->
                    <thead>
                        <!-- Start tabel row -->
                        <tr>
                            <!-- Start tabel head -->
                            <th>No</th>
                            <th>Judul</th>
                            <th>Foto</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                            <!-- End tabel head -->
                        </tr>
                        <!-- End tabel row -->
                    </thead>
                    <!-- End Header Tabel -->
                    <!-- Start tabel body -->
                    <tbody>
                        <!-- Start Tag PHP -->
                        <?php
                        // Start fetch artikel from database
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
                        // End fetch artikel from database
                        $no = 0;
                        $articles = fetchArtikelFromDatabase();
                        // Start perulangan data
                        foreach ($articles as $article) {
                            $no++;
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$article['judul']}</td>";
                            echo "<td><img src='{$article['foto']}' width='50px'></td>";
                            echo "<td>{$article['tglUpload']}</td>";
                            echo "<td>
                                <a href='artikelDetail.php?id={$article['id']}' class='btn btn-info btn-sm'>Detail</a>
                                <a href='artikelEdit.php?id={$article['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='artikelDel.php?id={$article['id']}' class='btn btn-danger btn-sm'>Delete</a>
                              </td>";
                            echo "</tr>";
                        }
                        // End perulangan data
                        ?>
                        <!-- End Tag PHP -->
                    </tbody>
                    <!-- End tabel body -->
                </table>
                <!-- End Tabel -->
            </div>
            <!-- End col-md-12 -->
        </div>
        <!-- End Row justify content Center -->
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
    <!-- End Script JS -->
</body>

</html>