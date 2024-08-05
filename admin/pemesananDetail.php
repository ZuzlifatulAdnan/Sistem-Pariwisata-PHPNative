<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Sanitize and validate the id parameter
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die("Invalid ID.");
}

// Fetch pemesanan data
$fetchPemesananQuery = "SELECT pemesanan.*, objekwisata.nama AS objekWisataNama FROM pemesanan 
                        JOIN objekwisata ON pemesanan.objekWisataId = objekwisata.id 
                        WHERE pemesanan.id = ?";
$stmt = $conn->prepare($fetchPemesananQuery);
$stmt->bind_param('i', $id);
$stmt->execute();
$pemesananResult = $stmt->get_result();

if (!$pemesananResult || $pemesananResult->num_rows == 0) {
    die("Pemesanan not found.");
}

$pemesanan = $pemesananResult->fetch_assoc();

// Fetch travel packages data
$fetchPaketQuery = "SELECT id, nama, harga FROM paketwisata";
$paketResult = $conn->query($fetchPaketQuery);

if (!$paketResult) {
    die("Query failed: " . $conn->error);
}

$selectedPaketIds = explode(',', $pemesanan['paket']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - Pariwisata Lampung</title>
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <link href="../assets/css/styles2.css" rel="stylesheet">
</head>

<body>
    <?php include '../templates/header.php'; ?>
    <?php include '../templates/adminNav.php'; ?>

    <div class="container content">
        <div class="row justify-content-center">
            <h2 class="text-center">Detail Pemesanan</h2>
        </div>
        <div class="form-group">
            <label for="noPemesanan">No Pemesanan</label>
            <p id="noPemesanan" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['noPemesanan'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <p id="nama" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['nama'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <p id="alamat" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['alamat'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="objekWisata">Objek Wisata</label>
            <p id="objekWisata" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['objekWisataNama'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="jenisKelamin">Jenis Kelamin</label>
            <p id="jenisKelamin" class="form-control-static">
                <?php echo ($pemesanan['jenisKelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></p>
        </div>
        <div class="form-group">
            <label for="tanggalBerangkat">Tanggal Berangkat</label>
            <p id="tanggalBerangkat" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['tanggalBerangkat'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="jumlahPeserta">Jumlah Peserta</label>
            <p id="jumlahPeserta" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['jumlahPeserta'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="paket">Paket Wisata</label>
            <p id="paket" class="form-control-static">
                <?php
                while ($row = $paketResult->fetch_assoc()) {
                    if (in_array($row['id'], $selectedPaketIds)) {
                        echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . ' (Rp ' . number_format($row['harga'], 0, ',', '.') . '), ';
                    }
                }
                ?>
            </p>
        </div>
        <div class="form-group">
            <label for="noTelephone">No Telephone</label>
            <p id="noTelephone" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['noTelephone'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="form-group">
            <label for="totalHarga">Total Harga</label>
            <p id="totalHarga" class="form-control-static">
                <?php echo htmlspecialchars($pemesanan['totalHarga'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <a href="pemesanan.php" class="btn btn-outline-warning">Kembali</a>
        <br>
    </div>
    <br>
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