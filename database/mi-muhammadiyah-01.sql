-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2024 at 01:31 AM
-- Server version: 8.0.39-0ubuntu0.20.04.1
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mi-muhammadiyah-01`
--

-- --------------------------------------------------------

--
-- Table structure for table `gelombang_pendaftaran`
--

CREATE TABLE `gelombang_pendaftaran` (
  `id` bigint NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `kuota_siswa` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel-berita`
--

CREATE TABLE `tabel-berita` (
  `id_berita` int NOT NULL,
  `judul_artikel` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_artikel` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel-calon-siswa`
--

CREATE TABLE `tabel-calon-siswa` (
  `id_calon_siswa` int NOT NULL,
  `id_pengguna` int DEFAULT NULL,
  `id_gelombang_pendaftaran` bigint DEFAULT NULL,
  `nama_lengkap_calon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur_calon` int DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pas_photo` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ortu_calon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KTP_ortu_calon` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KK_calon` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akteLahir_calon` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('belumlulus','lulus','tidaklulus') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel-kelola-kelulusan`
--

CREATE TABLE `tabel-kelola-kelulusan` (
  `id_kelulusan` int NOT NULL,
  `nama_kelulusan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kelulusan` enum('Lulus','Belum Lulus') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel-pembayaran-formulir`
--

CREATE TABLE `tabel-pembayaran-formulir` (
  `id_formulir` int NOT NULL,
  `id_calon_siswa` int DEFAULT NULL,
  `nama_formulir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pembayaran_formulir` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pembayaran_formulir` enum('belumlunas','lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel-pembayaran-ulang`
--

CREATE TABLE `tabel-pembayaran-ulang` (
  `id_pembayaran_ulang` int NOT NULL,
  `id_calon_siswa` int DEFAULT NULL,
  `nama_pembayaran_ulang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pembayaran_ulang` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pembayaran_ulang` enum('lunas','belumlunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel-siswa`
--

CREATE TABLE `tabel-siswa` (
  `id_siswa` int NOT NULL,
  `id_pengguna` int DEFAULT NULL,
  `id_gelombang_pendaftaran` bigint DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `umur_siswa` int NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `no_ortu_siswa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pas_photo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `KTP_ortu` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `KK` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akteLahir` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kategori`
--

CREATE TABLE `tabel_kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('Dana masuk','Dana keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pengguna`
--

CREATE TABLE `tabel_pengguna` (
  `id_pengguna` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_akun` enum('level1','level2','level3','level4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabel_pengguna`
--

INSERT INTO `tabel_pengguna` (`id_pengguna`, `username`, `email`, `nohp`, `password`, `nama_lengkap`, `level_akun`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL, '$2y$10$HSbgz2Xd2lm9U.uLTlhVbOIU5O.zrysLvP4ToXmJy0vk2NNiXf0cG', 'Admin', 'level1', NULL, NULL),
(3, 'panitia', NULL, NULL, '$2y$10$KGePYcpDaXbEDx8VQvE82O0Y10qeLQAqKpIi1ijriGNvHPsp8muGi', 'Panitia', 'level2', NULL, NULL),
(5, 'keuangan', NULL, NULL, '$2y$10$4ozNw9ZgnMbdEfwwGIx0Je1.eDGtua5tCLUfscvzny.//jS.mL6GW', 'Badan Keuangan', 'level3', NULL, NULL),
(10, NULL, 'rinaldi@gmail.com', '082268426474', '$2y$10$D7Pk34/2Q3Tpv2xF.xX6COwbBTB2K80.WefBQ2v4hVRLltDuUhDDe', 'Rinaldi Pratama Putra', 'level4', NULL, NULL),
(11, NULL, 'adamyoung@owlcity.com', '081234567890', '$2y$10$ptTgB/Nh/3pLnuTkzSeRWOPbVqjA6Dackwl3ZzqC3E3oOO6J1VR3.', 'Adam Young', 'level4', NULL, NULL),
(12, NULL, 'loremipsum@gmail.com', '081234567893', '$2y$10$dMcPRkXcTECNXQD03AzCfO0TUTCOFswmG7dqJu1.Z9Ul9ECwNmrAm', 'Lorem Ipsum', 'level4', NULL, NULL),
(13, NULL, 'loremsiswa@gmail.com', '082213456789', '$2y$10$nSRchD1Tav6wqWP8SZzyJ.3/Rt3YmhjRbX77UA4a8CgrJ0WD6zHwy', 'Lorem Siswa Dolor', 'level4', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gelombang_pendaftaran`
--
ALTER TABLE `gelombang_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel-berita`
--
ALTER TABLE `tabel-berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `tabel-calon-siswa`
--
ALTER TABLE `tabel-calon-siswa`
  ADD PRIMARY KEY (`id_calon_siswa`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_gelombang_pendaftaran` (`id_gelombang_pendaftaran`);

--
-- Indexes for table `tabel-kelola-kelulusan`
--
ALTER TABLE `tabel-kelola-kelulusan`
  ADD PRIMARY KEY (`id_kelulusan`);

--
-- Indexes for table `tabel-pembayaran-formulir`
--
ALTER TABLE `tabel-pembayaran-formulir`
  ADD PRIMARY KEY (`id_formulir`),
  ADD KEY `id_calon_siswa` (`id_calon_siswa`);

--
-- Indexes for table `tabel-pembayaran-ulang`
--
ALTER TABLE `tabel-pembayaran-ulang`
  ADD PRIMARY KEY (`id_pembayaran_ulang`),
  ADD KEY `id_calon_siswa` (`id_calon_siswa`);

--
-- Indexes for table `tabel-siswa`
--
ALTER TABLE `tabel-siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_gelombang_pendaftaran` (`id_gelombang_pendaftaran`);

--
-- Indexes for table `tabel_kategori`
--
ALTER TABLE `tabel_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tabel_pengguna`
--
ALTER TABLE `tabel_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gelombang_pendaftaran`
--
ALTER TABLE `gelombang_pendaftaran`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel-berita`
--
ALTER TABLE `tabel-berita`
  MODIFY `id_berita` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel-calon-siswa`
--
ALTER TABLE `tabel-calon-siswa`
  MODIFY `id_calon_siswa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel-kelola-kelulusan`
--
ALTER TABLE `tabel-kelola-kelulusan`
  MODIFY `id_kelulusan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel-pembayaran-formulir`
--
ALTER TABLE `tabel-pembayaran-formulir`
  MODIFY `id_formulir` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel-pembayaran-ulang`
--
ALTER TABLE `tabel-pembayaran-ulang`
  MODIFY `id_pembayaran_ulang` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel-siswa`
--
ALTER TABLE `tabel-siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_kategori`
--
ALTER TABLE `tabel_kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT;


CREATE OR REPLACE PROCEDURE update_kelulusan (
   p_id_calon_siswa IN INT,
   p_status IN VARCHAR2
) AS
BEGIN
   -- Update status kelulusan calon siswa berdasarkan ID
   UPDATE `tabel-calon-siswa`
   SET `status` = p_status
   WHERE `id_calon_siswa` = p_id_calon_siswa;
   
   -- Menampilkan pesan konfirmasi
   DBMS_OUTPUT.PUT_LINE('Status kelulusan calon siswa dengan ID ' || p_id_calon_siswa || ' telah diperbarui menjadi ' || p_status);
END update_kelulusan;

--
-- AUTO_INCREMENT for table `tabel_pengguna`
--
ALTER TABLE `tabel_pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
