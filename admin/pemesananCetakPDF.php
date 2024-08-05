<?php
session_start();

// Cek user login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include the FPDF library
require ('../fpdf186/fpdf.php'); // Adjust the path based on your directory structure

// Koneksi database
include '../config/db.php';

// Get the id from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch booking data from the database for the specific id
function fetchPemesananById($id)
{
    global $conn; // Access the database connection variable

    $sql = "SELECT p.id, p.noPemesanan, p.nama, p.alamat, p.tanggalBerangkat, p.jenisKelamin, p.jumlahPeserta, p.totalHarga,p.noTelephone, o.nama AS objekwisata, pk.nama AS paketwisata
            FROM pemesanan p
            JOIN objekwisata o ON p.objekWisataId = o.id 
            JOIN paketwisata pk ON p.paket = pk.id
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pesan = [];
    if ($result->num_rows > 0) {
        $pesan = $result->fetch_assoc();
    }

    return $pesan;
}

$pemesanan = fetchPemesananById($id);

if (!$pemesanan) {
    echo "Pemesanan tidak ditemukan.";
    exit();
}

// Create a new instance of the FPDF class
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 14);

// Title
$pdf->Cell(190, 10, 'Detail Pemesanan', 0, 1, 'C');

// Line break
$pdf->Ln(10);

// Booking details
$pdf->SetFont('Arial', '', 12);

// Create a function to add rows in a table-like format
function addRow($pdf, $label, $value)
{
    $pdf->Cell(50, 10, $label, 1);
    $pdf->Cell(140, 10, $value, 1, 1); // 1 for border, 1 for end of line
}

addRow($pdf, 'No Pemesanan:', $pemesanan['noPemesanan']);
addRow($pdf, 'Nama:', $pemesanan['nama']);
addRow($pdf, 'Alamat:', $pemesanan['alamat']);
addRow($pdf, 'Tanggal Berangkat:', $pemesanan['tanggalBerangkat']);
addRow($pdf, 'Jenis Kelamin:', $pemesanan['jenisKelamin']);
addRow($pdf, 'Tujuan Objek Wisata:', $pemesanan['objekwisata']);
addRow($pdf, 'Jumlah Peserta:', $pemesanan['jumlahPeserta']);
addRow($pdf, 'Paket:', $pemesanan['paketwisata']);
$harga = "Rp " . number_format($pemesanan['totalHarga'], 2, ',', '.');
addRow($pdf, 'Total Harga:', $harga);
addRow($pdf, 'No Telepon:', $pemesanan['noTelephone']);


// Output the PDF
$pdf->Output('D', 'Pemesanan_Detail.pdf');
?>