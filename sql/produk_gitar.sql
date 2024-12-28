-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 01:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_pemweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk_gitar`
--

CREATE TABLE `produk_gitar` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `admin_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_gitar`
--

INSERT INTO `produk_gitar` (`id`, `nama`, `harga`, `deskripsi`, `image_url`, `stok`, `admin_id`, `created_at`, `updated_at`) VALUES
(8, 'jbbm30', 5000000.00, 'adnatba arthasrtjar jasrtjsj', 'assets/guitar/p_region_JBBM30_BKF_1P_01.png', 5, 'admin-1735387084', '2024-12-28 12:01:42', '2024-12-28 12:01:42'),
(9, 'JBBM30', 20000000.00, 'rthrtasrms rtjsrtjsrys srykstykstyk', 'assets/guitar/p_region_JBBM30_BKF_1P_01.png', 10, 'admin-1735387084', '2024-12-28 12:07:56', '2024-12-28 12:07:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk_gitar`
--
ALTER TABLE `produk_gitar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk_gitar`
--
ALTER TABLE `produk_gitar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
