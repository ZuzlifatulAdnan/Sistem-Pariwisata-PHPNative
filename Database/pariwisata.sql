-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Agu 2024 pada 10.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pariwisata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tglUpload` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `deskripsi`, `foto`, `tglUpload`, `created_at`, `updated_at`) VALUES
(17, 'Taman Nasional Way Kambas', 'Taman Nasional Way Kambas adalah salah satu taman nasional tertua di Indonesia dan terkenal sebagai tempat konservasi gajah. Pengunjung dapat melihat gajah dalam habitat aslinya dan bahkan berkesempatan untuk mengikuti pelatihan gajah. Selain gajah, taman ini juga menjadi rumah bagi harimau Sumatra dan badak Sumatra yang sangat langka.', 'artikel/66b1d80eddd3b-waygambas.jpg', '2024-08-06', '2024-08-06 08:00:14', NULL),
(18, 'Pulau Pahawang', 'Pulau Pahawang dikenal sebagai surga bagi para penyelam dan pecinta snorkeling. Air lautnya yang jernih dan terumbu karang yang indah membuat pulau ini menjadi tempat yang sempurna untuk menikmati keindahan bawah laut. Di pulau ini juga terdapat beberapa penginapan yang menawarkan pengalaman menginap di tepi pantai.', 'artikel/66b1d81ecd786-pahawang.jpg', '2024-08-06', '2024-08-06 08:00:30', NULL),
(19, ' Pantai Mutun dan Pulau Tangkil', 'Pantai Mutun merupakan destinasi wisata pantai yang populer di Lampung. Pantai ini memiliki pasir putih yang halus dan air laut yang tenang, cocok untuk berenang dan bermain air. Dari Pantai Mutun, wisatawan juga dapat menyebrang ke Pulau Tangkil untuk menikmati pemandangan alam yang lebih eksotis.', 'artikel/66b1d83b89de6-mutun.jpg', '2024-08-06', '2024-08-06 08:00:59', NULL),
(20, 'Air Terjun Putri Malu', 'Air Terjun Putri Malu terletak di kawasan Way Kanan dan menawarkan pemandangan alam yang menakjubkan. Air terjun ini memiliki ketinggian sekitar 80 meter dan dikelilingi oleh hutan tropis yang lebat. Keindahan alamnya membuat tempat ini sangat cocok untuk berpetualang dan bersantai.', 'artikel/66b1d852709ed-air terjun putri malu.jpg', '2024-08-06', '2024-08-06 08:01:22', NULL),
(21, 'Teluk Kiluan', 'Teluk Kiluan terkenal dengan atraksi lumba-lumba dan paus yang bisa dilihat dari dekat. Pengunjung bisa menyewa perahu untuk berlayar ke tengah teluk dan menyaksikan kawanan lumba-lumba bermain di laut lepas. Selain itu, teluk ini juga memiliki pantai yang indah dan suasana yang tenang.', 'artikel/66b1d862c84ab-teluk kiluan.jpg', '2024-08-06', '2024-08-06 08:01:38', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fasilitaswisata`
--

CREATE TABLE `fasilitaswisata` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `objekWisataId` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `jenisFasilitas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fasilitaswisata`
--

