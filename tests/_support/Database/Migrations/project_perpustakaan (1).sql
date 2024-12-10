-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 09:43 AM
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
-- Database: `project_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` varchar(6) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username_admin` varchar(20) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `akses_level` enum('1','2','3') NOT NULL,
  `is_delete_admin` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `profile_image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama_admin`, `username_admin`, `password_admin`, `akses_level`, `is_delete_admin`, `created_at`, `updated_at`, `profile_image`) VALUES
('ADM000', 'Developer', 'developer', '$2y$10$KwIf5O6s6DujbcVohV/rZOrQTBpS95BtKJziuLsFzdj765BjWf6W6', '1', '0', '2024-06-06 10:46:12', '2024-11-26 12:24:48', '1732598687_Itadori-yuiji-shibuya-incident-arc-jujutsu-kaisen.jpg'),
('ADM001', 'dia', 'admin', '$2y$10$soPrtcBFHmX8MG63oNSE1.abpuy2yd3Uj2VS0nEP/VV95Khw87m/W', '2', '0', '2024-06-25 12:13:31', '2024-11-19 19:06:01', '1732017961_naruto.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id_anggota` varchar(6) NOT NULL,
  `nama_anggota` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password_anggota` varchar(50) NOT NULL,
  `is_delete_anggota` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `profile_image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id_anggota`, `nama_anggota`, `jenis_kelamin`, `no_tlp`, `alamat`, `email`, `password_anggota`, `is_delete_anggota`, `created_at`, `updated_at`, `profile_image`) VALUES
('ANG001', 'Pandu Tegar Prasetyo', 'L', '085951750898', 'Planet Mars', 'pandutgr13@gmail.com', '12345678', '0', '2024-06-08 16:10:14', '2024-11-23 20:53:54', '1732020590_naruto.jpeg'),
('ANG002', 'Muhammad Faried Putra Fadilah', 'L', '085158514660', 'Planet Pluto', 'faried@gmail.com', '12345678', '0', '2024-06-24 19:02:12', '2024-06-24 19:02:12', 'default.jpg'),
('ANG003', 'Damar Fikrie', 'L', '085156487577', 'Planet Saturnus', 'damar@gmail.com', '12345678', '0', '2024-06-24 19:03:06', '2024-11-12 13:57:59', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `id_buku` varchar(6) NOT NULL,
  `judul_buku` varchar(200) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `jumlah_buku` int(3) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `id_kategori` varchar(6) NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `id_rak` varchar(6) NOT NULL,
  `cover_buku` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_delete_buku` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_buku` enum('Tersedia','Tidak Tersedia') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `judul_buku`, `pengarang`, `penerbit`, `tahun`, `jumlah_buku`, `isbn`, `id_kategori`, `keterangan`, `id_rak`, `cover_buku`, `is_delete_buku`, `status_buku`, `created_at`, `updated_at`) VALUES
('BUK001', 'Harry Potter and the Sorcerer Stone', 'J.K. Rowling', 'Bloomsbury Publishing', '1997', 1, '901390179017', 'KAT001', 'Buku ini mengikuti petualangan seorang anak yatim piatu bernama Harry Potter, yang pada ulang tahun kesebelasnya menemukan bahwa dia seorang penyihir. Dia diundang untuk belajar di Sekolah Sihir Hogwarts, di mana dia bertemu dengan teman-teman setia Hermione Granger dan Ron Weasley.', 'RAK002', 'Harry-Potter.jpg', '0', 'Tersedia', '2024-06-28 10:02:32', '2024-11-23 14:31:51'),
('BUK002', 'Sapiens: A Brief History of Humankind', 'Yoval Noah Harari', 'Dvir Publishing House Ltd.', '2011', 5, '9786024244163', 'KAT002', '\"Sapiens: Riwayat Singkat Umat Manusia\" adalah sebuah buku karya Yuval Noah Harari yang mengisahkan perjalanan sejarah manusia dari masa prasejarah hingga era modern. Buku ini mengeksplorasi bagaimana Homo sapiens menjadi spesies dominan di bumi dan membahas berbagai revolusi yang terjadi, seperti revolusi kognitif, agrikultural, dan ilmiah.', 'RAK002', 'sapiens.jpg', '0', 'Tersedia', '2024-06-28 13:12:28', '2024-07-02 13:06:36'),
('BUK003', 'Bumi', 'Tere Liye', 'SABAKGRIP', '2022', 5, '9786239726263', 'KAT001', 'Bumi, merupakan rangkaian awal dari kisah sekelompok anak remaja berkemampuan istimewa. Menceritakan tentang Raib, Ali, dan Seli yang bertualang ke dunia paralel. Mereka yang istimewa, mampu pergi ke dunia pararel bumi, bertemu dengan klan lain dan berhadapan dengan Tamus yang memiliki ambisi membebaskan si Tanpa Mahkota dan kemudian, menguasai bumi.', 'RAK001', 'Bumi.jpg', '0', 'Tersedia', '2024-06-28 13:15:14', '2024-11-23 14:21:49'),
('BUK004', 'The Hobbit', 'J. R. R. Tolkien', 'Gramedia Pustaka Utama', '2002', 5, '9796867672', 'KAT001', 'Bilbo Baggins adalah hobbit yang suka hidup nyaman, tidak ambisius, jarang bepergian jauh selain ke gudang makanan di lubang hobbit-nya di Bag End. Tetapi hidup nyamannya terganggu ketika Gandalf si Penyihir, dan 13 kurcaci mendatanginya suatu hari, untuk mengajaknya menempuh suatu perjalanan “ke sana dan pulang kembali.” Mereka berencana untuk mengambil harta Smaug, naga raksasa yang sangat berbahaya.', 'RAK002', 'The-Hobbit.jpg', '0', 'Tersedia', '2024-07-02 13:17:53', '2024-11-23 14:26:04'),
('BUK005', 'Don Quixote', 'Miguel de Cervantes', 'Immortal Publisher', '2017', 5, '9786026657626', 'KAT001', 'Don Quixote, karya Miguel de Cervantes, adalah salah satu novel klasik terbesar dalam sastra dunia. Buku ini mengisahkan petualangan seorang pria paruh baya bernama Alonso Quixano, yang kehilangan kewarasannya setelah terlalu banyak membaca kisah-kisah kepahlawanan. Ia mengubah dirinya menjadi Don Quixote, seorang \"ksatria gagah berani,\" dan berangkat dalam misi untuk menghidupkan kembali nilai-nilai ksatria.', 'RAK002', 'Don-Quixote.jpg', '0', 'Tersedia', '2024-11-23 14:18:47', '2024-11-23 14:31:18'),
('BUK006', 'Catatan Seorang Demonstran', 'Soe Hak Gie', 'Lp3es', '2008', 5, '200038056', 'KAT002', 'Buku ini bercerita tentang Soe Hok Gie yang merupakan seorang aktivis kampus yang memegang teguh prinsipnya dan memiliki cita-cita yang besar. Mimpinya bukan hanya tentang dirinya tapi juga tentang kepentingan orang banyak dan kaum yang termarjinalkan. Sosok Gie ini gemar sekali membuat catatan-catatan tentang apa yang ada dipikiran kritisnya sebagai representasi dari pengalamanya menjadi seorang mahasiswa, pendaki, dan tentang dirinya yang merdeka yang memiliki darah Tionghoa.', 'RAK001', 'catatan-seorang-demonstran.jpg', '0', 'Tersedia', '2024-11-23 14:30:04', '2024-11-23 14:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_peminjaman`
--

