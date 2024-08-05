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
            <h2 class="text-center">Users</h2>
        </div>
        <!-- End H2 Center -->
        <!-- Start Row justify content Center -->
        <div class="row justify-content-center">
            <!-- Start col-md-12 -->
            <div class="col-md-12">
                <!-- Start Button Tambah Data -->
                <div class="mb-3">
                    <a href="userAdd.php" class="btn btn-primary">Tambah Data</a>
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
                            <th>Username</th>
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
                        // Start fetch user from database
                        function fetchUserFromDatabase()
                        {
                            global $conn; // Access the database connection variable
                        
                            $sql = "SELECT id, username FROM users";
                            $result = $conn->query($sql);
                            $users = [];
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $users[] = $row;
                                }
                            }

                            return $users;
                        }
                        // End fetchusersfrom database
                        $no = 0;
                        $users = fetchUserFromDatabase();
                        // Start perulangan data
                        foreach ($users as $u) {
                            $no++;
                            echo "<tr>";
                            echo "<td>{$no}</td>";
                            echo "<td>{$u['username']}</td>";
                            echo "<td>
                                <a href='userEdit.php?id={$u['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='userDel.php?id={$u['id']}' class='btn btn-danger btn-sm'>Delete</a>
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