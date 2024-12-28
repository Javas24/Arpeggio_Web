-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 11:24 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `nama`, `password`) VALUES
('admin-1717748921', 'acil', 'raul', '827ccb0eea8a706c4c34a16891f84e7b'),
('admin-1717749467', 'abrahamdj_', 'abraham', '248706c023957db08d14f39749879207');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` varchar(255) NOT NULL,
  `admin_id` varchar(255) DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `admin_id`, `aktivitas`, `waktu`) VALUES
('history-1717748921', 'admin-1717748921', 'Admin baru acil telah dibuat', '2024-06-07 08:28:41'),
('history-1717749015', 'admin-1717748921', 'Telah melakukan login', '2024-06-07 08:30:15'),
('history-1717749100', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:31:40'),
('history-1717749131', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:32:11'),
('history-1717749162', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:32:42'),
('history-1717749206', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:33:26'),
('history-1717749253', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:34:13'),
('history-1717749295', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:34:55'),
('history-1717749394', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:36:34'),
('history-1717749445', 'admin-1717748921', 'Menambahkan menu baru', '2024-06-07 08:37:25'),
('history-1717749467', 'admin-1717749467', 'Admin baru abrahamdj_ telah dibuat', '2024-06-07 08:37:47'),
('history-1717749475', 'admin-1717749467', 'Telah melakukan login', '2024-06-07 08:37:55'),
('history-1717749509', 'admin-1717748921', 'Telah mengupdate menu Es Teh', '2024-06-07 08:38:29'),
('history-1717749514', 'admin-1717748921', 'Telah mengupdate menu Es Jeruk', '2024-06-07 08:38:34'),
('history-1717749520', 'admin-1717748921', 'Telah mengupdate menu STMJ', '2024-06-07 08:38:40'),
('history-1717749525', 'admin-1717748921', 'Telah mengupdate menu Kopi Tubruk', '2024-06-07 08:38:45'),
('history-1717749531', 'admin-1717748921', 'Telah mengupdate menu Jus Alpukat', '2024-06-07 08:38:51'),
('history-1717749537', 'admin-1717748921', 'Telah mengupdate menu Es Teler', '2024-06-07 08:38:57'),
('history-1717750936', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:02:16'),
('history-1717750987', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:03:07'),
('history-1717751075', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:04:35'),
('history-1717751148', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:05:48'),
('history-1717751221', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:07:01'),
('history-1717751276', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:07:56'),
('history-1717751332', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:08:52'),
('history-1717751372', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:09:32'),
('history-1717751421', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:10:21'),
('history-1717751469', 'admin-1717749467', 'Menambahkan menu baru', '2024-06-07 09:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `kategori` enum('makanan','minuman') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `admin_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `nama`, `harga`, `deskripsi`, `image_url`, `stok`, `kategori`, `status`, `admin_id`) VALUES
('menu-1717749100', 'Es Teh', '5000.00', 'Teh yang disajikan dengan es batu, sangat populer sebagai minuman penyegar di cuaca panas.', 'assets/images/minuman-1.jpg', 100, 'minuman', 1, 'admin-1717748921'),
('menu-1717749131', 'Es Jeruk', '6000.00', 'Es jeruk adalah minuman segar yang terbuat dari perasan jeruk segar yang dicampur dengan es batu dan sedikit gula untuk memberikan rasa manis', 'assets/images/minuman-2.jpg', 50, 'minuman', 1, 'admin-1717748921'),
('menu-1717749162', 'STMJ', '15000.00', 'STMJ adalah singkatan dari Susu Telur Madu Jahe, minuman tradisional Indonesia yang dikenal karena khasiatnya untuk meningkatkan stamina dan menjaga kesehatan', 'assets/images/minuman-3.jpg', 20, 'minuman', 1, 'admin-1717748921'),
('menu-1717749206', 'Kopi Tubruk', '5000.00', 'Kopi tradisional Indonesia yang diseduh dengan cara mencampurkan kopi bubuk langsung dengan air panas tanpa disaring.', 'assets/images/minuman-4.jpg', 20, 'minuman', 1, 'admin-1717748921'),
('menu-1717749253', 'Jus Alpukat', '20000.00', 'Jus alpukat adalah minuman yang populer di Indonesia karena rasanya yang lezat dan teksturnya yang creamy.', 'assets/images/minuman-5.jpg', 20, 'minuman', 1, 'admin-1717748921'),
('menu-1717749295', 'Es Teler', '25000.00', 'Es Teler adalah minuman segar yang terdiri dari campuran berbagai buah segar, nangka, kelapa muda, alpukat, dan cincau yang disajikan dengan es serut dan sirup kental manis.', 'assets/images/minuman-6.jpg', 25, 'minuman', 1, 'admin-1717748921'),
('menu-1717749394', 'Teh Tarik', '9000.00', 'teh tarik adalah campuran teh hitam yang kuat dan susu evaporasi atau susu kental manis yang dicampur bersama-sama dengan cara yang unik, yaitu tuangkan campuran dari satu cangkir ke cangkir lainnya dari ketinggian, sehingga menciptakan busa yang lembut di atasnya', 'assets/images/minuman-8.jpg', 30, 'minuman', 1, 'admin-1717748921'),
('menu-1717749445', 'Es Kelapa Muda', '15000.00', 'Es Kelapa Muda adalah minuman segar yang terbuat dari daging kelapa muda yang dipadukan dengan air kelapa, gula, dan es serut.', 'assets/images/minuman-9.jpg', 25, 'minuman', 1, 'admin-1717748921'),
('menu-1717749475', 'Es Cincau', '8000.00', 'Es cincau adalah minuman segar yang terdiri dari cincau hitam (jelly hitam) yang dicampur dengan santan dan gula cair, kemudian disajikan dengan es serut.', 'assets/images/minuman-10.jpg', 30, 'minuman', 1, 'admin-1717748921'),
('menu-1717750936', 'Tahu Gejrot', '25000.00', 'Tahu Gejrot adalah salah satu makanan tradisional khas dari Cirebon, Jawa Barat, Indonesia. Makanan ini terbuat dari tahu yang dipotong kecil-kecil dan disajikan dengan kuah pedas manis yang khas.', 'assets/images/56b3b1238bf6168828749d95a4edb3f8.jpg', 12, 'makanan', 1, 'admin-1717749467'),
('menu-1717750987', 'Bakso', '22000.00', 'Bakso adalah salah satu hidangan khas Indonesia yang sangat populer dan digemari oleh berbagai kalangan. Makanan ini terdiri dari bola-bola daging yang umumnya terbuat dari campuran daging sapi giling dan tepung tapioka', 'assets/images/0eee90d35720492a8d2fb5d5f3b90ec1.jpg', 15, 'makanan', 1, 'admin-1717749467'),
('menu-1717751075', 'Pecel', '16000.00', 'Pecel adalah salah satu hidangan tradisional Indonesia yang berasal dari Jawa. Hidangan ini terdiri dari berbagai jenis sayuran rebus seperti kangkung, bayam, kacang panjang, tauge, dan daun singkong yang disajikan dengan saus kacang yang gurih dan sedikit pedas.', 'assets/images/1aadd728c61347fa67dce9690c8b44ba.jpg', 15, 'makanan', 1, 'admin-1717749467'),
('menu-1717751148', 'Ayam Penyet', '25000.00', 'Ayam penyet adalah salah satu hidangan khas Indonesia yang terkenal dengan cita rasa pedas dan gurihnya. ', 'assets/images/52aabbf933e63ece8f3b0593b890513a.jpg', 11, 'makanan', 1, 'admin-1717749467'),
('menu-1717751221', 'Papeda', '20000.00', 'Papeda adalah makanan tradisional khas dari wilayah timur Indonesia, terutama Papua dan Maluku. Makanan ini terbuat dari tepung sagu, yang merupakan pati yang diekstrak dari batang pohon sagu.', 'assets/images/74ca8157e5e6dbc02f0122c695ed8570.jpg', 10, 'makanan', 1, 'admin-1717749467'),
('menu-1717751276', 'Sate Ayam', '16000.00', 'Sate ayam adalah salah satu hidangan khas Indonesia yang terkenal dan digemari oleh banyak orang, baik di dalam maupun luar negeri. ', 'assets/images/5962f9f253bed8358b17fd2503b2f259.jpg', 13, 'makanan', 1, 'admin-1717749467'),
('menu-1717751332', 'Sop', '17000.00', 'Sop adalah salah satu hidangan berkuah yang populer di Indonesia, terdiri dari kaldu yang gurih dan berbagai bahan seperti daging, sayuran, dan rempah-rempah.', 'assets/images/e85a1cf417fa85c223d5d8d4ed663fd3.jpg', 20, 'makanan', 1, 'admin-1717749467'),
('menu-1717751372', 'Nasi Kuning', '18000.00', 'Nasi kuning adalah salah satu hidangan tradisional Indonesia yang terkenal dengan warna kuningnya yang cerah dan rasa yang gurih.', 'assets/images/8044b2282e43723e8a94b17dc4afbba0.jpg', 20, 'makanan', 1, 'admin-1717749467'),
('menu-1717751421', 'Mie Ayam', '14000.00', 'Mie ayam adalah salah satu hidangan populer di Indonesia yang terdiri dari mie kuning yang lembut disajikan dengan potongan ayam berbumbu, serta berbagai pelengkap dan sayuran.', 'assets/images/2931feec229f05a6a50dd64a3a8ddbad.jpg', 20, 'makanan', 1, 'admin-1717749467');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` varchar(50) NOT NULL,
  `menu_id` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tanggal_kirim` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_ibfk_1` (`menu_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
