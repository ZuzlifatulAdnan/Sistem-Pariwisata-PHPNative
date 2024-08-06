<?php
session_start();

// Check if booking data is present in the session
if (!isset($_SESSION['bookingDetails'])) {
    header("Location: pemesananForm.php");
    exit();
}

$bookingDetails = $_SESSION['bookingDetails'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Sukses - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'templates/userHeader.php'; ?>
    <?php include 'templates/userNav.php'; ?>

    <div class="container content">
        <div class="row">
            <div class="col-md-8">
                <h2 class="text-center">Pemesanan Sukses</h2>
                <p class="text-center">Terima kasih telah melakukan pemesanan. Berikut adalah detail pemesanan Anda:</p>
                
                <div class="card mb-4">
                    <div class="card-header">Detail Pemesanan</div>
                    <div class="card-body">
                    <div class="form-group">
                            <label>No Pemesanan:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['noPemesanan'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Nama:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['nama'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Alamat:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['alamat'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Berangkat:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['tanggalBerangkat'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['jekel'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Objek Wisata:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['objekWisata'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Peserta:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['jumlahPeserta'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Paket Wisata:</label>
                            <ul>
                                <?php foreach ($bookingDetails['paketDetails'] as $paket): ?>
                                    <li><?= htmlspecialchars($paket['nama'], ENT_QUOTES, 'UTF-8') ?> (Rp <?= number_format($paket['harga'], 0, ',', '.') ?>)</li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label>No Telephone:</label>
                            <p class="form-control-static"><?= htmlspecialchars($bookingDetails['noTelephone'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="form-group">
                            <label>Total Harga:</label>
                            <p class="form-control-static">Rp <?= number_format($bookingDetails['totalHarga'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="pemesanan.php" class="btn btn-outline-success">Lanjutkan Pemesanan</a>
                    <a href="pemesananCetak.php?noPemesanan=<?php echo urlencode($bookingDetails['noPemesanan']); ?>" class="btn btn-outline-primary">Cetak Pemesanan</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php include 'templates/footer.php'; ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