INSERT INTO `fasilitaswisata` (`id`, `nama`, `objekWisataId`, `foto`, `jenisFasilitas`, `created_at`, `updated_at`) VALUES
(4, 'Pusat Informasi dan Edukasi, Trekking', 8, 'waygambas.jpg', 'Gratis', '2024-08-06 08:08:55', NULL),
(5, 'Tur Safari Gajah, Penginapan dan Camping Ground, Pemandu Wisata', 8, 'waygambas.jpg', 'Berbayar', '2024-08-06 08:09:35', NULL),
(6, 'Homestay dan Resort, Persewaan Perahu, Pusat Diving, Warung Makan', 9, 'pahawang.jpg', 'Berbayar', '2024-08-06 08:10:32', NULL),
(7, 'Pantai, Trekking Ringan', 9, 'pahawang.jpg', 'Gratis', '2024-08-06 08:11:04', NULL),
(8, 'Penginapan, Persewaan Peralatan Snorkeling, Warung Makan', 10, 'mutun.jpg', 'Berbayar', '2024-08-06 08:11:52', NULL),
(9, 'Area Pantai, Tempat Duduk', 10, 'mutun.jpg', 'Gratis', '2024-08-06 08:12:12', NULL),
(10, 'Parkir, Jasa Pemandu', 11, 'air terjun putri malu.jpg', 'Berbayar', '2024-08-06 08:13:05', NULL),
(11, 'Area Air Terjun, Trekking:', 11, 'air terjun putri malu.jpg', 'Gratis', '2024-08-06 08:13:25', NULL),
(12, 'Homestay dan Resort, Persewaan Perahu, Pusat Diving, Warung Makan', 12, 'teluk kiluan.jpg', 'Berbayar', '2024-08-06 08:14:01', NULL),
(13, 'Pantai dan Pemandangan, Berjalan-jalan', 12, 'teluk kiluan.jpg', 'Gratis', '2024-08-06 08:14:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `nama`, `foto`, `created_at`, `updated_at`) VALUES
(5, 'Taman Nasional Way Kambas', 'gallery/66b1db9f8c1d7-waygambas.jpg', '2024-08-06 08:15:27', NULL),
(6, 'Pulau Pahawang', 'gallery/66b1dbb034d24-pahawang.jpg', '2024-08-06 08:15:44', NULL),
(7, 'Pantai Mutun dan pulau Tangkil', 'gallery/66b1dbc442470-mutun.jpg', '2024-08-06 08:16:04', NULL),
(8, 'Air Terjun Putri Malu', 'gallery/66b1dbd187041-air terjun putri malu.jpg', '2024-08-06 08:16:17', NULL),
(9, 'Teluk Kiluan', 'gallery/66b1dbdb22fe2-teluk kiluan.jpg', '2024-08-06 08:16:27', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `objekwisata`
--

CREATE TABLE `objekwisata` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tglUpload` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `objekwisata`
--

INSERT INTO `objekwisata` (`id`, `nama`, `deskripsi`, `foto`, `tglUpload`, `created_at`, `updated_at`) VALUES
(8, 'Taman Nasional Way Kambas', 'Salah satu taman nasional tertua di Indonesia. Dikenal sebagai pusat konservasi gajah Sumatera. Aktivitas safari gajah, melihat satwa liar, dan berkemah.                ', 'objekWisata/66b1d8a397274-waygambas.jpg', '2024-08-06', '2024-08-06 08:02:43', '2024-08-06 08:09:46'),
(9, 'Pulau Pahawang', 'Terletak di Teluk Punduh.Dikenal dengan keindahan bawah lautnya yang cocok untuk snorkeling dan diving.Aktivitas snorkeling, diving, dan menjelajahi pulau.\r\n', 'objekWisata/66b1d8c900b58-pahawang.jpg', '2024-08-06', '2024-08-06 08:03:21', NULL),
(10, 'Pantai Mutun', 'Terletak di Desa Mutun, Kecamatan Teluk Pandan, sekitar 20 km dari Bandar Lampung.Pantai ini terkenal dengan pasir putihnya yang lembut dan air lautnya yang jernih.', 'objekWisata/66b1d93bc40b5-mutun.jpg', '2024-08-06', '2024-08-06 08:05:15', NULL),
(11, 'Air Terjun Putri Malu', 'Lokasi: Terletak di Desa Sumber Agung, Kecamatan Way Kanan, sekitar 100 km dari Bandar Lampung. Ciri Khas: Air terjun ini memiliki keindahan yang memikat dengan tinggi sekitar 30 meter dan dikelilingi oleh hutan tropis. Nama \"Putri Malu\" berasal dari kata \"Malu\" yang merujuk pada tanaman menjalar dengan daun yang akan ', 'objekWisata/66b1d9794a790-air terjun putri malu.jpg', '2024-08-06', '2024-08-06 08:06:17', NULL),
(12, 'Teluk Kiluan', 'Terletak di Kecamatan Kelumbayan, sekitar 80 km dari Bandar Lampung. Terkenal dengan keindahan pantai dan teluknya, serta sebagai tempat melihat lumba-lumba liar.', 'objekWisata/66b1d99cd4621-teluk kiluan.jpg', '2024-08-06', '2024-08-06 08:06:52', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `paketwisata`
--

CREATE TABLE `paketwisata` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paketwisata`
--

INSERT INTO `paketwisata` (`id`, `nama`, `harga`, `created_at`, `updated_at`) VALUES
(6, 'Penginapan', 1000000, '2024-08-06 07:44:55', NULL),
(7, 'Transportasi', 1200000, '2024-08-06 07:45:09', NULL),
(8, 'Makanan', 500000, '2024-08-06 07:45:23', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `noPemesanan` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tanggalBerangkat` date NOT NULL,
  `jenisKelamin` enum('L','P') NOT NULL,
  `objekWisataId` int(11) NOT NULL,
  `jumlahPeserta` int(11) NOT NULL,
  `paket` text NOT NULL,
  `totalHarga` decimal(10,0) NOT NULL,
  `noTelephone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `noPemesanan`, `nama`, `alamat`, `tanggalBerangkat`, `jenisKelamin`, `objekWisataId`, `jumlahPeserta`, `paket`, `totalHarga`, `noTelephone`, `created_at`, `updated_at`) VALUES
(53, 'PM-468C8EE13C7BCAA7', 'ZUZLIFATUL ADNAN', 'TANJUNG INTAN', '2024-08-06', 'L', 8, 1, '8', 500000, '082178521212', '2024-08-06 03:17:08', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$7bxp4kK8jarQE/oBfy42yu/g5b4iubJ.9MtxSPw4jWrsNhKzORN4K', '2024-08-02 17:16:11', '2024-08-02 18:06:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `fasilitaswisata`
--
ALTER TABLE `fasilitaswisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objekWisataId` (`objekWisataId`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `objekwisata`
--
ALTER TABLE `objekwisata`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paketwisata`
--
ALTER TABLE `paketwisata`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objekWisataId` (`objekWisataId`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `fasilitaswisata`
--
ALTER TABLE `fasilitaswisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `objekwisata`
--
ALTER TABLE `objekwisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `paketwisata`
--
ALTER TABLE `paketwisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `fasilitaswisata`
--
ALTER TABLE `fasilitaswisata`
  ADD CONSTRAINT `fasilitaswisata_ibfk_1` FOREIGN KEY (`objekWisataId`) REFERENCES `objekwisata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`objekWisataId`) REFERENCES `objekwisata` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
