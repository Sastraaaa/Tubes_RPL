-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2024 at 03:17 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rasaunikom`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_pesanan`, `id_menu`, `nama_menu`, `qty`, `harga`, `sub_total`) VALUES
(1, 11, '11', 1, 1, 0),
(2, 11, '11', 1, 1, 0),
(3, 111, 'kambing', 1, 11111, 0),
(4, 11, '11', 1, 1, 0),
(5, 12221, 'ayam', 2, 12, 0),
(6, 11, '11', 4, 1, 4),
(7, 12, 'ayam', 11, 1222, 13442),
(8, 11, '11', 1, 1, 1),
(11, 12, 'ayam', 1, 1222, 1222),
(13, 32123, 'nasi goreng', 1, 20000, 20000),
(14, 32123, 'nasi goreng', 7, 20000, 140000),
(15, 32123, 'nasi goreng', 2, 20000, 40000),
(16, 32121, 'es teh', 1, 3, 3),
(17, 32121, 'es teh', 1, 3, 3),
(18, 32121, 'es teh', 1, 3, 3),
(19, 12, 'ayam', 1, 1222, 1222),
(20, 12, 'ayam', 1, 1222, 1222),
(21, 12, 'ayam', 1, 1222, 1222),
(22, 12, 'ayam', 1, 1222, 1222),
(23, 111, 'kambing', 5, 11111, 55555),
(24, 111, 'kambing', 5, 11111, 55555),
(25, 111, 'kambing', 5, 11111, 55555),
(26, 12, 'ayam', 1, 1222, 1222),
(27, 12, 'ayam', 1, 1222, 1222),
(28, 12, 'ayam', 1, 1222, 1222),
(29, 12, 'ayam', 1, 1222, 1222),
(30, 32125, '11111111', 1, 12233, 12233),
(31, 32128, 'nasi', 1, 1, 1),
(33, 32123, 'nasi goreng', 2, 20000, 40000),
(35, 32123, 'nasi goreng', 2, 20000, 40000),
(37, 111, 'kambing', 1, 11111, 11111),
(38, 12, 'ayam', 1, 1222, 1222),
(39, 111, 'kambing', 4, 11111, 44444),
(40, 32123, 'nasi goreng', 2, 20000, 40000),
(41, 32128, 'nasi', 1, 1, 1),
(42, 32128, 'nasi', 1, 1, 1),
(43, 111, 'kambing', 1, 11111, 11111),
(44, 111, 'kambing', 1, 11111, 11111),
(45, 111, 'kambing', 1, 11111, 11111),
(46, 111, 'kambing', 1, 11111, 11111),
(47, 111, 'kambing', 1, 11111, 11111),
(48, 32130, 'kue', 1, 1, 1),
(49, 32130, 'kue', 1, 1, 1),
(50, 32125, '11111111', 1, 12233, 12233),
(51, 12, 'ayam', 4, 1222, 4888),
(52, 32131, 'mi babi', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `id_jabatan`
--

CREATE TABLE `id_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `id_jabatan`
--

INSERT INTO `id_jabatan` (`id_jabatan`, `jabatan`) VALUES
(1, 'Admin'),
(2, 'Owner'),
(3, 'Koki'),
(4, 'Kasir'),
(5, 'Pelayan');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama`, `id_jabatan`, `no_telp`, `email`, `username`, `password`) VALUES
(1, 'Maman Suherman', 1, '082190932013', 'maman@wikwik.me', 'admin', '123'),
(2, 'Ahmad bin Saeed Al Maktoum', 2, '022378009123', 'saeedmaktoum@wukwuk.com', 'owner', '123'),
(3, 'mama', 3, '082190932045', 'man@wikwik.me', 'koki', '123'),
(4, 'Ahmad bin Saeed ', 4, '022378009333', 'saeedmakt333oum@wukwuk.com', 'kasir', '123'),
(5, 'uding nganga', 5, '082190932048', 'udin@gmail.com', 'pelayan', '123');

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `nomor_meja` int(11) NOT NULL,
  `status` enum('tersedia','tidak tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`nomor_meja`, `status`) VALUES
(1, 'tidak tersedia'),
(2, 'tidak tersedia'),
(3, 'tidak tersedia'),
(4, 'tidak tersedia'),
(5, 'tidak tersedia'),
(6, 'tidak tersedia'),
(7, 'tidak tersedia'),
(8, 'tersedia'),
(9, 'tersedia'),
(10, 'tersedia'),
(11, 'tersedia'),
(12, 'tidak tersedia'),
(13, 'tidak tersedia'),
(14, 'tersedia'),
(15, 'tersedia'),
(16, 'tersedia'),
(17, 'tersedia'),
(18, 'tidak tersedia'),
(19, 'tersedia'),
(20, 'tersedia'),
(21, 'tersedia'),
(22, 'tersedia'),
(23, 'tersedia'),
(24, 'tersedia'),
(25, 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `deskripsi` varchar(250) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `kategori` enum('makanan','minuman') NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `deskripsi`, `harga`, `stok`, `kategori`, `image`) VALUES
(12, 'ayam', 'ini ayam', 1222, 96, 'makanan', 'assets/images/menu/nasi.jpg'),
(111, 'kambing', 'ini kambing', 11111, 77, 'makanan', 'assets/images/menu/ayam_bakar.jpg'),
(12221, 'ayam babi', 'ini ayam', 12, 0, 'makanan', ''),
(32121, 'es teh', 'ini es', 3, 4, 'minuman', ''),
(32123, 'nasi goreng', 'tapi ga digoreng', 20000, 67, 'makanan', 'assets/images/menu/111111111111.jpg'),
(32125, '11111111', 'wwwwq', 12233, 10, 'minuman', 'assets/images/menu/wallpaperflare.com_wallpaper.jpg'),
(32126, 'nasi goreng', 'ss', 2147483647, 0, 'minuman', 'assets/images/menu/Screenshot 2024-05-27 083232.jpg'),
(32128, 'nasi', '1', 1, 5, 'makanan', 'assets/images/menu/Screenshot 2024-01-06 225624.jpg'),
(32129, 'nasi gila', 'aw aw', 1200, 111, 'makanan', 'assets/images/menu/wawancara.jpg'),
(32130, 'kue', 'e', 1, 9, 'makanan', 'assets/images/menu/dkm3.jpg'),
(32131, 'mi babi', 'a', 1, 11, 'makanan', 'assets/images/menu/1111.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` enum('pending','confirmed','paid') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nama_pelanggan`, `no_meja`, `tanggal`, `total_harga`, `status`) VALUES
(1, 'asdrftg', 1, '2024-06-12 12:55:37', 12349, 'paid'),
(2, 'qwerty', 3, '2024-05-10 12:56:06', 12349, 'paid'),
(3, 'xd', 7, '2024-07-18 12:57:50', 11111, 'paid'),
(4, 'a', 8, '2024-07-18 13:00:23', 1, 'paid'),
(5, 'w', 1, '2024-07-18 13:01:40', 24, 'paid'),
(6, 'aku', 2, '2024-07-18 13:06:13', 4, 'paid'),
(7, 'ssss', 3, '2024-07-18 13:06:59', 13457, 'paid'),
(8, 'asd', 9, '2024-07-18 13:30:13', 12349, 'paid'),
(11, 'kamu', 10, '2024-07-18 13:47:23', 12348, 'paid'),
(12, 'tes', 11, '2024-01-01 18:54:16', 21234, 'paid'),
(13, 'tes', 11, '2024-07-18 18:58:38', 21234, 'paid'),
(14, 'tes lagi', 12, '2024-07-18 18:59:16', 142444, 'paid'),
(15, 'TES1', 1, '2024-07-19 07:20:01', 42456, 'paid'),
(16, 'xd', 10, '2024-07-19 07:37:15', 2147483647, 'paid'),
(17, 'xd', 14, '2024-07-19 07:43:31', 12003, 'paid'),
(18, 's', 15, '2024-07-19 07:47:21', 12003, 'paid'),
(19, 'aa', 16, '2024-07-20 18:15:33', 12346, 'paid'),
(20, 'aa', 16, '2024-07-20 18:16:22', 12346, 'paid'),
(21, 'aa', 17, '2024-07-20 18:16:28', 1234, 'paid'),
(22, 'aa', 19, '2024-07-20 19:09:12', 1222, 'paid'),
(23, 'q', 19, '2024-07-20 19:11:40', 55555, 'paid'),
(24, 'q', 19, '2024-07-20 19:20:14', 55555, 'paid'),
(25, 'q', 19, '2024-07-20 19:25:11', 55555, 'paid'),
(26, 'aa', 19, '2024-07-20 19:26:19', 1222, 'paid'),
(27, 'aa', 19, '2024-07-20 19:26:50', 1222, 'paid'),
(28, 'aa', 19, '2024-07-20 19:26:57', 1222, 'paid'),
(29, 'aa', 19, '2024-07-20 19:27:02', 1222, 'paid'),
(30, 'aku', 20, '2024-07-20 19:42:10', 353433, 'paid'),
(31, 'ss', 20, '2024-07-20 19:42:50', 1, 'paid'),
(32, 's', 1, '2024-07-20 20:11:42', 2147483647, 'paid'),
(33, 's', 1, '2024-07-20 20:11:42', 2147483647, 'paid'),
(34, 's', 1, '2024-07-20 20:12:50', 2147483647, 'paid'),
(35, 's', 1, '2024-07-20 20:12:50', 2147483647, 'paid'),
(36, 'tes', 2, '2024-07-20 20:13:07', 11112, 'paid'),
(37, 'tes', 2, '2024-07-20 20:13:07', 11112, 'paid'),
(38, 'aa', 19, '2024-07-20 20:15:47', 1222, 'confirmed'),
(39, 'tes', 3, '2024-07-20 20:16:01', 44447, 'pending'),
(40, 'aku', 3, '2024-07-20 20:16:17', 40012, 'pending'),
(41, 'p', 7, '2024-07-20 20:17:38', 20001, 'pending'),
(42, 'p', 7, '2024-07-20 20:17:59', 20001, 'pending'),
(43, 'aa', 8, '2024-07-20 20:18:14', 12333, 'pending'),
(44, 'aa', 8, '2024-07-20 20:19:40', 12333, 'pending'),
(45, 'aa', 8, '2024-07-20 20:20:02', 12333, 'pending'),
(46, 'aa', 8, '2024-07-20 20:20:10', 12333, 'paid'),
(47, 'a', 1, '2024-07-23 13:52:08', 11111, 'pending'),
(48, 'kamuvv', 1, '2024-07-23 13:52:39', 1, 'paid'),
(49, 'kamuvv', 1, '2024-07-23 13:53:22', 1, 'confirmed'),
(50, '1', 1, '2024-07-23 16:39:17', 12233, 'confirmed'),
(51, 'q', 2, '2024-04-23 18:53:46', 2147483647, 'paid'),
(52, 'as', 2, '2024-07-23 19:51:04', 2, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `id_jabatan`
--
ALTER TABLE `id_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`nomor_meja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `no_meja` (`no_meja`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `id_jabatan`
--
ALTER TABLE `id_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `nomor_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32132;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `id_jabatan` (`id_jabatan`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`no_meja`) REFERENCES `meja` (`nomor_meja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
