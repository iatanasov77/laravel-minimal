-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2018 at 01:33 PM
-- Server version: 5.7.22-0ubuntu0.17.10.1
-- PHP Version: 7.1.15-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icover_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `um_roles`
--

CREATE TABLE `um_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `um_roles`
--

INSERT INTO `um_roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'Administrator', '2018-05-08 10:02:07', '2018-05-08 10:02:07'),
(2, 'User', 'User', '2018-05-08 10:02:51', '2018-05-08 10:02:51');

-- --------------------------------------------------------

--
-- Table structure for table `um_users`
--

CREATE TABLE `um_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `um_users`
--

INSERT INTO `um_users` (`id`, `name`, `email`, `password`, `last_name`, `image`, `created_at`, `updated_at`) VALUES
(7, 'Nikola', 'nikola@abv.bg', '$2y$10$3V6GVXlq4OcAc/GrvcHP5OKO9o2Ao89IjkNd3mI/HFcE09xHDfuZi', 'Nikolov', '/um/users/a64807077129fb9098bf33f9e2798180.png', '2018-05-08 07:27:53', '2018-05-08 09:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `um_users_roles`
--

CREATE TABLE `um_users_roles` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `um_users_roles`
--

INSERT INTO `um_users_roles` (`user_id`, `role_id`) VALUES
(7, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `um_roles`
--
ALTER TABLE `um_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `um_roles_name_unique` (`name`);

--
-- Indexes for table `um_users`
--
ALTER TABLE `um_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `um_users_email_unique` (`email`);

--
-- Indexes for table `um_users_roles`
--
ALTER TABLE `um_users_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `um_users_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `um_roles`
--
ALTER TABLE `um_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `um_users`
--
ALTER TABLE `um_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `um_users_roles`
--
ALTER TABLE `um_users_roles`
  ADD CONSTRAINT `um_users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `um_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `um_users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `um_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
