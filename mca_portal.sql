-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2025 at 09:26 PM
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
-- Database: `mca_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `year_name`, `start_date`, `end_date`, `is_current`, `is_archived`, `created_at`, `updated_at`) VALUES
(1, '2018-2019', '2018-06-01', '2019-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(2, '2019-2020', '2019-06-01', '2020-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(3, '2020-2021', '2020-06-01', '2021-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(4, '2021-2022', '2021-06-01', '2022-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(5, '2022-2023', '2022-06-01', '2023-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(6, '2023-2024', '2023-06-01', '2024-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(7, '2024-2025', '2024-06-01', '2025-05-31', 0, 1, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(8, '2025-2026', '2025-06-01', '2026-05-31', 1, 0, '2025-10-12 07:28:19', '2025-10-12 07:28:19'),
(9, '2026-2027', '2026-06-01', '2027-05-31', 0, 0, '2025-10-12 07:28:19', '2025-10-12 07:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `archived_attendance`
--

CREATE TABLE `archived_attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `archived_student_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','excused') NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_grades`
--

CREATE TABLE `archived_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `archived_student_id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `subject_code` varchar(255) DEFAULT NULL,
  `first_quarter` decimal(5,2) DEFAULT NULL,
  `second_quarter` decimal(5,2) DEFAULT NULL,
  `third_quarter` decimal(5,2) DEFAULT NULL,
  `fourth_quarter` decimal(5,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archived_students`
--

CREATE TABLE `archived_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `original_student_id` bigint(20) UNSIGNED NOT NULL,
  `school_student_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `lrn` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `grade_level_id` int(11) NOT NULL,
  `grade_level_name` varchar(255) NOT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `strand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `strand_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_enrolled` date DEFAULT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archive_logs`
--

CREATE TABLE `archive_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `students_count` int(11) DEFAULT NULL,
  `performed_by` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `archive_logs`
--

INSERT INTO `archive_logs` (`id`, `academic_year`, `action`, `students_count`, `performed_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, '2025-2026', 'export_data', 11, 1, 'Exported 11 students for 2025-2026', '2025-10-12 08:16:58', '2025-10-12 08:16:58'),
(2, 'current', 'export_data', 11, 1, 'Exported 11 students for current', '2025-10-12 08:23:33', '2025-10-12 08:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_class_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `instructor_class_id`, `student_id`, `date`, `status`, `time_in`, `time_out`, `created_at`, `updated_at`) VALUES
(1, 201, 1001, '2025-10-03', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(2, 201, 1002, '2025-10-03', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(3, 202, 1001, '2025-10-03', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(4, 202, 1002, '2025-10-03', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(5, 203, 13, '2025-10-03', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:42:48'),
(6, 203, 1003, '2025-10-03', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:42:48'),
(7, 201, 1001, '2025-10-02', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(8, 201, 1002, '2025-10-02', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(9, 202, 1001, '2025-10-02', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(10, 202, 1002, '2025-10-02', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(11, 203, 13, '2025-10-02', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(12, 203, 1003, '2025-10-02', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(13, 201, 1001, '2025-10-01', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(14, 201, 1002, '2025-10-01', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(15, 202, 1001, '2025-10-01', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(16, 202, 1002, '2025-10-01', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(17, 203, 13, '2025-10-01', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(18, 203, 1003, '2025-10-01', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(19, 201, 1001, '2025-09-30', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(20, 201, 1002, '2025-09-30', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(21, 202, 1001, '2025-09-30', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(22, 202, 1002, '2025-09-30', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(23, 203, 13, '2025-09-30', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(24, 203, 1003, '2025-09-30', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(25, 201, 1001, '2025-09-29', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(26, 201, 1002, '2025-09-29', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(27, 202, 1001, '2025-09-29', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(28, 202, 1002, '2025-09-29', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(29, 203, 13, '2025-09-29', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(30, 203, 1003, '2025-09-29', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(31, 201, 1001, '2025-09-28', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(32, 201, 1002, '2025-09-28', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(33, 202, 1001, '2025-09-28', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(34, 202, 1002, '2025-09-28', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(35, 203, 13, '2025-09-28', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(36, 203, 1003, '2025-09-28', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(37, 201, 1001, '2025-09-27', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(38, 201, 1002, '2025-09-27', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(39, 202, 1001, '2025-09-27', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(40, 202, 1002, '2025-09-27', 'late', '08:30:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(41, 203, 13, '2025-09-27', 'absent', NULL, NULL, '2025-10-03 08:14:03', '2025-10-03 08:14:03'),
(42, 203, 1003, '2025-09-27', 'present', '08:00:00', '15:00:00', '2025-10-03 08:14:03', '2025-10-03 08:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `grade_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `strand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `semester` enum('1st','2nd') DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `created_at`, `updated_at`, `code`, `subject_id`, `grade_level_id`, `strand_id`, `section_id`, `section_name`, `semester`, `room`) VALUES
(101, 'Math 7-Diamond', '2025-10-02 11:11:49', '2025-10-03 07:28:20', 'M7D', 1, 7, NULL, 1, NULL, NULL, 'R101'),
(102, 'English 7-Diamond', '2025-10-02 11:11:49', '2025-10-03 07:28:20', 'E7D', 2, 7, NULL, 1, NULL, NULL, 'R102'),
(103, 'Science 8-Emerald', '2025-10-02 11:11:49', '2025-10-03 07:28:20', 'S8E', 3, 8, NULL, 3, NULL, NULL, 'R201'),
(104, 'Math 9-Ruby', '2025-10-03 20:35:40', '2025-10-03 20:35:40', 'M9R', 1, 7, NULL, 1, NULL, '1st', 'R300'),
(105, 'English 9-Ruby', '2025-10-03 20:35:40', '2025-10-03 20:35:40', 'E9R', 2, 8, NULL, 2, NULL, '1st', 'R301'),
(106, 'Science 9-Ruby', '2025-10-03 20:35:40', '2025-10-03 20:35:40', 'S9R', 3, 7, NULL, 3, NULL, '1st', 'R302'),
(107, 'Math 10-Sapphire', '2025-10-03 20:35:40', '2025-10-03 20:35:40', 'M10S', 1, 8, NULL, 1, NULL, '1st', 'R303'),
(108, 'English 10-Sapphire', '2025-10-03 20:35:40', '2025-10-03 20:35:40', 'E10S', 2, 7, NULL, 2, NULL, '1st', 'R304'),
(109, 'Science 10-Sapphire', '2025-10-03 20:35:40', '2025-10-03 20:35:40', 'S10S', 3, 8, NULL, 3, NULL, '1st', 'R305'),
(113, 'Mathematics - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-4', 1, 7, NULL, 4, NULL, '1st', 'TBA'),
(114, 'English - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-4', 2, 7, NULL, 4, NULL, '1st', 'TBA'),
(115, 'Science - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-4', 3, 7, NULL, 4, NULL, '1st', 'TBA'),
(116, 'Filipino - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-4', 4, 7, NULL, 4, NULL, '1st', 'TBA'),
(117, 'Social Studies - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-4', 5, 7, NULL, 4, NULL, '1st', 'TBA'),
(118, 'Araling Panlipunan - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-4', 6, 7, NULL, 4, NULL, '1st', 'TBA'),
(119, 'MAPEH - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-4', 7, 7, NULL, 4, NULL, '1st', 'TBA'),
(120, 'TLE - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-4', 8, 7, NULL, 4, NULL, '1st', 'TBA'),
(121, 'CISCO - asd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-4', 10, 7, NULL, 4, NULL, '1st', 'TBA'),
(122, 'Mathematics - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-5', 1, 9, NULL, 5, NULL, '1st', 'TBA'),
(123, 'English - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-5', 2, 9, NULL, 5, NULL, '1st', 'TBA'),
(124, 'Science - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-5', 3, 9, NULL, 5, NULL, '1st', 'TBA'),
(125, 'Filipino - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-5', 4, 9, NULL, 5, NULL, '1st', 'TBA'),
(126, 'Social Studies - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-5', 5, 9, NULL, 5, NULL, '1st', 'TBA'),
(127, 'Araling Panlipunan - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-5', 6, 9, NULL, 5, NULL, '1st', 'TBA'),
(128, 'MAPEH - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-5', 7, 9, NULL, 5, NULL, '1st', 'TBA'),
(129, 'TLE - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-5', 8, 9, NULL, 5, NULL, '1st', 'TBA'),
(130, 'CISCO - Grade 9 - Gold', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-5', 10, 9, NULL, 5, NULL, '1st', 'TBA'),
(131, 'Mathematics - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-7', 1, 11, NULL, 7, NULL, '1st', 'TBA'),
(132, 'English - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-7', 2, 11, NULL, 7, NULL, '1st', 'TBA'),
(133, 'Science - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-7', 3, 11, NULL, 7, NULL, '1st', 'TBA'),
(134, 'Filipino - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-7', 4, 11, NULL, 7, NULL, '1st', 'TBA'),
(135, 'Social Studies - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-7', 5, 11, NULL, 7, NULL, '1st', 'TBA'),
(136, 'Araling Panlipunan - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-7', 6, 11, NULL, 7, NULL, '1st', 'TBA'),
(137, 'MAPEH - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-7', 7, 11, NULL, 7, NULL, '1st', 'TBA'),
(138, 'TLE - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-7', 8, 11, NULL, 7, NULL, '1st', 'TBA'),
(139, 'CISCO - Grade 11 - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-7', 10, 11, NULL, 7, NULL, '1st', 'TBA'),
(140, 'Mathematics - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-8', 1, 12, 4, 8, NULL, '1st', 'TBA'),
(141, 'English - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-8', 2, 12, 4, 8, NULL, '1st', 'TBA'),
(142, 'Science - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-8', 3, 12, 4, 8, NULL, '1st', 'TBA'),
(143, 'Filipino - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-8', 4, 12, 4, 8, NULL, '1st', 'TBA'),
(144, 'Social Studies - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-8', 5, 12, 4, 8, NULL, '1st', 'TBA'),
(145, 'Araling Panlipunan - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-8', 6, 12, 4, 8, NULL, '1st', 'TBA'),
(146, 'MAPEH - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-8', 7, 12, 4, 8, NULL, '1st', 'TBA'),
(147, 'TLE - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-8', 8, 12, 4, 8, NULL, '1st', 'TBA'),
(148, 'CISCO - Grade 12 - GAS - Section A', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-8', 10, 12, 4, 8, NULL, '1st', 'TBA'),
(149, 'Mathematics - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-9', 1, 10, NULL, 9, NULL, '1st', 'TBA'),
(150, 'English - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-9', 2, 10, NULL, 9, NULL, '1st', 'TBA'),
(151, 'Science - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-9', 3, 10, NULL, 9, NULL, '1st', 'TBA'),
(152, 'Filipino - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-9', 4, 10, NULL, 9, NULL, '1st', 'TBA'),
(153, 'Social Studies - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-9', 5, 10, NULL, 9, NULL, '1st', 'TBA'),
(154, 'Araling Panlipunan - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-9', 6, 10, NULL, 9, NULL, '1st', 'TBA'),
(155, 'MAPEH - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-9', 7, 10, NULL, 9, NULL, '1st', 'TBA'),
(156, 'TLE - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-9', 8, 10, NULL, 9, NULL, '1st', 'TBA'),
(157, 'CISCO - Rizal', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-9', 10, 10, NULL, 9, NULL, '1st', 'TBA'),
(158, 'Mathematics - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-10', 1, 10, NULL, 10, NULL, '1st', 'TBA'),
(159, 'English - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-10', 2, 10, NULL, 10, NULL, '1st', 'TBA'),
(160, 'Science - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-10', 3, 10, NULL, 10, NULL, '1st', 'TBA'),
(161, 'Filipino - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-10', 4, 10, NULL, 10, NULL, '1st', 'TBA'),
(162, 'Social Studies - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-10', 5, 10, NULL, 10, NULL, '1st', 'TBA'),
(163, 'Araling Panlipunan - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-10', 6, 10, NULL, 10, NULL, '1st', 'TBA'),
(164, 'MAPEH - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-10', 7, 10, NULL, 10, NULL, '1st', 'TBA'),
(165, 'TLE - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-10', 8, 10, NULL, 10, NULL, '1st', 'TBA'),
(166, 'CISCO - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-10', 10, 10, NULL, 10, NULL, '1st', 'TBA'),
(167, 'Mathematics - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-12', 1, 8, NULL, 12, NULL, '1st', 'TBA'),
(168, 'English - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-12', 2, 8, NULL, 12, NULL, '1st', 'TBA'),
(169, 'Science - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-12', 3, 8, NULL, 12, NULL, '1st', 'TBA'),
(170, 'Filipino - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-12', 4, 8, NULL, 12, NULL, '1st', 'TBA'),
(171, 'Social Studies - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-12', 5, 8, NULL, 12, NULL, '1st', 'TBA'),
(172, 'Araling Panlipunan - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-12', 6, 8, NULL, 12, NULL, '1st', 'TBA'),
(173, 'MAPEH - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-12', 7, 8, NULL, 12, NULL, '1st', 'TBA'),
(174, 'TLE - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-12', 8, 8, NULL, 12, NULL, '1st', 'TBA'),
(175, 'CISCO - Zaldy', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-12', 10, 8, NULL, 12, NULL, '1st', 'TBA'),
(176, 'Mathematics - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAT-13', 1, 9, NULL, 13, NULL, '1st', 'TBA'),
(177, 'English - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ENG-13', 2, 9, NULL, 13, NULL, '1st', 'TBA'),
(178, 'Science - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SCI-13', 3, 9, NULL, 13, NULL, '1st', 'TBA'),
(179, 'Filipino - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'FIL-13', 4, 9, NULL, 13, NULL, '1st', 'TBA'),
(180, 'Social Studies - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'SOC-13', 5, 9, NULL, 13, NULL, '1st', 'TBA'),
(181, 'Araling Panlipunan - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'ARA-13', 6, 9, NULL, 13, NULL, '1st', 'TBA'),
(182, 'MAPEH - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'MAP-13', 7, 9, NULL, 13, NULL, '1st', 'TBA'),
(183, 'TLE - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'TLE-13', 8, 9, NULL, 13, NULL, '1st', 'TBA'),
(184, 'CISCO - ddd', '2025-10-12 10:42:46', '2025-10-12 10:42:46', 'CIS-13', 10, 9, NULL, 13, NULL, '1st', 'TBA'),
(185, 'Mathematics - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'MAT-14', 1, 10, NULL, 14, NULL, '1st', 'TBA'),
(186, 'English - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'ENG-14', 2, 10, NULL, 14, NULL, '1st', 'TBA'),
(187, 'Science - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'SCI-14', 3, 10, NULL, 14, NULL, '1st', 'TBA'),
(188, 'Filipino - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'FIL-14', 4, 10, NULL, 14, NULL, '1st', 'TBA'),
(189, 'Social Studies - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'SOC-14', 5, 10, NULL, 14, NULL, '1st', 'TBA'),
(190, 'Araling Panlipunan - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'ARA-14', 6, 10, NULL, 14, NULL, '1st', 'TBA'),
(191, 'MAPEH - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'MAP-14', 7, 10, NULL, 14, NULL, '1st', 'TBA'),
(192, 'TLE - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'TLE-14', 8, 10, NULL, 14, NULL, '1st', 'TBA'),
(193, 'CISCO - BBBB', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'CIS-14', 10, 10, NULL, 14, NULL, '1st', 'TBA'),
(194, 'Mathematics - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'MAT-15', 1, 7, NULL, 15, NULL, '1st', 'TBA'),
(195, 'English - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'ENG-15', 2, 7, NULL, 15, NULL, '1st', 'TBA'),
(196, 'Science - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'SCI-15', 3, 7, NULL, 15, NULL, '1st', 'TBA'),
(197, 'Filipino - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'FIL-15', 4, 7, NULL, 15, NULL, '1st', 'TBA'),
(198, 'Social Studies - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'SOC-15', 5, 7, NULL, 15, NULL, '1st', 'TBA'),
(199, 'Araling Panlipunan - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'ARA-15', 6, 7, NULL, 15, NULL, '1st', 'TBA'),
(200, 'MAPEH - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'MAP-15', 7, 7, NULL, 15, NULL, '1st', 'TBA'),
(201, 'TLE - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'TLE-15', 8, 7, NULL, 15, NULL, '1st', 'TBA'),
(202, 'CISCO - Tttttt', '2025-10-12 10:42:47', '2025-10-12 10:42:47', 'CIS-15', 10, 7, NULL, 15, NULL, '1st', 'TBA'),
(203, 'Mathematics - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'MAT-16', 1, 10, NULL, 16, NULL, '1st', 'TBA'),
(204, 'English - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'ENG-16', 2, 10, NULL, 16, NULL, '1st', 'TBA'),
(205, 'Science - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'SCI-16', 3, 10, NULL, 16, NULL, '1st', 'TBA'),
(206, 'Filipino - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'FIL-16', 4, 10, NULL, 16, NULL, '1st', 'TBA'),
(207, 'Social Studies - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'SOC-16', 5, 10, NULL, 16, NULL, '1st', 'TBA'),
(208, 'Araling Panlipunan - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'ARA-16', 6, 10, NULL, 16, NULL, '1st', 'TBA'),
(209, 'MAPEH - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'MAP-16', 7, 10, NULL, 16, NULL, '1st', 'TBA'),
(210, 'TLE - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'TLE-16', 8, 10, NULL, 16, NULL, '1st', 'TBA'),
(211, 'CISCO - Saitama', '2025-10-12 10:50:41', '2025-10-12 10:50:41', 'CIS-16', 10, 10, NULL, 16, NULL, '1st', 'TBA'),
(212, 'Mathematics - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'MAT-17', 1, 10, NULL, 17, NULL, '1st', 'TBA'),
(213, 'English - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'ENG-17', 2, 10, NULL, 17, NULL, '1st', 'TBA'),
(214, 'Science - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'SCI-17', 3, 10, NULL, 17, NULL, '1st', 'TBA'),
(215, 'Filipino - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'FIL-17', 4, 10, NULL, 17, NULL, '1st', 'TBA'),
(216, 'Social Studies - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'SOC-17', 5, 10, NULL, 17, NULL, '1st', 'TBA'),
(217, 'Araling Panlipunan - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'ARA-17', 6, 10, NULL, 17, NULL, '1st', 'TBA'),
(218, 'MAPEH - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'MAP-17', 7, 10, NULL, 17, NULL, '1st', 'TBA'),
(219, 'TLE - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'TLE-17', 8, 10, NULL, 17, NULL, '1st', 'TBA'),
(220, 'CISCO - Genos', '2025-10-12 10:51:27', '2025-10-12 10:51:27', 'CIS-17', 10, 10, NULL, 17, NULL, '1st', 'TBA'),
(239, 'Mathematics - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'MAT-22', 1, 10, NULL, 22, NULL, '1st', 'TBA'),
(240, 'English - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'ENG-22', 2, 10, NULL, 22, NULL, '1st', 'TBA'),
(241, 'Science - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'SCI-22', 3, 10, NULL, 22, NULL, '1st', 'TBA'),
(242, 'Filipino - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'FIL-22', 4, 10, NULL, 22, NULL, '1st', 'TBA'),
(243, 'Social Studies - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'SOC-22', 5, 10, NULL, 22, NULL, '1st', 'TBA'),
(244, 'Araling Panlipunan - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'ARA-22', 6, 10, NULL, 22, NULL, '1st', 'TBA'),
(245, 'MAPEH - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'MAP-22', 7, 10, NULL, 22, NULL, '1st', 'TBA'),
(246, 'TLE - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'TLE-22', 8, 10, NULL, 22, NULL, '1st', 'TBA'),
(247, 'CISCO - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'CIS-22', 10, 10, NULL, 22, NULL, '1st', 'TBA'),
(248, 'Mathematics - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'MAT-22', 1, 10, NULL, 22, NULL, '1st', 'TBA'),
(249, 'English - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'ENG-22', 2, 10, NULL, 22, NULL, '1st', 'TBA'),
(250, 'Science - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'SCI-22', 3, 10, NULL, 22, NULL, '1st', 'TBA'),
(251, 'Filipino - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'FIL-22', 4, 10, NULL, 22, NULL, '1st', 'TBA'),
(252, 'Social Studies - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'SOC-22', 5, 10, NULL, 22, NULL, '1st', 'TBA'),
(253, 'Araling Panlipunan - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'ARA-22', 6, 10, NULL, 22, NULL, '1st', 'TBA'),
(254, 'MAPEH - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'MAP-22', 7, 10, NULL, 22, NULL, '1st', 'TBA'),
(255, 'TLE - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'TLE-22', 8, 10, NULL, 22, NULL, '1st', 'TBA'),
(256, 'CISCO - Tatsumaki', '2025-10-12 11:18:33', '2025-10-12 11:18:33', 'CIS-22', 10, 10, NULL, 22, NULL, '1st', 'TBA');

-- --------------------------------------------------------

--
-- Table structure for table `class_announcements`
--

CREATE TABLE `class_announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_announcements`
--

INSERT INTO `class_announcements` (`id`, `class_name`, `title`, `message`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 'Science 8-Emerald', 'asdasdasd', 'asdasdasdasdasdasdasd', 'announcements/Abo2n8PwipyoS2UdlW7fYKWdyR2Yk3kkWBjmknJ9.png', '2025-10-03 08:09:50', '2025-10-03 08:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `core_values`
--

CREATE TABLE `core_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `core_values`
--

INSERT INTO `core_values` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Makadiyos', 'makadiyos', '2025-09-30 07:35:20', '2025-09-30 07:35:20'),
(2, 'Makatao', 'makatao', '2025-09-30 07:35:20', '2025-09-30 07:35:20'),
(3, 'Makakalikasan', 'makakalikasan', '2025-09-30 07:35:20', '2025-09-30 07:35:20'),
(4, 'Makabansa', 'makabansa', '2025-09-30 07:35:20', '2025-09-30 07:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `core_value_evaluations`
--

CREATE TABLE `core_value_evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `core_value_id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `submitted` enum('yes','no') NOT NULL DEFAULT 'no',
  `submitted_online` enum('yes','no') NOT NULL DEFAULT 'no',
  `submitted_face_to_face` enum('yes','no') NOT NULL DEFAULT 'no',
  `document_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester` varchar(255) NOT NULL,
  `grade_level` enum('junior','senior') NOT NULL,
  `status` enum('new','existing') NOT NULL,
  `strand` enum('hss','stem','gas','he','ict','abm') NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `dob` date NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, '5740c387-2d81-4dcc-a878-580bd1488316', 'database', 'default', '{\"uuid\":\"5740c387-2d81-4dcc-a878-580bd1488316\",\"displayName\":\"App\\\\Mail\\\\EnrollmentConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":15:{s:8:\\\"mailable\\\";O:31:\\\"App\\\\Mail\\\\EnrollmentConfirmation\\\":3:{s:8:\\\"enrollee\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\NewStudentEnrollee\\\";s:2:\\\"id\\\";i:34;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:21:\\\"arniegabuya@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\"}}', 'Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\NewStudentEnrollee]. in C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Database\\Eloquent\\Builder.php:689\nStack trace:\n#0 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\SerializesAndRestoresModelIdentifiers.php(110): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\SerializesAndRestoresModelIdentifiers.php(63): App\\Mail\\EnrollmentConfirmation->restoreModel(Object(Illuminate\\Contracts\\Database\\ModelIdentifier))\n#2 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\SerializesModels.php(93): App\\Mail\\EnrollmentConfirmation->getRestoredPropertyValue(Object(Illuminate\\Contracts\\Database\\ModelIdentifier))\n#3 [internal function]: App\\Mail\\EnrollmentConfirmation->__unserialize(Array)\n#4 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(96): unserialize(\'O:34:\"Illuminat...\')\n#5 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(63): Illuminate\\Queue\\CallQueuedHandler->getCommand(Array)\n#6 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#7 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Jobs\\Job->fire()\n#8 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(392): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#9 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(335): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#10 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(149): Illuminate\\Queue\\Worker->runNextJob(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#11 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(132): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#12 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#13 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#15 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#16 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#17 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call(Array)\n#18 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#19 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#20 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\symfony\\console\\Application.php(1094): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#21 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\symfony\\console\\Application.php(342): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#22 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\symfony\\console\\Application.php(193): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#23 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#24 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#25 C:\\Users\\Acer\\Downloads\\Clients\\MCA_Portal\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#26 {main}', '2025-10-02 04:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `first_quarter` int(11) NOT NULL,
  `second_quarter` int(11) NOT NULL,
  `third_quarter` int(11) NOT NULL,
  `fourth_quarter` int(11) NOT NULL,
  `final_grade` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `class_id`, `subject_id`, `subject`, `first_quarter`, `second_quarter`, `third_quarter`, `fourth_quarter`, `final_grade`, `created_at`, `updated_at`) VALUES
(1, 1001, 101, 1, 'Mathematics', 86, 88, 99, 99, 93, '2025-10-02 11:11:50', '2025-10-03 07:47:56'),
(2, 1001, 102, 2, 'English', 92, 91, 92, 93, 92, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(3, 1002, 101, 1, 'Mathematics', 78, 90, 80, 90, 85, '2025-10-02 11:11:50', '2025-10-03 07:48:08'),
(4, 1002, 102, 2, 'English', 89, 90, 89, 92, 90, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(5, 1003, 103, 3, 'Science', 95, 94, 95, 96, 95, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(6, 13, 103, 3, 'Science', 90, 80, 80, 80, 83, '2025-10-02 12:03:50', '2025-10-02 12:05:51'),
(7, 9, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(8, 9, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(9, 9, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(10, 9, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(11, 9, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(12, 9, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(13, 9, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(14, 9, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(15, 10, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(16, 10, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(17, 10, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(18, 10, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(19, 10, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(20, 10, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(21, 10, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(22, 10, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(23, 13, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(24, 13, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(25, 13, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(26, 13, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(27, 13, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(28, 13, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(29, 13, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(30, 1001, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(31, 1001, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(32, 1001, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(33, 1001, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(34, 1001, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(35, 1001, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(36, 1002, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(37, 1002, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(38, 1002, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(39, 1002, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(40, 1002, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(41, 1002, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(42, 1003, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(43, 1003, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(44, 1003, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(45, 1003, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(46, 1003, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(47, 1003, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(48, 1003, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(49, 1004, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(50, 1004, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(51, 1004, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(52, 1004, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(53, 1004, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(54, 1004, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(55, 1004, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(56, 1004, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(57, 1005, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(58, 1005, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(59, 1005, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(60, 1005, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(61, 1005, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(62, 1005, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(63, 1005, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(64, 1005, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 06:30:38', '2025-10-03 06:30:38'),
(65, 9, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(66, 10, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(67, 13, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(68, 1001, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(69, 1002, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(70, 1003, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(71, 1004, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(72, 1005, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 06:56:34', '2025-10-03 06:56:34'),
(73, 1006, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(74, 1006, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(75, 1006, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(76, 1006, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(77, 1006, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(78, 1006, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(79, 1006, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(80, 1006, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(81, 1006, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(82, 1007, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(83, 1007, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(84, 1007, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(85, 1007, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(86, 1007, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(87, 1007, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(88, 1007, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(89, 1007, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(90, 1007, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(91, 1008, NULL, 1, 'Mathematics', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(92, 1008, NULL, 2, 'English', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(93, 1008, NULL, 3, 'Science', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(94, 1008, NULL, 4, 'Filipino', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(95, 1008, NULL, 5, 'Social Studies', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(96, 1008, NULL, 6, 'Araling Panlipunan', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(97, 1008, NULL, 7, 'MAPEH', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(98, 1008, NULL, 8, 'TLE', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(99, 1008, NULL, 10, 'CISCO', 0, 0, 0, 0, 0, '2025-10-03 10:10:08', '2025-10-03 10:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `grade_level`
--

CREATE TABLE `grade_level` (
  `grade_level_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_level`
--

INSERT INTO `grade_level` (`grade_level_id`, `name`, `created_at`, `updated_at`) VALUES
(7, '7', NULL, '2025-10-03 02:02:48'),
(8, '8', NULL, '2025-10-03 02:02:48'),
(9, '9', NULL, '2025-10-03 02:02:48'),
(10, '10', NULL, '2025-10-03 02:02:48'),
(11, '11', NULL, '2025-10-03 02:02:48'),
(12, '12', NULL, '2025-10-03 02:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_school_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `job_start_date` date DEFAULT NULL,
  `status` enum('active','on leave','retired','terminated') NOT NULL DEFAULT 'active',
  `advisory_section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `user_id`, `instructor_school_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `picture`, `gender`, `date_of_birth`, `contact_number`, `email`, `address`, `job_start_date`, `status`, `advisory_section_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Maria', 'Santos', 'Garcia', '', NULL, 'female', '1985-03-15', '09123456789', 'maria.garcia@mcams.edu.ph', '123 Main Street, Quezon City, Metro Manila', '2024-01-15', 'active', 1, '2025-09-27 23:35:49', '2025-09-27 23:35:49'),
(2, 15, 2, 'BluTech', NULL, 'Nano', NULL, NULL, 'male', '2025-10-03', '09123123123', 'runner@gmail.com', 'asdasdasdasdasd', '2025-09-29', 'active', NULL, '2025-10-02 10:34:16', '2025-10-02 10:34:16'),
(3, 113, 3, 'Pasko', 'Na', 'Pooooo', NULL, NULL, 'male', '2022-05-04', '09123123', 'customer12@gmail.com', 'asdasdasdasdasdasdasda', '2025-10-02', 'active', NULL, '2025-10-03 19:12:54', '2025-10-03 19:12:54'),
(4, 114, 4, 'Jessica', 'Co', 'Pooooo', NULL, NULL, 'male', '2001-02-28', '09123123', 'customer13@gmail.com', 'CurryCurryCurry', '2025-10-23', 'active', NULL, '2025-10-03 19:21:56', '2025-10-03 19:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_classes`
--

CREATE TABLE `instructor_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor_classes`
--

INSERT INTO `instructor_classes` (`id`, `instructor_id`, `class_id`, `assigned_at`, `created_at`, `updated_at`) VALUES
(201, 1, 101, '2025-10-02 19:02:29', '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(202, 1, 102, '2025-10-02 19:02:29', '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(203, 1, 103, '2025-10-02 19:02:29', '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(204, 2, 104, '2025-10-04 04:35:40', '2025-10-03 20:35:40', '2025-10-03 20:35:40'),
(205, 3, 105, '2025-10-04 04:35:40', '2025-10-03 20:35:40', '2025-10-03 20:35:40'),
(206, 4, 106, '2025-10-04 04:35:40', '2025-10-03 20:35:40', '2025-10-03 20:35:40'),
(207, 1, 104, '2025-10-12 18:37:40', '2025-10-12 10:37:40', '2025-10-12 10:37:40'),
(208, 1, 105, '2025-10-12 18:37:40', '2025-10-12 10:37:40', '2025-10-12 10:37:40'),
(209, 1, 106, '2025-10-12 18:37:40', '2025-10-12 10:37:40', '2025-10-12 10:37:40'),
(210, 1, 107, '2025-10-12 18:37:40', '2025-10-12 10:37:40', '2025-10-12 10:37:40'),
(211, 1, 108, '2025-10-12 18:37:40', '2025-10-12 10:37:40', '2025-10-12 10:37:40'),
(212, 1, 109, '2025-10-12 18:37:40', '2025-10-12 10:37:40', '2025-10-12 10:37:40'),
(213, 4, 101, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(214, 4, 102, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(215, 4, 103, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(216, 4, 104, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(217, 4, 105, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(218, 4, 107, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(219, 4, 108, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(220, 4, 109, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(221, 4, 113, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(222, 4, 114, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(223, 4, 115, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(224, 4, 116, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(225, 4, 117, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(226, 4, 118, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(227, 4, 119, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(228, 4, 120, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(229, 4, 121, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(230, 4, 122, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(231, 4, 123, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(232, 4, 124, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(233, 4, 125, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(234, 4, 126, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(235, 4, 127, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(236, 4, 128, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(237, 4, 129, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(238, 4, 130, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(239, 4, 131, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(240, 4, 132, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(241, 4, 133, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(242, 4, 134, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(243, 4, 135, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(244, 4, 136, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(245, 4, 137, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(246, 4, 138, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(247, 4, 139, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(248, 4, 140, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(249, 4, 141, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(250, 4, 142, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(251, 4, 143, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(252, 4, 144, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(253, 4, 145, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(254, 4, 146, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(255, 4, 147, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(256, 4, 148, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(257, 4, 149, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(258, 4, 150, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(259, 4, 151, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(260, 4, 152, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(261, 4, 153, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(262, 4, 154, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(263, 4, 155, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(264, 4, 156, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(265, 4, 157, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(266, 4, 158, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(267, 4, 159, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(268, 4, 160, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(269, 4, 161, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(270, 4, 162, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(271, 4, 163, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(272, 4, 164, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(273, 4, 165, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(274, 4, 166, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(275, 4, 167, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(276, 4, 168, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(277, 4, 169, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(278, 4, 170, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(279, 4, 171, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(280, 4, 172, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(281, 4, 173, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(282, 4, 174, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(283, 4, 175, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(284, 4, 176, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(285, 4, 177, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(286, 4, 178, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(287, 4, 179, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(288, 4, 180, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(289, 4, 181, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(290, 4, 182, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(291, 4, 183, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(292, 4, 184, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(293, 4, 185, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(294, 4, 186, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(295, 4, 187, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(296, 4, 188, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(297, 4, 189, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(298, 4, 190, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(299, 4, 191, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(300, 4, 192, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(301, 4, 193, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(302, 4, 194, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(303, 4, 195, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(304, 4, 196, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(305, 4, 197, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(306, 4, 198, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(307, 4, 199, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(308, 4, 200, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(309, 4, 201, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(310, 4, 202, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(311, 4, 203, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(312, 4, 204, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(313, 4, 205, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(314, 4, 206, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(315, 4, 207, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(316, 4, 208, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(317, 4, 209, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(318, 4, 210, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(319, 4, 211, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(320, 4, 212, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(321, 4, 213, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(322, 4, 214, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(323, 4, 215, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(324, 4, 216, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(325, 4, 217, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(326, 4, 218, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(327, 4, 219, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(328, 4, 220, '2025-10-12 18:52:02', '2025-10-12 10:52:02', '2025-10-12 10:52:02'),
(329, 3, 101, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(330, 3, 102, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(331, 3, 103, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(332, 3, 104, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(333, 3, 106, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(334, 3, 107, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(335, 3, 108, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(336, 3, 109, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(337, 3, 113, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(338, 3, 114, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(339, 3, 115, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(340, 3, 116, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(341, 3, 117, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(342, 3, 118, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(343, 3, 119, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(344, 3, 120, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(345, 3, 121, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(346, 3, 122, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(347, 3, 123, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(348, 3, 124, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(349, 3, 125, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(350, 3, 126, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(351, 3, 127, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(352, 3, 128, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(353, 3, 129, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(354, 3, 130, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(355, 3, 131, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(356, 3, 132, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(357, 3, 133, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(358, 3, 134, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(359, 3, 135, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(360, 3, 136, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(361, 3, 137, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(362, 3, 138, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(363, 3, 139, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(364, 3, 140, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(365, 3, 141, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(366, 3, 142, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(367, 3, 143, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(368, 3, 144, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(369, 3, 145, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(370, 3, 146, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(371, 3, 147, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(372, 3, 148, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(373, 3, 149, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(374, 3, 150, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(375, 3, 151, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(376, 3, 152, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(377, 3, 153, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(378, 3, 154, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(379, 3, 155, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(380, 3, 156, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(381, 3, 157, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(382, 3, 158, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(383, 3, 159, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(384, 3, 160, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(385, 3, 161, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(386, 3, 162, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(387, 3, 163, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(388, 3, 164, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(389, 3, 165, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(390, 3, 166, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(391, 3, 167, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(392, 3, 168, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(393, 3, 169, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(394, 3, 170, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(395, 3, 171, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(396, 3, 172, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(397, 3, 173, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(398, 3, 174, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(399, 3, 175, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(400, 3, 176, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(401, 3, 177, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(402, 3, 178, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(403, 3, 179, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(404, 3, 180, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(405, 3, 181, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(406, 3, 182, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(407, 3, 183, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(408, 3, 184, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(409, 3, 185, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(410, 3, 186, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(411, 3, 187, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(412, 3, 188, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(413, 3, 189, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(414, 3, 190, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(415, 3, 191, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(416, 3, 192, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(417, 3, 193, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(418, 3, 194, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(419, 3, 195, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(420, 3, 196, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(421, 3, 197, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(422, 3, 198, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(423, 3, 199, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(424, 3, 200, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(425, 3, 201, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(426, 3, 202, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(427, 3, 203, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(428, 3, 204, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(429, 3, 205, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(430, 3, 206, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(431, 3, 207, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(432, 3, 208, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(433, 3, 209, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(434, 3, 210, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(435, 3, 211, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(436, 3, 212, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(437, 3, 213, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(438, 3, 214, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(439, 3, 215, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(440, 3, 216, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(441, 3, 217, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(442, 3, 218, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(443, 3, 219, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(444, 3, 220, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(445, 3, 239, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(446, 3, 240, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(447, 3, 241, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(448, 3, 242, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(449, 3, 243, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(450, 3, 244, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(451, 3, 245, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(452, 3, 246, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(453, 3, 247, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(454, 3, 248, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(455, 3, 249, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(456, 3, 250, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(457, 3, 251, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(458, 3, 252, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(459, 3, 253, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(460, 3, 254, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(461, 3, 255, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56'),
(462, 3, 256, '2025-10-12 19:18:56', '2025-10-12 11:18:56', '2025-10-12 11:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_ids`
--

CREATE TABLE `instructor_ids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor_ids`
--

INSERT INTO `instructor_ids` (`id`, `instructor_number`, `created_at`, `updated_at`) VALUES
(1, 'INS-2024-001', '2025-09-27 23:35:49', '2025-09-27 23:35:49'),
(2, 'INS-2025-001', '2025-10-02 10:34:16', '2025-10-02 10:34:16'),
(3, 'INS-2025-002', '2025-10-03 19:12:53', '2025-10-03 19:12:53'),
(4, 'INS-2025-003', '2025-10-03 19:21:56', '2025-10-03 19:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2025_05_12_092640_create_old_student_enrollees_table', 1),
(2, '0001_01_01_000000_create_users_table', 2),
(3, '0001_01_01_000001_create_cache_table', 2),
(4, '0001_01_01_000002_create_jobs_table', 2),
(5, '2025_03_25_011828_add_user_type_to_users_table', 2),
(6, '2025_03_25_122045_create_grades_table', 2),
(7, '2025_03_26_131804_create_enrollments_table', 2),
(8, '2025_03_27_134849_create_subjects_table', 2),
(9, '2025_03_28_033459_create_documents_table', 2),
(10, '2025_03_28_061434_create_class_announcements_table', 2),
(11, '2025_03_28_072249_create_class_table', 2),
(12, '2025_03_28_072811_add_class_id_to_users_table', 2),
(13, '2025_03_29_130658_create_strands_table', 2),
(14, '2025_04_04_035941_update_users_table_for_username_and_userid', 2),
(15, '2025_04_11_034858_create_grade_table', 3),
(16, '2025_04_14_041422_add_foreign_key_to_grade_level_column_in_students_table', 4),
(17, '2025_04_29_144112_create_new_student_enrollees_table', 5),
(18, '2025_05_12_070433_add_step2_document_paths_to_new_student_enrollees_table', 6),
(19, '2025_05_12_073845_add_step3_document_paths_to_new_student_enrollees_table', 7),
(20, '2025_09_28_014139_add_status_and_decline_reason_to_new_student_enrollees_table', 8),
(21, '2025_09_28_014152_add_status_and_decline_reason_to_old_student_enrollees_table', 9),
(22, '2025_04_12_152930_create_status_table', 10),
(23, '2025_04_21_024902_make_instructor_id_table', 11),
(24, '2025_04_21_025720_make_instructor_table', 12),
(25, '2025_04_21_153857_create_instructor_classes_table', 13),
(26, '2025_04_23_054929_add_timestamps_to_instructor_classes_table', 14),
(27, '2025_09_28_045008_add_missing_columns_to_new_student_enrollees_table', 15),
(28, '2025_09_28_050230_add_application_number_to_new_student_enrollees_table', 16),
(29, '2025_09_28_052027_add_lrn_to_students_table', 17),
(30, '2025_04_21_154118_create_schedules_table', 18),
(31, '2025_09_28_074316_add_name_column_to_subjects_table', 19),
(32, '2025_09_28_074443_add_section_id_to_classes_table', 20),
(33, '2025_10_02_013800_add_jhs_grade_to_new_student_enrollees_table', 21),
(34, '2025_10_02_040936_add_grade_level_to_new_student_enrollees_table', 22),
(35, '2025_10_02_000001_alter_grades_add_class_and_subject', 23),
(36, '2025_10_02_000002_create_attendance_table', 24),
(37, '2025_10_02_000003_add_advisory_section_to_instructors', 25),
(38, '2025_10_03_161055_add_missing_columns_to_attendance_table', 26),
(39, '2025_04_22_024348_add_strand_id_to_classes_table', 27),
(40, '2025_10_12_145524_create_archived_students_table', 28),
(41, '2025_10_12_145528_create_archived_grades_table', 29),
(42, '2025_10_12_145533_create_archived_attendance_table', 30),
(43, '2025_10_12_145538_create_academic_years_table', 31),
(44, '2025_10_12_145544_create_archive_logs_table', 32),
(45, '2025_10_12_164019_create_strand_assessment_results_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `new_student_enrollees`
--

CREATE TABLE `new_student_enrollees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_number` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending',
  `decline_reason` text DEFAULT NULL,
  `status_updated_at` timestamp NULL DEFAULT NULL,
  `semester` varchar(255) NOT NULL,
  `grade_level` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`grade_level`)),
  `lrn` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `extension_name` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `pob` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `guardian_contact` varchar(255) DEFAULT NULL,
  `guardian_email` varchar(255) DEFAULT NULL,
  `last_school` varchar(255) NOT NULL,
  `school_address` varchar(255) NOT NULL,
  `grade_completed` varchar(255) NOT NULL,
  `sy_completed` varchar(255) NOT NULL,
  `form138_path` varchar(255) NOT NULL,
  `desired_grade` varchar(255) NOT NULL,
  `preferred_strand` varchar(255) DEFAULT NULL,
  `strand` varchar(255) DEFAULT NULL,
  `shs_grade` int(11) DEFAULT NULL,
  `jhs_grade` int(11) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `given_name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `living_with` varchar(255) DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `former_school` varchar(255) DEFAULT NULL,
  `previous_grade` varchar(255) DEFAULT NULL,
  `last_school_year` varchar(255) DEFAULT NULL,
  `school_type` varchar(255) DEFAULT NULL,
  `reason_transfer` varchar(255) DEFAULT NULL,
  `working_student` tinyint(1) NOT NULL DEFAULT 0,
  `intend_working_student` tinyint(1) NOT NULL DEFAULT 0,
  `siblings` int(11) DEFAULT NULL,
  `club_member` tinyint(1) NOT NULL DEFAULT 0,
  `club_name` varchar(255) DEFAULT NULL,
  `father_occupation` varchar(255) DEFAULT NULL,
  `father_contact_no` varchar(255) DEFAULT NULL,
  `father_email` varchar(255) DEFAULT NULL,
  `mother_occupation` varchar(255) DEFAULT NULL,
  `mother_contact_no` varchar(255) DEFAULT NULL,
  `mother_email` varchar(255) DEFAULT NULL,
  `guardian_occupation` varchar(255) DEFAULT NULL,
  `guardian_contact_no` varchar(255) DEFAULT NULL,
  `medical_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medical_history`)),
  `allergy_specify` varchar(255) DEFAULT NULL,
  `others_specify` varchar(255) DEFAULT NULL,
  `report_card_path` varchar(255) DEFAULT NULL,
  `good_moral_path` varchar(255) DEFAULT NULL,
  `birth_certificate_path` varchar(255) DEFAULT NULL,
  `id_picture_path` varchar(255) DEFAULT NULL,
  `payment_applicant_name` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `payment_receipt_path` varchar(255) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_student_enrollees`
--

INSERT INTO `new_student_enrollees` (`id`, `application_number`, `status`, `decline_reason`, `status_updated_at`, `semester`, `grade_level`, `lrn`, `last_name`, `first_name`, `middle_name`, `extension_name`, `dob`, `gender`, `pob`, `address`, `mobile`, `email`, `mother_name`, `father_name`, `guardian_name`, `relationship`, `guardian_contact`, `guardian_email`, `last_school`, `school_address`, `grade_completed`, `sy_completed`, `form138_path`, `desired_grade`, `preferred_strand`, `strand`, `shs_grade`, `jhs_grade`, `surname`, `given_name`, `contact_no`, `living_with`, `birthplace`, `religion`, `nationality`, `former_school`, `previous_grade`, `last_school_year`, `school_type`, `reason_transfer`, `working_student`, `intend_working_student`, `siblings`, `club_member`, `club_name`, `father_occupation`, `father_contact_no`, `father_email`, `mother_occupation`, `mother_contact_no`, `mother_email`, `guardian_occupation`, `guardian_contact_no`, `medical_history`, `allergy_specify`, `others_specify`, `report_card_path`, `good_moral_path`, `birth_certificate_path`, `id_picture_path`, `payment_applicant_name`, `payment_reference`, `payment_receipt_path`, `paid`, `created_at`, `updated_at`) VALUES
(37, 'MCA-NEW-2025-7CWM', 'accepted', NULL, '2025-10-02 22:18:15', '1st', NULL, '123456789123', 'Student', 'One', 'Now', NULL, '2020-06-17', 'Other', 'JasperJasperJasper', 'ButlerButlerButler', '09123445678', 'blutech18@gmail.com', 'Arnie', 'Arnie', 'Arnie', NULL, NULL, NULL, 'Jasper', 'ButlerButler', '11', '2024-2025', 'pending', '12', NULL, 'ICT', 12, NULL, 'Student', 'One', '09123445678', NULL, 'JasperJasperJasper', 'Jasper', 'ButlerButlerButler', 'Jasper', '11', '2024-2025', 'Homeschool', 'ArnieArnieArnie', 1, 1, 12, 1, 'ArnieArnie', 'Arnie', NULL, NULL, 'Arnie', NULL, NULL, 'Arnie', '09345678901', '[\"Asthma\",\"PhysicallyFit\",\"HeartCondition\"]', NULL, NULL, 'enroll/docs/B6iCyKuBtS6veyhwXyaDk9eecD6IlRCsxFJWuQO1.png', 'enroll/docs/GjRBCb6X9eRR7PGwVTtQYkcBhCsP9NzfyS3bXX3H.png', 'enroll/docs/hIYFZOejUmffufNX7IR6Bi9l9pto3lyXdcNrUQzg.png', 'enroll/docs/ISbX1rgv8rzREMxnLzHXQ6eMtvVxP1CB6rzXGBmw.png', 'Student, One Now', '123123123123', 'enroll/payments/UJmC6uS1UOyNLQ7BtS5YevuyFUjaXgDQWS3v4lN9.png', 1, '2025-10-02 22:09:43', '2025-10-02 22:18:15'),
(39, 'MCA-NEW-2025-SZSV', 'accepted', NULL, '2025-10-03 02:59:42', '1st', NULL, '123123123123', 'Curry', 'Curry', 'Curry', NULL, '2020-08-06', 'Other', 'CurryCurry', 'CurryCurryCurry', '09123456722', 'cristanjade70@gmail.com', 'CurryCurry', 'Curry', 'Curry', NULL, NULL, NULL, 'Curry', 'CurryCurryCurry', '12', '2024-2025', 'pending', '13', NULL, 'ICT', 12, 10, 'Curry', 'Curry', '09123456722', NULL, 'CurryCurry', 'CurryCurry', 'CurryCurry', 'Curry', '12', '2024-2025', 'Homeschool', 'CurryCurry', 1, 1, 2, 1, 'CurryCurryCurry', 'Curry', NULL, NULL, 'CurryCurry', NULL, NULL, 'Curry', '09123456789', '[\"PhysicallyFit\",\"HeartCondition\"]', NULL, NULL, 'enroll/docs/ZSkawY3Y6H9lSHoqMszt5S8st7nEzE5e96eZuuLD.png', 'enroll/docs/iaIawSFFufzfaRibOEQ6rKUn9YFPF7WowbDwqQPS.png', 'enroll/docs/iO4A4tcBwHmaXPEfLwWiLivld8X3bkGe0fVI2B81.png', 'enroll/docs/iCaHpzdKYPGe71hUba0nRZwTCSqQ7GvFi9JmAuBR.png', 'Cash Payment', 'CASH-20251003105715', 'enroll/payments/KgP2liH15vSlz1aX66WkLxLtDDCUQlTm4C7w2EFU.png', 1, '2025-10-03 02:56:38', '2025-10-03 02:59:42'),
(41, 'MCA-NEW-2025-GEAF', 'accepted', NULL, '2025-10-03 09:40:13', '1st', NULL, '696969696969', 'Sensku', 'Ishigami', 'Stone', NULL, '2020-07-13', 'Female', 'CurryCurry', 'CurryCurryCurry', '09123456789', 'cristanjade10@gmail.com', 'errrror', 'errrror', 'errrror', NULL, NULL, NULL, 'errrror', 'errrrorerrrror', '11', '2025-2026', 'pending', '12', NULL, 'HE', 11, NULL, 'Sensku', 'Ishigami', '09123456789', NULL, 'CurryCurry', 'errrror', 'errrror', 'errrror', '11', '2025-2026', 'Public', 'errrrorerrrror', 1, 1, 3, 1, 'errrrorerrrror', 'errrror', NULL, NULL, 'errrrorerrrror', NULL, NULL, 'errrror', '09123456789', '[\"HeartCondition\"]', NULL, NULL, 'enroll/docs/50mdqxVeE0rdT0pIRV7pvT0YmgYpN12FjasrTTd3.png', 'enroll/docs/AK6R3EXW5zNeSkXk9CMna8LJi8WTnLMeXc9LZoy7.png', 'enroll/docs/DGqvqs08ChLdfDLcQ1rAGyNQZMk4vDAVS8vXQXLB.png', 'enroll/docs/ayKznGOllJzdbNvOzHypo104XXYTlKBTMgdfBj3I.png', 'Cash Payment', 'CASH-20251003173935', 'enroll/payments/mvZVD2NbCvvoLflcYdrtbGL2HHD7vSZhlWKQIvdR.png', 1, '2025-10-03 09:39:19', '2025-10-03 09:40:13'),
(42, 'MCA-NEW-2025-OJCD', 'accepted', NULL, '2025-10-03 10:10:08', '1st', NULL, '612362342356', 'dasdasd', 'dasdasd', 'dasdasd', NULL, '2020-08-05', 'Other', 'dasdasddasdasd', 'dasdasddasdasd', '09123456789', 'customer@gmail.com', 'dasdasd', 'dasdasd', 'dasdasd', NULL, NULL, NULL, 'dasdasd', 'dasdasddasdasd', '12', '2024-2025', 'pending', '13', NULL, 'GAS', 12, NULL, 'dasdasd', 'dasdasd', '09123456789', NULL, 'dasdasddasdasd', 'dasdasddasdasd', 'dasdasd', 'dasdasd', '12', '2024-2025', 'Public', 'dasdasd', 1, 1, 3, 1, 'dasdasddasdasd', 'dasdasd', NULL, NULL, 'dasdasd', NULL, NULL, 'dasdasd', '09123456789', '[\"PhysicallyFit\"]', NULL, NULL, 'enroll/docs/68UU5bY43ylHPWwD3SP9GjQFUxs1xLzDIFs9A0zp.png', 'enroll/docs/zpYdr3ohLyIlvhomEa2PhZvn7pzYWaG1bkOKIwW9.png', 'enroll/docs/Ougl3nbtoCpAmJzvfrF9jeiuUbR6AOKMx8S20kfW.png', 'enroll/docs/wJWP647zkbtYFXI6WeM8c9OvAv2lMX2So7qrFlBN.png', 'Dasdasd, Dasdasd Dasdasd', '3123123', 'enroll/payments/q1IgcZbd2ajCWCqiWQCw4M4wBA7AUwJTQConTPZj.png', 1, '2025-10-03 10:08:53', '2025-10-03 10:10:08'),
(43, NULL, 'pending', NULL, NULL, '1st', NULL, '734548353473', 'Gone', 'Gone', 'Gone', NULL, '2020-07-16', 'Female', 'GoneGoneGone', 'GoneGone', '09123456789', 'customer1@gmail.com', 'Gone', 'Gone', 'Gone', NULL, NULL, NULL, 'GoneGone', 'GoneGone', '9', '2024-2025', 'pending', '10', NULL, NULL, NULL, 10, 'Gone', 'Gone', '09123456789', NULL, 'GoneGoneGone', 'dasdasddasdasd', 'GoneGone', 'GoneGone', '9', '2024-2025', 'Homeschool', 'GoneGone', 0, 0, NULL, 0, NULL, 'Gone', NULL, NULL, 'Gone', NULL, NULL, 'Gone', '09123456789', '[\"Asthma\",\"PhysicallyFit\"]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-10-03 19:10:50', '2025-10-03 19:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `old_student_enrollees`
--

CREATE TABLE `old_student_enrollees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester` enum('1st','2nd') NOT NULL,
  `surname` varchar(255) NOT NULL,
  `given_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `lrn` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `grade_level_applying` tinyint(3) UNSIGNED DEFAULT NULL,
  `terms_accepted` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`terms_accepted`)),
  `payment_applicant_name` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `payment_receipt_path` varchar(255) DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `payment_verified` tinyint(1) NOT NULL DEFAULT 0,
  `payment_verified_at` timestamp NULL DEFAULT NULL,
  `registrar_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `accounting_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `library_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `discipline_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `guidance_cleared` tinyint(1) NOT NULL DEFAULT 0,
  `clearance_path` varchar(255) DEFAULT NULL,
  `application_number` varchar(255) DEFAULT NULL,
  `status` enum('pending','accepted','declined') NOT NULL DEFAULT 'pending',
  `decline_reason` text DEFAULT NULL,
  `status_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_class_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`schedule_id`, `instructor_class_id`, `day_of_week`, `start_time`, `end_time`, `room`, `created_at`, `updated_at`) VALUES
(301, 201, 'Monday', '08:00:00', '09:00:00', 'R101', '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(302, 202, 'Tuesday', '09:00:00', '10:00:00', 'R102', '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(303, 203, 'Wednesday', '10:00:00', '11:00:00', 'R201', '2025-10-02 11:11:50', '2025-10-02 11:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `grade_level_id` int(11) NOT NULL,
  `strand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `section_name`, `grade_level_id`, `strand_id`, `created_at`, `updated_at`) VALUES
(1, 'Grade 7 - Diamond', 7, NULL, '2025-10-02 11:11:49', '2025-10-03 06:17:44'),
(2, 'Baliw', 12, NULL, '2025-09-30 09:47:11', '2025-09-30 09:47:11'),
(3, 'Grade 8 - Emerald', 8, NULL, '2025-10-02 11:11:49', '2025-10-03 06:17:44'),
(4, 'asd', 7, NULL, '2025-10-02 07:38:59', '2025-10-02 07:38:59'),
(5, 'Grade 9 - Gold', 9, NULL, '2025-10-02 11:11:49', '2025-10-03 06:17:44'),
(7, 'Grade 11 - Section A', 11, NULL, '2025-10-03 09:40:13', '2025-10-03 09:40:13'),
(8, 'Grade 12 - GAS - Section A', 12, 4, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(9, 'Rizal', 10, NULL, '2025-10-03 19:30:40', '2025-10-03 19:30:40'),
(10, 'Zaldy', 10, NULL, '2025-10-03 19:32:44', '2025-10-03 19:32:44'),
(12, 'Zaldy', 8, NULL, '2025-10-03 20:05:03', '2025-10-03 20:05:03'),
(13, 'ddd', 9, NULL, '2025-10-03 20:16:56', '2025-10-03 20:16:56'),
(14, 'BBBB', 10, NULL, '2025-10-03 20:23:05', '2025-10-03 20:23:05'),
(15, 'Tttttt', 7, NULL, '2025-10-12 10:38:35', '2025-10-12 10:38:35'),
(16, 'Saitama', 10, NULL, '2025-10-12 10:43:55', '2025-10-12 10:43:55'),
(17, 'Genos', 10, NULL, '2025-10-12 10:51:27', '2025-10-12 10:51:27'),
(22, 'Tatsumaki', 10, NULL, '2025-10-12 11:18:33', '2025-10-12 11:18:33');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cYeMF9e8zTHsZ6cY1IwZYj919Js3DuY8tZ2CHp1P', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 OPR/121.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZnVCelRSd0doa0s1cW9BOW9UeEdYaUpZZDJHR2tJaVhyVXA1UEdUOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2hvbWUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2xvZ2luIjt9fQ==', 1760297154);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Enrolled', NULL, NULL),
(2, 'Active', NULL, NULL),
(3, 'Inactive', NULL, NULL),
(4, 'Graduated', NULL, NULL),
(5, 'Transferred', NULL, NULL),
(6, 'Dropped', NULL, NULL),
(7, 'Not Enrolled', '2025-10-03 19:27:08', '2025-10-03 19:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `strands`
--

CREATE TABLE `strands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `no_of_sections` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strands`
--

INSERT INTO `strands` (`id`, `name`, `no_of_sections`, `created_at`, `updated_at`) VALUES
(1, 'STEM', 2, '2025-10-02 07:43:23', '2025-10-02 07:43:23'),
(2, 'ABM', 2, '2025-10-02 07:43:23', '2025-10-02 07:43:23'),
(3, 'HUMSS', 2, '2025-10-02 07:43:23', '2025-10-02 07:43:23'),
(4, 'GAS', 1, '2025-10-02 07:43:23', '2025-10-02 07:43:23'),
(5, 'TVL-ICT', 1, '2025-10-02 07:43:23', '2025-10-02 07:43:23'),
(6, 'TVL-HE', 1, '2025-10-02 07:43:23', '2025-10-02 07:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `strand_assessment_results`
--

CREATE TABLE `strand_assessment_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recommended_strand` varchar(255) NOT NULL,
  `scores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`scores`)),
  `total_questions` int(11) NOT NULL DEFAULT 25,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `enrollment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strand_assessment_results`
--

INSERT INTO `strand_assessment_results` (`id`, `email`, `academic_year_id`, `recommended_strand`, `scores`, `total_questions`, `completed_at`, `is_used`, `enrollment_id`, `created_at`, `updated_at`) VALUES
(1, 'cristanjade14@gmail.com', NULL, 'ICT', '{\"ABM\":2,\"STEM\":4,\"GAS\":3,\"ICT\":10,\"HE\":2,\"HUMSS\":3}', 25, '2025-10-12 09:32:38', 0, NULL, '2025-10-12 09:32:39', '2025-10-12 09:32:39'),
(2, 'blutech18@gmail.com', 8, 'ICT', '{\"ICT\":12,\"HUMSS\":2,\"HE\":3,\"GAS\":1,\"STEM\":1,\"ABM\":2}', 25, '2025-10-12 10:11:46', 0, NULL, '2025-10-12 10:11:46', '2025-10-12 10:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `school_student_id` varchar(50) NOT NULL,
  `lrn` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `date_of_birth` date NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `grade_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `strand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL,
  `date_enrolled` date DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED DEFAULT NULL,
  `documents_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attendance_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `school_student_id`, `lrn`, `user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `picture`, `gender`, `date_of_birth`, `contact_number`, `email`, `address`, `grade_level_id`, `strand_id`, `section_id`, `status_id`, `date_enrolled`, `semester`, `grade_id`, `schedule_id`, `documents_id`, `attendance_report_id`, `created_at`, `updated_at`) VALUES
(9, 'MCA-2025-9E03', '44444444', 8, 'James', 'Bronny', 'Lebron', NULL, NULL, 'male', '2005-09-17', '09123456789', 'lebronjames23@gmail.com', 'Philippines', 7, NULL, NULL, 2, '2025-09-30', '1st', 1, NULL, NULL, NULL, '2025-09-30 07:30:08', '2025-09-30 07:30:08'),
(10, 'MCA-2025-DPO3', '564673829437', 9, 'tal', 'a', 'garmea', NULL, 'enroll/docs/CnG8Wi5dXz8WvthXd8eI5I6n75G1Y3kpBms7s7gr.jpg', 'male', '1999-11-17', '09643789483', 'krystalmendez2000@gmail.com', 'taguig', 12, NULL, NULL, 2, '2025-09-30', '1st', 1, NULL, NULL, NULL, '2025-09-30 09:35:07', '2025-10-02 21:27:54'),
(13, 'MCA-NEW-2025-TUAN', '010101010101', 1, 'Arnie', 'Arnie', 'Arnie', NULL, 'enroll/docs/Mxvo5azhB5Tnvwdq3JzPXefbCTx7M51Z9TSmvmLM.png', 'male', '2019-02-22', '09123445678', 'arniegabuya@gmail.com', 'ArnieArnie', 11, NULL, 3, 2, '2025-10-02', '1st', 1, NULL, NULL, NULL, '2025-10-02 02:22:25', '2025-10-02 02:22:25'),
(1001, 'STU-001', NULL, 100, 'Juan', NULL, 'Dela Cruz', NULL, NULL, 'male', '2012-01-15', '09171234567', NULL, 'Manila', NULL, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(1002, 'STU-002', NULL, 101, 'Maria', NULL, 'Santos', NULL, NULL, 'female', '2012-03-20', '09181234567', NULL, 'Manila', NULL, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(1003, 'STU-003', NULL, 102, 'Pedro', NULL, 'Reyes', NULL, NULL, 'male', '2011-05-10', '09191234567', NULL, 'Manila', NULL, NULL, 3, 1, NULL, NULL, 2, NULL, NULL, NULL, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(1004, 'MCA-NEW-2025-7CWM', '123456789123', 106, 'One', 'Now', 'Student', NULL, 'enroll/docs/ISbX1rgv8rzREMxnLzHXQ6eMtvVxP1CB6rzXGBmw.png', 'male', '2020-06-17', '09123445678', 'blutech18@gmail.com', 'ButlerButlerButler', 12, NULL, 2, 2, '2025-10-03', '1st', 1, NULL, NULL, NULL, '2025-10-02 22:18:15', '2025-10-02 22:18:15'),
(1005, 'MCA-NEW-2025-SZSV', '123123123123', 107, 'Curry', 'Curry', 'Curry', NULL, 'enroll/docs/iCaHpzdKYPGe71hUba0nRZwTCSqQ7GvFi9JmAuBR.png', 'male', '2020-08-06', '09123456722', 'cristanjade70@gmail.com', 'CurryCurryCurry', 12, NULL, 2, 2, '2025-10-03', '1st', 1, NULL, NULL, NULL, '2025-10-03 02:59:43', '2025-10-03 02:59:43'),
(1006, 'flove-524256', '856978581427', 110, 'Family', 'Is', 'Love', NULL, 'student_pictures/yfyI6vwrv14ow1vVudJeCCbDlRP7YP1OO8IjRYDZ.png', 'male', '2013-06-04', '096711023123', 'cristanjade166@gmail.com', 'asdasdasd', 9, NULL, 5, 1, '2025-10-03', NULL, 1, NULL, NULL, NULL, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(1007, 'MCA-NEW-2025-GEAF', '696969696969', 111, 'Ishigami', 'Stone', 'Sensku', NULL, 'enroll/docs/ayKznGOllJzdbNvOzHypo104XXYTlKBTMgdfBj3I.png', 'male', '2020-07-13', '09123456789', 'cristanjade10@gmail.com', 'CurryCurryCurry', 11, 6, 7, 2, '2025-10-03', '1st', 1, NULL, NULL, NULL, '2025-10-03 09:40:14', '2025-10-03 09:58:55'),
(1008, 'MCA-NEW-2025-OJCD', '612362342356', 112, 'dasdasd', 'dasdasd', 'dasdasd', NULL, 'enroll/docs/wJWP647zkbtYFXI6WeM8c9OvAv2lMX2So7qrFlBN.png', 'male', '2020-08-05', '09123456789', 'customer@gmail.com', 'dasdasddasdasd', 12, 4, 8, 2, '2025-10-03', '1st', 1, NULL, NULL, NULL, '2025-10-03 10:10:08', '2025-10-03 10:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `student_id`
--

CREATE TABLE `student_id` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_id`
--

INSERT INTO `student_id` (`id`, `student_number`, `created_at`, `updated_at`) VALUES
(2, 'MCA-2025-HTOZ', '2025-09-30 06:53:16', '2025-09-30 06:53:16'),
(4, 'MCA-2025-DPO3', '2025-09-30 09:35:07', '2025-09-30 09:35:07'),
(6, 'MCA-NEW-2025-FRST', '2025-10-02 00:13:39', '2025-10-02 00:13:39'),
(7, 'MCA-NEW-2025-TUAN', '2025-10-02 02:22:25', '2025-10-02 02:22:25'),
(8, '2500035', '2025-10-02 03:08:54', '2025-10-02 03:08:54'),
(11, '2500037', '2025-10-02 22:18:15', '2025-10-02 22:18:15'),
(12, '2500039', '2025-10-03 02:59:42', '2025-10-03 02:59:42'),
(13, 'flove-473781', '2025-10-03 09:02:51', '2025-10-03 09:02:51'),
(14, 'flove-135681', '2025-10-03 09:05:59', '2025-10-03 09:05:59'),
(15, 'flove-247018', '2025-10-03 09:24:31', '2025-10-03 09:24:31'),
(16, 'flove-524256', '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(18, '2500041', '2025-10-03 09:40:13', '2025-10-03 09:40:13'),
(19, '2500042', '2025-10-03 10:10:08', '2025-10-03 10:10:08');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `code`, `is_default`, `user_id`, `subject`, `day`, `time`, `teacher`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Mathematics', 'MATH-101', 1, NULL, 'Mathematics', 'Monday', '08:00:00', 'Test Instructor', NULL, '2025-10-02 11:11:49', '2025-10-03 07:06:06'),
(2, 'English', 'ENG-101', 1, NULL, 'English', 'Monday', '08:00:00', 'Test Instructor', NULL, '2025-10-02 11:11:49', '2025-10-03 07:06:06'),
(3, 'Science', 'SCI-101', 1, NULL, 'Science', 'Monday', '08:00:00', 'Test Instructor', NULL, '2025-10-02 11:11:49', '2025-10-03 07:06:06'),
(4, 'Filipino', 'FIL-101', 1, NULL, 'Filipino', 'Monday', '08:00:00', 'Test Instructor', NULL, '2025-10-02 11:11:49', '2025-10-03 07:06:06'),
(5, 'Social Studies', 'SS-101', 1, NULL, 'Social Studies', 'Monday', '08:00:00', 'Test Instructor', NULL, '2025-10-02 11:11:49', '2025-10-03 07:06:06'),
(6, 'Araling Panlipunan', 'AP-101', 1, NULL, 'Araling Panlipunan', 'Monday', '08:00:00', 'TBA', NULL, '2025-10-03 06:28:53', '2025-10-03 07:06:06'),
(7, 'MAPEH', 'MAPEH-101', 1, NULL, 'MAPEH', 'Tuesday', '08:00:00', 'TBA', NULL, '2025-10-03 06:28:53', '2025-10-03 07:06:06'),
(8, 'TLE', 'TLE-101', 1, NULL, 'TLE', 'Wednesday', '08:00:00', 'TBA', NULL, '2025-10-03 06:28:53', '2025-10-03 07:06:06'),
(10, 'CISCO', 'CISCO-101', 1, NULL, 'CISCO', 'Monday', '08:00:00', 'TBA', NULL, '2025-10-03 06:45:54', '2025-10-03 06:45:54'),
(11, 'IT Era', 'ITE-101', 0, NULL, 'IT Era', 'Monday', '08:00:00', 'TBA', NULL, '2025-10-03 06:54:24', '2025-10-03 06:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'student',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `class_id`, `name`, `username`, `email`, `user_type`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Administrator', 'admin', 'admin@mcams.edu.ph', 'admin', '2025-09-27 20:09:45', '$2y$12$ps/5uk/94hPndkrykit/guzYIHRvwQkJKB4u95cr1sNx0rIriqk4u', NULL, '2025-09-27 20:09:45', '2025-10-06 04:41:35'),
(2, NULL, 'Maria Garcia', 'mgarcia574', 'maria.garcia@mcams.edu.ph', 'instructor', NULL, '$2y$12$LiFmqq8UAzFOfSRFCMr7LOaQ4l8LXI97j5kZ7FmR2WxJO78L/H3HC', NULL, '2025-09-27 23:35:49', '2025-09-27 23:35:49'),
(4, NULL, 'Instructor', 'instructor', 'instructor@mcams.edu.ph', 'instructor', NULL, '$2y$12$IEwousLtgyBg4MWB8qVFz.oVvHtp67hElFhvokrXUOKVPsShL.xry', NULL, '2025-09-28 09:29:51', '2025-09-28 09:29:51'),
(8, NULL, 'Lebron James', 'lebron.james', 'lebronjames23@gmail.com', 'student', NULL, '$2y$12$tDMTFuslZRMEg.d8Chz0YOsFqSl8CigRmBFeDJ3W9BhUmKJSZCvvq', NULL, '2025-09-30 07:30:08', '2025-09-30 07:30:33'),
(9, NULL, 'tal garmea', 'tal.garmea', 'krystalmendez2000@gmail.com', 'student', NULL, '$2y$12$JunpA3QSu5T3DcGJctr8fOzY6yoZr4HhhFGEpdQpOsjvsGf6f//BK', NULL, '2025-09-30 09:35:07', '2025-09-30 09:35:07'),
(11, NULL, 'Test User', NULL, 'test@example.com', 'student', '2025-10-01 19:56:06', '$2y$12$noUcttXfvId7.bnMRCSXpuP6wGUNpbabf5zCIpiXvDX6YpT3RUJJi', 'Goadf1z8k0', '2025-10-01 19:56:07', '2025-10-01 19:56:07'),
(15, NULL, 'BluTech Nano', 'ano.INS-2025-001', 'runner@gmail.com', 'instructor', NULL, '$2y$12$SXbA9XDlqVwXVfbS1GTrx.XcEy7q4SfO9OVKiu37X7leGn7tULfNK', NULL, '2025-10-02 10:34:16', '2025-10-02 10:34:16'),
(100, NULL, 'Juan Dela Cruz', 'juan.dc', 'juan@example.com', 'student', NULL, '$2y$12$qZNgQj0frOLosb9Kf77r5u5nLqqOZXeMoa4Rdgp20mN2Ea/UwQWHC', NULL, '2025-10-02 11:11:49', '2025-10-02 11:11:49'),
(101, NULL, 'Maria Santos', 'maria.s', 'maria@example.com', 'student', NULL, '$2y$12$BsdILhqXzAdL8C1FHJd0N.5nGVIz7tRxzhuHJfzLDFfQAEZQhEVh2', NULL, '2025-10-02 11:11:49', '2025-10-02 11:11:49'),
(102, NULL, 'Pedro Reyes', 'pedro.r', 'pedro@example.com', 'student', NULL, '$2y$12$FcVy9XdH0gvdWWrr4A1skOCC/1VgcKPLNLkt1jtVgmRm./3z.s1vy', NULL, '2025-10-02 11:11:50', '2025-10-02 11:11:50'),
(106, NULL, 'One Student', 'student.2500037', 'blutech18@gmail.com', 'student', NULL, '$2y$12$MTBN6MzQfyhWhajbzTMcl.KPnyS82PMfXtLyf9olkWnLWvNEVT1PC', NULL, '2025-10-02 22:18:15', '2025-10-02 22:18:15'),
(107, NULL, 'Curry Curry', 'curry.2500039', 'cristanjade70@gmail.com', 'student', NULL, '$2y$12$oXcx0jlj4zUXPJ8dqb7Aoe64uVy507P7bxM807iVXtj0SIHNsvu22', NULL, '2025-10-03 02:59:42', '2025-10-03 02:59:42'),
(110, NULL, 'Family Love', 'love.flove-524256', 'cristanjade166@gmail.com', 'student', NULL, '$2y$12$h0mIGGCfIIlVI6vsiHLiNu6R/XYwXbA3H7tStEQdxRHAoDn23CeP6', NULL, '2025-10-03 09:29:09', '2025-10-03 09:29:09'),
(111, NULL, 'Ishigami Sensku', 'sensku.2500041', 'cristanjade10@gmail.com', 'student', NULL, '$2y$12$OENERjBoAOCghsVTKFJ2fuWKSt6F7.9A3e4s0G92i7JiL0bwlzMj.', NULL, '2025-10-03 09:40:14', '2025-10-03 09:40:14'),
(112, NULL, 'dasdasd dasdasd', 'dasdasd.2500042', 'customer@gmail.com', 'student', NULL, '$2y$12$lKCvgIgUYBkX0JLPrhZYiu6ks6FWV.UngmsTPreTrr/Kv90pVk4ou', NULL, '2025-10-03 10:10:08', '2025-10-03 10:10:08'),
(113, NULL, 'Pasko Pooooo', 'ooooo.INS-2025-002', 'customer12@gmail.com', 'instructor', NULL, '$2y$12$Wy/KlBrzY23kbFUhUZx.5.y56wdx4i/0FElW9RpR7DKC1RxGot/hK', NULL, '2025-10-03 19:12:54', '2025-10-03 19:12:54'),
(114, NULL, 'Jessica Pooooo', 'ooooo.INS-2025-003', 'customer13@gmail.com', 'instructor', NULL, '$2y$12$b9YG.MCjS5mh.Jhtx7M4k.t/w.tMe0fYWun3TscKHJvCGLRyXIc82', NULL, '2025-10-03 19:21:56', '2025-10-03 19:21:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academic_years_year_name_unique` (`year_name`);

--
-- Indexes for table `archived_attendance`
--
ALTER TABLE `archived_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archived_attendance_archived_student_id_academic_year_index` (`archived_student_id`,`academic_year`);

--
-- Indexes for table `archived_grades`
--
ALTER TABLE `archived_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archived_grades_archived_student_id_academic_year_index` (`archived_student_id`,`academic_year`);

--
-- Indexes for table `archived_students`
--
ALTER TABLE `archived_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archived_students_academic_year_index` (`academic_year`),
  ADD KEY `archived_students_original_student_id_index` (`original_student_id`),
  ADD KEY `archived_students_academic_year_grade_level_id_index` (`academic_year`,`grade_level_id`);

--
-- Indexes for table `archive_logs`
--
ALTER TABLE `archive_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archive_logs_academic_year_index` (`academic_year`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `attendance_instructor_class_id_date_index` (`instructor_class_id`,`date`),
  ADD KEY `attendance_student_id_date_index` (`student_id`,`date`),
  ADD KEY `attendance_instructor_class_id_student_id_date_index` (`instructor_class_id`,`student_id`,`date`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_strand_id_foreign` (`strand_id`);

--
-- Indexes for table `class_announcements`
--
ALTER TABLE `class_announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_values`
--
ALTER TABLE `core_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `core_values_slug_unique` (`slug`);

--
-- Indexes for table `core_value_evaluations`
--
ALTER TABLE `core_value_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cve_student_id_index` (`student_id`),
  ADD KEY `cve_core_value_id_index` (`core_value_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_class_id_foreign` (`class_id`),
  ADD KEY `grades_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `grade_level`
--
ALTER TABLE `grade_level`
  ADD PRIMARY KEY (`grade_level_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`),
  ADD UNIQUE KEY `instructors_email_unique` (`email`),
  ADD KEY `instructors_user_id_foreign` (`user_id`),
  ADD KEY `instructors_instructor_school_id_foreign` (`instructor_school_id`),
  ADD KEY `instructors_advisory_section_id_foreign` (`advisory_section_id`);

--
-- Indexes for table `instructor_classes`
--
ALTER TABLE `instructor_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_classes_instructor_id_foreign` (`instructor_id`),
  ADD KEY `instructor_classes_class_id_foreign` (`class_id`);

--
-- Indexes for table `instructor_ids`
--
ALTER TABLE `instructor_ids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `instructor_ids_instructor_number_unique` (`instructor_number`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_student_enrollees`
--
ALTER TABLE `new_student_enrollees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `new_student_enrollees_email_unique` (`email`),
  ADD UNIQUE KEY `new_student_enrollees_application_number_unique` (`application_number`);

--
-- Indexes for table `old_student_enrollees`
--
ALTER TABLE `old_student_enrollees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `old_student_enrollees_application_number_unique` (`application_number`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `schedules_instructor_class_id_foreign` (`instructor_class_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_grade_level` (`grade_level_id`),
  ADD KEY `idx_strand` (`strand_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strands`
--
ALTER TABLE `strands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strand_assessment_results`
--
ALTER TABLE `strand_assessment_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `strand_assessment_results_email_completed_at_index` (`email`,`completed_at`),
  ADD KEY `strand_assessment_results_enrollment_id_foreign` (`enrollment_id`),
  ADD KEY `strand_assessment_results_email_index` (`email`),
  ADD KEY `strand_assessment_results_academic_year_id_foreign` (`academic_year_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `students_lrn_unique` (`lrn`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_grade_level_id_index` (`grade_level_id`);

--
-- Indexes for table `student_id`
--
ALTER TABLE `student_id`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id_student_number_unique` (`student_number`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_class_id_foreign` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `archived_attendance`
--
ALTER TABLE `archived_attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archived_grades`
--
ALTER TABLE `archived_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archived_students`
--
ALTER TABLE `archived_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archive_logs`
--
ALTER TABLE `archive_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `class_announcements`
--
ALTER TABLE `class_announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `core_value_evaluations`
--
ALTER TABLE `core_value_evaluations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `grade_level`
--
ALTER TABLE `grade_level`
  MODIFY `grade_level_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `instructor_classes`
--
ALTER TABLE `instructor_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- AUTO_INCREMENT for table `instructor_ids`
--
ALTER TABLE `instructor_ids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `new_student_enrollees`
--
ALTER TABLE `new_student_enrollees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `old_student_enrollees`
--
ALTER TABLE `old_student_enrollees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `strands`
--
ALTER TABLE `strands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `strand_assessment_results`
--
ALTER TABLE `strand_assessment_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1009;

--
-- AUTO_INCREMENT for table `student_id`
--
ALTER TABLE `student_id`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archived_attendance`
--
ALTER TABLE `archived_attendance`
  ADD CONSTRAINT `archived_attendance_archived_student_id_foreign` FOREIGN KEY (`archived_student_id`) REFERENCES `archived_students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `archived_grades`
--
ALTER TABLE `archived_grades`
  ADD CONSTRAINT `archived_grades_archived_student_id_foreign` FOREIGN KEY (`archived_student_id`) REFERENCES `archived_students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_strand_id_foreign` FOREIGN KEY (`strand_id`) REFERENCES `strands` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `core_value_evaluations`
--
ALTER TABLE `core_value_evaluations`
  ADD CONSTRAINT `cve_core_value_fk` FOREIGN KEY (`core_value_id`) REFERENCES `core_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cve_student_fk` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `instructors`
--
ALTER TABLE `instructors`
  ADD CONSTRAINT `instructors_advisory_section_id_foreign` FOREIGN KEY (`advisory_section_id`) REFERENCES `section` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `instructors_instructor_school_id_foreign` FOREIGN KEY (`instructor_school_id`) REFERENCES `instructor_ids` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `instructor_classes`
--
ALTER TABLE `instructor_classes`
  ADD CONSTRAINT `instructor_classes_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_classes_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_instructor_class_id_foreign` FOREIGN KEY (`instructor_class_id`) REFERENCES `instructor_classes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `strand_assessment_results`
--
ALTER TABLE `strand_assessment_results`
  ADD CONSTRAINT `strand_assessment_results_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `strand_assessment_results_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `new_student_enrollees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_grade_level_id_foreign` FOREIGN KEY (`grade_level_id`) REFERENCES `grade_level` (`grade_level_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
