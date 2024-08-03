<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Koneksi database
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM objekwisata WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Objek Wisata not found.";
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
        <div class="row justify-content-center">
            <h2 class="text-center">Detail Objek Wisata</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Judul :</th>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        </tr>
                        <tr>
                            <th>Deskripsi :</th>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Upload :</th>
                            <td><?php echo htmlspecialchars($row['tglUpload']); ?></td>
                        </tr>
                        <tr>
                            <th>Foto :</th>
                            <td><img src="<?php echo $row['foto']; ?>" style="max-width: 200px; max-height: 200px;">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <a href="objekWisata.php" class="btn btn-secondary">Kembali</a>
                    <a href="objekWisataEdit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
        <!-- End container content -->
        <br>
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