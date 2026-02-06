-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 06 Feb 2026 pada 11.47
-- Versi server: 8.0.45
-- Versi PHP: 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `potensi1_umkm_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `businesses`
--

CREATE TABLE `businesses` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `whatsapp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `businesses`
--

INSERT INTO `businesses` (`id`, `user_id`, `name`, `description`, `phone`, `whatsapp`, `image`, `category`) VALUES
(10, 16, 'Modelling Bangunan', 'Membuat model 2D atau 3D untuk rumah atau bangunan anda', NULL, '083182490834', '1770102592_444.jpg', 'jasa'),
(11, 17, 'Game Station', 'Membuat usaha Game atau Warnet', NULL, '083182490834', '1770103186_834.jpeg', 'elektronik'),
(12, 18, 'Toko Buket', 'Menjual Buket Kisaran 75k sampai 200k', NULL, '083182490834', '1770103406_355.jpg', 'fashion'),
(13, 19, 'WarmIndo', 'Menjual Mie', NULL, '083182490834', '1770105240_320.jpeg', 'makanan'),
(14, 21, 'digital servis', 'jual jasa desain', NULL, '081211679167', '1770108158_381.JPG', 'jasa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `business_id` int DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `type` enum('produk','jasa') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `business_id`, `name`, `price`, `type`, `image`, `category`) VALUES
(15, 13, 'Indomie Kuah', 10000.00, 'produk', '1770107702_633.jpeg', 'makanan'),
(16, 13, 'Indomie Goreng ', 12000.00, 'produk', '1770107723_215.jpg', 'makanan'),
(17, 13, 'Mie Banglades', 15000.00, 'produk', '1770107762_178.jpg', 'makanan'),
(18, 14, 'Desain poster', 50000.00, 'jasa', '1770108201_339.JPG', 'jasa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('buyer','seller') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(16, 'Danil', 'c@gmail.com', '$2y$10$Ts.C8k3iu6SGdn7rmdo9nOkjKfKGo7pRyNHzhgl8RjE3kyLP8Uq3W', 'seller'),
(17, 'Danil', 'd@gmail.com', '$2y$10$h6AAvkZKX2p4Kx/3H/msve2aAV0rfiWUNK7Y/jyrYhaG/1IRtA.z.', 'seller'),
(18, 'Buket ', 'e@gmail.com', '$2y$10$AdW3xp9RzviDqxBWNyvw1eCGgXBARtdF/J.UMirFeGMupp/LlkGv2', 'seller'),
(19, 'WarmIndo', 'a@gmail.com', '$2y$10$XyFR/Pea8NdVCMwAwjBr.uruKVJ7oCtf8pb7NbpNx3thYdBrpSRJW', 'seller'),
(20, 'Danil', 'z@gmail.com', '$2y$10$IbQC/aFE4KuH4rgmB9YOlOSEfu.nq0VIk0HtwJnmDKbMg7Argr58S', 'buyer'),
(21, 'Muhammad', 'mohammedariqs@gmail.com', '$2y$10$iYna8JBqhGpKDOuC2uNt4eGpZfy.8c02Cl/5x7qO7lpRgbuHXDX22', 'seller'),
(22, 'arrr', 'arr@gmail.com', '$2y$10$c19wTXrpwgbCq7I.bzsMjulXQiW0811d2VaorSyTdclvtj6SLeIgS', 'seller');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `businesses` ADD FULLTEXT KEY `name` (`name`,`description`,`category`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `products` ADD FULLTEXT KEY `name` (`name`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
