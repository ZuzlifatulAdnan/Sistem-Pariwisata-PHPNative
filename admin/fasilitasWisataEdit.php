<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Fetch the ID from the GET request
$id = $_GET['id'];

// Fetch the existing data
$query = "SELECT * FROM fasilitaswisata WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data not found.");
}

// Fetch objek wisata data for the select field
$fetchObjekWisataQuery = "SELECT id, nama FROM objekwisata";
$objekWisataResult = $conn->query($fetchObjekWisataQuery);

if (!$objekWisataResult) {
    die("Query failed: " . $conn->error);
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
    <?php include '../templates/header.php'; ?>
    <?php include '../templates/adminNav.php'; ?>
    <div class="container content">
        <div class="row justify-content-center">
            <h2 class="text-center">Edit Fasilitas Wisata</h2>
        </div>
        <form action="fasilitasWisataEditProses.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
                <label for="inputNama">Nama</label>
                <input id="inputNama" class="form-control" type="text" name="nama"
                    value="<?php echo htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="inputObjekWisata">Objek Wisata</label>
                <select class="form-control" name="objekWisataId" id="inputObjekWisata" required>
                    <?php
                    while ($row = $objekWisataResult->fetch_assoc()) {
                        $selected = $row['id'] == $data['objek_wisata_id'] ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="inputFoto">Foto</label>
                <input id="inputFoto" class="form-control" type="file" name="foto">
                <img src="fasilitas/<?php echo htmlspecialchars($data['foto'], ENT_QUOTES, 'UTF-8'); ?>"
                    alt="Current Foto" width="100">
            </div>
            <div class="form-group">
                <label for="jenisFasilitas">Jenis Fasilitas</label>
                <select class="form-control" name="jenisFasilitas" id="jenisFasilitas">
                    <option value="Gratis" <?php echo $data['jenisFasilitas'] == 'Gratis' ? 'selected' : ''; ?>>Gratis
                    </option>
                    <option value="Berbayar" <?php echo $data['jenisFasilitas'] == 'Berbayar' ? 'selected' : ''; ?>>Berbayar
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-success">Update</button>
            <a href="fasilitasWisata.php" class="btn btn-outline-warning">Kembali</a>
        </form>
        <br>
    </div>
    <?php include '../templates/footer.php'; ?>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table-1').DataTable();
        });
    </script>
</body>

</html>