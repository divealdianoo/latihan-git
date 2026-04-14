-- phpMyAdmin SQL Dump
-- Database: `db_aspirasi_siswa`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aspirasi_siswa`
--
CREATE DATABASE IF NOT EXISTS `db_aspirasi_siswa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_aspirasi_siswa`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_admin` varchar(60) NOT NULL DEFAULT 'Administrator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `nama_admin`) VALUES
('admin', '123', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nis` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `nama_siswa` varchar(60) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nis`, `username`, `nama_siswa`, `kelas`, `password`) VALUES
(10001, 'siswa1', 'Ahmad Rizky', '12 RPL 1', '123'),
(10002, 'siswa2', 'Budi Santoso', '12 RPL 2', '123'),
(10003, 'siswa3', 'Citra Dewi', '11 RPL 1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Fasilitas'),
(2, 'Kebersihan'),
(3, 'Keamanan'),
(4, 'Pembelajaran'),
(5, 'Ekstrakurikuler'),
(6, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int(11) NOT NULL,
  `nis` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi_aspirasi` text NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') NOT NULL DEFAULT 'Menunggu',
  `prioritas` enum('Rendah','Sedang','Tinggi') NOT NULL DEFAULT 'Sedang',
  `progres` int(3) NOT NULL DEFAULT 0,
  `catatan_progres` text DEFAULT NULL,
  `tgl_lapor` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_update` datetime DEFAULT NULL,
  `username_admin` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `nis`, `id_kategori`, `judul`, `isi_aspirasi`, `lokasi`, `status`, `prioritas`, `progres`, `catatan_progres`, `tgl_lapor`, `tgl_update`, `username_admin`) VALUES
(1, 10001, 1, 'AC Kelas Rusak', 'AC di kelas 12 RPL 1 sudah tidak berfungsi sejak minggu lalu. Mohon segera diperbaiki karena mengganggu proses belajar.', 'Kelas 12 RPL 1', 'Selesai', 'Tinggi', 100, 'AC sudah diganti dengan unit baru', '2026-04-01 08:00:00', '2026-04-05 14:00:00', 'admin'),
(2, 10002, 2, 'Toilet Lantai 2 Kotor', 'Toilet di lantai 2 gedung utama sangat kotor dan bau. Mohon dibersihkan secara rutin.', 'Gedung Utama Lt.2', 'Diproses', 'Sedang', 50, 'Sedang dijadwalkan pembersihan rutin', '2026-04-03 09:30:00', '2026-04-07 10:00:00', 'admin'),
(3, 10001, 4, 'Penambahan Jam Praktikum', 'Mohon jam praktikum untuk mata pelajaran pemrograman ditambah karena materi yang harus dipraktikkan sangat banyak.', 'Lab Komputer', 'Menunggu', 'Sedang', 0, NULL, '2026-04-10 10:00:00', NULL, NULL),
(4, 10003, 3, 'CCTV Parkiran Mati', 'CCTV di area parkiran motor sudah mati selama 2 minggu. Mohon segera diperbaiki demi keamanan.', 'Parkiran Motor', 'Diproses', 'Tinggi', 30, 'Teknisi sedang memeriksa unit CCTV', '2026-04-08 07:45:00', '2026-04-10 09:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `umpan_balik`
--

CREATE TABLE `umpan_balik` (
  `id_feedback` int(11) NOT NULL,
  `id_aspirasi` int(11) NOT NULL,
  `username_admin` varchar(30) NOT NULL,
  `isi_feedback` text NOT NULL,
  `tgl_feedback` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `umpan_balik`
--

INSERT INTO `umpan_balik` (`id_feedback`, `id_aspirasi`, `username_admin`, `isi_feedback`, `tgl_feedback`) VALUES
(1, 1, 'admin', 'Terima kasih atas laporannya. AC akan segera kami perbaiki.', '2026-04-02 10:00:00'),
(2, 1, 'admin', 'AC sudah diperbaiki dan unit baru sudah terpasang. Silakan dicek.', '2026-04-05 14:00:00'),
(3, 2, 'admin', 'Laporan diterima. Kami akan menjadwalkan pembersihan rutin.', '2026-04-04 11:00:00'),
(4, 4, 'admin', 'Terima kasih laporannya. Teknisi akan segera memeriksa CCTV.', '2026-04-09 08:30:00');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`);

ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `fk_aspirasi_siswa` (`nis`),
  ADD KEY `fk_aspirasi_kategori` (`id_kategori`),
  ADD KEY `fk_aspirasi_admin` (`username_admin`);

ALTER TABLE `umpan_balik`
  ADD PRIMARY KEY (`id_feedback`),
  ADD KEY `fk_feedback_aspirasi` (`id_aspirasi`),
  ADD KEY `fk_feedback_admin` (`username_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `umpan_balik`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

ALTER TABLE `aspirasi`
  ADD CONSTRAINT `fk_aspirasi_siswa` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`),
  ADD CONSTRAINT `fk_aspirasi_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `fk_aspirasi_admin` FOREIGN KEY (`username_admin`) REFERENCES `admin` (`username`);

ALTER TABLE `umpan_balik`
  ADD CONSTRAINT `fk_feedback_aspirasi` FOREIGN KEY (`id_aspirasi`) REFERENCES `aspirasi` (`id_aspirasi`),
  ADD CONSTRAINT `fk_feedback_admin` FOREIGN KEY (`username_admin`) REFERENCES `admin` (`username`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
