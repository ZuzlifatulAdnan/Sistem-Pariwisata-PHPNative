<?php
require('fpdf186/fpdf.php');

// Koneksi database
include 'config/db.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['noPemesanan'])) {
    $noPemesanan = htmlspecialchars($_GET['noPemesanan']);

    // Fetch booking details with joins
    function fetchBookingDetails($conn, $bookingNumber) {
        $sql = "SELECT p.*, o.nama AS namaObjekWisata, w.nama AS namaPaket 
                FROM pemesanan p
                LEFT JOIN objekwisata o ON p.objekWisataId = o.id
                LEFT JOIN paketwisata w ON p.paket = w.id
                WHERE p.noPemesanan = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
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

    $bookingDetails = fetchBookingDetails($conn, $noPemesanan);

    if ($bookingDetails) {
         // Translate gender code
         $gender = '';
         if ($bookingDetails['jenisKelamin'] === 'P') {
             $gender = 'Perempuan';
         } elseif ($bookingDetails['jenisKelamin'] === 'L') {
             $gender = 'Laki-laki';
         }

        // Create instance of FPDF class
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Set title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Detail Pemesanan', 0, 1, 'C');
        $pdf->Ln(10);

        // Set font for content
        $pdf->SetFont('Arial', '', 12);

        // Add booking details with labels
        $pdf->Cell(50, 10, 'Nomor Pemesanan:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['noPemesanan'], 1, 1);
        $pdf->Cell(50, 10, 'Nama Pemesan:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['nama'], 1, 1);
        $pdf->Cell(50, 10, 'Alamat:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['alamat'], 1, 1);
        $pdf->Cell(50, 10, 'Tanggal Pemesanan:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['tanggalBerangkat'], 1, 1);
        $pdf->Cell(50, 10, 'Jenis Kelamin:', 1, 0);
        $pdf->Cell(0, 10, $gender, 1, 1);
        $pdf->Cell(50, 10, 'Objek Wisata:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['namaObjekWisata'], 1, 1);
        $pdf->Cell(50, 10, 'Jumlah Peserta:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['jumlahPeserta'], 1, 1);
        $pdf->Cell(50, 10, 'Paket:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['namaPaket'], 1, 1);
        $pdf->Cell(50, 10, 'No Telephone:', 1, 0);
        $pdf->Cell(0, 10, $bookingDetails['noTelephone'], 1, 1);

        // Output the PDF
        $pdf->Output();
    } else {
        echo 'Data pemesanan tidak ditemukan.';
    }
} else {
    echo 'Nomor pemesanan tidak diberikan.';
}
?>
