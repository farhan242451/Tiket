-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Agu 2024 pada 07.33
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tiketing`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bandara`
--

CREATE TABLE `bandara` (
  `id_bandara` int(11) NOT NULL,
  `nama_bandara` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `negara` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bandara`
--

INSERT INTO `bandara` (`id_bandara`, `nama_bandara`, `kota`, `negara`) VALUES
(1, 'Bandara Soekarno-Hatta', 'Tangerang', 'Indonesia'),
(2, 'Bandara Ngurah Rai', 'Denpasar', 'Indonesia'),
(3, 'Bandara Kualanamu', 'Medan', 'Indonesia'),
(4, 'Bandara Juanda', 'Surabaya', 'Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) DEFAULT NULL,
  `metode_pembayaran` enum('Kartu Kredit','Transfer Bank','E-wallet') NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah_pembayaran` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `metode_pembayaran`, `tanggal_pembayaran`, `jumlah_pembayaran`) VALUES
(1, 1, 'Kartu Kredit', '2024-07-30', 1500000.00),
(2, 2, 'Transfer Bank', '2024-07-31', 4000000.00),
(5, 36, 'Kartu Kredit', '2024-08-01', 1500000.01),
(6, 36, 'Kartu Kredit', '2024-08-01', 1500000.00),
(7, 37, 'Transfer Bank', '2024-08-01', 1500000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_penerbangan` int(11) DEFAULT NULL,
  `id_penumpang` int(11) DEFAULT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `jumlah_penumpang` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_penerbangan`, `id_penumpang`, `tanggal_pemesanan`, `jumlah_penumpang`, `total_harga`) VALUES
(1, 1, 1, '2024-07-30', 1, 1500000.00),
(2, 2, 2, '2024-07-31', 2, 4000000.00),
(10, 1, 37, '2024-08-01', 2, 3000000.00),
(11, 1, 38, '2024-08-01', 2, 3000000.00),
(12, 1, 39, '2024-08-01', 2, 3000000.00),
(13, 1, 40, '2024-08-01', 2, 3000000.00),
(14, 1, 41, '2024-08-01', 2, 3000000.00),
(15, 1, 42, '2024-08-01', 2, 3000000.00),
(16, 1, 43, '2024-08-01', 2, 3000000.00),
(17, 1, 44, '2024-08-01', 2, 3000000.00),
(18, 1, 47, '2024-08-01', 2, 3000000.00),
(36, 1, 65, '2024-08-01', 1, 1500000.00),
(37, 1, 66, '2024-08-01', 1, 1500000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbangan`
--

CREATE TABLE `penerbangan` (
  `id_penerbangan` int(11) NOT NULL,
  `nomor_penerbangan` varchar(20) NOT NULL,
  `id_bandara_keberangkatan` int(11) DEFAULT NULL,
  `id_bandara_tujuan` int(11) DEFAULT NULL,
  `waktu_keberangkatan` date DEFAULT NULL,
  `waktu_kedatangan` date DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penerbangan`
--

INSERT INTO `penerbangan` (`id_penerbangan`, `nomor_penerbangan`, `id_bandara_keberangkatan`, `id_bandara_tujuan`, `waktu_keberangkatan`, `waktu_kedatangan`, `harga`) VALUES
(1, 'GA 123', 1, 2, '2024-08-01', '2024-08-01', 1500000.00),
(2, 'JT 456', 3, 4, '2024-08-02', '2024-08-02', 2000000.00),
(3, 'Lion 789', 2, 1, '2024-08-03', '2024-08-03', 1200000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `email`) VALUES
(1, 'farhan', '$2y$10$vKPhM26pAj62jK4CbxOK0uArL62jZ/MpuszSWlrWMQn1WKAh7NoAq', 'mf5000352@gmail.com'),
(2, 'mamat', '$2y$10$IVfo9PjZptG.PAy673gSb.V8fplS1FRARVVpxvL8FeUzyPgDgiPym', 'mf5000372@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penumpang`
--

CREATE TABLE `penumpang` (
  `id_penumpang` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penumpang`
--

INSERT INTO `penumpang` (`id_penumpang`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `nomor_telepon`, `email`) VALUES
(1, 'John Doe', '1985-05-15', 'L', '081234567890', 'john.doe@example.com'),
(2, 'Jane Smith', '1990-09-22', 'P', '082345678901', 'jane.smith@example.com'),
(37, 'farhan', '2022-06-01', 'L', '0021212', 'mf5000@gmail.com'),
(38, 'farhan', '2021-07-01', 'P', '0021212', 'mf5000@gmail.com'),
(39, 'farhan', '2022-06-01', 'L', '0021212', 'mf5000@gmail.com'),
(40, 'farhan', '2021-07-01', 'P', '0021212', 'mf5000@gmail.com'),
(41, 'farhan', '2022-06-01', 'L', '0021212', 'mf5000@gmail.com'),
(42, 'farhan', '2021-07-01', 'P', '0021212', 'mf5000@gmail.com'),
(43, 'farhan', '2022-06-01', 'L', '0021212', 'mf5000@gmail.com'),
(44, 'farhan', '2021-07-01', 'P', '0021212', 'mf5000@gmail.com'),
(47, 'farhan', '2022-06-01', 'L', '0021212', 'mf5000@gmail.com'),
(48, 'farhan', '2021-07-01', 'P', '0021212', 'mf5000@gmail.com'),
(49, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(50, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(51, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(52, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(53, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(54, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(55, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(56, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(57, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(58, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(59, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(60, 'farhan', '2022-06-30', 'P', '0021212', 'mf5000@gmail.com'),
(61, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(62, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(63, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(64, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(65, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(66, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(67, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(68, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(69, 'farhan', '2024-08-01', 'L', '0021212', 'mf5000@gmail.com'),
(70, 'farhan', '2024-08-01', 'L', '51515511', 'mf5000@gmail.com'),
(71, 'farhan', '2000-08-30', 'L', '51515511', 'mf5000@gmail.com'),
(72, 'farhan', '2000-06-01', 'L', '082124010460', 'mf5000@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bandara`
--
ALTER TABLE `bandara`
  ADD PRIMARY KEY (`id_bandara`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_penerbangan` (`id_penerbangan`),
  ADD KEY `id_penumpang` (`id_penumpang`) USING BTREE;

--
-- Indeks untuk tabel `penerbangan`
--
ALTER TABLE `penerbangan`
  ADD PRIMARY KEY (`id_penerbangan`),
  ADD KEY `id_bandara_keberangkatan` (`id_bandara_keberangkatan`),
  ADD KEY `id_bandara_tujuan` (`id_bandara_tujuan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  ADD PRIMARY KEY (`id_penumpang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bandara`
--
ALTER TABLE `bandara`
  MODIFY `id_bandara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `penerbangan`
--
ALTER TABLE `penerbangan`
  MODIFY `id_penerbangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `penumpang`
--
ALTER TABLE `penumpang`
  MODIFY `id_penumpang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_penerbangan`) REFERENCES `penerbangan` (`id_penerbangan`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_penumpang`) REFERENCES `penumpang` (`id_penumpang`);

--
-- Ketidakleluasaan untuk tabel `penerbangan`
--
ALTER TABLE `penerbangan`
  ADD CONSTRAINT `penerbangan_ibfk_1` FOREIGN KEY (`id_bandara_keberangkatan`) REFERENCES `bandara` (`id_bandara`),
  ADD CONSTRAINT `penerbangan_ibfk_2` FOREIGN KEY (`id_bandara_tujuan`) REFERENCES `bandara` (`id_bandara`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
