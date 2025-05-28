-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 08:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `id_jenis_barang` char(7) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `harga` int(20) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `kedaluwarsa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `id_jenis_barang`, `nama_barang`, `unit`, `harga`, `jumlah`, `tanggal_masuk`, `kedaluwarsa`) VALUES
('BA00001', 'JB00001', 'Indomilk', 'kotak', 6000, 43, '2025-05-19', '2029-12-04'),
('BA00002', 'JB00002', 'Chocolatos', 'Pcs', 1000, 90, '2025-05-28', '2027-12-04'),
('BA00003', 'JB00004', 'Indomie', 'Pcs', 3000, 45, '2025-05-23', '2028-11-04'),
('BA00004', 'JB00003', 'Bimoli', 'Liter', 37000, 65, '2025-05-04', '2030-12-27'),
('BA00009', 'JB00002', 'Malkis Abon', 'Pcs', 1000, 25, '2025-05-15', '2028-12-31'),
('BA00010', 'JB00002', 'Beng-Beng', 'Pcs', 2500, 3, '2025-05-25', '2027-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis_barang` char(7) NOT NULL,
  `jenis_barang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis_barang`, `jenis_barang`) VALUES
('JB00001', 'Minumann'),
('JB00002', 'Makanan Ringan'),
('JB00003', 'Minyak'),
('JB00004', 'Mie');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `nomor_hp` char(15) NOT NULL,
  `alamat` text NOT NULL,
  `poin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `jenis_kelamin`, `nomor_hp`, `alamat`, `poin`) VALUES
(1, 'rizky', 'L', '085456543211', 'Naru Timurr', 7),
(2, 'Zoro', 'L', '085456543222', 'east blue', 14),
(3, 'nami', 'P', '089776543211', 'north blue', 6),
(4, 'robin', 'P', '084321112567', 'jombang', 4);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_struk` char(13) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_barang` char(7) DEFAULT NULL,
  `tanggal_pembelian` datetime DEFAULT NULL,
  `jumlah_pembelian` int(11) DEFAULT NULL,
  `status_pembelian` enum('Terjual','Belum Terjual') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_struk`, `id_pelanggan`, `id_user`, `id_barang`, `tanggal_pembelian`, `jumlah_pembelian`, `status_pembelian`) VALUES
