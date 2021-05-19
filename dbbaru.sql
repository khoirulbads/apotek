-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2021 at 06:10 PM
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


-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `satuan` varchar(40) NOT NULL,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `laba` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `stokMinimal` int(4) NOT NULL,
  `selisih` int(4) NOT NULL,
  `tgl_kadaluarsa` date DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

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

-- --------------------------------------------------------

--
-- Stand-in structure for view `rekom`
-- (See below for the actual view)
--
CREATE TABLE `rekom` (
`id_obat` int(11)
,`nama_obat` varchar(100)
,`id_kategori` int(11)
,`satuan` varchar(40)
,`harga_jual` int(11)
,`harga_beli` int(11)
,`laba` int(11)
,`stok` int(11)
,`stokMinimal` int(4)
,`selisih` int(4)
,`tgl_kadaluarsa` date
,`aktif` tinyint(1)
,`TIMESTAMPDIFF(DAY,now(),tgl_kadaluarsa)` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `rekomendasi`
-- (See below for the actual view)
--
CREATE TABLE `rekomendasi` (
`id_obat` int(11)
,`nama_obat` varchar(100)
,`id_kategori` int(11)
,`satuan` varchar(40)
,`harga_jual` int(11)
,`harga_beli` int(11)
,`laba` int(11)
,`stok` int(11)
,`stokMinimal` int(4)
,`selisih` int(4)
,`tgl_kadaluarsa` date
,`aktif` tinyint(1)
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
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

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
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penyetokan`
--
ALTER TABLE `penyetokan`
  MODIFY `id_penyetokan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

INSERT INTO `level` (`id_level`, `level`) VALUES
(1, 'pemilik'),
(2, 'pengadaan'),
(3, 'kasir'),
(4, 'adminobat');
INSERT INTO `kategori` (`id_kategori`, `kategori`, `aktif`) VALUES
(1, 'Obat Luar', 0),
(2, 'Obat Dalam', 1),
(3, 'Obat Kaki', 0);

INSERT INTO `obat` (`id_obat`, `nama_obat`, `id_kategori`, `satuan`, `harga_jual`, `harga_beli`, `laba`, `stok`, `stokMinimal`, `selisih`, `tgl_kadaluarsa`, `aktif`) VALUES
(1, 'Paracetamol 500 Ml', 2, 'Botol', 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(2, 'Autan', 2, 'Biji', 0, 0, 0, 0, 0, 0, '0000-00-00', 0),
(3, 'Mixagrip', 2, 'Tablet', 11714, 6714, 5000, 7, 5, 10, '2021-07-21', 1),
(4, 'New As Tar 250 gr', 2, 'Tube', 1300, 1000, 300, 0, 10, 10, NULL, 1),
(5, 'Paramex', 2, 'Tablet', 0, 0, 500, 0, 25, 25, NULL, 1);

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telp`, `aktif`) VALUES
(1, 'PT. Jaya Medika', 'Jl Ahmad Dahlan, Mojoroto, Kediri', '085736645772', 0),
(2, 'PT. Jaya Medika', 'Jl Ahmad Dahlan, Mojoroto, Kediri', '085736645771', 1),
(3, 'q', 'q', '08999855173', 0);


INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `id_level`, `aktif`) VALUES
(1, 'Dr. Darmoko, S.ST.', 'pemilik', 'pemilik', 1, 1),
(2, 'adminstok', 'adminstok', 'adminstok', 2, 0),
(3, 'Imam Mulyadi, A.Md. Kom.', 'pengadaan', 'pengadaan', 2, 1),
(4, 'Anisa WIdya', 'kasir', 'kasir', 3, 1),
(5, 'Sulistyowati, S.P.', 'adminobat', 'adminobat', 4, 1);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
