-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2022 at 04:55 PM
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
-- Database: `exam_time_managment`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `studing_year` int(11) NOT NULL,
  `duration` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1:30',
  `students_number` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `semester`, `studing_year`, `duration`, `students_number`, `created_at`, `updated_at`) VALUES
(12, 'نظرية التعقيد', '2', 3, '01:30', 360, '2022-07-12 23:52:45', '2022-08-13 05:45:28'),
(48, 'برمجة متقدمة 1', '1', 2, '01:30', 230, '2022-07-13 03:32:39', '2022-08-27 20:16:33'),
(62, 'قواعد معطيات 2', '2', 4, '01:00', 500, '2022-07-29 01:18:05', '2022-08-19 12:38:48'),
(65, 'لغة عربية', '1', 1, '01:30', 300, '2022-08-06 04:30:09', '2022-08-23 18:32:32'),
(66, 'خوارزميات بحث ذكية', '1', 5, '02:00', 100, '2022-08-11 14:33:52', '2022-08-11 15:00:38'),
(68, 'نظم الوسائط المتعددة', '1', 4, '01:30', 300, '2022-08-13 05:44:29', '2022-08-13 05:44:52'),
(69, 'نظم زمن حقيقي', '1', 5, '01:30', 200, '2022-08-13 05:47:37', '2022-08-13 05:47:37'),
(74, 'برمجة 2', '2', 1, '01:30', 120, '2022-08-13 06:04:48', '2022-08-13 06:04:48'),
(75, 'إنكليزي 1', '1', 1, '01:30', 230, '2022-08-13 06:06:01', '2022-09-11 10:53:55'),
(76, 'قواعد معطيات 1', '1', 2, '01:00', 120, '2022-08-13 06:07:19', '2022-08-20 09:23:07'),
(78, 'تطبيقات إنترنت (ب)', '1', 5, '01:30', 300, '2022-08-13 06:08:33', '2022-08-13 06:08:33'),
(79, 'منطق ترجيحي', '1', 5, '01:30', 300, '2022-08-13 06:08:51', '2022-08-13 06:08:51'),
(81, 'تصميم تجارب', '2', 4, '01:30', 200, '2022-08-13 06:10:26', '2022-08-13 06:10:26'),
(82, 'رؤية حاسوبية', '2', 4, '01:30', 300, '2022-08-13 06:10:51', '2022-08-13 06:10:51'),
(83, 'تحليل 1', '1', 1, '01:30', 400, '2022-08-13 06:11:32', '2022-08-13 06:11:32'),
(84, 'إحصاء و إحتمالات', '1', 2, '01:30', 400, '2022-08-13 06:11:52', '2022-08-13 06:11:52'),
(85, 'تصميم شبكات', '2', 5, '01:30', 400, '2022-08-13 06:12:30', '2022-08-13 06:12:30'),
(86, 'نماذج تصميم', '2', 5, '01:30', 400, '2022-08-13 06:12:45', '2022-08-13 06:12:45'),
(87, 'تعلم تلقائي', '2', 5, '01:30', 400, '2022-08-13 06:13:00', '2022-08-13 06:13:00'),
(88, 'بنيان حواسيب 1', '2', 3, '01:30', 400, '2022-08-13 06:13:53', '2022-08-13 06:13:53'),
(89, 'شبكات 2', '1', 4, '01:30', 400, '2022-08-13 06:14:50', '2022-08-13 06:14:50'),
(90, 'شبكات عصبونية', '1', 4, '01:30', 400, '2022-08-13 06:15:07', '2022-08-13 06:15:07'),
(91, 'هندسة برمجيات 2', '1', 4, '01:30', 400, '2022-08-13 06:15:21', '2022-08-19 06:23:10'),
(92, 'تحليل 2', '2', 1, '01:30', 400, '2022-08-13 06:15:39', '2022-08-13 06:16:28'),
(93, 'تحليل عددي', '1', 2, '01:00', 400, '2022-08-13 06:17:20', '2022-08-20 09:27:41'),
(94, 'تعليم إلكتروني', '1', 5, '01:30', 112, '2022-08-13 06:18:14', '2022-08-20 09:45:58'),
(95, 'روبوتية', '1', 5, '01:30', 112, '2022-08-13 06:18:32', '2022-08-13 06:18:32'),
(96, 'إنكليزي معلوماتة 1', '1', 2, '01:30', 250, '2022-08-13 06:19:20', '2022-08-13 06:19:20'),
(97, 'نظرية الحوسبة', '1', 3, '01:30', 250, '2022-08-13 06:20:11', '2022-08-13 06:20:11'),
(98, 'قواعد معرفة', '2', 4, '01:30', 250, '2022-08-13 06:21:02', '2022-08-20 09:47:01'),
(100, 'شبكات 1', '2', 3, '01:30', 400, '2022-08-13 06:23:11', '2022-08-19 06:10:05'),
(101, 'إدارة شبكات', '2', 5, '01:30', 400, '2022-08-13 06:24:59', '2022-08-13 06:24:59'),
(102, 'هندسة برمجيات 3', '2', 5, '01:30', 230, '2022-08-13 06:25:21', '2022-09-11 11:47:14'),
(103, 'معالجة لغات', '2', 5, '01:30', 400, '2022-08-13 06:25:46', '2022-08-13 06:25:46'),
(104, 'أنصاف نواقل', '2', 1, '01:30', 400, '2022-08-13 06:26:33', '2022-08-13 06:26:33'),
(105, 'برمجة متقدمة 2', '2', 2, '01:30', 400, '2022-08-13 06:27:11', '2022-08-13 06:27:11'),
(106, 'تفرعية', '1', 4, '01:30', 400, '2022-08-13 06:28:02', '2022-08-13 06:28:02'),
(107, 'إتصالات رقمية', '1', 3, '01:30', 400, '2022-08-13 06:29:04', '2022-08-13 06:29:04'),
(108, 'إدارة مشاريع', '1', 5, '01:30', 400, '2022-08-13 06:29:44', '2022-08-13 06:29:44'),
(109, 'إنكليزي 2', '2', 1, '01:30', 400, '2022-08-13 06:31:45', '2022-08-13 06:31:45'),
(110, 'إنكليزي معلوماتية 2', '2', 2, '01:30', 400, '2022-08-13 06:32:21', '2022-08-13 06:32:21'),
(111, 'دارات منطقية', '1', 3, '01:30', 400, '2022-08-13 06:32:56', '2022-08-13 06:32:56'),
(112, 'نظم موزعة', '2', 4, '01:30', 400, '2022-08-13 06:33:35', '2022-08-13 06:33:35'),
(113, 'برمجة 1', '1', 1, '01:30', 400, '2022-08-13 06:34:24', '2022-08-13 06:34:24'),
(114, 'هندسة النظم', '2', 5, '01:30', 400, '2022-08-13 06:35:26', '2022-08-13 06:35:26'),
(115, 'إستكشاف معرفة', '2', 5, '01:30', 400, '2022-08-13 06:35:54', '2022-08-13 06:35:54'),
(116, 'تطبيقات إنترنت (ش)', '2', 5, '01:30', 400, '2022-08-13 06:36:20', '2022-08-13 06:36:20'),
(117, 'تحليل 3', '1', 2, '01:30', 400, '2022-08-13 06:37:01', '2022-08-13 06:37:01'),
(118, 'ذكاء صنعي', '2', 3, '01:30', 400, '2022-08-13 06:37:38', '2022-08-13 06:37:38'),
(119, 'فيزياء كهربائية', '1', 1, '01:30', 400, '2022-08-13 06:38:59', '2022-08-13 06:38:59'),
(120, 'إدارة منظمات', '1', 4, '01:30', 400, '2022-08-13 06:39:41', '2022-08-13 06:39:41'),
(122, 'حقائق افتراضية', '1', 5, '01:30', 120, '2022-08-20 04:22:29', '2022-08-20 04:22:29'),
(123, 'تطبيقات شبكية', '1', 5, '01:00', 122, '2022-08-20 07:57:23', '2022-08-20 09:23:39'),
(125, 'نظم تشغيل 1', '1', 3, '01:30', 124, '2022-08-20 09:25:17', '2022-08-20 09:25:17'),
(126, 'نمذجة ومحاكاه', '2', 4, '01:30', 123, '2022-08-20 09:48:13', '2022-08-20 09:48:13'),
(127, 'بحوث العمليات', '2', 2, '01:30', 123, '2022-08-20 09:51:13', '2022-08-20 09:51:13'),
(128, 'أمن المعلومات', '1', 5, '01:30', 123, '2022-08-20 09:51:59', '2022-08-20 09:51:59'),
(129, 'ثقافة', '2', 1, '01:30', 123, '2022-08-20 09:52:38', '2022-08-20 09:52:38'),
(130, 'خوارزميات وبنى المعطيات', '1', 3, '01:30', 123, '2022-08-20 09:53:36', '2022-08-20 09:53:36'),
(131, 'تحليل نظم مالية', '2', 4, '01:30', 200, '2022-08-20 09:55:19', '2022-08-20 09:55:19'),
(132, 'تعلم الة', '2', 4, '01:30', 230, '2022-08-20 09:55:56', '2022-08-20 09:55:56'),
(133, 'بروتوكولات شبكية', '2', 4, '01:30', 230, '2022-08-20 09:56:29', '2022-08-20 09:56:29'),
(134, 'رياضيات متقطعة', '1', 2, '01:30', 230, '2022-08-20 09:58:33', '2022-08-20 09:58:33'),
(135, 'نظم تشغيل 2', '1', 4, '01:30', 230, '2022-08-20 09:59:13', '2022-08-20 09:59:13'),
(137, 'تسويق و جوده', '2', 5, '01:30', 230, '2022-08-20 10:02:06', '2022-08-20 10:02:06'),
(138, 'هندسة برمجيات 1', '2', 3, '01:30', 230, '2022-08-20 10:04:19', '2022-08-20 10:04:19'),
(139, 'جبر خطي', '2', 1, '01:30', 230, '2022-08-20 10:04:49', '2022-08-20 10:04:59'),
(140, 'مهارات التواصل', '1', 3, '01:30', 230, '2022-08-20 10:05:36', '2022-08-20 10:05:36'),
(141, 'إشارات ونظم', '2', 2, '01:30', 230, '2022-08-20 10:06:24', '2022-08-20 10:06:24'),
(142, 'خوارزميات بحث ذكية(ب)', '1', 5, '01:30', 230, '2022-08-20 10:07:01', '2022-08-20 10:08:29'),
(143, 'نظم رقمية', '1', 5, '01:30', 230, '2022-08-20 10:07:37', '2022-08-20 10:07:37'),
(144, 'خوارزميات بحث ذكية(ذ)', '1', 4, '01:30', 230, '2022-08-20 10:08:56', '2022-08-20 10:09:34'),
(145, 'مبادى عمل حواسيب', '1', 1, '01:30', 230, '2022-08-20 10:10:25', '2022-08-20 10:10:25'),
(146, 'نظرية المعلومات', '2', 3, '01:30', 230, '2022-08-20 10:10:52', '2022-08-20 10:10:52'),
(147, 'بنيان حواسيب 2', '2', 4, '01:30', 230, '2022-08-20 10:11:23', '2022-08-20 10:11:23'),
(148, 'بناء مترجمات', '2', 4, '01:30', 230, '2022-08-20 10:11:38', '2022-08-20 10:11:38'),
(149, 'جبر لاخطي', '1', 1, '01:30', 230, '2022-08-20 10:12:10', '2022-08-20 10:12:10'),
(150, 'دارات كهربائية', '1', 2, '01:30', 230, '2022-08-20 10:12:47', '2022-08-20 10:12:47'),
(151, 'رسم بمعونة الحاسب', '1', 4, '01:30', 230, '2022-08-20 10:13:14', '2022-08-20 10:13:14'),
(152, 'لغات البرمجة', '1', 4, '01:30', 230, '2022-08-20 10:13:41', '2022-08-20 10:13:41'),
(154, 'انكليزي معلوماتية 1', '1', 2, '01:30', 230, '2022-08-23 19:27:43', '2022-08-23 19:27:43'),
(155, 'داتا 3', '1', 5, '01:30', 200, '2022-08-27 20:54:23', '2022-08-27 20:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `course_room_user`
--

CREATE TABLE `course_room_user` (
  `date` date NOT NULL,
  `time` time NOT NULL,
  `roleIn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_student_in_room` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_room_user`
--

INSERT INTO `course_room_user` (`date`, `time`, `roleIn`, `num_student_in_room`, `course_id`, `room_id`, `user_id`) VALUES
('2022-09-06', '19:47:00', 'Room-Head', 60, 102, 100, 2),
('2022-09-06', '19:47:00', 'Secertary', 60, 102, 100, 67),
('2022-09-06', '19:47:00', 'Observer', 60, 102, 100, 68),
('2022-09-06', '19:47:00', 'Room-Head', 13, 102, 101, 3),
('2022-09-06', '19:47:00', 'Secertary', 13, 102, 101, 69),
('2022-09-06', '19:47:00', 'Observer', 13, 102, 101, 70),
('2022-09-06', '19:47:00', 'Room-Head', 25, 102, 102, 4),
('2022-09-06', '19:47:00', 'Secertary', 25, 102, 102, 71),
('2022-09-06', '19:47:00', 'Observer', 25, 102, 102, 72),
('2022-09-06', '19:47:00', 'Room-Head', 20, 102, 103, 5),
('2022-09-06', '19:47:00', 'Secertary', 20, 102, 103, 73),
('2022-09-06', '19:47:00', 'Observer', 20, 102, 103, 74),
('2022-09-06', '19:47:00', 'Room-Head', 12, 102, 104, 6),
('2022-09-06', '19:47:00', 'Secertary', 12, 102, 104, 75),
('2022-09-06', '19:47:00', 'Observer', 12, 102, 104, 76),
('2022-09-06', '19:47:00', 'Room-Head', 20, 102, 105, 7),
('2022-09-06', '19:47:00', 'Secertary', 20, 102, 105, 77),
('2022-09-06', '19:47:00', 'Observer', 20, 102, 105, 78),
('2022-09-06', '19:47:00', 'Room-Head', 15, 102, 106, 8),
('2022-09-06', '19:47:00', 'Secertary', 15, 102, 106, 79),
('2022-09-06', '19:47:00', 'Observer', 15, 102, 106, 80),
('2022-09-06', '19:47:00', 'Room-Head', 15, 102, 107, 9),
('2022-09-06', '19:47:00', 'Secertary', 15, 102, 107, 81),
('2022-09-06', '19:47:00', 'Observer', 15, 102, 107, 82),
('2022-09-06', '19:47:00', 'Room-Head', 15, 102, 108, 10),
('2022-09-06', '19:47:00', 'Secertary', 15, 102, 108, 83),
('2022-09-06', '19:47:00', 'Observer', 15, 102, 108, 84),
('2022-09-06', '19:47:00', 'Room-Head', 15, 102, 109, 11),
('2022-09-06', '19:47:00', 'Secertary', 15, 102, 109, 85),
('2022-09-06', '19:47:00', 'Observer', 15, 102, 109, 86),
('2022-09-06', '19:47:00', 'Room-Head', 12, 102, 110, 12),
('2022-09-06', '19:47:00', 'Secertary', 12, 102, 110, 87),
('2022-09-06', '19:47:00', 'Observer', 12, 102, 110, 88);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2021_09_07_112352_create_permission_tables', 1),
(235, '2014_10_12_000002_create_users_table', 2),
(236, '2014_10_12_100000_create_password_resets_table', 2),
(237, '2019_08_19_000000_create_failed_jobs_table', 2),
(238, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(239, '2020_05_17_082346_create_courses_table', 2),
(240, '2022_06_24_094856_create_rooms_table', 2),
(241, '2022_06_25_081134_create_courses_rooms_users_pivot_table', 2),
(242, '2022_07_12_223017_create_objections_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 14);

-- --------------------------------------------------------

--
-- Table structure for table `objections`
--

CREATE TABLE `objections` (
  `date` date NOT NULL,
  `time` time NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suggest_date` date NOT NULL,
  `suggest_time` time NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users-list', 'web', '2022-06-29 00:20:09', '2022-06-29 00:20:26'),
(2, 'roles-panel', 'web', '2022-06-29 00:24:19', '2022-06-29 00:24:31'),
(3, 'user-create', 'web', '2022-06-29 00:25:46', '2022-06-29 00:25:57'),
(4, 'role-create', 'web', '2022-06-29 00:26:08', '2022-06-29 00:26:08'),
(5, 'user-edit', 'web', '2022-06-29 00:26:34', '2022-06-29 00:26:34'),
(6, 'role-edit', 'web', '2022-06-29 00:26:46', '2022-06-29 00:26:46'),
(7, 'course-create', 'web', '2022-06-29 00:26:58', '2022-06-29 00:26:58'),
(8, 'course-edit', 'web', '2022-06-29 00:27:07', '2022-06-29 00:27:07'),
(9, 'user-delete', 'web', '2022-06-29 00:27:16', '2022-06-29 00:27:16'),
(10, 'role-delete', 'web', '2022-06-29 00:27:23', '2022-06-29 00:27:23'),
(11, 'course-delete', 'web', '2022-06-29 00:27:35', '2022-06-29 00:27:35'),
(12, 'courses-list', 'web', '2022-06-29 00:35:22', '2022-06-29 00:35:52'),
(13, 'course-show', 'web', '2022-06-30 21:02:53', '2022-06-30 21:02:53'),
(14, 'permissions-panel', 'web', '2022-07-01 00:41:29', '2022-07-01 00:41:29');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', NULL, NULL),
(2, 'Employee', 'web', NULL, NULL),
(3, 'Room-Head', 'web', '2022-06-29 00:34:27', '2022-06-29 00:34:27'),
(4, 'Secertary', 'web', '2022-06-29 16:20:27', '2022-06-29 16:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(12, 3),
(12, 4),
(13, 1),
(13, 3),
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `capacity`, `location`, `notes`, `created_at`, `updated_at`) VALUES
(100, 'مدرج علوم', 120, NULL, NULL, '2022-07-12 23:11:46', '2022-08-24 06:55:28'),
(101, 'المكتبة', 26, NULL, NULL, '2022-08-12 05:13:42', '2022-08-12 05:13:42'),
(102, 'قاعة السمينار', 50, NULL, NULL, '2022-08-12 05:13:25', '2022-08-12 05:34:39'),
(103, 'ر1', 40, NULL, NULL, '2022-07-12 23:11:23', '2022-08-24 06:55:39'),
(104, 'ر2', 40, NULL, NULL, '2022-07-12 23:11:26', '2022-08-24 06:55:45'),
(105, 'ر3', 40, NULL, NULL, '2022-07-12 23:11:30', '2022-08-24 06:55:54'),
(106, 'ج2', 30, NULL, NULL, '2022-07-12 23:19:23', '2022-08-12 05:26:04'),
(107, 'ج3', 30, NULL, NULL, '2022-07-12 23:19:26', '2022-08-12 05:26:23'),
(108, 'ج4', 30, NULL, NULL, '2022-07-12 23:19:29', '2022-08-24 06:56:06'),
(109, 'ج5', 30, NULL, NULL, '2022-07-12 23:19:34', '2022-08-24 06:56:13'),
(110, 'ق1', 24, NULL, NULL, '2022-07-12 23:10:39', '2022-08-12 05:27:14'),
(111, 'ق2', 24, NULL, NULL, '2022-07-12 23:11:03', '2022-08-12 05:27:23'),
(112, 'م1', 24, NULL, NULL, '2022-07-12 23:06:19', '2022-08-12 05:10:12'),
(113, 'م2', 20, NULL, NULL, '2022-07-12 23:15:52', '2022-08-12 05:10:37'),
(114, 'م3', 24, NULL, NULL, '2022-07-12 23:16:02', '2022-08-12 05:10:49'),
(115, 'م4', 24, NULL, NULL, '2022-07-12 23:16:10', '2022-08-12 05:11:03'),
(116, 'م5', 30, NULL, NULL, '2022-07-12 23:16:14', '2022-08-12 05:11:16'),
(117, 'م6', 24, NULL, NULL, '2022-07-12 23:16:20', '2022-08-12 05:11:31'),
(118, 'م10', 18, NULL, NULL, '2022-08-12 05:12:10', '2022-08-12 05:12:10'),
(119, 'م11', 27, NULL, NULL, '2022-08-12 05:12:23', '2022-08-12 05:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_observation` int(11) NOT NULL DEFAULT 8,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `email_verified_at`, `password`, `number_of_observation`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'admin', NULL, '$2y$10$JMl5ahvtCFsybG4H0iBYGuAWWhDJqs.f60m7D7do97yMSxKB6KAj2', 11, NULL, NULL, NULL, '2022-08-12 05:36:34'),
(2, '11@gmail.com', 'د. غيث بلال', NULL, '$2y$10$ApcDEBdwLy1qRUGZLpTWau6Ah.SpnRgaAPu9ZHVOIWPM1MJM130QK', 11, 'Doctor', NULL, '2022-07-12 23:19:56', '2022-08-24 07:17:14'),
(3, '22@gmail.com', 'د . بسيم برهوم', NULL, '$2y$10$duxL6PaoOENOoq7wt9iT7upbBrS2oy6IoWRByiWP9LvsHWq0g477i', 11, 'Doctor', NULL, '2022-07-12 23:20:07', '2022-08-24 05:23:34'),
(4, '33@gmail.com', 'د. محمد صبيح', NULL, '$2y$10$lZUyVNbjE60JDFQuP0nX8.0edUc5JOZFyqyJ6y2xK8BJrKoMGUcYy', 11, 'Doctor', NULL, '2022-07-12 23:20:21', '2022-08-24 06:14:32'),
(5, '44@gmail.com', 'د. علي إسماعيل', NULL, '$2y$10$yKeaDqgRAvRqsZ0EFmXkouPzMc1Q4tnrRb8MolHrjb4O9fe5j9dXa', 11, 'Doctor', NULL, '2022-07-12 23:20:31', '2022-08-24 05:24:31'),
(6, '55@gmail.com', 'د. باسل حسن', NULL, '$2y$10$n4OlBYCUFuOpUfOFK8O5DOeIEsWvYiRMpk3Uu8RY7m19rI5CtTB8C', 12, 'Doctor', NULL, '2022-07-12 23:20:44', '2022-08-24 06:14:44'),
(7, '66@gmail.com', 'حسام عبد الله مزريب', NULL, '$2y$10$wTRSFKB/UqsPbPDYgE6MN.gIDAXNhaU4DH3oyO5YbOgNsf1V2VnA2', 12, 'teacher', NULL, '2022-07-12 23:20:55', '2022-08-24 06:40:46'),
(8, '77@gmail.com', 'خولة علي قاسم', NULL, '$2y$10$YP00WRSXanQO0ZxLw/cEWe0vd0rQH/bMLROi5zsMHwNgjEG1/G2fS', 12, 'teacher', NULL, '2022-07-12 23:21:06', '2022-08-24 06:41:00'),
(9, '88@gmail.com', 'ريم يونس ابراهيم', NULL, '$2y$10$dKbFM5g2ieNMYmZSRd6zRu.rCWX5jl2Nv/kv/Rjp9wOW2dNBjk4Se', 12, 'teacher', NULL, '2022-07-12 23:21:15', '2022-08-24 06:41:15'),
(10, '99@gmail.com', 'طارق زهير جبلاوي', NULL, '$2y$10$nqVCGwGLrjfOFOvDZwS1n.1pcCxiNkX1J/AsTzyywCxrOTHbD/osG', 12, 'teacher', NULL, '2022-07-12 23:21:26', '2022-08-24 06:41:07'),
(11, '1010@gmail.com', 'غيداء حبيب متوج', NULL, '$2y$10$e8Uu86.Ndl3NdBkGboqiXeNCZiTV6xgPE86Je7Zhqe4ujV2YT5AHW', 12, 'teacher', NULL, '2022-07-12 23:21:38', '2022-08-24 06:41:25'),
(12, '1111@gmail.com', 'فاطمة محمد زكريا الدبس', NULL, '$2y$10$j/HjjHQw4FgpfojpkdrElOQzxI2AV5oX8DvsVcj7dwBerJ9GFbMMe', 12, 'teacher', NULL, '2022-07-12 23:22:02', '2022-08-24 06:41:43'),
(13, '1212@gmail.com', 'اسامة محمود غانم', NULL, '$2y$10$cwGSKibxBujX7RYgJKyq/.2aAFg7lCzJGkvIthH4B3IgnaNekIrNy', 12, 'teacher', NULL, '2022-07-12 23:22:12', '2022-08-24 06:41:59'),
(14, '1313@gmail.com', 'علاء محمد جراد', NULL, '$2y$10$.Pn7ffNOWlOTtpZE57L8ru/zLBeno.XB9I7ncb/0F4o14fp47W3xG', 12, 'teacher', NULL, '2022-07-12 23:22:25', '2022-08-24 06:42:18'),
(15, '1414@gmail.com', 'رنيم جرجي طاسيه', NULL, '$2y$10$iNIO51EbSTWU6SatfrNJh.h5c0ZyAJ8H0ttvIZ4Mt36ipcNl0RO1a', 12, 'teacher', NULL, '2022-07-12 23:22:38', '2022-08-24 06:42:30'),
(16, '1515@gmail.com', 'ندى بلال جنيدي', NULL, '$2y$10$rE3q8obUCWNc4NdH6vqCUuuuwdxUt/TaBdD0R2ZS/K6Ru9rXl7mWi', 14, 'teacher', NULL, '2022-07-12 23:22:47', '2022-08-24 06:42:52'),
(17, '1616@gmail.com', 'ماهر أحمد الرحيه', NULL, '$2y$10$0cWc1PDj2nGRxfNttfs4rOwYqQONaKs7QT4F4nlS0cHdZbQRDyGuq', 12, 'teacher', NULL, '2022-07-12 23:22:58', '2022-08-24 06:43:16'),
(18, '1717@gmail.com', 'حلا نجيب جوريه', NULL, '$2y$10$8imezN/91Q.HmVmCtMC0COyuR9vB9Ds38GpRGyQVkvYKLJzCEd9LW', 14, 'teacher', NULL, '2022-07-12 23:23:11', '2022-08-24 06:43:28'),
(19, '1818@gmail.com', 'علاء نديم الخدام', NULL, '$2y$10$nxsFztL3LGAd.yAtEGIYZeLeDW2.05EHR6L7Zx6dNQPAG4JRJ10i6', 14, 'teacher', NULL, '2022-07-12 23:23:26', '2022-08-24 06:43:42'),
(20, '1919@gmail.com', 'رامي عبد المجيد جديد', NULL, '$2y$10$y4hyXo1p5cdri69qjEtLs.eQyIK7qFMaSJaJaRWoaS63mmj0vdkTS', 14, 'teacher', NULL, '2022-07-12 23:24:16', '2022-08-24 06:43:55'),
(21, '2020@gmail.com', 'دعاء جمال شخيص', NULL, '$2y$10$ikdZ2bDYTrKxl/Sjj4gAqO0I7gzcKXfXfiIkG5vpGLFtShRiB4VnO', 14, 'teacher', NULL, '2022-07-12 23:24:29', '2022-08-24 06:44:07'),
(22, 'aaaa@gmail.com', 'راما اكثم الخير', NULL, '$2y$10$lol7sXrzbTaF0yKEr9G6Ue/r4Szet5XrkixpHRZcNbxl1fxjV2k9a', 12, 'teacher', NULL, '2022-08-03 17:41:18', '2022-08-24 06:44:25'),
(23, 'aaaa22@gmail.com', 'اروى خلوف', NULL, '$2y$10$Aa3SMtzbite3QC412h7Le.aEjRtsn7J55qU2.sbL76IpJLnEgT2aC', 13, 'teacher', NULL, '2022-08-03 17:42:54', '2022-08-24 06:44:40'),
(24, 'aaaa222@gmail.com', 'شعبان الخطيب', NULL, '$2y$10$8Z8eC1ekCHsb0YqHdHbRh.JqB7hjW0zbdhuTq4ZPKf3fP4W9/Q5i2', 14, 'teacher', NULL, '2022-08-03 17:44:19', '2022-08-24 06:44:54'),
(25, 'asem@gmail.com', 'لمى إبراهيم', NULL, '$2y$10$5co0OY8roIeswGN5V2LAk.ZA4EhqkG6D49OF.eL5ZkaccPdO7ZGk6', 14, 'teacher', NULL, '2022-08-04 02:09:24', '2022-08-24 06:45:11'),
(26, 'aiham@gmail.com', 'الاء نجيب', NULL, '$2y$10$Uj2VZEqMLkT7Slimg9mksOwClXzeT.MyFis3hLOSTK.corO9oOlYm', 14, 'teacher', NULL, '2022-08-04 02:12:42', '2022-08-24 06:45:40'),
(27, 'a.abodaraa@comptechco.com', 'بتول حميدي', NULL, '$2y$10$PowAIEC8XCzYX5YExe/xmeRrLoQXjZuhqkcnirjaQsd.mKotbBOdq', 14, 'teacher', NULL, '2022-08-11 15:38:42', '2022-08-24 06:45:57'),
(28, 'aNew.abodaraa@comptechco.com12', 'رشا غدير', NULL, '$2y$10$lz4JLZcewewlY0XaC.dDGuWxqAI8tka7KMCaLmTYn7LBKL5Hm4Rau', 16, 'teacher', NULL, '2022-08-12 19:12:16', '2022-08-24 06:52:11'),
(29, 'ee@gmail.com', 'عباده حاتم', NULL, '$2y$10$B17TAbWsBhYpFiv/tYrue./davJ.08LDNLbAxlCBXauxhC7TWK2M.', 14, 'teacher', NULL, '2022-08-15 11:47:58', '2022-08-24 06:51:33'),
(30, 'admin22@gmail.com1', 'بلسم محمود سليطين', NULL, '$2y$10$uESBaYPY3jvgTcjUCoMioOqKouFrr/BZSkPoEjaDiX4qRn9./u5TC', 16, 'teacher', NULL, '2022-08-26 08:20:33', '2022-08-26 08:20:33'),
(31, 'admin33@gmail.com1', 'زهور يوسف حبيب', NULL, '$2y$10$3KMZtznJslB09egFGY9L4uB3/4we.luY3PRz.Di/CLrR.7MHV8Nw2', 11, 'administrative employee', NULL, '2022-08-26 08:21:33', '2022-08-26 08:21:33'),
(32, 'admin44@gmail.com1', 'محمد يوسف خدام', NULL, '$2y$10$GeMZ9HAPZ8ciVDuZ/08Uf.fn4a5uHGjU5voQhXjANVxrWa2n5e98W', 9, 'administrative employee', NULL, '2022-08-26 08:21:56', '2022-08-26 08:21:56'),
(33, 'admin55@gmail.com1', 'نجوى رفعت المرقبي', NULL, '$2y$10$rE2GFXruYBsjV2XlXp8MVe9/auxXXxf3kJJeO68g5Ne7oCA.lWKF6', 9, 'administrative employee', NULL, '2022-08-26 08:22:23', '2022-08-26 08:22:23'),
(34, 'admin66@gmail.com1', 'هناء درويش درويش', NULL, '$2y$10$b8g6kuPtFlCuxsWL.Ej0eOnDJCJtbBB1mRoIqgoDnFH5KCSQxYp.S', 9, 'administrative employee', NULL, '2022-08-26 08:22:55', '2022-08-26 08:22:55'),
(35, 'admin77@gmail.com1', 'رهام كامل صقر', NULL, '$2y$10$43/B2HdFpuMi5TjkRF2hr.q84.aKfPlp69yGVhDQoXvdOJdetafUi', 9, 'teacher', NULL, '2022-08-26 08:23:17', '2022-08-26 08:23:17'),
(36, 'admin88@gmail.com1', 'هيا قبلان', NULL, '$2y$10$gu9I3D0ZzkHjNhDdErEv7et5HnL58VF9jHgXkzxDr4itsQph5L3z6', 13, 'administrative employee', NULL, '2022-08-26 08:23:40', '2022-08-26 08:23:40'),
(37, 'admin99@gmail.com1', 'مجد محمد ساتر', NULL, '$2y$10$sO0yveQdnDZtN2weKFrSteiho.fVzuvu6mk0nw/FstCj6WwpDpYvC', 13, 'administrative employee', NULL, '2022-08-26 08:23:59', '2022-08-26 08:23:59'),
(38, 'admin100@gmail.com1', 'منى ناجي حيدر', NULL, '$2y$10$C4b0A4H7rmCRRB76q5HlT.0TMcDlp1XmWm3rH8Zn.8JVLYBBWGupO', 13, 'administrative employee', NULL, '2022-08-26 08:24:57', '2022-08-26 08:24:57'),
(39, 'admin101@gmail.com1', 'بتول ابراهيم الوزه', NULL, '$2y$10$HixmK0JIjjc/kmdatHROMegZZ//76.Z8uKFpYDPzYS.ghUKvP/tem', 13, 'teacher', NULL, '2022-08-26 08:25:31', '2022-08-26 08:25:31'),
(40, 'admin102@gmail.com1', 'د. هبة أبو احمد', NULL, '$2y$10$t3jVDPAyEHrryf48ePuJSe/01CFM/s2M4oi3pLapzfLQUAKeSzsH2', 13, 'Doctor', NULL, '2022-08-26 08:26:16', '2022-08-26 08:26:16'),
(41, 'admin103@gmail.com1', 'لمى دوبا', NULL, '$2y$10$NQ5.J9.CQysL5ILY1gjjOOPReLK0z9eFcv.rbBIk7aqiw5vNKiN6O', 13, 'teacher', NULL, '2022-08-26 08:26:46', '2022-08-26 08:26:46'),
(42, 'admin104@gmail.com1', 'د. هبة حيدر', NULL, '$2y$10$X1JOvPuXqn2I5jR4WXzgQ.C1bOZmwCxVK6OH9w3O137Z8Fg74mPKO', 15, 'Doctor', NULL, '2022-08-26 08:27:06', '2022-08-26 08:27:06'),
(43, 'admin105@gmail.com1', 'د. روني قسام', NULL, '$2y$10$1xDSGcnW5JMDrb9Ind436.stRpj9Gff7b4UwznUbuymE8x9WanY.C', 15, 'Doctor', NULL, '2022-08-26 08:27:26', '2022-08-26 08:27:26'),
(44, 'admin106@gmail.com1', 'اياد مصطفى', NULL, '$2y$10$U4CNx53s0/dwWfUORyDbMOLfr6gysnwa3.6HHfpCWAhCAQmGLRXr.', 15, 'teacher', NULL, '2022-08-26 08:27:54', '2022-08-26 08:27:54'),
(45, 'admin107@gmail.com1', 'رنيم سينو', NULL, '$2y$10$xSKGFfIa3axUcq6Fkfu85.8B/UsQwOEMC7CvoqslqhRQfC/i8S7/a', 15, 'teacher', NULL, '2022-08-26 08:28:15', '2022-08-26 08:28:15'),
(46, 'admin108@gmail.com1', 'هلا اسعد', NULL, '$2y$10$yANpSKT5B6BgZLIhT2aBOuoMLbu0CFJkU8VGuNFZmnrjvaj6CER0m', 13, 'teacher', NULL, '2022-08-26 08:28:35', '2022-08-26 08:28:35'),
(47, 'admin109@gmail.com1', 'نجلاء عباس', NULL, '$2y$10$CXvdTZteW1Dc72Wuv0qWLeNvQ80wWQznafaBfYTRfO9gGm/HhZ/s.', 15, 'teacher', NULL, '2022-08-26 08:28:54', '2022-08-26 08:28:54'),
(48, 'admin110@gmail.com1', 'الحسين محمد', NULL, '$2y$10$nCmdtAZe5EMbCwtjOOYQp.BJ5NIE4LFvncLT8ztWbDjzqVl5Nrt5e', 7, 'Master\'s student', NULL, '2022-08-26 08:29:22', '2022-08-26 08:29:22'),
(49, 'admin111@gmail.com1', 'رهام درويش', NULL, '$2y$10$doyYiRrFEBGUyr6als69aO34jiICawLJukijjZZIMwN/0aGsPL2ty', 11, 'teacher', NULL, '2022-08-26 08:29:48', '2022-08-26 08:29:48'),
(50, 'admin112@gmail.com1', 'سلمان حيدر', NULL, '$2y$10$XunqS.iQOYdaaRwzcNrUJOQCWmpmK68RsO6jFFnVi2GQ3CwQAJFOK', 13, 'teacher', NULL, '2022-08-26 08:30:08', '2022-08-26 08:30:08'),
(51, 'admin113@gmail.com1', 'نجوى المرقبي', NULL, '$2y$10$eL8.7qo56SkfC4N.qFEpNuqUawjHGGfjVWGKJBaKy3.MnUo.vmu7G', 12, 'teacher', NULL, '2022-08-26 08:30:22', '2022-08-26 08:30:22'),
(52, 'admin114@gmail.com1', 'يارا الكنج', NULL, '$2y$10$8D70tHlvbsygtGMZPUwGzOIC0WPWbAHBuDJQeLZyjm52ddzGPxps.', 12, 'teacher', NULL, '2022-08-26 08:30:39', '2022-08-26 08:30:39'),
(53, 'admin115@gmail.com1', 'محمد ريحان', NULL, '$2y$10$owQ41SaaDnC9DROJQ.ejVO0vRXrwHLpLfVTyvCCSjxxZoL7W/bIdK', 12, 'Master\'s student', NULL, '2022-08-26 08:31:18', '2022-08-26 08:31:18'),
(54, 'admin116@gmail.com1', 'عبير حسن', NULL, '$2y$10$Ue8.FFEqImjkg1JIH7KxgOKqogu0rFojKevJVBij8Kk7lQ3HU44TW', 13, 'Master\'s student', NULL, '2022-08-26 08:31:42', '2022-08-26 08:31:42'),
(55, 'admin117@gmail.com1', 'منى حيدر', NULL, '$2y$10$J.BQ0FaNi8cSYF3nJjotMuOYEJmvaQxyHcOoCCB2s4dJC2q1CkPQK', 13, 'Master\'s student', NULL, '2022-08-26 08:31:52', '2022-08-26 08:31:52'),
(56, 'admin118@gmail.com1', 'خالدية علوش', NULL, '$2y$10$mud9mIL7s16FcrebScSD7O5E5wjDs.oWbztrM8m/bvc7XHQroqXr2', 15, 'administrative employee', NULL, '2022-08-26 08:32:20', '2022-08-26 08:32:20'),
(57, 'admin119@gmail.com1', 'الاء خليفة', NULL, '$2y$10$omW1x3R3yXbzs/K/Qg2eoO.qvFw04K1iRlt3J08Y4KKW75uKMKBTq', 15, 'administrative employee', NULL, '2022-08-26 08:32:37', '2022-08-26 08:32:37'),
(58, 'admin120@gmail.com1', 'ختام حميش', NULL, '$2y$10$iR/vDiqBOZK0Ss.GIT2Dde7.ofAwLCzaOerEjH5hSxn2/hTyr/CkC', 14, 'administrative employee', NULL, '2022-08-26 08:32:53', '2022-08-26 08:32:53'),
(59, 'admin121@gmail.com1', 'زينة فارس', NULL, '$2y$10$IMKhjwL1bnGTmTGQkmzP/uXIX6bqPMrOLNZoo3gryNlAlqj.918EK', 13, 'administrative employee', NULL, '2022-08-26 08:33:09', '2022-08-26 08:33:09'),
(60, 'admin122@gmail.com1', 'اقبال ناصيف', NULL, '$2y$10$2VuDSpQnQQ6fjyxr501W4uYlXnQ6/l/ZRCS.tr3vtEt7mOWdToK2m', 13, 'administrative employee', NULL, '2022-08-26 08:33:24', '2022-08-26 08:33:24'),
(61, 'admin123@gmail.com1', 'الهام صالح', NULL, '$2y$10$Kgwfc5uMD2mQx0NTNDMGSezH2mmSz9hrcwQeph0InNIGEsPuo1PXS', 13, 'administrative employee', NULL, '2022-08-26 08:33:38', '2022-08-26 08:33:38'),
(67, 'admin124@gmail.com1', 'مارد عبدالله', NULL, '$2y$10$L4K28qBI6QB7x.ZzucXKxuPVZAw.vLYrAXsasLCAT7gVVfyQRszui', 6, 'administrative employee', NULL, '2022-09-11 11:01:20', '2022-09-11 11:01:20'),
(68, 'admin125@gmail.com1', 'عبير العماري', NULL, '$2y$10$WU8W0skqvApGKgdZnHAVme.O5YriM5YiuI/FemNDMT.YbLiKNRNrC', 6, 'administrative employee', NULL, '2022-09-11 11:01:35', '2022-09-11 11:01:35'),
(69, 'admin126@gmail.com1', 'محمد حبق', NULL, '$2y$10$EO8a3xtFwR8PjJHud5oVjOivNo/wNDEd/wN9E1aKQEpV5gYZicg26', 6, 'administrative employee', NULL, '2022-09-11 11:01:50', '2022-09-11 11:01:50'),
(70, 'admin127@gmail.com1', 'ربيع مسيلماني', NULL, '$2y$10$kdPDJfFTSWDL2ikmUYz5GughTWXhOMiywwHH3rzPgBZ6T9EIJmah2', 6, 'administrative employee', NULL, '2022-09-11 11:02:14', '2022-09-11 11:02:14'),
(71, 'admin128@gmail.com1', 'نهلة ابراهيم صلاط', NULL, '$2y$10$dheAVsafgBNF.D7U0BBTWOPakSscZsOg69W37ANUNeM7XMb13iynC', 6, 'administrative employee', NULL, '2022-09-11 11:02:26', '2022-09-11 11:02:26'),
(72, 'admin129@gmail.com1', 'أمين محمد برجس', NULL, '$2y$10$HVu66PYu7Qhs4uQzMqgqxeyBr5qocBmPR5go3dWoqikUAp4Mf1Pim', 6, 'administrative employee', NULL, '2022-09-11 11:02:41', '2022-09-11 11:02:41'),
(73, 'admin130@gmail.com1', 'ربى أيوب أحمد', NULL, '$2y$10$CC03ajdFgNm3hYod8lRUXepOMj0LIlpqiecvSP0/3gJCRpOw6N.V.', 6, 'administrative employee', NULL, '2022-09-11 11:03:09', '2022-09-11 11:03:09'),
(74, 'admin131@gmail.com1', 'لينا نعيسة', NULL, '$2y$10$CsIirL878f4u11hHbDZ7xO725ZOI/J4wKx57o9cOyXoBjEesgYfEK', 6, 'administrative employee', NULL, '2022-09-11 11:03:25', '2022-09-11 11:03:25'),
(75, 'admin132@gmail.com1', 'تمام علي درويش', NULL, '$2y$10$tvqsN0k2hsDsJ0/EvYHAqudPmNE2.nRq7D8Xi1vSGaKAG5.bo8fGe', 6, 'administrative employee', NULL, '2022-09-11 11:03:37', '2022-09-11 11:03:37'),
(76, 'admin133@gmail.com1', 'سوزان كمال بريدي', NULL, '$2y$10$8WxvZ1KOV9FkHgtRvZByfO5TsZgBZstQ/h7aY9oJahxKlQZ0NJQYq', 6, 'administrative employee', NULL, '2022-09-11 11:03:51', '2022-09-11 11:03:51'),
(77, 'admin134@gmail.com1', 'عبير علي صالحة', NULL, '$2y$10$1Myvf7GHAHHErx5B.DzyNOl2AdidUinDKZSaVl4pXimJs2ECMr1Z.', 6, 'administrative employee', NULL, '2022-09-11 11:04:06', '2022-09-11 11:04:06'),
(78, 'admin135@gmail.com1', 'ديما رياض الشاطر', NULL, '$2y$10$jS3b7GEeiqM8aj3uaIp8Ou/rYv4SsK5NcV8ZZZXnS4sC3kIDjfQQq', 6, 'administrative employee', NULL, '2022-09-11 11:04:20', '2022-09-11 11:04:20'),
(79, 'admin136@gmail.com1', 'فاتن رياض جديد', NULL, '$2y$10$i5ehfzMnYUWuSu9R7vtxZ.MoEwfK9CkyhdFjd0TbrnPrMI6Rj.gay', 6, 'administrative employee', NULL, '2022-09-11 11:04:32', '2022-09-11 11:04:32'),
(80, 'admin137@gmail.com1', 'سائر نديم شعبان', NULL, '$2y$10$HmPY13BBZZpgDifxmHYwhucrR1g5zcrOHf5Co0DXCUYw8Jird/2MO', 7, 'administrative employee', NULL, '2022-09-11 11:05:21', '2022-09-11 11:05:21'),
(81, 'admin138@gmail.com1', 'محمد علي ريحان', NULL, '$2y$10$9uYmK08T0eVawwmU9bIfbeuOgXHFdyzyikJ0pmryjlUUpEYLYmsD.', 8, 'administrative employee', NULL, '2022-09-11 11:06:20', '2022-09-11 11:06:20'),
(82, 'admin139@gmail.com1', 'رهام عماد رحال', NULL, '$2y$10$B5jz9zzIXVteCVLvKFzu7OwPw5UMuZjJdUSSmydtTTLj1EqTHLfgC', 8, 'administrative employee', NULL, '2022-09-11 11:06:51', '2022-09-11 11:06:51'),
(83, 'admin140@gmail.com1', 'بشرى محمد يوسف', NULL, '$2y$10$cMtoPacYLrjtFOpbC4mQzeZ1RY8afqdy2yhKb7VtD18xa5nVK4TAq', 8, 'administrative employee', NULL, '2022-09-11 11:07:52', '2022-09-11 11:07:52'),
(84, 'admin141@gmail.com1', 'بشرى حسين حسن', NULL, '$2y$10$z/Cx7HF15xeZiqnRsTFgIOK1FTEbDyBhnq5ZXjNP4km19SFfioIye', 8, 'administrative employee', NULL, '2022-09-11 11:08:08', '2022-09-11 11:08:08'),
(85, 'admin142@gmail.com1', 'سمير عبد الكريم ابراهيم', NULL, '$2y$10$YUO2xQE4ruHUjg5PRcd7IOZkHKMIq8v0zRO8CeHeR2MziI9SXpytW', 8, 'administrative employee', NULL, '2022-09-11 11:08:21', '2022-09-11 11:08:21'),
(86, 'admin143@gmail.com1', 'علي محي الدين عيد', NULL, '$2y$10$6rBRty49LRc6zx216NwyEeChVhR/gljakQwhqJv4f3rRbdYqg1BRe', 8, 'administrative employee', NULL, '2022-09-11 11:08:38', '2022-09-11 11:08:38'),
(87, 'admin144@gmail.com1', 'هبه عدنان الجندي', NULL, '$2y$10$cKlJ672v/RFA6huHUrl68OUSYVZg.Sn3oFdvBodTgjMDKbS9X2NpC', 8, 'administrative employee', NULL, '2022-09-11 11:08:53', '2022-09-11 11:08:53'),
(88, 'admin145@gmail.com1', 'تغريد علي عمران', NULL, '$2y$10$qNl8NT8gyM05D21HEt9Sae7JDhkCULkGm40e6iKpNugvo54229D/a', 8, 'administrative employee', NULL, '2022-09-11 11:09:05', '2022-09-11 11:09:05'),
(89, 'admin146@gmail.com1', 'سنان سعيد', NULL, '$2y$10$ikgmfgMNCj9R.TJA5rT2e.mIKSN79Hg5UTyo6OyDE3NidUAaOt0aO', 8, 'administrative employee', NULL, '2022-09-11 11:09:18', '2022-09-11 11:09:18'),
(90, 'admin147@gmail.com1', 'شذى سليم زريق', NULL, '$2y$10$OhvyHAtzxoZzF9YDkImarukjhHjz357/BJ90K7nkgQ9QtUT1oU7oW', 8, 'administrative employee', NULL, '2022-09-11 11:09:31', '2022-09-11 11:09:31'),
(91, 'admin148@gmail.com1', 'شادي مصطفى طربوش', NULL, '$2y$10$08RpURT2QrBitkbAJS9fiO.qJD8zGnqOyY9HrGLYDoq94OZhrkmHK', 8, 'administrative employee', NULL, '2022-09-11 11:09:46', '2022-09-11 11:09:46'),
(92, 'admin149@gmail.com1', 'عبير محمود زريق', NULL, '$2y$10$sb07Pa2lvqq4XqoDKUG4lOw4vP/nVfqCdDU/G.MsD/9h2i4OK81PW', 8, 'administrative employee', NULL, '2022-09-11 11:10:01', '2022-09-11 11:10:01'),
(93, 'admin150@gmail.com1', 'كيناز جميل عثمان', NULL, '$2y$10$sFD/tuzrphlp2auomZZ7tOVC6aWCfJEpTqyJBZz2WNUKKE0l1zJhi', 8, 'administrative employee', NULL, '2022-09-11 11:10:16', '2022-09-11 11:10:16'),
(94, 'admin151@gmail.com1', 'نور علي حمود', NULL, '$2y$10$K6o6Rr8T76/H5f74roFmPOo9HF4oDOUT0cXc14Thu0ToPv5dxzwsK', 8, 'administrative employee', NULL, '2022-09-11 11:10:45', '2022-09-11 11:10:45'),
(95, 'admin152@gmail.com1', 'رناس محسن رجب', NULL, '$2y$10$hLtAUq32f69ajU91.HqcaOS4wcluDczUk.ubrQYNj9GOPTOkcCIIy', 8, 'administrative employee', NULL, '2022-09-11 11:10:58', '2022-09-11 11:10:58'),
(96, 'admin153@gmail.com1', 'بسمه يونس ابراهيم', NULL, '$2y$10$qA6b7NM6hvEIYzzrZKRd/O1kf3uNMIcA2A30dESQrno448GYUF1rG', 8, 'administrative employee', NULL, '2022-09-11 11:11:12', '2022-09-11 11:11:12'),
(97, 'admin154@gmail.com1', 'دلال محمود الصباغ', NULL, '$2y$10$5a19avtWKRCguqmfuuZoMOqgcyFrpNAlP0ugaIc9Z7WuHbpjl27Zq', 8, 'administrative employee', NULL, '2022-09-11 11:11:25', '2022-09-11 11:11:25'),
(98, 'admin155@gmail.com1', 'رغداء اسماعيل بوعيسى', NULL, '$2y$10$i3zvN4lN6z7FmEO1VzWiK.gpHBK3UcyWxC0ahkXZU3twqcwiraC.C', 8, 'administrative employee', NULL, '2022-09-11 11:11:37', '2022-09-11 11:11:37'),
(99, 'admin156@gmail.com1', 'نرمين سهيل عدره', NULL, '$2y$10$IlGLOz18fRyxw5s4fFV8k.8XavayLssvyXe7P7ltdEtL6EXnCnl3S', 7, 'administrative employee', NULL, '2022-09-11 11:12:04', '2022-09-11 11:12:04'),
(100, 'admin157@gmail.com1', 'هناء علي ملحم', NULL, '$2y$10$1KHyX5DWmpjmSA6Cyom1..ajLkUvUzUFgbOuj6Fgw7AWK/DMNA9Pq', 8, 'administrative employee', NULL, '2022-09-11 11:12:37', '2022-09-11 11:12:37'),
(101, 'admin158@gmail.com1', 'حياة سلطان مخلوف', NULL, '$2y$10$6TSOJ.nwDp4rFPAGXgS5Xu/ezdQd4r0Twd47aYVxAdbR0W3TOAlWG', 8, 'administrative employee', NULL, '2022-09-11 11:12:52', '2022-09-11 11:12:52'),
(102, 'admin159@gmail.com1', 'فراس كاسر يحيى', NULL, '$2y$10$VyHa/Zz22Q7BfvKjv9wthOxSXpj9OPAVXm121KLPNhkSWu6phUwZe', 8, 'administrative employee', NULL, '2022-09-11 11:13:04', '2022-09-11 11:13:04'),
(103, 'admin160@gmail.com1', 'هناء ثابت طراف', NULL, '$2y$10$e9peTW9hIWgcL27AmS/96uJWJwB0rkvaPUoq3LJrdUgOSjXR/2.bq', 8, 'administrative employee', NULL, '2022-09-11 11:13:20', '2022-09-11 11:13:20'),
(104, 'admin161@gmail.com1', 'علاء غازي وهيبي', NULL, '$2y$10$yBRA344UieA6tGt9CoKHsO6EL/mHvA00eWFV9CyGJ81.nIIL.4uXG', 8, 'administrative employee', NULL, '2022-09-11 11:14:14', '2022-09-11 11:14:14'),
(105, 'admin162@gmail.com1', 'بدور عبد اللطيف الأحمد', NULL, '$2y$10$HmLeMwyveEABiG3szLbhGeU4mtUuPJvgugYI0ELkGicTohzhJtQZW', 8, 'administrative employee', NULL, '2022-09-11 11:15:19', '2022-09-11 11:15:19'),
(106, 'admin163@gmail.com1', 'هناء درويش', NULL, '$2y$10$.Kw2L.jc5DAVgx5YxSyIQOrRaSqm6HCIJaGP.QiC2SuEAxJ2qXQNa', 8, 'administrative employee', NULL, '2022-09-11 11:15:40', '2022-09-11 11:15:40'),
(107, 'admin164@gmail.com1', 'خالدية قدور علوش', NULL, '$2y$10$icnb64.t.Ct9nDquap1F1.YM2tudDSpx6P6JZtB0Vda6zyfbOYd4u', 7, 'administrative employee', NULL, '2022-09-11 11:16:23', '2022-09-11 11:16:23'),
(108, 'admin165@gmail.com1', 'آلاء محمود خليفه', NULL, '$2y$10$wIGMNTXSAMq/AlLl3HpZ/OIza5OUKXKtf2i/F/o/sNes/HOE29SAm', 7, 'administrative employee', NULL, '2022-09-11 11:16:45', '2022-09-11 11:16:45'),
(109, 'admin166@gmail.com1', 'ختام عبد العزيز حميش', NULL, '$2y$10$.UfIhbDEze7vO/mG7ul5nOpSb3rjZXvkDi49c4dujOLJVFXn2R2yC', 7, 'administrative employee', NULL, '2022-09-11 11:17:07', '2022-09-11 11:17:07'),
(110, 'admin167@gmail.com1', 'زينه محمد فارس', NULL, '$2y$10$2i0wgFXBBO18m8FSZrkWeeqSiqL/bpRdJWMaGagVqApCzahA...ju', 7, 'administrative employee', NULL, '2022-09-11 11:17:30', '2022-09-11 11:17:30'),
(111, 'admin168@gmail.com1', 'شيرين جابر سبيب', NULL, '$2y$10$vo2BcwODYPrud5jOl8kqtOfEwmRxb583JKa.DEbY5UcETRX5/tJhi', 6, 'administrative employee', NULL, '2022-09-11 11:17:54', '2022-09-11 11:17:54'),
(112, 'admin169@gmail.com1', 'شيرين جابر سبيب1', NULL, '$2y$10$ZC7PYXWwlkaK0aWfLNhtAOBJer9qygB.Qh72/dpMbx5XWRei8GO/a', 6, 'administrative employee', NULL, '2022-09-11 11:18:25', '2022-09-11 11:18:25'),
(113, 'admin170@gmail.com1', 'هزار يوسف غدير', NULL, '$2y$10$1OxFNFK4yhsZdzvmdRf58O2KRYUgvkIbApskNqgEOJcAuC2omHcAi', 6, 'administrative employee', NULL, '2022-09-11 11:18:39', '2022-09-11 11:18:39'),
(114, 'admin171@gmail.com1', 'ميسون مهنا سعود', NULL, '$2y$10$THxZZjPGdWpQXlfdaZD5MOrlZHCD3b/fpWR/jd/VwPLLzzQ88YQzu', 6, 'administrative employee', NULL, '2022-09-11 11:18:51', '2022-09-11 11:18:51'),
(115, 'admin172@gmail.com1', 'سماهر محمود الهيبي', NULL, '$2y$10$RYAlUVeOCJezJV4o76Agy.GC1tqG9fW0N8WXTEBdgDJ5U9dXpqRO6', 6, 'administrative employee', NULL, '2022-09-11 11:19:02', '2022-09-11 11:19:02'),
(116, 'admin173@gmail.com1', 'مها نواف نصور', NULL, '$2y$10$emsvyeXqVMeh0qvEZ3ibUOCv3Q1Ogd6ZWpitUeqLRfTNT/K.KZQoq', 6, 'administrative employee', NULL, '2022-09-11 11:19:18', '2022-09-11 11:19:18'),
(117, 'admin174@gmail.com1', 'هناء ابراهيم راعي', NULL, '$2y$10$wCeF85pO1x1okN.mlKDPVODUPnasWwxsTB9MCWp4yH3T3smM6fyT2', 6, 'administrative employee', NULL, '2022-09-11 11:19:32', '2022-09-11 11:19:32'),
(118, 'admin175@gmail.com1', 'أحمد محمد صالح خليلو', NULL, '$2y$10$/h4a3wBkTBN9dHC4nAxDeOPL0QHSXRcc008.Ivu9MCP9qCi3i2S8W', 6, 'administrative employee', NULL, '2022-09-11 11:19:48', '2022-09-11 11:19:48'),
(119, 'admin176@gmail.com1', 'سندس رضا برنيك', NULL, '$2y$10$uzLd.G/GD.V.uucW/pxNcuNZ05jiMSp7LD0qCciy4iMdf5wucKccq', 6, 'administrative employee', NULL, '2022-09-11 11:20:24', '2022-09-11 11:20:24'),
(120, 'admin177@gmail.com1', 'سماهر علو', NULL, '$2y$10$8cY/TYYy16gjWrRgFvHhkeJUgg/Oxk45PUs6tCWldZmGjLPud2ObW', 6, 'administrative employee', NULL, '2022-09-11 11:20:36', '2022-09-11 11:20:36'),
(121, 'admin178@gmail.com1', 'عواطف محمد', NULL, '$2y$10$GGfIVbmoCduEn.ax7G1o7.Qm4LLPaLUUyS80YJ6qEtVg460TMZOoS', 7, 'administrative employee', NULL, '2022-09-11 11:21:25', '2022-09-11 11:21:25'),
(122, 'admin179@gmail.com1', 'علي خنيسة', NULL, '$2y$10$BwDonupilWIW13ivHTck2ObqYAUbTOPYFRS5Gn.CWRasLzXdcOysa', 6, 'administrative employee', NULL, '2022-09-11 11:22:17', '2022-09-11 11:22:17'),
(123, 'admin180@gmail.com1', 'ريم حسون', NULL, '$2y$10$jQ80wf0LmEKAc6KTqj4yfuRiW47PV/mg0j08.73nB6Rng2ns3c/3O', 6, 'administrative employee', NULL, '2022-09-11 11:22:29', '2022-09-11 11:22:29'),
(124, 'admin181@gmail.com1', 'رشا حميشه', NULL, '$2y$10$326VIBwTcRmSqsqo1NWA1OyfkzhbVtjPsG1v5oIvzdCRkI3kk4/HO', 6, 'administrative employee', NULL, '2022-09-11 11:22:46', '2022-09-11 11:22:46'),
(125, 'admin182@gmail.com1', 'هبة ميا', NULL, '$2y$10$PdyP9tvI0jZcaDWYMHwTqOnHwWvmnf5oIB/X3Ab9b/NB395EtpcB6', 6, 'administrative employee', NULL, '2022-09-11 11:22:59', '2022-09-11 11:22:59'),
(126, 'admin183@gmail.com1', 'همام كاسو', NULL, '$2y$10$cYP8848gD9MWvuGhAJh9mOaCRR/iV2ExIjtmO9utKNcpS1mh722am', 6, 'administrative employee', NULL, '2022-09-11 11:23:10', '2022-09-11 11:23:10'),
(127, 'admin184@gmail.com1', 'نور الكنج', NULL, '$2y$10$.5BwBQKNUMgxWW2iRkZ0R.5PP0w6ygkHKSZBFAGNDevrDr3uu4Zd6', 6, 'administrative employee', NULL, '2022-09-11 11:23:38', '2022-09-11 11:23:38'),
(128, 'admin185@gmail.com1', 'صبا زازو', NULL, '$2y$10$TT6BOQkfPyCO.2MYwSWZJOrmbCYLaZuW8n9HMPF5I1uYmniuRUKFy', 6, 'administrative employee', NULL, '2022-09-11 11:23:54', '2022-09-11 11:23:54'),
(129, 'admin186@gmail.com1', 'ميريام العربجي الصايغ', NULL, '$2y$10$waLs/p5AxJXJ7EQiepyEh.w7dOB9rdzjvSNukS81cangVWCwigAwG', 6, 'administrative employee', NULL, '2022-09-11 11:24:05', '2022-09-11 11:24:05'),
(130, 'admin187@gmail.com1', 'امجد حجار', NULL, '$2y$10$Mej1bTiyy55kmKxXIPqbduBGX6jD8IV3HHi3DBBOb83v4HHjP.Tbe', 6, 'administrative employee', NULL, '2022-09-11 11:24:19', '2022-09-11 11:24:19'),
(131, 'admin188@gmail.com1', 'ايهاب مرشد', NULL, '$2y$10$gadBeXngRJcuzDb4eM8p9uM2aqj0rdt6DNPJxYfsGfioxxA4J3opy', 6, 'administrative employee', NULL, '2022-09-11 11:24:29', '2022-09-11 11:24:29'),
(132, 'admin189@gmail.com1', 'رشا نجمة', NULL, '$2y$10$cxqgd3ZiOx99O1ilEViNCesTZQFEqyajtHqO9qWgR51hVYX4TxVXK', 6, 'administrative employee', NULL, '2022-09-11 11:24:39', '2022-09-11 11:24:39'),
(133, 'admin190@gmail.com1', 'علي سلوم', NULL, '$2y$10$SGnjTKwS4qBNu69VNQttyOMbvtt0UYlUcS4tfOlDhMv/iBAsXwzTm', 10, 'administrative employee', NULL, '2022-09-11 11:25:41', '2022-09-11 11:25:41'),
(134, 'admin191@gmail.com1', 'عبد الحميد حسين', NULL, '$2y$10$Q64QcnW4patcU761j59QxOxm88OpbzFt5LFSsZBqrCErJ9RljKIdK', 8, 'administrative employee', NULL, '2022-09-11 11:27:03', '2022-09-11 11:27:03'),
(135, 'admin192@gmail.com1', 'لينا بدور', NULL, '$2y$10$8JbVd2G9fM1SIDYAbSN7y.WXoFZ9b9ZxtgB3bUvyeKIDiXDrfYsY2', 8, 'administrative employee', NULL, '2022-09-11 11:27:19', '2022-09-11 11:27:19'),
(136, 'admin193@gmail.com1', 'جيهان عرقاوي', NULL, '$2y$10$YkoBh053PUM2GaizDmIkCO3U.62ejeoCv9Jv/9JeqYC.74pS6wEEu', 8, 'administrative employee', NULL, '2022-09-11 11:27:38', '2022-09-11 11:27:38'),
(137, 'admin194@gmail.com1', 'جعفر قبيلي', NULL, '$2y$10$tLKrqxG5p1ohm4VsDKfMiuntZKoX8rvgQtb0OOOGX5kE8qieAjpV2', 8, 'administrative employee', NULL, '2022-09-11 11:27:50', '2022-09-11 11:27:50'),
(138, 'admin195@gmail.com1', 'سونيا صالح', NULL, '$2y$10$fit6ZnnZ0xIUACu8kJ/GT.3vS9L9bL0MAfE.wt8XqT/zFeC90rr6e', 8, 'administrative employee', NULL, '2022-09-11 11:28:08', '2022-09-11 11:28:08'),
(139, 'admin196@gmail.com1', 'دعاء غانم', NULL, '$2y$10$ODta7iV37HYazbJ/LWLtVOJoj5dN9OUV60rauIrlrTEfIpPZqRhw6', 8, 'administrative employee', NULL, '2022-09-11 11:28:22', '2022-09-11 11:28:22'),
(140, 'admin197@gmail.com1', 'ريم عيسى', NULL, '$2y$10$X4zJx0oOudw/ksLmVj03aOYmEYfkzgJXwUJqoSJDDYbUlIrOQtjiW', 8, 'administrative employee', NULL, '2022-09-11 11:28:34', '2022-09-11 11:28:34'),
(141, 'admin198@gmail.com1', 'علا حسن', NULL, '$2y$10$xugUlh0H6AaKCl38uA6Vj.8wD3Lu64Vs2KTex7lJfaAf0H7Ws9CJu', 8, 'administrative employee', NULL, '2022-09-11 11:28:55', '2022-09-11 11:28:55'),
(142, 'admin199@gmail.com1', 'لؤي رستم', NULL, '$2y$10$fOGB8F8Wn/32BlyU7kU9eeoFDlSgyo.1hp4wKQjRuJH8/846UoHnS', 8, 'administrative employee', NULL, '2022-09-11 11:29:24', '2022-09-11 11:29:24'),
(143, 'admin200@gmail.com1', 'ايباء علي', NULL, '$2y$10$LZ67DsBDroaOCOSVM97xyeP8gM0ugL14UZrcgI11k.Ka6AqJTpACS', 8, 'administrative employee', NULL, '2022-09-11 11:29:37', '2022-09-11 11:29:37'),
(144, 'admin201@gmail.com1', 'ايمان خليل', NULL, '$2y$10$5znIDW3BlbX/ios0DmUe2u2Yf7ZkscLhbml2dwPEJ7qKMMQY/2u6K', 8, 'administrative employee', NULL, '2022-09-11 11:29:48', '2022-09-11 11:29:48'),
(145, 'admin202@gmail.com1', 'الحسن ابو عبيد', NULL, '$2y$10$wpWKyqXcPYqsjYHsLUoj2eUoXZ7W0peCUFURTAtXaC64GZA1NCJFm', 8, 'administrative employee', NULL, '2022-09-11 11:29:59', '2022-09-11 11:29:59'),
(146, 'admin203@gmail.com1', 'حيدر خليل', NULL, '$2y$10$uNWpDChabPmzPWgu/247l.LRFpIcs4ZIB976q2CyZjzkNKb7aYN4a', 8, 'administrative employee', NULL, '2022-09-11 11:30:10', '2022-09-11 11:30:10'),
(147, 'admin204@gmail.com1', 'حيان رجب', NULL, '$2y$10$NSlis/DW1hVNz3B8rmsZjOVcaOC0SfU5gpSadxrUDr2r7gH.WnPaO', 8, 'administrative employee', NULL, '2022-09-11 11:30:21', '2022-09-11 11:30:21'),
(148, 'admin205@gmail.com1', 'علي ابو سعيد', NULL, '$2y$10$WmzM3D2A55d5XS.X6D0wXOUFWPCCRSpXV4KNMxk.w.K0h0l5/oq96', 8, 'administrative employee', NULL, '2022-09-11 11:30:34', '2022-09-11 11:30:34'),
(149, 'admin206@gmail.com1', 'محمود احمد', NULL, '$2y$10$T5PzFQSUwvX1DuAdTGYKbuuy2bG2VGiqYGl1nfKQ05FosqDM3xsHK', 8, 'administrative employee', NULL, '2022-09-11 11:30:46', '2022-09-11 11:30:46'),
(150, 'admin207@gmail.com1', 'علاء عليشة', NULL, '$2y$10$mnm6Y/Ju1XaJPGZZcErYjeNUDm5xdXoS1/yeVj3blg4CnwXLZcvYC', 8, 'administrative employee', NULL, '2022-09-11 11:30:59', '2022-09-11 11:30:59'),
(151, 'admin208@gmail.com1', 'يارا علي', NULL, '$2y$10$EwCrzJSPS6uDZsSNf9oIEeiZYzkbHeeQoCySTOM3jfFii2YP6NW3C', 8, 'administrative employee', NULL, '2022-09-11 11:31:11', '2022-09-11 11:31:11'),
(152, 'admin209@gmail.com1', 'حسام رسلان', NULL, '$2y$10$O3J27c1EVG4QYC/fvmK2EeYpy1PAGnpOyjA0jlqXW.VxLzWZDctvq', 8, 'administrative employee', NULL, '2022-09-11 11:31:27', '2022-09-11 11:31:27'),
(153, 'admin210@gmail.com1', 'ليلاس سعيد', NULL, '$2y$10$MMEMIbp2ZzSgbAPEbhHqS.JsXqKVUslvC8tvyNpqwtLxOnl6Zo/vK', 8, 'administrative employee', NULL, '2022-09-11 11:31:41', '2022-09-11 11:31:41'),
(154, 'admin211@gmail.com1', 'الاء البيشيني', NULL, '$2y$10$WXtaxdSXB9/TEQBMZGxoDunH4s0RscD62EUMCXPOsim0ROOsNfw3q', 8, 'administrative employee', NULL, '2022-09-11 11:31:59', '2022-09-11 11:31:59'),
(155, 'admin212@gmail.com1', 'ساره عبدو', NULL, '$2y$10$iPNVeFy6HLVkhGcu8EVsMO.LL6KX.b0mif9OQ0bLQreX67iCWlt2O', 8, 'administrative employee', NULL, '2022-09-11 11:32:10', '2022-09-11 11:32:10'),
(156, 'admin213@gmail.com1', 'باسل معلا', NULL, '$2y$10$HU0MzP3d.Jn/LHfeVMeJS..lwTdHFsZYD3STWISrpL98KHEJn9Scu', 8, 'administrative employee', NULL, '2022-09-11 11:32:28', '2022-09-11 11:32:28'),
(157, 'admin214@gmail.com1', 'اغيد الجلاد', NULL, '$2y$10$CAUeyXKFiWf1paV4JgW7PO9MrTDo61F121WEC79z9wTumJ8Bdiwzq', 8, 'administrative employee', NULL, '2022-09-11 11:32:41', '2022-09-11 11:32:41'),
(158, 'admin215@gmail.com1', 'سامر يوسف', NULL, '$2y$10$TpN/3gOchcDRHQjikF15suQ1LVturrzmkr07CJJ7qL9w2MOYV3Ie6', 8, 'administrative employee', NULL, '2022-09-11 11:32:53', '2022-09-11 11:32:53'),
(159, 'admin216@gmail.com1', 'بيسان يوسف', NULL, '$2y$10$n8Vo50rsIK3XfbqquoXoHOE1XPC5OTK2YHMW/IRgBWF3AJnthsAZW', 8, 'administrative employee', NULL, '2022-09-11 11:33:07', '2022-09-11 11:33:07'),
(160, 'admin217@gmail.com1', 'حسين شعبان', NULL, '$2y$10$kjb2wchWbtgu2a3O9p5zReAp7eYhegOnThvPbikEXBjdoz1r1EAhG', 8, 'administrative employee', NULL, '2022-09-11 11:33:34', '2022-09-11 11:33:34'),
(161, 'admin218@gmail.com1', 'احمد عباس', NULL, '$2y$10$30dFVWyHX32ftif.gYJzd.An2f.ojZ6aJ2yOLvlVVIZdBJ.RqN1X6', 8, 'Master\'s student', NULL, '2022-09-11 11:33:55', '2022-09-11 11:33:55'),
(162, 'admin219@gmail.com1', 'ربا صلوح', NULL, '$2y$10$MGlNGC3Si81me/AoftHXuOjcFJJhJ9cB5qTCcpD56xEolokzQ1GHu', 8, 'Master\'s student', NULL, '2022-09-11 11:34:13', '2022-09-11 11:34:13'),
(163, 'admin220@gmail.com1', 'نعمى عمار', NULL, '$2y$10$6jIfXu/2Fu5mguz.SNRVm.3W2yh1y0F1UJKX1Z2NIFLad8KS0Skg6', 8, 'Master\'s student', NULL, '2022-09-11 11:34:24', '2022-09-11 11:34:24'),
(164, 'admin221@gmail.com1', 'حنين حسن', NULL, '$2y$10$sat7bhhwJlqGl9HltSDFoebMXhXeHpnLk67bYd27JhVHaJ3D1beLa', 8, 'Master\'s student', NULL, '2022-09-11 11:34:38', '2022-09-11 11:34:38'),
(165, 'admin222@gmail.com1', 'ميار حسن', NULL, '$2y$10$ObMHbFUwWrstVB3.TQNAveO58wqu9Rwt89wHhnteO28zavTfNVMgu', 8, 'Master\'s student', NULL, '2022-09-11 11:34:50', '2022-09-11 11:34:50'),
(166, 'admin223@gmail.com1', 'مريم يوسف', NULL, '$2y$10$lmllall7oByIKisvjgiYYO55ZLlEWZOsXvlHTHgYQb/ZK1IAyIDK6', 8, 'Master\'s student', NULL, '2022-09-11 11:35:31', '2022-09-11 11:35:31'),
(167, 'admin224@gmail.com1', 'علي ابراهيم', NULL, '$2y$10$1eZEi2MzGeo3AsDqeLFEeuq3GUT0gcdnhKMiiHU.YGvIaLMion4NW', 8, 'Master\'s student', NULL, '2022-09-11 11:35:47', '2022-09-11 11:35:47'),
(168, 'admin225@gmail.com1', 'اية جمعة', NULL, '$2y$10$ERlLQercxHC0uAUHZIXnJutldjcK6XNYGIIx80Zn8aiffjZJc9fpe', 8, 'Master\'s student', NULL, '2022-09-11 11:36:09', '2022-09-11 11:36:09'),
(169, 'admin226@gmail.com1', 'زينب جمعة', NULL, '$2y$10$SvGPBFePTUHWu1IK86xvq.YH4AnvTKRu3Wq.yJ4N7NeTfEkev.ADm', 8, 'Master\'s student', NULL, '2022-09-11 11:36:21', '2022-09-11 11:36:21'),
(170, 'admin227@gmail.com1', 'لين معلا', NULL, '$2y$10$/wwrx8/pC1hpUlgv800IiegLg4TQuaIExFgUK6.q/bvPx7razNPTi', 8, 'Master\'s student', NULL, '2022-09-11 11:36:33', '2022-09-11 11:36:33'),
(171, 'admin228@gmail.com1', 'اريج صالح', NULL, '$2y$10$/B7yjKjU5/AXyaVF/zH8zec7Qh1pxDPgu2cMtZHNXX9ZuEO9Y1nNq', 8, 'Master\'s student', NULL, '2022-09-11 11:36:43', '2022-09-11 11:36:43'),
(172, 'admin229@gmail.com1', 'اروى فاهود', NULL, '$2y$10$/bXWGYlTN0hq4v4UkpQNbu6EM1hOqQUdEDmtlfJIQryr/F4tTxDA2', 8, 'Master\'s student', NULL, '2022-09-11 11:36:58', '2022-09-11 11:36:58'),
(173, 'admin230@gmail.com1', 'عزام حبيب', NULL, '$2y$10$tXZWy8btbCXZOtBhzzxQBOKyEVSVvhOrwYrCKWpzce0t5smUhlVby', 8, 'Master\'s student', NULL, '2022-09-11 11:37:10', '2022-09-11 11:37:10'),
(174, 'admin231@gmail.com1', 'رنا سقور', NULL, '$2y$10$0pDQU/LJFabpaMBmRm5IVu0yvFYXuQtb/oNJSEjZD2rYJ.AxvGp2S', 8, 'Master\'s student', NULL, '2022-09-11 11:37:26', '2022-09-11 11:37:26'),
(175, 'admin232@gmail.com1', 'سامر يونس', NULL, '$2y$10$3ADwwglmEaupLd9smgwcse8CFJm1AID37Rp9kzeF0YXBqHh8.3mMS', 8, 'Master\'s student', NULL, '2022-09-11 11:37:39', '2022-09-11 11:37:39'),
(176, 'admin233@gmail.com1', 'ناجي ديوب', NULL, '$2y$10$mk9kyXTmvx7o.s8nXTwwcOmfLyFHtXlXTrs8pWm2xfZUs562XxIIS', 8, 'Master\'s student', NULL, '2022-09-11 11:37:48', '2022-09-11 11:37:48'),
(177, 'admin234@gmail.com1', 'مي ناصر', NULL, '$2y$10$1NWeDrPqb4JTRFnldi2aBeW8ImwfcjzFI.8fdgazW9IlglERpxbB.', 8, 'Master\'s student', NULL, '2022-09-11 11:38:01', '2022-09-11 11:38:01'),
(178, 'admin235@gmail.com1', 'ميري بشارة', NULL, '$2y$10$RDZzYOT.no5eVP3wifs1ou55DbIkRaIa.0XRMkQ09wuocHl9ZXvMS', 8, 'Master\'s student', NULL, '2022-09-11 11:38:17', '2022-09-11 11:38:17'),
(179, 'admin236@gmail.com1', 'الاء معروف', NULL, '$2y$10$oLERTGg0aOzAicWtYHF4dulqxfSFWHm4lYzARMf/c.Fi4TPouwm12', 8, 'Master\'s student', NULL, '2022-09-11 11:38:34', '2022-09-11 11:38:34'),
(180, 'admin237@gmail.com1', 'حازم محمد', NULL, '$2y$10$UKs0KOp3tRY/CqRZf/thgOyCcTsxuAm3YQIpBrFNxxbG3IDV70oR2', 8, 'Master\'s student', NULL, '2022-09-11 11:38:42', '2022-09-11 11:38:42'),
(181, 'admin238@gmail.com1', 'فراس حمدان', NULL, '$2y$10$2QJOj1jCmtaAUJFxpJIa6etc0kveJRkTPniqZC5Iutd42Q4Ew0c5K', 8, 'Master\'s student', NULL, '2022-09-11 11:38:53', '2022-09-11 11:38:53'),
(182, 'admin239@gmail.com1', 'جورج لاذية', NULL, '$2y$10$hAWRctLmp58xxNYU0D8Ff.OXqLKgQb2Qv6tXgbQBhQMloyuqmnsjO', 8, 'Master\'s student', NULL, '2022-09-11 11:39:03', '2022-09-11 11:39:03'),
(183, 'admin240@gmail.com1', 'مرح دريوسي', NULL, '$2y$10$vZsuZ9KB5TlSArZ.WGqVVutwCbzwNyA00dT3JT0ePi07517ig/N.a', 8, 'Master\'s student', NULL, '2022-09-11 11:39:15', '2022-09-11 11:39:15'),
(184, 'admin241@gmail.com1', 'ريما ابراهيم', NULL, '$2y$10$6YZcdlzlfGfUQZPT9SLqhOiitOUe4KQt00ZP1nu35ef5NBMBs7nY.', 8, 'Master\'s student', NULL, '2022-09-11 11:39:27', '2022-09-11 11:39:27'),
(185, 'admin242@gmail.com1', 'ربا الحاطوم', NULL, '$2y$10$lOCB2xOWTIY6jgN/QciCaOZNVvVXi7Dugu5yzGeegmuzFJxn3b83y', 8, 'Master\'s student', NULL, '2022-09-11 11:39:43', '2022-09-11 11:39:43'),
(186, 'admin243@gmail.com1', 'سجى هاشم', NULL, '$2y$10$WPI69svzFbILRbwoXOVJf.rnqLMoktNC5kwcaE3hOYwA952V4YKTC', 8, 'Master\'s student', NULL, '2022-09-11 11:39:56', '2022-09-11 11:39:56'),
(187, 'admin244@gmail.com1', 'لمى العبد الله', NULL, '$2y$10$mziR8FUcyfei12Cw3YDgzeYCQHUQ4KFNls2AlceTeyUmMkD7W3uRi', 8, 'Master\'s student', NULL, '2022-09-11 11:40:21', '2022-09-11 11:40:21'),
(188, 'admin245@gmail.com1', 'غيثاء غدير', NULL, '$2y$10$ndxBXjKFv6FdrAAJNaki3.ZfO6ae2VyvTRQIuwJdm.x9Vte/bHGvS', 8, 'Master\'s student', NULL, '2022-09-11 11:40:33', '2022-09-11 11:40:33'),
(189, 'admin246@gmail.com1', 'مرح العيسى', NULL, '$2y$10$oeu4QxMwW3CdkxyeyRjtPeW6Bwu3kp7I9qz9xqzR1KMOIOzWDs53K', 8, 'Master\'s student', NULL, '2022-09-11 11:40:47', '2022-09-11 11:40:47'),
(190, 'admin247@gmail.com1', 'انتصار ابراهيم', NULL, '$2y$10$DlxvreB6mLvJkX7DmXkR2u4KMtxhSHH/LJQL1JpPtzlgGC/sBe82i', 6, 'administrative employee', NULL, '2022-09-11 11:41:59', '2022-09-11 11:41:59'),
(191, 'admin248@gmail.com1', 'رنجس طه', NULL, '$2y$10$cU6OATAl3eo4Z32XqejBv.CxMh3Lo7RmeDKNwWMnaVtPOLtd4MO.i', 6, 'Master\'s student', NULL, '2022-09-11 11:42:18', '2022-09-11 11:42:18'),
(192, 'admin249@gmail.com1', 'سولين زيني', NULL, '$2y$10$PUQvWOPItEBaq82EBNatCepN9i35DZdYIAH7yW2eguv4FFc632hZm', 6, 'Master\'s student', NULL, '2022-09-11 11:42:32', '2022-09-11 11:42:32'),
(193, 'admin250@gmail.com1', 'سحر فياض', NULL, '$2y$10$F7HL7SwTz7cvXKMkVKEz3u5R85vCE5UcCE7SQ7yOXHPcLTTGpmNLi', 6, 'Master\'s student', NULL, '2022-09-11 11:42:44', '2022-09-11 11:42:44'),
(194, 'admin251@gmail.com1', 'علاء حايك', NULL, '$2y$10$XIBaCRijdBUelrzOpiFbIOEmAEMBB4cE4X/RsycWSvlPPHsYzReue', 6, 'Master\'s student', NULL, '2022-09-11 11:42:55', '2022-09-11 11:42:55'),
(195, 'admin252@gmail.com1', 'بشرى تويتي', NULL, '$2y$10$zGDscJ3klAFJXrS3T2DIgeIBR1d7dYzjOC2vOPL.MsNUh3bxZsY0u', 6, 'Master\'s student', NULL, '2022-09-11 11:43:06', '2022-09-11 11:43:06'),
(196, 'admin253@gmail.com1', 'بشرى زهير حسن', NULL, '$2y$10$shL3BHeZxdOpp8GAiLp3weafz3nRxcbPPtJjYdtdJ7oqu65kP.F5u', 6, 'Master\'s student', NULL, '2022-09-11 11:43:16', '2022-09-11 11:43:16'),
(197, 'admin254@gmail.com1', 'ميساء التزه', NULL, '$2y$10$bS.s.fS3o8bHYJvZNCrBZeVagOYxS83LSaILxuarhwhf7xt.S61/e', 6, 'Master\'s student', NULL, '2022-09-11 11:43:26', '2022-09-11 11:43:26'),
(198, 'admin255@gmail.com1', 'بشرى ابراهيم', NULL, '$2y$10$hJeCj5urzVQTvRwNklLzQe3onhqs5KrcMOgYxgG6bWgUSnTO4cDP.', 6, 'Master\'s student', NULL, '2022-09-11 11:43:37', '2022-09-11 11:43:37'),
(199, 'admin256@gmail.com1', 'رشا عثمان', NULL, '$2y$10$i1pxGdUNMBtN6fdl5jTP4.B/glKGGA09K.XlpS.ojDz1V.oCCOIz6', 6, 'Master\'s student', NULL, '2022-09-11 11:43:48', '2022-09-11 11:43:48'),
(200, 'admin257@gmail.com1', 'وسيلة سليم', NULL, '$2y$10$TN7izS9oKrKvQIy4bs28T.zDXDyHw3UNsiQN90z37jeILRrBSBX/W', 6, 'Master\'s student', NULL, '2022-09-11 11:44:01', '2022-09-11 11:44:01'),
(201, 'admin258@gmail.com1', 'امل كنجو', NULL, '$2y$10$Vs8jM5rhJ63EpaeHtpxNDegfSwzwAVu3j4ZX6aC883aDPvKVjEfQm', 6, 'Master\'s student', NULL, '2022-09-11 11:44:16', '2022-09-11 11:44:16'),
(202, 'admin259@gmail.com1', 'هيا سلوم', NULL, '$2y$10$GxMfcksG8bMRw8sjs64aJ.Maan3ojpzi8ZwYBAZ61YeyYFOqe7E2O', 6, 'Master\'s student', NULL, '2022-09-11 11:44:30', '2022-09-11 11:44:30'),
(203, 'admin260@gmail.com1', 'سوار غنيجة', NULL, '$2y$10$hMBjhMdoaI8tvzcOyNrf9euX/k/Z2N4agELEczyaT/WjAoGyyBSB6', 6, 'Master\'s student', NULL, '2022-09-11 11:44:44', '2022-09-11 11:44:44'),
(204, 'admin261@gmail.com1', 'رشا عامودي', NULL, '$2y$10$zU7GxHnQCAuhODPs1bnyau54Pu3g7MfqJ6.GFdnxNiWNhtsFLLs2y', 6, 'Master\'s student', NULL, '2022-09-11 11:44:55', '2022-09-11 11:44:55'),
(205, 'admin262@gmail.com1', 'غدير احمد', NULL, '$2y$10$XtcM29umlhCvYP9muz8.FOo778FGP8jGMA2Ilr5ABagwGozUteIFu', 6, 'Master\'s student', NULL, '2022-09-11 11:45:06', '2022-09-11 11:45:06'),
(206, 'admin263@gmail.com1', 'علي صلاح', NULL, '$2y$10$2yuyMQX8oTpgeO//eHWvbed5lx/03c.Uz4fKTcbgT3bJ4j16gZCt2', 6, 'Master\'s student', NULL, '2022-09-11 11:45:19', '2022-09-11 11:45:19'),
(207, 'admin264@gmail.com1', 'فريال مهنا', NULL, '$2y$10$ejvm6FEy.hnmnDEqFI23veEWZnXG7KWKjk7bieCacV3IsnbvqqU4u', 6, 'administrative employee', NULL, '2022-09-11 11:45:33', '2022-09-11 11:45:33'),
(208, 'admin265@gmail.com1', 'فيحاء احمد', NULL, '$2y$10$HzJTdDxQY4HWgX8oSEyITOYzXdhNjtPUZN.AfrwnZ/kvHA4.QDZay', 6, 'administrative employee', NULL, '2022-09-11 11:45:47', '2022-09-11 11:45:47'),
(209, 'admin266@gmail.com1', 'خلود بعيتي', NULL, '$2y$10$etVxJhZeC5gyVTJh0s5gxOwPAAcoHoTDt1KzmUMGaTBQaka.hFky6', 6, 'administrative employee', NULL, '2022-09-11 11:46:02', '2022-09-11 11:46:02'),
(210, 'admin267@gmail.com1', 'بشرى شبيب', NULL, '$2y$10$0umsH6JVQ8q.272fdSvTyuE.gKMEsgMS7128pVskN/aJLjHjLTj8.', 6, 'administrative employee', NULL, '2022-09-11 11:46:15', '2022-09-11 11:46:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_room_user`
--
ALTER TABLE `course_room_user`
  ADD PRIMARY KEY (`course_id`,`room_id`,`user_id`),
  ADD KEY `course_room_user_room_id_foreign` (`room_id`),
  ADD KEY `course_room_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `objections`
--
ALTER TABLE `objections`
  ADD PRIMARY KEY (`user_id`,`date`,`time`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1112;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_room_user`
--
ALTER TABLE `course_room_user`
  ADD CONSTRAINT `course_room_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_room_user_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_room_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `objections`
--
ALTER TABLE `objections`
  ADD CONSTRAINT `objections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `course_room_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
