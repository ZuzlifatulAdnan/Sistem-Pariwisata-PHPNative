<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
include '../config/db.php';

// Fetch pemesanan data
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Sanitasi input
$fetchPemesananQuery = "SELECT * FROM pemesanan WHERE id = ?";
$stmt = $conn->prepare($fetchPemesananQuery);
$stmt->bind_param('i', $id);
$stmt->execute();
$pemesananResult = $stmt->get_result();

if (!$pemesananResult || $pemesananResult->num_rows == 0) {
    die("Pemesanan not found.");
}

$pemesanan = $pemesananResult->fetch_assoc();

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
    <title>Edit Pemesanan - Pariwisata Lampung</title>
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
            <h2 class="text-center">Edit Pemesanan</h2>
        </div>
        <form action="pemesananEditProses.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="inputNama">Nama</label>
                <input id="inputNama" class="form-control" type="text" name="nama"
                    value="<?php echo htmlspecialchars($pemesanan['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="inputAlamat">Alamat</label>
                <input id="inputAlamat" class="form-control" type="text" name="alamat"
                    value="<?php echo htmlspecialchars($pemesanan['alamat'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="inputObjekWisata">Objek Wisata</label>
                <select class="form-control" name="objekWisataId" id="inputObjekWisata" required>
                    <option value="">Pilih Objek Wisata</option>
                    <?php
                    while ($row = $objekWisataResult->fetch_assoc()) {
                        $selected = ($row['id'] == $pemesanan['objekWisataId']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' $selected>" . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jenisKelamin">Jenis Kelamin</label>
                <select class="form-control" name="jekel" id="jenisKelamin" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" <?php echo ($pemesanan['jenisKelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki
                    </option>
                    <option value="P" <?php echo ($pemesanan['jenisKelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="inputTglBerangkat">Tanggal Berangkat</label>
                <input id="inputTglBerangkat" class="form-control" type="date" name="tanggalBerangkat"
                    value="<?php echo htmlspecialchars($pemesanan['tanggalBerangkat'], ENT_QUOTES, 'UTF-8'); ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="inputJumlahPaket">Jumlah Peserta</label>
                <input id="inputJumlahPaket" class="form-control" type="number" name="jumlahPeserta"
                    value="<?php echo htmlspecialchars($pemesanan['jumlahPeserta'], ENT_QUOTES, 'UTF-8'); ?>"
                    onchange="calculateTotal()" required>
            </div>

            <label for="">Paket Wisata </label>
            <?php
            $selectedPaketIds = explode(',', $pemesanan['paket']);
            while ($row = $paketResult->fetch_assoc()) {
                $checked = in_array($row['id'], $selectedPaketIds) ? 'checked' : '';
                echo '<div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="paket[]" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" data-harga="' . htmlspecialchars($row['harga'], ENT_QUOTES, 'UTF-8') . '" onchange="calculateTotal()" ' . $checked . '>
                ' . htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8') . ' (Rp ' . number_format($row['harga'], 0, ',', '.') . ')
            </label>
        </div>';
            }
            ?>

            <div class="form-group">
                <label for="inputNo">No Telephone</label>
                <input id="inputNo" class="form-control" type="number" name="noTelephone"
                    value="<?php echo htmlspecialchars($pemesanan['noTelephone'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="form-group">
                <label for="inputTotal">Total Harga</label>
                <input id="inputTotal" class="form-control" type="number" name="totalHarga"
                    value="<?php echo htmlspecialchars($pemesanan['totalHarga'], ENT_QUOTES, 'UTF-8'); ?>" readonly
                    required>
            </div>

            <button type="submit" class="btn btn-outline-success">Update</button>
            <a href="pemesanan.php" class="btn btn-outline-warning">Kembali</a>
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

        function calculateTotal() {
            const jumlahPaket = parseFloat(document.getElementById('inputJumlahPaket').value) || 0;
            let totalHarga = 0;

            document.querySelectorAll('input[name="paket[]"]:checked').forEach(checkbox => {
                const paketHarga = parseFloat(checkbox.dataset.harga);
                totalHarga += paketHarga;
            });

            totalHarga *= jumlahPaket;
            document.getElementById('inputTotal').value = totalHarga.toFixed(0); // Ensure no decimal places
        }
    </script>
</body>

</html>