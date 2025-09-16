-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2025 at 03:28 PM
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
-- Database: `music_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `promo_id` int(11) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `deposit_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled','complete') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `promo_id`, `start_time`, `end_time`, `total_price`, `deposit_price`, `status`, `created_at`, `updated_at`) VALUES
(80, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'cancelled', '2025-09-10 05:24:26', '2025-09-16 08:36:23'),
(81, 6, 12, NULL, '2025-09-11 00:27:00', '2025-09-11 01:27:00', 1800.50, 900.25, 'cancelled', '2025-09-10 17:28:27', '2025-09-16 08:36:20'),
(82, 6, 12, NULL, '2025-09-11 03:35:00', '2025-09-11 04:35:00', 2801.00, 1400.50, 'cancelled', '2025-09-10 17:35:59', '2025-09-16 08:36:12'),
(83, 6, 12, NULL, '2025-09-16 01:37:00', '2025-09-16 02:37:00', 3908.50, 1954.25, 'cancelled', '2025-09-15 18:38:14', '2025-09-16 13:08:14'),
(84, 6, 16, NULL, '2025-09-16 01:44:00', '2025-09-16 04:44:00', 6652.25, 3326.13, 'pending', '2025-09-15 18:44:45', '2025-09-16 09:53:06'),
(85, 6, 14, NULL, '2025-09-16 14:46:00', '2025-09-16 15:46:00', 532.35, 266.18, 'confirmed', '2025-09-16 07:47:37', '2025-09-16 09:53:04'),
(89, 6, 16, NULL, '2025-09-16 15:55:00', '2025-09-16 18:55:00', 2666.25, 1333.13, 'complete', '2025-09-16 08:55:45', '2025-09-16 09:52:50'),
(90, 6, 11, NULL, '2025-09-16 15:56:00', '2025-09-16 17:56:00', 4596.00, 2298.00, 'complete', '2025-09-16 08:56:16', '2025-09-16 09:51:08'),
(91, 6, 9, NULL, '2025-09-16 20:53:00', '2025-09-16 21:53:00', 3330.00, 1665.00, 'confirmed', '2025-09-16 09:54:20', '2025-09-16 12:06:09'),
(92, 6, 12, NULL, '2025-09-16 16:56:00', '2025-09-16 21:56:00', 10238.50, 5119.25, 'confirmed', '2025-09-16 09:56:24', '2025-09-16 12:06:12'),
(93, 6, 12, NULL, '2025-09-16 18:27:00', '2025-09-16 19:27:00', 0.50, 0.25, 'pending', '2025-09-16 11:30:33', '2025-09-16 11:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `booking_addons`
--

CREATE TABLE `booking_addons` (
  `booking_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_addons`
--

INSERT INTO `booking_addons` (`booking_id`, `instrument_id`, `quantity`, `price`) VALUES
(80, 2, 5, 100.00),
(80, 7, 7, 300.00),
(81, 7, 6, 300.00),
(82, 2, 7, 100.00),
(82, 7, 7, 300.00),
(83, 2, 2, 100.00),
(83, 7, 3, 300.00),
(83, 17, 1, 144.00),
(83, 18, 4, 666.00),
(84, 2, 8, 100.00),
(84, 7, 6, 300.00),
(84, 17, 5, 144.00),
(84, 18, 5, 666.00),
(85, 2, 1, 100.00),
(85, 17, 3, 144.00),
(89, 18, 4, 666.00),
(90, 2, 3, 100.00),
(90, 7, 4, 300.00),
(90, 17, 3, 144.00),
(90, 18, 4, 666.00),
(91, 18, 5, 666.00),
(92, 2, 6, 100.00),
(92, 7, 11, 300.00),
(92, 17, 7, 144.00),
(92, 18, 8, 666.00);

-- --------------------------------------------------------

--
-- Table structure for table `instruments`
--

CREATE TABLE `instruments` (
  `instrument_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable','maintenance') DEFAULT 'available',
  `price_per_unit` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instruments`
--

INSERT INTO `instruments` (`instrument_id`, `category_id`, `code`, `name`, `brand`, `picture_url`, `status`, `price_per_unit`) VALUES
(2, 5, '22222', 'Dodge', 'D33', 'instruments/YNkHVTdaAdapPH6wiNWb3TTZEwDifzvZvMbU5HRD.jpg', 'available', 100.00),
(4, 6, '22233', 'Johnson - KutchUpdate', 'JW1122', 'instruments/0dYbMvBfFkfXSp510Lb7A7xl2vELzKPqrVa0dMKJ.png', 'unavailable', 200.00),
(7, 7, '12445', 'Johnson - Kutchhh', 'JW1122', 'instruments/sZvk9NdrIsnU1ERS4x5sAAjlC7M9NzPNYezZQd2a.jpg', 'available', 300.00),
(17, 21, '43434', '100% Discount', '13131ss', 'instruments/2jwJzLDBpjC8lIEfZhjN4gCY9NfIb0Js8MkBC7KK.jpg', 'available', 144.00),
(18, 21, '141414243', 'Wisozk Group', '13131', 'instruments/t2unMWcVgsPLkubiR0VhaSSa7Mcu7vcppvaGSIDM.jpg', 'available', 666.00);

-- --------------------------------------------------------

--
-- Table structure for table `instrument_categories`
--

CREATE TABLE `instrument_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instrument_categories`
--

INSERT INTO `instrument_categories` (`category_id`, `name`) VALUES
(2, 'กีตาร์'),
(3, 'คีย์บอร์ด'),
(4, 'ไวโอลิน'),
(5, 'YippyCat'),
(6, 'Jewery'),
(7, 'CattyEIEI'),
(21, 'Holiday Discount');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `reset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`reset_id`, `user_id`, `reset_token`, `expires_at`, `used`, `created_at`) VALUES
(1, 1, 'sWx3Vbhm8M7IWZ4BGbDbBXSrlmqlbXZZSJxTr2Z6B8P727ngs8heI38SyE1t9uuT', '2025-08-28 16:54:34', 0, '2025-08-28 08:54:34'),
(2, 1, '4yqXk02ctgffWh3HnjD0rvus0HVwJ4GA7qLPcUcLBJ9as2rV3zVlc79Fs33Sgv6j', '2025-08-28 16:57:03', 1, '2025-08-28 08:57:03'),
(3, 1, 'Hkhu3O0hKCmy4U7nfbjgjPhxSnttIuGz5YNyqljrlezSk2SkZvXQbye5RJxOume2', '2025-08-28 17:01:20', 1, '2025-08-28 09:01:20'),
(4, 6, 'yzKJoNMk6pXuzmwNChO0Nn0jscTyCGecdkFV02MVHHH0Vn8KD865cVAM9ptcZY4F', '2025-09-09 14:36:18', 1, '2025-09-09 06:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('qr_code','manual') DEFAULT 'qr_code',
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `paid_at`, `created_at`) VALUES
(13, 80, 3689.00, 'qr_code', 'paid', 'TXN1757481866', '2025-09-10 12:24:26', '2025-09-10 05:24:26'),
(14, 81, 900.25, 'qr_code', 'paid', 'TXN1757525307', '2025-09-11 00:28:27', '2025-09-10 17:28:27'),
(15, 82, 1400.50, 'qr_code', 'paid', 'TXN1757525759', '2025-09-11 00:35:59', '2025-09-10 17:35:59'),
(16, 83, 1954.25, 'qr_code', 'paid', 'TXN1757961494', '2025-09-16 01:38:14', '2025-09-15 18:38:14'),
(17, 84, 3326.13, 'qr_code', 'paid', 'TXN1757961885', '2025-09-16 01:44:45', '2025-09-15 18:44:45'),
(18, 85, 266.18, 'qr_code', 'paid', 'TXN1758008857', '2025-09-16 14:47:37', '2025-09-16 07:47:37'),
(22, 89, 1333.13, 'qr_code', 'paid', 'TXN1758012945', '2025-09-16 15:55:45', '2025-09-16 08:55:45'),
(23, 90, 2298.00, 'qr_code', 'paid', 'TXN1758012976', '2025-09-16 15:56:16', '2025-09-16 08:56:16'),
(24, 91, 1665.00, 'qr_code', 'paid', 'TXN1758016460', '2025-09-16 16:54:20', '2025-09-16 09:54:20'),
(25, 92, 5119.25, 'qr_code', 'paid', 'TXN1758016584', '2025-09-16 16:56:24', '2025-09-16 09:56:24'),
(26, 93, 0.25, 'qr_code', 'paid', 'TXN1758022233', '2025-09-16 18:30:33', '2025-09-16 11:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promo_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promo_id`, `name`, `description`, `discount_type`, `discount_value`, `start_date`, `end_date`, `is_active`) VALUES
(3, 'Holiday Discount Scoopy', 'test', 'percent', 99.99, '2025-09-10', '2025-09-17', 0),
(4, 'test222', 'test222', 'fixed', 222.00, '2025-09-02', '2025-09-18', 0),
(8, 'YippyVoucherrr', 'Ehereeee', 'percent', 40.00, '2025-09-11', '2025-09-14', 0),
(9, 'Discount 10% off\'s', 'Discount rooms price for this events, for sure', 'percent', 10.00, '2025-09-16', '2025-09-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `full_amount` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `booking_id`, `receipt_number`, `full_amount`, `deposit_amount`, `discount_amount`, `created_at`) VALUES
(13, 80, '00080', 7378.00, 3689.00, 0.00, '2025-09-10 05:24:26'),
(14, 81, '00081', 1800.50, 900.25, 0.00, '2025-09-10 17:28:27'),
(15, 82, '00082', 2801.00, 1400.50, 0.00, '2025-09-10 17:35:59'),
(16, 83, '00083', 3908.50, 1954.25, 0.00, '2025-09-15 18:38:14'),
(17, 84, '00084', 6652.25, 3326.13, 0.00, '2025-09-15 18:44:45'),
(18, 85, '00085', 532.35, 266.18, 0.00, '2025-09-16 07:47:37'),
(22, 89, '00089', 2666.25, 1333.13, 0.00, '2025-09-16 08:55:45'),
(23, 90, '00090', 4596.00, 2298.00, 0.00, '2025-09-16 08:56:16'),
(24, 91, '00091', 3330.00, 1665.00, 0.00, '2025-09-16 09:54:20'),
(25, 92, '00092', 10238.50, 5119.25, 0.00, '2025-09-16 09:56:24'),
(26, 93, '00093', 0.50, 0.25, 0.00, '2025-09-16 11:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price_per_hour` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `name`, `price_per_hour`, `capacity`, `description`, `image_url`, `created_at`) VALUES
(9, 'A13', 5.00, 5, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/Se5ry9aSnIdy64WESJb6RhcF910UtwiXcFSKwbpp.png', '2025-09-04 06:12:23'),
(11, 'A12', 12.00, 12121, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/vIJc6z9i18dt2RaCXrKvpZ9SqTSX8h1Ymc6RbW5L.jpg', '2025-09-05 16:50:34'),
(12, 'Studio A - Premium', 5000.00, 6, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/8hC814xXQG6KUfeoC58hCyoh8S9zx0tERPkV9Zgk.jpg', '2025-09-08 18:18:09'),
(14, 'Luxury XXL', 3500.00, 10, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/UWxG0x75nG0h0O1nUp8SjTSOXm7QpmXGa9umufJH.png', '2025-09-10 18:38:05'),
(16, 'GoldPremium', 7500.00, 12, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/SEleDmCd0VPgs5T0DFSpJZwSvDPxDkwJqrSTUmMR.jpg', '2025-09-11 06:18:26'),
(18, 'Room Pillar Premium XL', 15000.00, 300, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/fBCoNyzm32gXEHPQTCXQpAfpSgeXV31kl6YsX4hi.png', '2025-09-16 13:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `room_instruments`
--

CREATE TABLE `room_instruments` (
  `room_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_instruments`
--

INSERT INTO `room_instruments` (`room_id`, `instrument_id`, `quantity`) VALUES
(9, 2, 3),
(9, 4, 1111),
(9, 7, 6),
(9, 17, 1),
(9, 18, 8),
(11, 17, 1),
(11, 18, 8),
(12, 17, 1),
(14, 2, 3),
(14, 4, 5),
(14, 7, 3),
(14, 17, 1),
(18, 7, 3),
(18, 17, 5),
(18, 18, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `email`, `password_hash`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'ssdUpdated', 'RazorUpdated', 'ssd', 'ssd@gmail.com', '$2y$12$CC0qPkH/dXQyMJZXsy7.j.geXF/.eyZOSW.Mhi2xMiGLt6JufNS2K', '0000000000', 'user', '2025-08-28 08:15:50', '2025-08-30 18:42:45'),
(2, 'AdminUpdated', 'AdminnaUpdated', 'admin', 'admin@gmail.com', '$2y$12$qWLk1jgW9AmYTDegQLnTx.gF4LrmSp/J3LalWgd4oS.vqJuR061Qe', '0123456789', 'admin', '2025-08-28 09:22:19', '2025-08-30 18:43:28'),
(3, 'test2Logg', 'test2Logg', 'test2', 'test2@gmail.com', '$2y$12$u0Tc4T6MzHLfLJamNqcepu84ex2PImFPr/vzxujZ9t9yqIwD/kMoK', '0234445551', 'admin', '2025-08-28 09:23:38', '2025-09-10 17:58:33'),
(4, 'Testingnew', 'Testingnew', 'Testing123new', 'Testing123@gmail.com', '$2y$12$LLP1NEDU3aScsyyiTiQEo.nkhxvXTY5ZqULn9upgdtkTdQSLaOp5e', '0111111111', 'user', '2025-09-05 16:58:24', '2025-09-11 06:31:35'),
(5, 'Testingg', 'Testingg', 'Testing333444', 'Testing333@gmail.com', '$2y$12$dUd9BlUtBaJYiV9Yog2VAuVPJs209CxHz.w4NmerNM/jA4ZjukK86', '0123456789', 'user', '2025-09-05 16:59:11', '2025-09-10 18:06:18'),
(6, 'News', 'Looks', 'Newlookauth3', 'Newlookauth3@gmail.com', '$2y$12$UUwnROXyy9ydejCsTnc7pecOf6nzDsCD16/lrT3LfLOBmvYTkayQ6', '0812345678', 'user', '2025-09-09 06:35:11', '2025-09-10 17:40:33'),
(7, 'Tester1', 'Tester1', 'TesterLast', 'Tester@gmail.com', '$2y$12$xU4VdVkGBCEn04/f24ndcu2lVVWoNmf5wQIsAds/N4/dgIgo3rr7a', '033333333', 'admin', '2025-09-16 12:45:30', '2025-09-16 13:19:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `booking_addons`
--
ALTER TABLE `booking_addons`
  ADD PRIMARY KEY (`booking_id`,`instrument_id`),
  ADD KEY `instrument_id` (`instrument_id`);

--
-- Indexes for table `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`instrument_id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `instrument_categories`
--
ALTER TABLE `instrument_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`reset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_instruments`
--
ALTER TABLE `room_instruments`
  ADD PRIMARY KEY (`room_id`,`instrument_id`),
  ADD KEY `instrument_id` (`instrument_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instrument_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `instrument_categories`
--
ALTER TABLE `instrument_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`promo_id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_addons`
--
ALTER TABLE `booking_addons`
  ADD CONSTRAINT `booking_addons_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_addons_ibfk_2` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`instrument_id`) ON DELETE CASCADE;

--
-- Constraints for table `instruments`
--
ALTER TABLE `instruments`
  ADD CONSTRAINT `instruments_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `instrument_categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `room_instruments`
--
ALTER TABLE `room_instruments`
  ADD CONSTRAINT `room_instruments_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_instruments_ibfk_2` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`instrument_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