(1, '68177e7fa9836', 1, 1, 'BA00002', '2025-05-04 22:49:00', 5, 'Terjual'),
(2, '68177e7fa9836', 1, 1, 'BA00003', '2025-05-04 22:49:00', 7, 'Terjual'),
(3, '68177f93a537f', 2, 1, 'BA00001', '2025-05-04 22:54:00', 4, 'Terjual'),
(4, '6817811bd960c', 2, 1, 'BA00004', '2025-05-04 23:00:00', 2, 'Terjual'),
(5, '68178309f114c', 2, 1, 'BA00002', '2025-05-04 23:08:00', 10, 'Terjual'),
(6, '68178a527b234', 2, 3, 'BA00002', '2025-05-04 23:40:00', 25, 'Terjual'),
(7, '68178a527b234', 2, 3, 'BA00001', '2025-05-04 23:40:00', 9, 'Terjual'),
(8, '68178a527b234', 2, 3, 'BA00004', '2025-05-04 23:40:00', 2, 'Terjual'),
(9, '68178a527b234', 2, 3, 'BA00003', '2025-05-04 23:40:00', 9, 'Terjual'),
(11, '681a1fb4e7367', 2, 3, 'BA00004', '2025-05-06 22:41:00', 9, 'Terjual'),
(12, '681a31bbbd312', 1, 3, 'BA00002', '2025-05-06 23:58:00', 5, 'Terjual'),
(14, '6820dead5b0ee', 1, 3, 'BA00004', '2025-05-12 01:30:00', 2, 'Terjual'),
(17, '6824c8744add4', NULL, 3, 'BA00004', '2025-05-15 00:44:00', 3, 'Terjual'),
(18, '6824c8c04bf09', NULL, 3, 'BA00003', '2025-05-15 00:45:00', 5, 'Terjual'),
(19, '68273ebe4ee81', 3, 3, 'BA00001', '2025-05-16 21:33:00', 3, 'Terjual'),
(20, '68273ee71f2cc', NULL, 3, 'BA00003', '2025-05-16 21:34:00', 1, 'Terjual'),
(21, '682747605872c', NULL, 3, 'BA00003', '2025-05-16 22:10:00', 4, 'Terjual'),
(22, '6827558156ba0', NULL, 3, 'BA00003', '2025-05-16 23:10:00', 8, 'Terjual'),
(23, '682755c3730eb', 3, 3, 'BA00003', '2025-05-16 23:12:00', 9, 'Terjual'),
(25, '6827678189667', NULL, 3, 'BA00003', '2025-05-17 00:27:00', 5, 'Terjual'),
(26, '6827678189667', NULL, 3, 'BA00004', '2025-05-17 00:27:00', 1, 'Terjual'),
(27, '6827678189667', NULL, 3, 'BA00002', '2025-05-17 00:27:00', 3, 'Terjual'),
(28, '6827683d2f725', 3, 3, 'BA00002', '2025-05-17 00:30:00', 20, 'Terjual'),
(29, '6827683d2f725', 3, 3, 'BA00003', '2025-05-17 00:30:00', 9, 'Terjual'),
(30, '68276863db570', NULL, 3, 'BA00002', '2025-05-17 00:31:00', 6, 'Terjual'),
(31, '68276863db570', NULL, 3, 'BA00004', '2025-05-17 00:31:00', 1, 'Terjual'),
(32, '6827687b71a56', 2, 3, 'BA00004', '2025-05-17 00:31:00', 3, 'Terjual'),
(33, '6827687b71a56', 2, 3, 'BA00001', '2025-05-17 00:31:00', 3, 'Terjual'),
(34, '68276a805a232', NULL, 3, 'BA00004', '2025-05-17 00:40:00', 2, 'Terjual'),
(35, '68276a8a643fe', 2, 3, 'BA00003', '2025-05-17 00:40:00', 9, 'Terjual'),
(36, '68276c044d56e', 1, 3, 'BA00002', '2025-05-17 00:47:00', 8, 'Terjual'),
(37, '68276d859b2dd', NULL, 3, 'BA00001', '2025-05-17 00:53:00', 9, 'Terjual'),
(38, '68276f03bc58f', 1, 3, 'BA00002', '2025-05-17 00:59:00', 15, 'Terjual'),
(39, '68276f259dfc1', NULL, 3, 'BA00002', '2025-05-17 01:00:00', 6, 'Terjual'),
(41, '682ee6f203019', 4, 3, 'BA00001', '2025-05-22 16:57:00', 5, 'Terjual'),
(43, '6830a404b7e2d', NULL, 3, 'BA00009', '2025-05-24 00:36:00', 20, 'Terjual'),
(44, '6830a404b7e2d', NULL, 3, 'BA00002', '2025-05-24 00:36:00', 9, 'Terjual'),
(45, '6830a74d4d320', 4, 3, 'BA00009', '2025-05-24 00:50:00', 15, 'Terjual'),
(46, '68313f923c8c5', 1, 1, 'BA00009', '2025-05-24 11:40:00', 15, 'Terjual'),
(48, '6831e7f361f96', 4, 1, 'BA00010', '2025-05-24 23:38:00', 1, 'Terjual'),
(49, '6831e9168a182', 2, 1, 'BA00004', '2025-05-24 23:43:00', 2, 'Terjual'),
(50, '68326b3e49d69', 1, 1, 'BA00003', '2025-05-25 08:58:00', 5, 'Terjual'),
(51, '68326b3e49d69', 1, 1, 'BA00009', '2025-05-25 08:58:00', 15, 'Terjual'),
(52, '68326ba2413de', 1, 1, 'BA00010', '2025-05-25 09:00:00', 8, 'Terjual'),
(53, '6832cb02dacae', NULL, 1, 'BA00010', '2025-05-25 15:47:00', 5, 'Terjual'),
(54, '6832cb45a05e2', 3, 1, 'BA00001', '2025-05-25 15:48:00', 2, 'Terjual'),
(59, '68352cac2ff1e', NULL, 3, 'BA00004', '2025-05-27 11:08:00', 1, 'Terjual'),
(60, '68352cac2ff1e', NULL, 3, 'BA00010', '2025-05-27 11:08:00', 4, 'Terjual'),
(61, '68352d79c8ba9', NULL, 3, 'BA00004', '2025-05-27 11:11:00', 2, 'Terjual'),
(62, NULL, NULL, NULL, 'BA00010', NULL, NULL, 'Belum Terjual'),
(63, NULL, NULL, NULL, 'BA00004', NULL, NULL, 'Belum Terjual'),
(64, NULL, NULL, NULL, 'BA00003', NULL, NULL, 'Belum Terjual');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`) VALUES
(1, 'zoro', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(3, 'Fahiraa', 'fahira', 'bb648e8f7447085cf0a4dbfa46cb1ea2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis_barang`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
