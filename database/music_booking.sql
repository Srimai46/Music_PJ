-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2025 at 08:34 AM
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

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `user_id`, `role`, `action_type`, `details`, `created_at`) VALUES
(1, 6, 'user', 'confirm_payment', 'Booking #00069 confirmed via QR Code', '2025-09-09 19:06:48'),
(2, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #66 คืนเงิน 50%', '2025-09-09 19:18:50'),
(3, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #68 คืนเงิน 50%', '2025-09-09 19:25:28'),
(4, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #67 คืนเงิน 50%', '2025-09-09 19:25:30'),
(5, 6, 'user', 'confirm_payment', 'Booking #00070 confirmed via QR Code', '2025-09-09 19:28:19'),
(6, 6, 'user', 'confirm_payment', 'Booking #00071 confirmed via QR Code', '2025-09-09 19:31:45'),
(7, 6, 'user', 'confirm_payment', 'Booking #00072 confirmed via QR Code', '2025-09-10 03:34:26'),
(8, 6, 'user', 'confirm_payment', 'Booking #00073 confirmed via QR Code', '2025-09-10 04:26:11'),
(9, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #70 คืนเงิน 50%', '2025-09-10 04:28:22'),
(10, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #71 คืนเงิน 50%', '2025-09-10 04:28:23'),
(11, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #72 คืนเงิน 50%', '2025-09-10 04:28:25'),
(12, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #69 คืนเงิน 50%', '2025-09-10 04:28:27'),
(13, 6, 'user', 'confirm_payment', 'Booking #00074 confirmed via QR Code', '2025-09-10 04:40:10'),
(14, 6, 'user', 'confirm_payment', 'Booking #00075 confirmed via QR Code', '2025-09-10 04:43:04'),
(15, 6, 'user', 'confirm_payment', 'Booking #00076 confirmed via QR Code', '2025-09-10 05:12:22'),
(16, 6, 'user', 'confirm_payment', 'Booking #00077 confirmed via QR Code', '2025-09-10 05:14:53'),
(17, 6, 'user', 'confirm_payment', 'Booking #00078 confirmed via QR Code', '2025-09-10 05:19:50'),
(18, 6, 'user', 'confirm_payment', 'Booking #00079 confirmed via QR Code', '2025-09-10 05:21:04'),
(19, 6, 'user', 'confirm_payment', 'Booking #00080 confirmed via QR Code', '2025-09-10 05:24:26'),
(20, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #79 คืนเงิน 50%', '2025-09-10 05:32:46'),
(21, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #78 คืนเงิน 50%', '2025-09-10 05:32:55'),
(22, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #76 คืนเงิน 50%', '2025-09-10 05:32:59'),
(23, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #73 คืนเงิน 50%', '2025-09-10 05:33:08'),
(24, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #75 คืนเงิน 50%', '2025-09-10 05:33:10'),
(25, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #74 คืนเงิน 50%', '2025-09-10 05:33:11'),
(26, 6, 'user', 'delete_booking', 'ลบการจอง #73 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:00'),
(27, 6, 'user', 'delete_booking', 'ลบการจอง #75 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:08'),
(28, 6, 'user', 'delete_booking', 'ลบการจอง #72 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:10'),
(29, 6, 'user', 'delete_booking', 'ลบการจอง #74 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:12'),
(30, 6, 'user', 'delete_booking', 'ลบการจอง #76 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:28'),
(31, 6, 'user', 'delete_booking', 'ลบการจอง #79 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:31'),
(32, 6, 'user', 'delete_booking', 'ลบการจอง #78 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:33'),
(33, 6, 'user', 'delete_booking', 'ลบการจอง #71 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:35'),
(34, 6, 'user', 'delete_booking', 'ลบการจอง #70 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:36'),
(35, 6, 'user', 'delete_booking', 'ลบการจอง #67 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:38'),
(36, 6, 'user', 'delete_booking', 'ลบการจอง #68 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:39'),
(37, 6, 'user', 'delete_booking', 'ลบการจอง #66 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:40'),
(38, 6, 'user', 'delete_booking', 'ลบการจอง #69 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:43:42'),
(39, 6, 'user', 'cancel_booking', 'ยกเลิกการจอง #77 คืนเงิน 50%', '2025-09-10 11:43:59'),
(40, 6, 'user', 'delete_booking', 'ลบการจอง #77 และข้อมูลที่เกี่ยวข้องทั้งหมด', '2025-09-10 11:44:04'),
(41, 6, 'user', 'confirm_payment', 'Booking #00081 confirmed via QR Code', '2025-09-10 17:28:27'),
(42, 6, 'user', 'confirm_payment', 'Booking #00082 confirmed via QR Code', '2025-09-10 17:35:59'),
(43, 6, 'user', 'update_profile', 'User updated profile information', '2025-09-10 17:40:33'),
(44, 3, 'admin', 'update_profile', 'แก้ไขโปรไฟล์จาก [ชื่อ: test2Logg test2Logg, เบอร์: 0234445551] เป็น [ชื่อ: test2Logg test2Logg, เบอร์: 0234445551]', '2025-09-10 18:00:08'),
(45, 3, 'admin', 'update_profile', 'แก้ไขโปรไฟล์จาก [ชื่อ: test2Logg test2Logg, เบอร์: 0234445551] เป็น [ชื่อ: test2Logg test2Logg, เบอร์: 0234445551]', '2025-09-10 18:04:17'),
(46, 3, 'admin', 'update_profile', 'แก้ไขโปรไฟล์จาก [ชื่อ: test2Logg test2Logg, เบอร์: 0234445551] เป็น [ชื่อ: test2Logg test2Logg, เบอร์: 0234445551]', '2025-09-10 18:04:27'),
(47, 3, 'admin', 'reset_password', 'รีเซ็ตรหัสผ่านผู้ใช้ [ID: 5, Username: Testing333] เป็นค่าเริ่มต้นใหม่', '2025-09-10 18:05:29'),
(48, 3, 'admin', 'update_user', 'แก้ไขผู้ใช้ [ID: 5] จาก [ชื่อ: Testingg Testingg, Username: Testing333, Email: Testing333@gmail.com, เบอร์: 0123456789, Role: user] → [ชื่อ: Testingg Testingg, Username: Testing333444, Email: Testing333@gmail.com, เบอร์: 0123456789, Role: user]', '2025-09-10 18:06:11'),
(49, 3, 'admin', 'reset_password', 'รีเซ็ตรหัสผ่านผู้ใช้ [ID: 5, Username: Testing333444] เป็นค่าเริ่มต้นใหม่', '2025-09-10 18:06:18'),
(50, 3, 'admin', 'delete_room', 'ลบห้อง [ID: 13, ชื่อ: Luxury XL]', '2025-09-10 18:37:38'),
(51, 3, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-10 18:38:05'),
(52, 3, 'admin', 'update_room', 'แก้ไขห้อง [ID: 14] จาก [ชื่อ: Luxury XXL, ราคา/ชม.: 3500.00, ความจุ: 10] → [ชื่อ: Luxury XXL, ราคา/ชม.: 3500.00, ความจุ: 10]', '2025-09-10 18:39:38'),
(53, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Dodge] จำนวน 3 ในห้อง [ID: 14, ชื่อ: Luxury XXL]', '2025-09-10 18:40:29'),
(54, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Johnson - KutchUpdate] จำนวน 3 ในห้อง [ID: 14, ชื่อ: Luxury XXL]', '2025-09-10 18:40:42'),
(55, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Johnson - Kutchhh] จำนวน 3 ในห้อง [ID: 14, ชื่อ: Luxury XXL]', '2025-09-10 18:40:45'),
(56, 3, 'admin', 'update_instrument_quantity', 'แก้ไขจำนวนเครื่องดนตรี [Johnson - KutchUpdate] ในห้อง [Luxury XXL] จาก 3 → 5', '2025-09-10 18:44:28'),
(57, 3, 'admin', 'remove_instrument_from_room', 'ลบเครื่องดนตรี [Johnson - KutchUpdate] ออกจากห้อง [Luxury XXL]', '2025-09-10 18:44:44'),
(58, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Johnson - KutchUpdate] จำนวน 5 ในห้อง [ID: 14, ชื่อ: Luxury XXL]', '2025-09-10 18:45:01'),
(59, 3, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-10 18:45:15'),
(60, 3, 'admin', 'update_room', 'แก้ไขห้อง [ID: 15] จาก [ชื่อ: dawdw, ราคา/ชม.: 23.00, ความจุ: 23] → [ชื่อ: dawdw, ราคา/ชม.: 23.00, ความจุ: 23]', '2025-09-10 18:45:28'),
(61, 3, 'admin', 'delete_room', 'ลบห้อง [ID: 15, ชื่อ: dawdw]', '2025-09-10 18:45:38'),
(62, 3, 'admin', 'create_promotion', 'สร้างโปรโมชั่น [Test] (ประเภท: percent, ส่วนลด: 60)', '2025-09-10 18:52:59'),
(63, 3, 'admin', 'update_promotion', 'แก้ไขโปรโมชั่น [Test] → [Testtttt], \n                        ส่วนลด: 60.00 → 60.00, \n                        สถานะ: Active → Inactive', '2025-09-10 18:53:34'),
(64, 3, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [Testtttt] เป็น Active', '2025-09-10 18:53:46'),
(65, 3, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [Testtttt] เป็น Inactive', '2025-09-10 18:53:48'),
(66, 3, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [Testtttt] เป็น Active', '2025-09-10 18:53:50'),
(67, 3, 'admin', 'delete_promotion', 'ลบโปรโมชั่น [Testtttt]', '2025-09-10 18:53:58'),
(68, 3, 'admin', 'create_promotion', 'สร้างโปรโมชั่น [Ts] (ประเภท: percent, ส่วนลด: 12)', '2025-09-10 18:59:33'),
(69, 3, 'admin', 'delete_promotion', 'ลบโปรโมชั่น [Ts]', '2025-09-10 18:59:44'),
(70, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [Wisozk Group]', '2025-09-10 19:09:17'),
(71, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [asdasdad] รหัส: 13124', '2025-09-10 19:09:43'),
(72, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Holiday Discount] รหัส: 142535', '2025-09-10 19:10:05'),
(73, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Wisozk Group] รหัส: 2222211', '2025-09-10 19:10:18'),
(74, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A13] ให้เครื่องดนตรี [Wisozk Group] จำนวน 1', '2025-09-10 19:11:05'),
(75, 3, 'admin', 'update_instrument_room', 'อัปเดตจำนวนเครื่องดนตรี [Wisozk Group] ในห้อง [A13] จาก 1 → 5', '2025-09-10 19:11:29'),
(76, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Wisozk Group] → [Wisozk Grouppp]', '2025-09-10 19:14:12'),
(77, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Wisozk Grouppp] → [Wisozk Grouppp]', '2025-09-10 19:14:33'),
(78, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Holiday Discount] → [Holiday Discount]', '2025-09-10 19:15:14'),
(79, 3, 'admin', 'delete_instrument', 'ลบเครื่องดนตรี [asdasdad] รหัส: 13124', '2025-09-10 19:15:31'),
(80, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [Wisozk Group] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-10 19:15:42'),
(81, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [Wisozk Group]', '2025-09-10 19:16:14'),
(82, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Holiday Discount] รหัส: 353534', '2025-09-11 05:11:06'),
(83, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Holiday Discount] → [Holiday Discount]', '2025-09-11 05:16:57'),
(84, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Holiday Discount] → [Holiday Discount]', '2025-09-11 05:17:11'),
(85, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Holiday Discount] → [Holiday Discount]', '2025-09-11 05:17:33'),
(86, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Holiday Discount] → [Holiday Discount]', '2025-09-11 05:17:38'),
(87, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [Holiday Discount] → [Holiday Discount]', '2025-09-11 05:18:27'),
(88, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [131] รหัส: 131313', '2025-09-11 05:18:51'),
(89, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A13] ให้เครื่องดนตรี [Holiday Discount] จำนวน 1', '2025-09-11 05:19:09'),
(90, 3, 'admin', 'delete_instrument', 'ลบเครื่องดนตรี [131] รหัส: 131313', '2025-09-11 05:19:22'),
(91, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [Wisozk Group] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:19:57'),
(92, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [113131] รหัส: 1414s', '2025-09-11 05:26:29'),
(93, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [113131] → [113131]', '2025-09-11 05:26:43'),
(94, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [113131] → [113131]', '2025-09-11 05:26:49'),
(95, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [113131] → [113131]', '2025-09-11 05:26:54'),
(96, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [sadssd] รหัส: 11313', '2025-09-11 05:28:30'),
(97, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [113131] → [113131ss]', '2025-09-11 05:28:40'),
(98, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [113131ss] → [113131ss]', '2025-09-11 05:28:55'),
(99, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [Luxury XXL] ให้เครื่องดนตรี [113131ss] จำนวน 555', '2025-09-11 05:29:06'),
(100, 3, 'admin', 'update_instrument_room', 'อัปเดตจำนวนเครื่องดนตรี [113131ss] ในห้อง [Luxury XXL] จาก 555 → 558', '2025-09-11 05:29:11'),
(101, 3, 'admin', 'update_instrument_room', 'อัปเดตจำนวนเครื่องดนตรี [113131ss] ในห้อง [Luxury XXL] จาก 558 → 562', '2025-09-11 05:29:14'),
(102, 3, 'admin', 'detach_room_from_instrument', 'ลบห้อง [Luxury XXL] ออกจากเครื่องดนตรี [113131ss]', '2025-09-11 05:29:26'),
(103, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A13] ให้เครื่องดนตรี [113131ss] จำนวน 1', '2025-09-11 05:29:37'),
(104, 3, 'admin', 'update_instrument_room', 'อัปเดตจำนวนเครื่องดนตรี [113131ss] ในห้อง [A13] จาก 1 → 10', '2025-09-11 05:29:53'),
(105, 3, 'admin', 'delete_instrument', 'ลบเครื่องดนตรี [113131ss] รหัส: 1414s', '2025-09-11 05:30:09'),
(106, 3, 'admin', 'delete_instrument', 'ลบเครื่องดนตรี [sadssd] รหัส: 11313', '2025-09-11 05:30:27'),
(107, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [กลอง]', '2025-09-11 05:33:35'),
(108, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [Holiday Discount]', '2025-09-11 05:34:07'),
(109, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [Holiday Discount] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:38:55'),
(110, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [Holiday Discount]', '2025-09-11 05:39:43'),
(111, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [A11]', '2025-09-11 05:41:37'),
(112, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [Holiday Discount] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:41:43'),
(113, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [A11] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:41:43'),
(114, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [Holiday Discount]', '2025-09-11 05:45:29'),
(115, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [AdminTest3]', '2025-09-11 05:45:34'),
(116, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [Holiday Discount] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:45:44'),
(117, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [AdminTest3] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:45:44'),
(118, 3, 'admin', 'create_instrument_category', 'เพิ่มประเภทเครื่องดนตรี [Holiday Discount]', '2025-09-11 05:45:56'),
(119, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [100% Discount] รหัส: 43434', '2025-09-11 05:46:17'),
(120, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Wisozk Group] รหัส: 141414243', '2025-09-11 05:46:29'),
(121, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [100% Discount] → [100% Discount]', '2025-09-11 05:46:42'),
(122, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [100% Discount] → [100% Discount]', '2025-09-11 05:46:53'),
(123, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [Luxury XXL] ให้เครื่องดนตรี [100% Discount] จำนวน 1', '2025-09-11 05:47:02'),
(124, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [Studio A - Premium] ให้เครื่องดนตรี [100% Discount] จำนวน 1', '2025-09-11 05:47:06'),
(125, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A12] ให้เครื่องดนตรี [100% Discount] จำนวน 1', '2025-09-11 05:47:09'),
(126, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A13] ให้เครื่องดนตรี [100% Discount] จำนวน 1', '2025-09-11 05:47:13'),
(127, 3, 'admin', 'update_instrument', 'แก้ไขเครื่องดนตรี [100% Discount] → [100% Discount]', '2025-09-11 05:47:20'),
(128, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A13] ให้เครื่องดนตรี [Wisozk Group] จำนวน 1', '2025-09-11 05:47:46'),
(129, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A12] ให้เครื่องดนตรี [Wisozk Group] จำนวน 1', '2025-09-11 05:47:50'),
(130, 3, 'admin', 'update_instrument_room', 'อัปเดตจำนวนเครื่องดนตรี [Wisozk Group] ในห้อง [A12] จาก 1 → 8', '2025-09-11 05:48:01'),
(131, 3, 'admin', 'update_instrument_room', 'อัปเดตจำนวนเครื่องดนตรี [Wisozk Group] ในห้อง [A13] จาก 1 → 8', '2025-09-11 05:48:05'),
(132, 3, 'admin', 'create_instrument', 'เพิ่มเครื่องดนตรี [Holiday Discount] รหัส: 25267', '2025-09-11 05:48:35'),
(133, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A13] ให้เครื่องดนตรี [Holiday Discount] จำนวน 1', '2025-09-11 05:48:47'),
(134, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [A12] ให้เครื่องดนตรี [Holiday Discount] จำนวน 1', '2025-09-11 05:48:50'),
(135, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [Studio A - Premium] ให้เครื่องดนตรี [Holiday Discount] จำนวน 1', '2025-09-11 05:48:53'),
(136, 3, 'admin', 'add_room_to_instrument', 'เพิ่มห้อง [Luxury XXL] ให้เครื่องดนตรี [Holiday Discount] จำนวน 1', '2025-09-11 05:48:56'),
(137, 3, 'admin', 'delete_instrument_category', 'ลบประเภทเครื่องดนตรี [กลอง] และเครื่องดนตรีทั้งหมดใน category นี้', '2025-09-11 05:49:44'),
(138, 3, 'admin', 'create_promotion', 'สร้างโปรโมชั่น [YippyVoucher] (ประเภท: percent, ส่วนลด: 20)', '2025-09-11 06:04:55'),
(139, 3, 'admin', 'update_promotion', 'แก้ไขโปรโมชั่น [YippyVoucher] → [YippyVoucherrr], \n                        ส่วนลด: 20.00 → 30.00, \n                        สถานะ: Active → Inactive', '2025-09-11 06:05:24'),
(140, 3, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [YippyVoucherrr] เป็น Active', '2025-09-11 06:05:27'),
(141, 3, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [YippyVoucherrr] เป็น Inactive', '2025-09-11 06:05:34'),
(142, 3, 'admin', 'toggle_promotion', 'สลับสถานะโปรโมชั่น [YippyVoucherrr] เป็น Active', '2025-09-11 06:05:36'),
(143, 3, 'admin', 'update_promotion', 'แก้ไขโปรโมชั่น [YippyVoucherrr] → [YippyVoucherrr], \n                        ส่วนลด: 30.00 → 40.00, \n                        สถานะ: Active → Active', '2025-09-11 06:05:43'),
(144, 3, 'admin', 'delete_promotion', 'ลบโปรโมชั่น [100% Discount]', '2025-09-11 06:05:58'),
(145, 3, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-11 06:18:26'),
(146, 3, 'admin', 'create_room', 'เพิ่มห้องใหม่', '2025-09-11 06:22:58'),
(147, 3, 'admin', 'update_room', 'แก้ไขห้อง [ID: 17] จาก [ชื่อ: TestDelete, ราคา/ชม.: 4555.00, ความจุ: 14] → [ชื่อ: TestDelete, ราคา/ชม.: 4555.00, ความจุ: 14]', '2025-09-11 06:23:10'),
(148, 3, 'admin', 'update_room', 'แก้ไขห้อง [ID: 17] จาก [ชื่อ: TestDelete, ราคา/ชม.: 4555.00, ความจุ: 14] → [ชื่อ: TestDeleteee, ราคา/ชม.: 455555.00, ความจุ: 144]', '2025-09-11 06:23:38'),
(149, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Dodge] จำนวน 1 ในห้อง [ID: 17, ชื่อ: TestDeleteee]', '2025-09-11 06:23:51'),
(150, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Johnson - KutchUpdate] จำนวน 1 ในห้อง [ID: 17, ชื่อ: TestDeleteee]', '2025-09-11 06:23:54'),
(151, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Johnson - Kutchhh] จำนวน 1 ในห้อง [ID: 17, ชื่อ: TestDeleteee]', '2025-09-11 06:23:56'),
(152, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [100% Discount] จำนวน 1 ในห้อง [ID: 17, ชื่อ: TestDeleteee]', '2025-09-11 06:23:59'),
(153, 3, 'admin', 'add_instrument_to_room', 'เพิ่มเครื่องดนตรี [Wisozk Group] จำนวน 1 ในห้อง [ID: 17, ชื่อ: TestDeleteee]', '2025-09-11 06:24:02'),
(154, 3, 'admin', 'update_instrument_quantity', 'แก้ไขจำนวนเครื่องดนตรี [Dodge] ในห้อง [TestDeleteee] จาก 1 → 4', '2025-09-11 06:24:23'),
(155, 3, 'admin', 'update_instrument_quantity', 'แก้ไขจำนวนเครื่องดนตรี [Johnson - KutchUpdate] ในห้อง [TestDeleteee] จาก 1 → 4', '2025-09-11 06:24:26'),
(156, 3, 'admin', 'update_instrument_quantity', 'แก้ไขจำนวนเครื่องดนตรี [Johnson - Kutchhh] ในห้อง [TestDeleteee] จาก 1 → 4', '2025-09-11 06:24:27'),
(157, 3, 'admin', 'update_instrument_quantity', 'แก้ไขจำนวนเครื่องดนตรี [100% Discount] ในห้อง [TestDeleteee] จาก 1 → 4', '2025-09-11 06:24:30'),
(158, 3, 'admin', 'update_instrument_quantity', 'แก้ไขจำนวนเครื่องดนตรี [Wisozk Group] ในห้อง [TestDeleteee] จาก 1 → 4', '2025-09-11 06:24:31'),
(159, 3, 'admin', 'remove_instrument_from_room', 'ลบเครื่องดนตรี [Johnson - KutchUpdate] ออกจากห้อง [TestDeleteee]', '2025-09-11 06:24:40'),
(160, 3, 'admin', 'delete_room', 'ลบห้อง [ID: 17, ชื่อ: TestDeleteee]', '2025-09-11 06:24:50'),
(161, 3, 'admin', 'update_user', 'แก้ไขผู้ใช้ [ID: 4] จาก [ชื่อ: Testing Testing, Username: Testing123, Email: Testing123@gmail.com, เบอร์: 0222222222, Role: user] → [ชื่อ: Testingnew Testingnew, Username: Testing123new, Email: Testing123@gmail.com, เบอร์: 0111111111, Role: user]', '2025-09-11 06:30:51'),
(162, 3, 'admin', 'reset_password', 'รีเซ็ตรหัสผ่านผู้ใช้ [ID: 4, Username: Testing123new] เป็นค่าเริ่มต้นใหม่', '2025-09-11 06:31:23'),
(163, 3, 'admin', 'reset_password', 'รีเซ็ตรหัสผ่านผู้ใช้ [ID: 4, Username: Testing123new] เป็นค่าเริ่มต้นใหม่', '2025-09-11 06:31:35');

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
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `promo_id`, `start_time`, `end_time`, `total_price`, `deposit_price`, `status`, `created_at`, `updated_at`) VALUES
(80, 6, 12, NULL, '2025-09-10 12:12:00', '2025-09-10 13:12:00', 7378.00, 3689.00, 'confirmed', '2025-09-10 05:24:26', '2025-09-10 05:24:26'),
(81, 6, 12, NULL, '2025-09-11 00:27:00', '2025-09-11 01:27:00', 1800.50, 900.25, 'confirmed', '2025-09-10 17:28:27', '2025-09-10 17:28:27'),
(82, 6, 12, NULL, '2025-09-11 03:35:00', '2025-09-11 04:35:00', 2801.00, 1400.50, 'confirmed', '2025-09-10 17:35:59', '2025-09-10 17:36:44');

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
(82, 7, 7, 300.00);

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
(15, 82, 1400.50, 'qr_code', 'paid', 'TXN1757525759', '2025-09-11 00:35:59', '2025-09-10 17:35:59');

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
(1, 'Holiday Discount', 'You can save up to 50 pounds per person !!!', 'fixed', 50.00, '2025-09-02', '2025-09-04', 0),
(3, 'Holiday Discount Scoopy', 'test', 'percent', 99.99, '2025-09-10', '2025-09-17', 1),
(4, 'test222', 'test222', 'fixed', 222.00, '2025-09-02', '2025-09-18', 0),
(8, 'YippyVoucherrr', 'Ehereeee', 'percent', 40.00, '2025-09-11', '2025-09-14', 1);

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
(15, 82, '00082', 2801.00, 1400.50, 0.00, '2025-09-10 17:35:59');

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
(16, 'GoldPremium', 7500.00, 12, 'ห้องซ้อมขนาดกลาง เก็บเสียงอย่างดี พร้อมเครื่องดนตรีครบวงจร (กลองชุด, กีตาร์, เบส, คีย์บอร์ด)', 'rooms/SEleDmCd0VPgs5T0DFSpJZwSvDPxDkwJqrSTUmMR.jpg', '2025-09-11 06:18:26');

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
(14, 17, 1);

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
(6, 'News', 'Looks', 'Newlookauth3', 'Newlookauth3@gmail.com', '$2y$12$UUwnROXyy9ydejCsTnc7pecOf6nzDsCD16/lrT3LfLOBmvYTkayQ6', '0812345678', 'user', '2025-09-09 06:35:11', '2025-09-10 17:40:33');

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
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `instrument_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `instrument_categories`
--
ALTER TABLE `instrument_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
