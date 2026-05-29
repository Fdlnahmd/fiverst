-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 03:07 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiverst`
--

-- --------------------------------------------------------

--
-- Table structure for table `cust`
--

CREATE TABLE `cust` (
  `email` varchar(255) NOT NULL,
  `pass` varchar(25) NOT NULL,
  `nama_lengkap` varchar(25) NOT NULL,
  `jenis_kelamin` varchar(25) DEFAULT NULL,
  `alamat` varchar(25) NOT NULL,
  `hp` varchar(25) NOT NULL,
  `stats` enum('admin','user') NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cust`
--

INSERT INTO `cust` (`email`, `pass`, `nama_lengkap`, `jenis_kelamin`, `alamat`, `hp`, `stats`, `id_user`) VALUES
('fadlan@gmail.com', 'fadlan91', 'Fadlan achmad f', 'laki laki', 'jalanan', '98989', 'user', 1),
('admin@gmail.com', 'admin123', 'Admin', 'perempuan', 'jalanannnn', '1281938', 'admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(50) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `total_belanja` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_produk`
--

CREATE TABLE `pemesanan_produk` (
  `id_pemesanan_produk` int(50) NOT NULL,
  `id_pemesanan` int(50) NOT NULL,
  `id_menu` varchar(50) NOT NULL,
  `jumlah` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemesanan_produk`
--

INSERT INTO `pemesanan_produk` (`id_pemesanan_produk`, `id_pemesanan`, `id_menu`, `jumlah`) VALUES
(1, 1, '1', 1),
(2, 1, '6', 1),
(3, 2, '2', 1),
(4, 2, '8', 1),
(5, 2, '1', 1),
(6, 3, '3', 1),
(7, 4, '2', 1),
(8, 5, '3', 1),
(9, 5, '1', 1),
(10, 6, '5', 1),
(11, 7, '6', 1),
(12, 8, '6', 2),
(13, 8, '1', 2),
(14, 8, '11', 1),
(15, 9, '5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(50) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `harga_menu` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_menu`, `harga_menu`, `kategori`, `deskripsi`, `gambar`) VALUES
(1, 'Prawn Paste Chicken', '79000', 'CHICKEN', 'Udang segar renyah dibalut dengan pasta terasi khas aromatik yang lezat dan gurih.', 'PRAWN-CHICKEN.jpg'),
(4, 'Imperial Pork Ribs', '128000', 'PORK', 'Iga babi pilihan dimasak dengan saus kekaisaran madu manis gurih tradisional yang legit.', 'imperial-pork.jpg'),
(5, 'Salted Egg Pork Ribs', '105000', 'PORK', 'Iga babi empuk berbalut saus telur asin (salted egg) creamy yang gurih dan harum daun kari.', 'saltde-egg-pork.jpg'),
(6, 'Thai Style Tofu', '55000', 'TOFU & OMELETTE', 'Tahu sutera lembut digoreng keemasan disajikan dengan saus asam manis khas Thailand.', 'THAI_TOFU.jpg'),
(8, 'HomeTown Tofu', '65000', 'TOFU & OMELETTE', 'Tahu tradisional Five Star dimasak ala rumahan dengan jamur dan sayuran segar berkuah kental.', 'section_tofu_copy.jpg'),
(9, 'BBQ Stingray', '87000', 'FISH', 'Ikan pari segar panggang bumbu BBQ pedas harum dibakar di atas daun pisang aromatik.', 'BBQ-FISH.jpg'),
(10, 'Sweet & Sour Sliced Fish', '90000', 'FISH', 'Irisan fillet ikan gurame segar berbalut saus asam manis nanas oriental klasik.', 'SWEET-SOUR-FISH.jpg'),
(11, 'Chilli Crab', '70000', 'SEAFOOD', 'Kepiting cangkang lunak khas disiram saus cabai Singapura kental pedas manis berempah.', 'CHIIL-SEAFOOD.jpg'),
(12, 'Cereal Prawn', '65000', 'SEAFOOD', 'Udang windu jumbo digoreng garing berselimut remahan sereal gandum manis renyah daun kari.', 'CEREAL-SEAFOOD.jpg'),
(13, 'Salted Egg Sotong', '99000', 'SEAFOOD', 'Cumi segar empuk berbalut tepung telur asin gurih melimpah dan harum rempah.', 'SOTONG-SEAFOOD.jpg'),
(14, 'Mango Sago', '27000', 'DESSERTS & BEVERAGES', 'Puding mangga harum manis legendaris disajikan dingin dengan mutiara sago dan susu krim.', 'MANGO-DESS.jpg'),
(15, 'Peanut Ice Kachang', '40000', 'DESSERTS & BEVERAGES', 'Es serut kacang merah legendaris bertabur gula merah Melaka kental dan sirup wangi.', 'KACHANG-DESS.jpg'),
(16, 'Red Bean Lotus Seed ', '28000', 'DESSERTS & BEVERAGES', 'Sup manis kacang merah hangat berpadu biji teratai lembut berkhasiat untuk penutup hidangan.', 'REDLOTUS-DESS.jpg'),
(18, 'Kailan Vegetables', '65000', 'VEGETABLES', 'Sayur Kailan muda segar ditumis bawang putih aromatik dengan saus tiram premium.', 'EMERALD-VEGE.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cust`
--
ALTER TABLE `cust`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`);

--
-- Indexes for table `pemesanan_produk`
--
ALTER TABLE `pemesanan_produk`
  ADD PRIMARY KEY (`id_pemesanan_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cust`
--
ALTER TABLE `cust`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pemesanan_produk`
--
ALTER TABLE `pemesanan_produk`
  MODIFY `id_pemesanan_produk` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
