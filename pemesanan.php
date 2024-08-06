<?php
// Include database connection
include 'config/db.php';

// Fetch objek wisata data
$fetchObjekWisataQuery = "SELECT id, nama FROM objekwisata";
$objekWisataResult = $conn->query($fetchObjekWisataQuery);

if (!$objekWisataResult) {
    die("Query failed: " . $conn->error);
}

// Fetch travel packages data
$fetchPaketQuery = "SELECT id, nama, harga FROM paketwisata";
$paketResult = $conn->query($fetchPaketQuery);

if (!$paketResult) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - Pariwisata Lampung</title>
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
                <div class="row justify-content-center">
                    <h2 class="text-center">From Pemesanan</h2>
                </div>
                <form action="pemesananKonfirmasi.php" method="post">
                    <div class="form-group">
                        <label for="inputNama">Nama</label>
                        <input id="inputNama" class="form-control" type="text" name="nama" placeholder="Nama" required>
                    </div>

                    <div class="form-group">
                        <label for="inputAlamat">Alamat</label>
                        <input id="inputAlamat" class="form-control" type="text" name="alamat" placeholder="Alamat"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="inputTglBerangkat">Tanggal Berangkat</label>
                        <input id="inputTglBerangkat" class="form-control" type="date" name="tanggalBerangkat" required>
                    </div>

                    <div class="form-group">
                        <label for="jenisKelamin">Jenis Kelamin</label>
                        <select class="form-control" name="jekel" id="jenisKelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputObjekWisata">Objek Wisata</label>
                        <select class="form-control" name="objekWisataId" id="inputObjekWisata" required>
                            <option value="">Pilih Objek Wisata</option>
                            <?php
                            while ($row = $objekWisataResult->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputJumlahPaket">Jumlah Peserta</label>
                        <input id="inputJumlahPaket" class="form-control" type="number" name="jumlahPeserta"
                            onchange="calculateTotal()" required>
                    </div>

                    <label for="">Paket Wisata</label>
                    <?php
                    while ($row = $paketResult->fetch_assoc()) {
                        echo '<div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="paket[]" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" data-harga="' . htmlspecialchars($row['harga'], ENT_QUOTES, 'UTF-8') . '" onchange="calculateTotal()">
                            ' . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . ' (Rp ' . number_format($row['harga'], 0, ',', '.') . ')
                        </label>
                    </div>';
                    }
                    ?>

                    <div class="form-group">
                        <label for="inputNo">No Telephone</label>
                        <input id="inputNo" class="form-control" type="number" name="noTelephone"
                            placeholder="No Telephone" required>
                    </div>

                    <div class="form-group">
                        <label for="inputTotal">Total Harga</label>
                        <input id="inputTotal" class="form-control" type="number" name="totalHarga"
                            placeholder="Total Harga" required readonly>
                    </div>

                    <button type="submit" class="btn btn-outline-success">Tambah</button>
                    <a href="pemesananCari.php" class="btn btn-outline-warning">Kembali</a>
                </form>
            </div>
            <div class="col-md-4">
                <div class="embed-responsive embed-responsive-16by9 mb-4">
                    <video class="embed-responsive-item" controls>
                        <source src="assets/video/video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php include 'templates/footer.php'; ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table-1').DataTable();
        });

        function calculateTotal() {
            const jumlahPaket = parseFloat(document.getElementById('inputJumlahPaket').value) || 0;
            let totalHarga = 0;

            document.querySelectorAll('input[name="paket[]"]:checked').forEach(checkbox => {
                const paketHarga = parseFloat(checkbox.dataset.harga);
                totalHarga += paketHarga;
            });

            totalHarga *= jumlahPaket;
            document.getElementById('inputTotal').value = totalHarga;

            return true;
        }
    </script>
</body>

</html>