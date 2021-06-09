-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2021 at 08:22 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_obat`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `inv` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_obat`, `qty`, `harga_jual`, `harga_beli`, `total`, `inv`) VALUES
(1, 4, 5, 1200, 1000, 6000, 'INV/1623219263'),
(2, 3, 7, 11714, 6714, 81998, 'INV/1623219263');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(15) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`, `aktif`) VALUES
(1, 'Obat Luar', 0),
(2, 'Obat Dalam', 1),
(3, 'Obat Kaki', 0);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `level`) VALUES
(1, 'pemilik'),
(2, 'pengadaan'),
(3, 'kasir'),
(4, 'adminobat');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `satuan` varchar(40) NOT NULL,
  `harga_jualResep` int(11) NOT NULL DEFAULT 0,
  `harga_jualNon` int(11) NOT NULL DEFAULT 0,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `labaResep` int(11) NOT NULL,
  `labaNon` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `stokMinimal` int(4) NOT NULL,
  `selisih` int(4) NOT NULL,
  `tgl_kadaluarsa` date DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `id_kategori`, `satuan`, `harga_jualResep`, `harga_jualNon`, `harga_beli`, `labaResep`, `labaNon`, `stok`, `stokMinimal`, `selisih`, `tgl_kadaluarsa`, `aktif`) VALUES
(1, 'Paracetamol 500 Ml', 2, 'Botol', 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(2, 'Autan', 2, 'Biji', 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(3, 'Mixagrip', 2, 'Tablet', 11714, 0, 6714, 5000, 0, 7, 5, 10, '2021-05-23', 1),
(4, 'New As Tar 250 gr', 2, 'Tablet', 1200, 1100, 1000, 20, 10, 40, 10, 10, '2021-06-15', 1),
(5, 'Paramex', 2, 'Tablet', 0, 0, 0, 500, 0, 0, 25, 25, NULL, 1),
(6, 'Konidin 4 gr', 2, 'Tablet', 0, 0, 0, 6, 1, 0, 15, 10, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penyetokan`
--

CREATE TABLE `penyetokan` (
  `id_penyetokan` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL DEFAULT current_timestamp(),
  `tgl_kadaluarsa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyetokan`
--

INSERT INTO `penyetokan` (`id_penyetokan`, `id_obat`, `id_supplier`, `jumlah`, `harga_beli`, `stok_awal`, `stok_akhir`, `total`, `tgl_masuk`, `tgl_kadaluarsa`) VALUES
(3, 4, 2, 30, 9000, 0, 30, 270000, '2021-05-21', '2021-10-21'),
(4, 4, 2, 10, 10000, 30, 40, 100000, '2021-05-29', '2021-06-15');

-- --------------------------------------------------------

--
-- Stand-in structure for view `rekom`
-- (See below for the actual view)
--
CREATE TABLE `rekom` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rekomendasi`
-- (See below for the actual view)
--
CREATE TABLE `rekomendasi` (
);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `telp` varchar(14) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telp`, `aktif`) VALUES
(1, 'PT. Jaya Medika', 'Jl Ahmad Dahlan, Mojoroto, Kediri', '085736645772', 0),
(2, 'PT. Jaya Medika', 'Jl Ahmad Dahlan, Mojoroto, Kediri', '085736645771', 1),
(3, 'q', 'q', '08999855173', 0);

-- --------------------------------------------------------

--
-- Table structure for table `temp_transaksi`
--

CREATE TABLE `temp_transaksi` (
  `id_temp` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `laba` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `inv` varchar(50) NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembali` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `inv`, `jenis`, `grand_total`, `bayar`, `kembali`, `tanggal`, `id_user`) VALUES
(1623219263, 'INV/1623219263', 'resep', 87998, 100000, 12002, '2021-06-09 06:14:23', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_level` int(3) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `id_level`, `aktif`) VALUES
(1, 'Dr. Darmoko, S.ST.', 'pemilik', 'pemilik', 1, 1),
(2, 'adminstok', 'adminstok', 'adminstok', 2, 0),
(3, 'Imam Mulyadi, A.Md. Kom.', 'pengadaan', 'pengadaan', 2, 1),
(4, 'Anisa WIdya', 'kasir', 'kasir', 3, 1),
(5, 'Sulistyowati, S.P.', 'adminobat', 'adminobat', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `rekom`
--
DROP TABLE IF EXISTS `rekom`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rekom`  AS  select `obat`.`id_obat` AS `id_obat`,`obat`.`nama_obat` AS `nama_obat`,`obat`.`id_kategori` AS `id_kategori`,`obat`.`satuan` AS `satuan`,`obat`.`harga_jual` AS `harga_jual`,`obat`.`harga_beli` AS `harga_beli`,`obat`.`laba` AS `laba`,`obat`.`stok` AS `stok`,`obat`.`stokMinimal` AS `stokMinimal`,`obat`.`selisih` AS `selisih`,`obat`.`tgl_kadaluarsa` AS `tgl_kadaluarsa`,`obat`.`aktif` AS `aktif`,timestampdiff(DAY,current_timestamp(),`obat`.`tgl_kadaluarsa`) AS `TIMESTAMPDIFF(DAY,now(),tgl_kadaluarsa)` from `obat` where timestampdiff(DAY,current_timestamp(),`obat`.`tgl_kadaluarsa`) <= `obat`.`selisih` or `obat`.`stok` <= `obat`.`stokMinimal` ;

-- --------------------------------------------------------

--
-- Structure for view `rekomendasi`
--
DROP TABLE IF EXISTS `rekomendasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rekomendasi`  AS  select `obat`.`id_obat` AS `id_obat`,`obat`.`nama_obat` AS `nama_obat`,`obat`.`id_kategori` AS `id_kategori`,`obat`.`satuan` AS `satuan`,`obat`.`harga_jual` AS `harga_jual`,`obat`.`harga_beli` AS `harga_beli`,`obat`.`laba` AS `laba`,`obat`.`stok` AS `stok`,`obat`.`stokMinimal` AS `stokMinimal`,`obat`.`selisih` AS `selisih`,`obat`.`tgl_kadaluarsa` AS `tgl_kadaluarsa`,`obat`.`aktif` AS `aktif` from `obat` where timestampdiff(DAY,current_timestamp(),`obat`.`tgl_kadaluarsa`) <= `obat`.`selisih` or `obat`.`stokMinimal` <= `obat`.`stok` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `penyetokan`
--
ALTER TABLE `penyetokan`
  ADD PRIMARY KEY (`id_penyetokan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `temp_transaksi`
--
ALTER TABLE `temp_transaksi`
  ADD PRIMARY KEY (`id_temp`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penyetokan`
--
ALTER TABLE `penyetokan`
  MODIFY `id_penyetokan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_transaksi`
--
ALTER TABLE `temp_transaksi`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1623219264;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
