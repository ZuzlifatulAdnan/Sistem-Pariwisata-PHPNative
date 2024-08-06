<?php
session_start();
include 'config/db.php';

// Retrieve form data from session
if (!isset($_SESSION['formData'])) {
    header("Location: pemesanan.php");
    exit();
}

$formData = $_SESSION['formData'];

// Extract individual variables
$nama = $formData['nama'];
$alamat = $formData['alamat'];
$tanggalBerangkat = $formData['tanggalBerangkat'];
$jekel = $formData['jekel'];
$objekWisataId = $formData['objekWisataId'];
$jumlahPeserta = $formData['jumlahPeserta'];
$paket = isset($formData['paket']) ? $formData['paket'] : [];
$noTelephone = $formData['noTelephone'];
$totalHarga = $formData['totalHarga'];

// Generate unique ID
$prefix = "PM-";
$uniqueId = strtoupper($prefix . bin2hex(random_bytes(8)));

// Get current timestamp
$createdAt = date('Y-m-d H:i:s');

// Prepare SQL statement for booking details
$sql = "INSERT INTO pemesanan (noPemesanan, nama, alamat, tanggalBerangkat, jenisKelamin, objekWisataId, jumlahPeserta, paket, totalHarga, noTelephone, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Start a transaction
$conn->begin_transaction();

try {
    // Prepare and execute the SQL query to insert the booking details
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    // Convert paket array to a comma-separated string
    $paketString = implode(',', $paket);

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("sssssisssss", $uniqueId, $nama, $alamat, $tanggalBerangkat, $jekel, $objekWisataId, $jumlahPeserta, $paketString, $totalHarga, $noTelephone, $createdAt);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $stmt->close();

    // Fetch objek wisata details
    $stmt = $conn->prepare("SELECT nama FROM objekwisata WHERE id = ?");
    $stmt->bind_param("i", $objekWisataId);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $objekWisataResult = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Fetch paket wisata details
    $paketIds = implode(',', array_fill(0, count($paket), '?'));
    $paketQuery = "SELECT nama, harga FROM paketwisata WHERE id IN ($paketIds)";
    $stmt = $conn->prepare($paketQuery);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(str_repeat('i', count($paket)), ...$paket);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $paketResult = $stmt->get_result();
    $paketDetails = [];
    while ($row = $paketResult->fetch_assoc()) {
        $paketDetails[] = $row;
    }
    $stmt->close();

    // Commit the transaction
    $conn->commit();

    // Save booking details in session for the success page
    $_SESSION['bookingDetails'] = [
        'noPemesanan' => $uniqueId,
        'nama' => $nama,
        'alamat' => $alamat,
        'objekWisata' => $objekWisataResult['nama'],
        'jekel' => $jekel == 'L' ? 'Laki-laki' : 'Perempuan',
        'tanggalBerangkat' => $tanggalBerangkat,
        'jumlahPeserta' => $jumlahPeserta,
        'paketDetails' => $paketDetails,
        'noTelephone' => $noTelephone,
        'totalHarga' => $totalHarga,
    ];

    // Clear session data
    unset($_SESSION['formData']);
    header("Location: pemesananSukses.php");
    exit();
} catch (Exception $e) {
    // Rollback the transaction if any query fails
    $conn->rollback();
    echo "ERROR: " . $e->getMessage();
    // Optionally log the error message to a file or error logging system
}
?>
