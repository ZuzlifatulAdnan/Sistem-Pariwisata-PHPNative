<?php
// Koneksi database
include 'config/db.php';

// Fetch booking details if a booking number is provided
function fetchBookingDetails($conn, $bookingNumber)
{
    $sql = "SELECT * FROM pemesanan WHERE noPemesanan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $bookingNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    $booking = null;
    if ($result && $result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    }
    $stmt->close();
    return $booking;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $bookingNumber = $_POST['noPemesanan'];
    $bookingDetails = fetchBookingDetails($conn, $bookingNumber);
} else {
    $bookingDetails = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
</head>

<body>
    <?php include 'templates/userHeader.php'; ?>
    <?php include 'templates/userNav.php'; ?>

    <main class="container content">
        <div class="row">
            <div class="col-md-8">
                <!-- Form Pencarian Pemesanan -->
                <div class="search-booking">
                    <h3>Cari Pemesanan</h3>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="noPemesanan">Nomor Pemesanan</label>
                            <input type="text" class="form-control" id="noPemesanan" name="noPemesanan" required>
                        </div>
                        <button type="submit" name="search" class="btn btn-secondary">Cari</button>
                    </form>

                    <?php if ($bookingDetails): ?>
                        <div class="mt-4">
                            <h4>Detail Pemesanan</h4>
                            <ul class="list-unstyled">
                                <li><strong>Nomor Pemesanan:</strong>
                                    <?php echo htmlspecialchars($bookingDetails['noPemesanan']); ?></li>
                                <li><strong>Nama :</strong> <?php echo htmlspecialchars($bookingDetails['nama']); ?>
                                </li>
                                <li><strong>Alamat:</strong>
                                    <?php echo htmlspecialchars($bookingDetails['alamat']); ?></li>
                                <li><strong>Tanggal Berangkat:</strong>
                                    <?php echo htmlspecialchars($bookingDetails['tanggalBerangkat']); ?></li>
                            </ul>
                            <a href="pemesananCetak.php?noPemesanan=<?php echo urlencode($bookingDetails['noPemesanan']); ?>"
                                class="btn btn-success">Cetak PDF</a>
                        </div>
                    <?php elseif (isset($_POST['search'])): ?>
                        <div class="mt-4">
                            <p>Data pemesanan tidak ditemukan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
<br>
            <div class="col-md-4">
                <div class="embed-responsive embed-responsive-16by9 mb-4">
                    <video class="embed-responsive-item" controls>
                        <source src="assets/video/video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </main>
    <br>
    <?php include 'templates/footer.php'; ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>