CREATE TABLE `tbl_detail_peminjaman` (
  `id_peminjaman` varchar(6) NOT NULL,
  `id_buku` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_pinjam` enum('Sedang Dipinjam','Sudah Dikembalikan') NOT NULL,
  `perpanjangan` int(1) NOT NULL,
  `tgl_kembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_detail_peminjaman`
--

INSERT INTO `tbl_detail_peminjaman` (`id_peminjaman`, `id_buku`, `status_pinjam`, `perpanjangan`, `tgl_kembali`) VALUES
('PIN001', 'BUK004', 'Sudah Dikembalikan', 2, '2024-11-25'),
('PIN002', 'BUK004', 'Sudah Dikembalikan', 2, '2024-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` varchar(6) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `is_delete_kategori` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`, `is_delete_kategori`, `created_at`, `updated_at`) VALUES
('KAT001', 'Fiksi', '0', '2024-06-09 04:32:38', '2024-06-09 17:36:06'),
('KAT002', 'Non-fiksi', '0', '2024-06-24 19:05:55', '2024-06-24 19:05:55'),
('KAT003', 'Referensi', '0', '2024-06-24 19:06:10', '2024-10-08 05:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_peminjaman`
--

CREATE TABLE `tbl_peminjaman` (
  `id_peminjaman` varchar(6) NOT NULL,
  `id_anggota` varchar(6) NOT NULL,
  `id_admin` varchar(6) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `total_pinjam` int(3) NOT NULL,
  `status_transaksi` enum('Selesai','Berjalan') NOT NULL,
  `status_ambil_buku` enum('Belum Diambil','Sudah Diambil') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_peminjaman`
--

INSERT INTO `tbl_peminjaman` (`id_peminjaman`, `id_anggota`, `id_admin`, `tgl_pinjam`, `total_pinjam`, `status_transaksi`, `status_ambil_buku`) VALUES
('PIN001', 'ANG003', '-', '2024-11-24 00:00:00', 1, 'Selesai', 'Sudah Diambil'),
('PIN002', 'ANG003', '-', '2024-11-26 00:00:00', 1, 'Selesai', 'Sudah Diambil');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengembalian`
--

CREATE TABLE `tbl_pengembalian` (
  `id_pengembalian` varchar(6) NOT NULL,
  `id_peminjaman` varchar(6) NOT NULL,
  `id_buku` varchar(6) NOT NULL,
  `denda` double NOT NULL,
  `tgl_pengembalian` datetime NOT NULL,
  `id_admin` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_pengembalian`
--

INSERT INTO `tbl_pengembalian` (`id_pengembalian`, `id_peminjaman`, `id_buku`, `denda`, `tgl_pengembalian`, `id_admin`) VALUES
('PB-001', 'PIN001', 'BUK004', 6000, '2024-11-26 00:00:00', 'ANG003'),
('PB-002', 'PIN002', 'BUK004', 9000, '2024-12-06 00:00:00', 'ANG003');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rak`
--

CREATE TABLE `tbl_rak` (
  `id_rak` varchar(6) NOT NULL,
  `nama_rak` varchar(50) NOT NULL,
  `is_delete_rak` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_rak`
--

INSERT INTO `tbl_rak` (`id_rak`, `nama_rak`, `is_delete_rak`, `created_at`, `updated_at`) VALUES
('RAK001', 'A01', '0', '2024-06-06 12:50:59', '2024-11-12 12:20:15'),
('RAK002', 'A02', '0', '2024-06-24 19:06:19', '2024-06-24 19:06:19'),
('RAK003', 'A03', '0', '2024-06-24 19:06:23', '2024-10-08 05:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_temp_peminjaman`
--

CREATE TABLE `tbl_temp_peminjaman` (
  `id_anggota` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_buku` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jumlah_temp` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`,`id_rak`);

--
-- Indexes for table `tbl_detail_peminjaman`
--
ALTER TABLE `tbl_detail_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `no_peminjaman` (`id_peminjaman`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_anggota` (`id_anggota`,`id_admin`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tbl_rak`
--
ALTER TABLE `tbl_rak`
  ADD PRIMARY KEY (`id_rak`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
