-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jan 2023 pada 11.00
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absen`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `jam_masuk` varchar(255) DEFAULT NULL,
  `jam_keluar` varchar(255) DEFAULT NULL,
  `req_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `tgl`, `jam_masuk`, `jam_keluar`, `req_id`) VALUES
(16, 3, '2023-01-19', '21:24:46', '21:24:47', NULL),
(17, 3, '2023-01-18', '21:48:19', '22:58:45', NULL),
(18, 4, '2023-01-18', '23:14:31', NULL, NULL),
(19, 4, '2023-01-21', '17:28:10', '17:28:55', NULL),
(20, 4, '2023-01-13', '--:--:--', '--:--:--', 1),
(21, 5, '2023-01-21', '18:51:33', '18:51:35', NULL),
(23, 5, '2023-01-22', '--:--:--', '--:--:--', 3),
(24, 4, '2023-01-27', '--:--:--', '--:--:--', 4),
(25, 3, '2023-01-21', '20:57:32', '20:57:52', NULL),
(26, 4, '2023-01-22', '17:43:15', '17:43:17', NULL),
(27, 6, '2023-01-22', '17:55:38', '18:09:27', 5),
(28, 6, '2023-01-23', '18:22:07', '18:22:09', 6),
(29, 3, '2023-01-23', '20:11:30', '05:41:46', NULL),
(30, 4, '2023-01-23', '21:52:52', '21:52:56', NULL),
(31, 1, '2023-01-24', '16:59:58', '17:00:02', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `req_id` int(11) NOT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `request`
--

INSERT INTO `request` (`id`, `req_id`, `jenis`, `keterangan`, `status`) VALUES
(2, 1, 'Cuti Tahunan', 'sakt', 'Accept'),
(4, 3, 'Cuti Tahunan', 'Saudara Menikah', 'Accept'),
(5, 4, 'Cuti Tahunan', 'Tak Tahu', 'Reject'),
(6, 5, 'Cuti Tahunan', 'testets', 'Reject'),
(7, 6, 'Cuti Tahunan', 'tetetet', 'Reject');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `masuk_kerja` date DEFAULT NULL,
  `keluar_kerja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `user_id`, `password`, `nama_lengkap`, `role`, `masuk_kerja`, `keluar_kerja`) VALUES
(23, 3, '1', '65456', '1231', '2023-01-17', NULL),
(24, 4, '1', '1', 'admin', '2022-12-01', NULL),
(25, 5, '1', 'ARI MAGHFIRON', 'AREA MANAGER', '2023-01-23', NULL),
(26, 6, '1', 'Ryu', 'Supervisor', '2023-01-01', NULL),
(27, 1, '1', 'Ryu Kojiro', 'admin', '2023-01-18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `req_id` (`req_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `req_id` (`req_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`req_id`) REFERENCES `request` (`req_id`),
  ADD CONSTRAINT `absensi_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
