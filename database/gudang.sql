-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 03:14 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang3`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(5) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `stok_minimum` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `satuan` int(11) NOT NULL,
  `harga` double NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama_barang`, `stok_minimum`, `stok`, `satuan`, `harga`, `foto`) VALUES
('B0001', 'Repsol DXR 8 15W-40 API CI-4', 10, 10, 2, 6300000, NULL),
('B0002', 'Repsol Maker Hydroflux', 10, 0, 2, 5400000, NULL),
('B0003', 'Repsol Maker Hydroflux VG68', 10, 0, 3, 5500000, NULL),
('B0004', 'Repsol Navigator EP GL-5 SAE 90', 10, 0, 2, 7300000, NULL),
('B0005', 'Repsol  Navigator API GL-5 SAE 140', 10, 0, 2, 7650000, NULL),
('B0006', 'Repsol Navigator API GL-5 SAE 85W-140', 10, 0, 2, 7900000, NULL),
('B0007', 'Repsol Transmission EP GL-5 SAE 80W-90', 10, 0, 2, 7700000, NULL),
('B0008', 'Repsol ATF 3', 10, 0, 2, 6900000, NULL),
('B0009', 'Grease EPI NLGI 2', 5, 0, 2, 10500000, NULL),
('B0010', 'Repsol Giant 1020 SAE 10W CF4/SG', 10, 0, 2, 5500000, NULL),
('B0011', 'Repsol Giant 1020 SAE 30W CF/SF', 10, 0, 2, 5750001, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_keluar`
--

CREATE TABLE `tbl_barang_keluar` (
  `id_transaksi` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `tgl_jatuh_tempo` date NOT NULL,
  `no_po` varchar(100) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `cetak_invoice` varchar(50) DEFAULT NULL,
  `cetak_surat_jln` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_barang_keluar`
--

INSERT INTO `tbl_barang_keluar` (`id_transaksi`, `tanggal`, `tgl_jatuh_tempo`, `no_po`, `id_customer`, `cetak_invoice`, `cetak_surat_jln`) VALUES
('00001/LSA-BKA/VII/2024', '2024-07-06', '2024-07-06', '1', 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_masuk`
--

CREATE TABLE `tbl_barang_masuk` (
  `id_transaksi` varchar(50) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`id_transaksi`, `tanggal`) VALUES
('0001/LSA-AEK/VI/2024', '2024-07-06'),
('0003/LSA-AEK/VII/2024', '2024-07-08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id_customer` int(11) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL,
  `singkatan` varchar(10) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `kontak` varchar(25) DEFAULT NULL,
  `no_tlp` varchar(15) DEFAULT NULL,
  `sites` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id_customer`, `nama_perusahaan`, `singkatan`, `alamat`, `kontak`, `no_tlp`, `sites`) VALUES
(14, 'PT Berkerja Keras Anjay', 'BKA', 'Jl. Kuin utara No.36. Rt.12. Rw.03.', 'Amang Udin', '087899992133', 'Jembatan Putih'),
(15, 'PT Kada Karuan Negeri', 'KKN', 'Jl. Handil Bhakti No.36. Rt.12. Rw.05 Kota Banjarm', 'Acil Bayah', '087855341234', 'Permata Indah'),
(16, 'PT Pusaka Abadi Nan Jaya', 'PANJ', 'Jl. Kuin utara No.18. Rt.12. Rw.5 Kota Banjarmasin', 'Alm Udin', '087899992322', 'Kuburan'),
(17, 'PT. Wush Jer Ahai', 'WJA', 'Jl Mangga Besar Raya 4 NN,  Dki Jakarta', 'Adit', '08782123333', 'Jakar'),
(18, 'PT Bermain Bersama', 'BB', 'Jl Alkateri 15, Jawa Barat', 'Mama Rika', '087734545555', 'Alkaut'),
(19, 'PT Malindo Jaya Abadi', 'MJA', 'Jl Jend Basuki Rachmad 2-12 Plaza Tunjungan III 20', 'Amang Ijul', '087823661233', 'Basuki');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_barang_keluar`
--

CREATE TABLE `tbl_detail_barang_keluar` (
  `id_keluar` varchar(50) NOT NULL,
  `id_barang` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_detail_barang_keluar`
--

INSERT INTO `tbl_detail_barang_keluar` (`id_keluar`, `id_barang`, `jumlah`, `harga`) VALUES
('00001/LSA-BKA/VII/2024', 'B0001', 1, 6300000),
('00001/LSA-BKA/VII/2024', 'B0002', 1, 5400000),
('00001/LSA-BKA/VII/2024', 'B0003', 1, 5500000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_barang_masuk`
--

CREATE TABLE `tbl_detail_barang_masuk` (
  `id_masuk` varchar(50) NOT NULL,
  `id_barang` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_detail_barang_masuk`
--

INSERT INTO `tbl_detail_barang_masuk` (`id_masuk`, `id_barang`, `jumlah`, `harga`) VALUES
('0001/LSA-AEK/VI/2024', 'B0001', 10, 6300000),
('0001/LSA-AEK/VI/2024', 'B0002', 10, 5400000),
('0001/LSA-AEK/VI/2024', 'B0003', 10, 5500000),
('0001/LSA-AEK/VI/2024', 'B0004', 10, 7300000),
('0001/LSA-AEK/VI/2024', 'B0005', 10, 7650000),
('0001/LSA-AEK/VI/2024', 'B0006', 10, 7900000),
('0001/LSA-AEK/VI/2024', 'B0007', 10, 7700000),
('0001/LSA-AEK/VI/2024', 'B0008', 10, 6900000),
('0001/LSA-AEK/VI/2024', 'B0009', 10, 10500000),
('0001/LSA-AEK/VI/2024', 'B0010', 10, 5500000),
('0001/LSA-AEK/VI/2024', 'B0011', 10, 5750001),
('0003/LSA-AEK/VII/2024', 'B0001', 2, 6300000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`id_satuan`, `nama_satuan`) VALUES
(2, 'Drum'),
(3, 'Pail');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hak_akses` enum('Admin','Gudang','Pimpinan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `username`, `password`, `hak_akses`) VALUES
(10, 'Noor Hamidah', 'Midah', '$2y$12$szN96TWI8litd.eAIeJjy.EdYU28nhunm/4dBlvBcg7Ur.J2Jxu5W', 'Gudang'),
(12, 'Mulya', 'Mulya', '$2y$12$zFwAHFRvf98p8j6qRUK38ucmwF.EX2GWSOtcSPmrLpXxi3n8dEAGe', 'Admin'),
(14, 'Ramadhani Noor Pratama', 'Bapak', '$2y$12$6q5hv3/xMn4x2U86c6Kdee7hNqC6KNx5mVmpGtIGhFWNhYHyaqPwq', 'Pimpinan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `satuan` (`satuan`);

--
-- Indexes for table `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `id_transaksi` (`id_transaksi`),
  ADD UNIQUE KEY `id_transaksi_2` (`id_transaksi`),
  ADD UNIQUE KEY `id_transaksi_3` (`id_transaksi`),
  ADD UNIQUE KEY `id_transaksi_4` (`id_transaksi`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tbl_detail_barang_keluar`
--
ALTER TABLE `tbl_detail_barang_keluar`
  ADD PRIMARY KEY (`id_keluar`,`id_barang`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `tbl_detail_barang_masuk`
--
ALTER TABLE `tbl_detail_barang_masuk`
  ADD PRIMARY KEY (`id_masuk`,`id_barang`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_barang_2` (`id_barang`),
  ADD KEY `id_barang_3` (`id_barang`);

--
-- Indexes for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD CONSTRAINT `tbl_barang_ibfk_1` FOREIGN KEY (`satuan`) REFERENCES `tbl_satuan` (`id_satuan`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_barang_keluar`
--
ALTER TABLE `tbl_barang_keluar`
  ADD CONSTRAINT `tbl_barang_keluar_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `tbl_customer` (`id_customer`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detail_barang_keluar`
--
ALTER TABLE `tbl_detail_barang_keluar`
  ADD CONSTRAINT `tbl_detail_barang_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id_barang`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detail_barang_masuk`
--
ALTER TABLE `tbl_detail_barang_masuk`
  ADD CONSTRAINT `tbl_detail_barang_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tbl_barang` (`id_barang`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
