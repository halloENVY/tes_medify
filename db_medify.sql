-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 10:30 AM
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
-- Database: `db_medify`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `kode`, `nama`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '00001', 'Obat', '2025-08-07 23:49:55', '2025-08-08 00:26:01', '2025-08-08 00:26:01'),
(2, '00002', 'ATK', '2025-08-07 23:51:05', '2025-08-07 23:51:05', NULL),
(3, '00003', 'Matkes', '2025-08-07 23:51:26', '2025-08-07 23:51:26', NULL),
(4, '00004', 'Umum', '2025-08-07 23:51:38', '2025-08-07 23:52:35', NULL),
(5, '00005', 'Alkes', '2025-08-07 23:51:58', '2025-08-07 23:51:58', NULL),
(11, '00006', 'Obat', '2025-08-08 00:33:16', '2025-08-08 00:33:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_master_item`
--

CREATE TABLE `kategori_master_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `master_item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_master_item`
--

INSERT INTO `kategori_master_item` (`id`, `kategori_id`, `master_item_id`, `created_at`, `updated_at`) VALUES
(1, 5, 9, NULL, NULL),
(5, 11, 10, NULL, NULL),
(6, 11, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_items`
--

CREATE TABLE `master_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `laba` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_items`
--

INSERT INTO `master_items` (`id`, `kode`, `nama`, `harga_beli`, `laba`, `supplier`, `jenis`, `foto`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '00001', 'Jarum Suntik', 2000, 10, 'Tokopaedi', 'Alkes', 'master_items/VP0aoOyDR8E0gxS6696knVNuFtvGfYtnzQ9WbuO8.jpg', '2025-08-07 23:12:22', '2025-08-07 23:36:11', NULL),
(2, '00002', 'APD', 3000, 10, 'TokoBagas', 'Alkes', 'master_items/tmrFSBAKyAXD1GhKaRt5PWioauhlQ2xHp1z6mNJY.jpg', '2025-08-07 23:12:52', '2025-08-07 23:33:33', NULL),
(3, '00003', 'Gunting', 2000, 12, 'E Commurz', 'Alkes', NULL, '2025-08-07 23:13:22', '2025-08-08 00:39:52', '2025-08-08 00:39:52'),
(4, '00004', 'Paracetamol', 2000, 12, 'Tokopaedi', 'Obat', 'master_items/OeHI1SNtJuUO3IYshAQe5WLy26tpQufNc7WcGNWd.jpg', '2025-08-07 23:14:14', '2025-08-08 00:15:03', NULL),
(5, '00005', 'Alcohol', 2000, 10, 'Tokopaedi', 'Obat', 'master_items/mxz6ba7S76ibbaRZx4p5MruSoDL14m7o3Tsk4RLn.jpg', '2025-08-07 23:14:42', '2025-08-07 23:30:49', NULL),
(6, '00006', 'Konidin', 2000, 10, 'Tokopaedi', 'Obat', 'master_items/UZpWW1LlUhvA1gChrWu7WnYPBQhztOFuanyQysEd.jpg', '2025-08-07 23:19:11', '2025-08-08 00:14:47', NULL),
(7, '00007', 'Mixagrip', 1000, 10, 'TokoBagas', 'Obat', 'master_items/n1CoK2FVjAyKstAZvijEjl4py4TQWSJyBg79w4EB.jpg', '2025-08-07 23:21:09', '2025-08-08 00:10:13', NULL),
(8, '00008', 'Combi', 1000, 10, 'Tokopaedi', 'Obat', 'master_items/xjFJtdS7ni9Q8uT1h3LimRODuk1PdKtivF8dPDsf.jpg', '2025-08-07 23:29:05', '2025-08-07 23:29:05', NULL),
(9, '00009', 'APD 2', 5000, 10, 'Bukulapuk', 'Alkes', 'master_items/f9bWR7HwkgOK9R2CZzkdiisiFDaONZudG8VIA0n6.jpg', '2025-08-08 00:00:56', '2025-08-08 00:12:11', NULL),
(10, '00010', 'Paracetamol', 6000, 10, 'TokoBagas', 'Obat', 'master_items/8hHUnJkjyaMljcqBRjtad2XAilNT5EwZxNjHmtZz.jpg', '2025-08-08 00:33:59', '2025-08-08 00:33:59', NULL),
(11, '00010', 'Paracetamol 3', 4000, 10, 'E Commurz', 'Obat', 'master_items/MDi1YoQkzH9zWdMZLMLwrQcDlbldRoMK2rbfXABQ.jpg', '2025-08-08 00:40:55', '2025-08-08 00:40:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_11_05_005605_create_master_items_table', 1),
(6, '2025_08_08_061331_add_foto_to_master_items_table', 2),
(7, '2025_08_08_063630_create_kategoris_table', 3),
(8, '2025_08_08_063655_create_kategori_master_item_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nopal@gmail.com', '$2y$10$Lc8PiTvPf6sNI63huDX0BOFOgmplElhmuncjcXkKpMe4PiDcBJjVC', '2025-08-07 10:48:46'),
('yunusdwibachtiar01@gmail.com', '$2y$10$g.YNMnGMWfQNJ2XbGzbW8Oq/jChWJ3mc3jHpKM1wheySDt3XNn0fu', '2025-08-07 12:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nopal', 'nopal@gmail.com', NULL, '$2y$10$D9QvhHsheKoY/CBYyUN6u.xbJTOLJzLjrUuhwQ.w.C126ZbemJh0a', NULL, '2025-08-07 10:15:32', '2025-08-07 10:15:32'),
(2, 'Yunus', 'yunusdwibachtiar01@gmail.com', NULL, '$2y$10$iaQclBuLYln2B9z/rxO5Luj2p8DPorGfBLpQV6tJOLfXumJKFDneu', NULL, '2025-08-07 10:29:03', '2025-08-07 10:29:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_kode_unique` (`kode`);

--
-- Indexes for table `kategori_master_item`
--
ALTER TABLE `kategori_master_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_master_item_kategori_id_master_item_id_unique` (`kategori_id`,`master_item_id`),
  ADD KEY `kategori_master_item_master_item_id_foreign` (`master_item_id`);

--
-- Indexes for table `master_items`
--
ALTER TABLE `master_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kategori_master_item`
--
ALTER TABLE `kategori_master_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_items`
--
ALTER TABLE `master_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategori_master_item`
--
ALTER TABLE `kategori_master_item`
  ADD CONSTRAINT `kategori_master_item_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kategori_master_item_master_item_id_foreign` FOREIGN KEY (`master_item_id`) REFERENCES `master_items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
