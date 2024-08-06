<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['formData'] = $_POST;
    $formData = $_SESSION['formData'];
} else {
    header("Location: pemesanan.php");
    exit();
}

include 'config/db.php';

// Fetch objek wisata details
$stmt = $conn->prepare("SELECT nama FROM objekwisata WHERE id = ?");
$stmt->bind_param("i", $formData['objekWisataId']);
$stmt->execute();
$objekWisataResult = $stmt->get_result()->fetch_assoc();

// Fetch paket wisata details
$paketIds = implode(',', $formData['paket']);
$paketQuery = "SELECT nama, harga FROM paketwisata WHERE id IN ($paketIds)";
$paketResult = $conn->query($paketQuery);
$paketDetails = [];
while ($row = $paketResult->fetch_assoc()) {
    $paketDetails[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
</head>
<body>
    <?php include 'templates/userHeader.php'; ?>
    <?php include 'templates/userNav.php'; ?>

    <div class="container content">
        <div class="row">
            <div class="col-md-8">
                <h2 class="text-center">Konfirmasi Pemesanan</h2>
                <p class="text-center">Silakan periksa detail pemesanan Anda sebelum melanjutkan.</p>
                <div class="form-group">
                    <label>Nama:</label>
                    <p class="form-control-static"><?= htmlspecialchars($formData['nama'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <p class="form-control-static"><?= htmlspecialchars($formData['alamat'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="form-group">
                    <label>Tanggal Berangkat:</label>
                    <p class="form-control-static"><?= htmlspecialchars($formData['tanggalBerangkat'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <p class="form-control-static"><?= $formData['jekel'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                </div>
                <div class="form-group">
                    <label>Objek Wisata:</label>
                    <p class="form-control-static"><?= htmlspecialchars($objekWisataResult['nama'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="form-group">
                    <label>Jumlah Peserta:</label>
                    <p class="form-control-static"><?= htmlspecialchars($formData['jumlahPeserta'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="form-group">
                    <label>Paket Wisata:</label>
                    <?php foreach ($paketDetails as $paket): ?>
                        <p class="form-control-static"><?= htmlspecialchars($paket['nama'], ENT_QUOTES, 'UTF-8') ?> (Rp <?= number_format($paket['harga'], 0, ',', '.') ?>)</p>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label>No Telephone:</label>
                    <p class="form-control-static"><?= htmlspecialchars($formData['noTelephone'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="form-group">
                    <label>Total Harga:</label>
                    <p class="form-control-static">Rp <?= number_format($formData['totalHarga'], 0, ',', '.') ?></p>
                </div>
                <form action="pemesananProses.php" method="post">
                    <button type="submit" class="btn btn-outline-success">Konfirmasi</button>
                    <a href="pemesanan.php" class="btn btn-outline-warning">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <br>
    <?php include 'templates/footer.php'; ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
</body>
</html>
