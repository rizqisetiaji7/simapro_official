-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2022 at 07:04 AM
-- Server version: 10.5.11-MariaDB-log
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simapro`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_company`
--

CREATE TABLE `tb_company` (
  `company_id` int(11) NOT NULL,
  `comp_parent_id` int(11) NOT NULL DEFAULT 0,
  `comp_code` text DEFAULT NULL,
  `comp_prefix` varchar(5) NOT NULL,
  `comp_name` varchar(255) NOT NULL,
  `comp_logo` varchar(255) DEFAULT NULL,
  `comp_email` varchar(150) DEFAULT NULL,
  `comp_phone` char(15) DEFAULT NULL,
  `comp_address` text DEFAULT NULL,
  `comp_type` enum('CV','PT') DEFAULT NULL,
  `comp_desc` longtext DEFAULT NULL,
  `comp_since` date DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_company`
--

INSERT INTO `tb_company` (`company_id`, `comp_parent_id`, `comp_code`, `comp_prefix`, `comp_name`, `comp_logo`, `comp_email`, `comp_phone`, `comp_address`, `comp_type`, `comp_desc`, `comp_since`, `created`, `updated`) VALUES
(1, 0, 'COMP2003021247635', 'M', 'PT. Aryabakti Saluyu', '83f3a83265126472180ef67b4ddc16bc.png', 'aryabakti@gmail.com', '087665332445', 'Kab. Ciamis, Jawa Barat', 'PT', '', '2003-02-12', '2022-05-11 13:07:40', '2022-06-08 22:35:55'),
(2, 1, 'COMP2017070570462518', 'SM1', 'CV. Lima Utama', 'limautama-logo.jpg', 'didu_ciamis@yahoo.com', '087665778990', '', 'CV', '', '2017-07-05', '2022-05-11 13:07:40', '2022-05-23 12:46:03'),
(3, 1, NULL, 'SM2', 'CV. Berkah Jaya Buana', 'berkahjayabuana-logo.jpg', '', NULL, NULL, 'CV', NULL, NULL, '2022-05-11 13:07:40', NULL),
(4, 1, NULL, 'SM3', 'CV. Putra Jaya', 'putrajaya-logo.jpg', 'cvputrajaya51@gmail.com', NULL, NULL, 'CV', NULL, NULL, '2022-05-11 13:07:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_livechat`
--

CREATE TABLE `tb_livechat` (
  `chat_id` int(11) NOT NULL,
  `ID_project` int(11) NOT NULL,
  `ID_sender` int(11) NOT NULL,
  `ID_receiver` int(11) NOT NULL,
  `chat_message` longtext NOT NULL,
  `chat_type` enum('text','task') NOT NULL DEFAULT 'text',
  `chat_status` enum('ok','pending') DEFAULT NULL,
  `chat_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_livechat`
--

INSERT INTO `tb_livechat` (`chat_id`, `ID_project`, `ID_sender`, `ID_receiver`, `chat_message`, `chat_type`, `chat_status`, `chat_created`) VALUES
(1, 14, 1, 22, 'Helo bro?', 'text', NULL, '2022-06-28 13:05:32'),
(2, 14, 22, 1, 'Hai bro, apa kabar?', 'text', NULL, '2022-06-28 13:05:32'),
(3, 26, 1, 24, 'Anjay,, tes livechat', 'text', NULL, '2022-06-28 13:45:19'),
(4, 26, 24, 1, 'Sok, mangga bro...', 'text', NULL, '2022-06-28 13:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_photo`
--

CREATE TABLE `tb_photo` (
  `photo_id` int(11) NOT NULL,
  `ID_project` int(11) DEFAULT NULL,
  `ID_subproject` int(11) DEFAULT NULL,
  `photo_url` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_photo`
--

INSERT INTO `tb_photo` (`photo_id`, `ID_project`, `ID_subproject`, `photo_url`, `created`, `updated`) VALUES
(69, 22, 32, 'subproject_doc/3c5aecf86e7fc3d15ce771381c73e7c3.jpg', '2022-06-21 12:40:01', NULL),
(70, 22, 32, 'subproject_doc/e4e785556a2602deef6cfec576361c1b.jpg', '2022-06-21 12:40:01', NULL),
(71, 22, 32, 'subproject_doc/5c6c44c3579bb378e258aaeaead9cb59.jpg', '2022-06-21 12:40:02', NULL),
(73, 22, NULL, 'project_doc/3ced7831072b773c6f186d5b6f78de14.jpg', '2022-06-21 12:41:03', NULL),
(74, 22, NULL, 'project_doc/1cf31dafd417b95653c3d5e6d241e788.jpg', '2022-06-21 12:41:05', NULL),
(76, 22, 35, 'subproject_doc/b41da0858f6a2a68c19158693d565121.jpg', '2022-06-21 15:59:21', NULL),
(77, 22, 34, 'subproject_doc/99c27ec1f787856daea5c865497540c4.png', '2022-06-21 16:03:40', NULL),
(78, 22, 34, 'subproject_doc/ce24cadca356b1ac507af1de8b5af7c1.jpg', '2022-06-21 16:03:41', NULL),
(80, 22, 33, 'subproject_doc/897a7c3d2cea3a1d5eb27333995944fd.jpg', '2022-06-21 16:18:43', NULL),
(81, 22, 36, 'subproject_doc/731ca443b8eb72723f354a6b01219687.jpg', '2022-06-22 18:17:22', NULL),
(82, 22, 36, 'subproject_doc/215d1537680ecc30a43d265f50568403.jpg', '2022-06-22 18:17:22', NULL),
(83, 23, 37, 'subproject_doc/8e452554bef0c7dce35aa486f4125962.jpg', '2022-06-26 10:47:05', NULL),
(84, 23, 37, 'subproject_doc/a39e5d266b8ce605733bf232474821fe.JPG', '2022-06-26 10:47:06', NULL),
(85, 23, NULL, 'project_doc/a518b4fe2e0d8e1ca8cd31aa13a304ae.jpg', '2022-06-26 10:47:44', NULL),
(93, 17, NULL, 'project_doc/996bc2b16cf515862de72dd53616c297.jpeg', '2022-06-26 17:14:57', NULL),
(94, 17, 39, 'subproject_doc/3a7936839d1c2cd7fb44990235a699ef.jpeg', '2022-06-26 17:15:18', NULL),
(95, 25, NULL, 'project_doc/dcf75c015dcf4735a5d5bc62ed4ebc51.jpeg', '2022-06-27 19:27:13', NULL),
(96, 25, NULL, 'project_doc/570c2a712a01afb08d1b86c21c88b13c.jpeg', '2022-06-27 19:27:15', NULL),
(97, 25, 43, 'subproject_doc/308b5828babb124badc5f29b511ad30f.jpeg', '2022-06-27 19:28:41', NULL),
(98, 25, 44, 'subproject_doc/49df6ed177d95c14763810597ffe0536.jpeg', '2022-06-27 21:27:46', NULL),
(100, 25, 46, 'subproject_doc/a9cc9b390d7db0a0352cf7fab46e4378.jpeg', '2022-06-27 21:35:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_priority`
--

CREATE TABLE `tb_priority` (
  `priority_id` int(11) NOT NULL,
  `priority_name` varchar(128) NOT NULL,
  `priority_color` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_priority`
--

INSERT INTO `tb_priority` (`priority_id`, `priority_name`, `priority_color`) VALUES
(1, 'Rendah', 'bg-inverse-warning'),
(2, 'Normal', 'bg-inverse-info'),
(3, 'Tinggi', 'bg-inverse-danger');

-- --------------------------------------------------------

--
-- Table structure for table `tb_project`
--

CREATE TABLE `tb_project` (
  `project_id` int(11) NOT NULL,
  `ID_pm` int(11) DEFAULT NULL,
  `ID_company` int(11) NOT NULL,
  `project_code_ID` text NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_thumbnail` text DEFAULT NULL,
  `project_address` text DEFAULT NULL,
  `project_description` longtext DEFAULT NULL,
  `project_start` date NOT NULL,
  `project_deadline` date NOT NULL,
  `project_current_deadline` date DEFAULT NULL,
  `project_status` enum('none','pending','archive','review','finish','revision','on_progress') DEFAULT NULL,
  `project_deadline_status` enum('lebih_awal','tepat_waktu','terlambat') DEFAULT NULL,
  `project_deadline_month` varchar(15) DEFAULT NULL,
  `project_progress` float DEFAULT NULL,
  `project_archive` enum('1','0') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_project`
--

INSERT INTO `tb_project` (`project_id`, `ID_pm`, `ID_company`, `project_code_ID`, `project_name`, `project_thumbnail`, `project_address`, `project_description`, `project_start`, `project_deadline`, `project_current_deadline`, `project_status`, `project_deadline_status`, `project_deadline_month`, `project_progress`, `project_archive`, `created`, `updated`) VALUES
(10, 22, 1, 'PROYM48329', 'Rumah Sakit Kawali', 'b782e0cd9b78ed899e3453ff74651f11.jpg', 'Desa Kawali, Kab. Ciamis', 'Proyek pembangunan Rumah Sakit umum daerah Kawali.', '2022-06-09', '2022-06-14', '2022-06-09', 'pending', NULL, '2022-06', 100, '1', '2022-06-08 17:12:36', '2022-06-11 15:04:30'),
(11, 18, 1, 'PROYM65027', 'Pembangunan SDN 1 Kujangsari', 'placeholder.jpg', 'Kota Banjar, Jawa Barat', '', '2022-06-14', '2022-06-26', '2022-10-03', 'finish', NULL, '2022-10', 100, '0', '2022-06-08 20:05:39', '2022-06-10 15:31:13'),
(12, 18, 1, 'PROYM60172', 'Proyek Pembangunan SMPN 8 Banjar', '5e1e26a2b79e3c8c3e162cfa9acd4c47.jpg', 'Jl. Raya Kujang No. 77, Kota Banjar', 'Pembangunan proyek sekolah menengah negeri, yang dibagun di wilayah pedesaan di kota banjar', '2022-06-08', '2022-12-02', '2022-06-09', 'pending', NULL, '2022-06', 100, '1', '2022-06-08 20:06:55', '2022-06-09 20:21:43'),
(13, 18, 1, 'PROYM27016', 'dsgdhsgd', 'placeholder.jpg', 'jhdjshjds', 'sdssjhds', '2022-06-09', '2022-06-30', NULL, 'pending', NULL, NULL, 0, '1', '2022-06-09 21:09:47', NULL),
(14, 22, 1, 'PROYM56814', 'Perbaikan Jembatan Cirahong', '7cb6a6ba38b9f0ce568688b1488afcff.jpg', 'Desa Cirahong, Kab. Ciamis', 'Project Perbaikan jembatan', '2022-06-09', '2023-07-14', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-09 21:25:03', '2022-06-10 16:38:46'),
(15, 24, 1, 'PROYM78439', 'Proyek anu 1', 'placeholder.jpg', 'Banjar', '', '2022-06-03', '2022-07-09', NULL, 'pending', NULL, NULL, 0, '1', '2022-06-15 16:00:02', NULL),
(16, 24, 1, 'PROYM06217', 'Proyek PT.Anu 003', 'placeholder.jpg', 'Bandung, Jabar', '', '2022-06-10', '2022-08-26', NULL, 'pending', NULL, NULL, 0, '1', '2022-06-15 16:00:43', NULL),
(17, 24, 1, 'PROYM58169', 'Pembangunan Pesantren', '11ea7189c53d10192a317ffb27bfec22.jpg', 'Kab. Ciamis, Jawa Barat', 'Oke', '2022-06-15', '2022-11-26', NULL, 'on_progress', NULL, NULL, 100, '0', '2022-06-15 19:15:15', '2022-06-26 16:59:36'),
(18, 24, 1, 'PROYM69413', 'okeokok', 'placeholder.jpg', 'anjay alamat', '', '2022-06-03', '2022-09-24', NULL, 'pending', NULL, NULL, 0, '1', '2022-06-15 20:15:22', NULL),
(19, 22, 1, 'PROYM93468', 'oke lagi', '8de2fdbfab275a58d06eccc7c419522c.jpg', 'banjarsari', '', '2022-06-08', '2024-01-04', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 20:26:25', NULL),
(20, 24, 1, 'PROYM79158', 'tes lagi', '5651f82d8b9dd2da46e0c52f681303ab.png', 'okeokeoko', '', '2022-08-17', '2023-05-25', NULL, 'pending', NULL, NULL, 0, '1', '2022-06-15 20:35:15', NULL),
(21, 18, 1, 'PROYM37865', 'Oke lagi', 'placeholder.jpg', 'okeokeo', '', '2022-06-14', '2023-01-25', NULL, 'review', NULL, NULL, 0, '0', '2022-06-16 10:23:48', NULL),
(22, 24, 1, 'PROYM06793', 'Pembangunan Sekolah SDN 1 Kujangsari', 'a2c78ca161091518a91d4fee604485e9.jpg', 'Desa Kujangsari, Kota Banjar, Jawa Barat', '', '2022-02-03', '2023-09-02', '2022-06-27', 'finish', NULL, '2022-06', 100, '0', '2022-06-16 10:26:07', '2022-06-27 17:56:44'),
(23, 24, 1, 'PROYM83275', 'Perbaikan Pondasi Sungai Citanduy', 'placeholder.jpg', 'Ciamis', '', '2022-06-16', '2023-02-13', NULL, 'on_progress', NULL, NULL, 100, '0', '2022-06-16 21:42:03', '2022-06-26 10:48:41'),
(24, 24, 1, 'PROYM40128', 'oke', 'placeholder.jpg', 'elk', 'krke', '2022-07-02', '2022-06-28', NULL, 'pending', NULL, NULL, 0, '1', '2022-06-26 17:21:09', NULL),
(25, 24, 1, 'PROYM76098', 'Oke Proyek', 'placeholder.jpg', 'Banjar Ptroman', '', '2022-06-30', '2022-07-07', '2022-06-27', 'finish', NULL, '2022-06', 100, '0', '2022-06-27 19:24:23', '2022-06-27 21:44:32'),
(26, 24, 1, 'PROYM61432', 'Kapus UBSI', '6aad5d88c00847871e57ad92f4c13e19.jpeg', 'Tasikmalaya', '', '2022-06-28', '2023-03-02', NULL, 'none', NULL, NULL, 0, '0', '2022-06-27 21:57:14', NULL),
(27, 18, 1, 'PROYM82619', 'Bank Indonesia', 'ca2c7afe9bef104e1a5f634ecc1c140b.jpeg', 'Banjarsari', '', '2022-06-30', '2022-12-08', NULL, 'none', NULL, NULL, 0, '0', '2022-06-27 22:00:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_project_task`
--

CREATE TABLE `tb_project_task` (
  `project_task_id` int(11) NOT NULL,
  `ID_subproject` int(11) NOT NULL,
  `ID_priority` int(11) NOT NULL,
  `project_task_name` varchar(150) NOT NULL,
  `project_task_deadline` date NOT NULL,
  `project_task_status` enum('none','pending','onprogress','finish') DEFAULT 'none',
  `project_task_progress` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_project_task`
--

INSERT INTO `tb_project_task` (`project_task_id`, `ID_subproject`, `ID_priority`, `project_task_name`, `project_task_deadline`, `project_task_status`, `project_task_progress`, `created`, `updated`) VALUES
(43, 33, 1, 'lklksld 02', '2022-07-08', 'finish', 100, '2022-06-21 12:42:52', '2022-06-21 15:45:20'),
(47, 35, 1, 'tes', '2022-06-25', 'finish', 100, '2022-06-21 15:50:38', '2022-06-21 17:00:52'),
(48, 36, 1, 'cek 1', '2022-06-26', 'finish', 100, '2022-06-21 20:16:36', '2022-06-22 16:17:42'),
(49, 36, 1, 'lod', '2022-07-25', 'finish', 100, '2022-06-21 20:17:03', '2022-06-22 16:18:18'),
(50, 36, 2, 'mdn', '2022-10-07', 'finish', 100, '2022-06-21 20:17:24', '2022-06-22 16:18:08'),
(51, 35, 1, 'kllwe', '2022-07-09', 'finish', 100, '2022-06-21 20:17:50', '2022-06-22 16:17:29'),
(52, 36, 3, 'klskd', '2022-07-25', 'finish', 100, '2022-06-21 20:18:59', '2022-06-22 16:17:57'),
(53, 37, 2, 'tes 1', '2022-06-24', 'finish', 100, '2022-06-23 08:32:13', '2022-06-26 10:48:09'),
(55, 38, 1, 'tes lagi 2', '2022-06-27', 'finish', 100, '2022-06-26 10:49:01', '2022-06-26 10:50:23'),
(56, 38, 2, 'tes lagi 3', '2022-07-01', 'finish', 100, '2022-06-26 10:49:21', '2022-06-26 10:50:09'),
(57, 39, 1, 'tes 1', '2022-06-29', 'finish', 100, '2022-06-26 15:26:15', '2022-06-26 15:32:38'),
(59, 41, 2, 'oke lagi 1', '2022-07-06', 'none', 0, '2022-06-26 21:23:33', NULL),
(62, 44, 3, 'Lists 1', '2022-06-29', 'finish', 100, '2022-06-27 19:31:44', '2022-06-27 21:26:57'),
(63, 44, 2, 'Lists 2xxx', '2022-07-01', 'finish', 100, '2022-06-27 19:32:02', '2022-06-27 21:26:10'),
(67, 46, 2, 'Lis baru 1', '2022-07-04', 'finish', 100, '2022-06-27 21:30:22', '2022-06-27 21:31:52'),
(68, 46, 3, 'yes', '2022-07-06', 'finish', 100, '2022-06-27 21:30:44', '2022-06-27 21:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_subproject`
--

CREATE TABLE `tb_subproject` (
  `subproject_id` int(11) NOT NULL,
  `ID_project` int(11) NOT NULL,
  `ID_priority` int(11) NOT NULL,
  `subproject_name` varchar(150) NOT NULL,
  `subproject_deadline` date DEFAULT NULL,
  `subproject_status` enum('onprogress','pending','finish') DEFAULT NULL,
  `subproject_progress` float DEFAULT NULL,
  `panel_color` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_subproject`
--

INSERT INTO `tb_subproject` (`subproject_id`, `ID_project`, `ID_priority`, `subproject_name`, `subproject_deadline`, `subproject_status`, `subproject_progress`, `panel_color`, `created`, `updated`) VALUES
(33, 22, 2, 'Lapangan Upacara', '2022-06-27', NULL, 100, 'kanban-purple', '2022-06-21 12:38:33', NULL),
(35, 22, 1, 'Ruang kelas', '2022-06-24', NULL, 100, 'kanban-success', '2022-06-21 15:50:08', '2022-06-21 20:54:53'),
(36, 22, 1, 'Perpustakaan', '2022-07-25', NULL, 100, 'kanban-warning', '2022-06-21 20:15:08', '2022-06-21 20:55:06'),
(37, 23, 2, 'oke', '2022-06-17', NULL, 100, 'kanban-success', '2022-06-23 08:23:36', NULL),
(38, 23, 3, 'oke 2', '2022-08-20', NULL, 100, 'kanban-info', '2022-06-26 10:48:41', NULL),
(39, 17, 1, 'Lahan Masjid', '2022-07-29', NULL, 100, 'kanban-danger', '2022-06-26 15:26:02', NULL),
(41, 12, 1, 'tes', '2022-06-30', NULL, 0, 'kanban-warning', '2022-06-26 21:23:15', NULL),
(42, 14, 1, 'Subproj 1', '2022-07-06', NULL, 0, 'kanban-purple', '2022-06-27 18:23:58', NULL),
(44, 25, 2, 'Sub-Proj 01', '2022-07-21', NULL, 100, 'kanban-purple', '2022-06-27 19:31:18', NULL),
(46, 25, 1, 'oke sip', '2022-07-09', NULL, 100, 'kanban-danger', '2022-06-27 21:30:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `ID_company` int(11) DEFAULT NULL,
  `user_role` enum('direktur','pm') NOT NULL,
  `user_unique_id` varchar(50) DEFAULT NULL,
  `user_profile` text DEFAULT NULL,
  `user_fullname` varchar(145) NOT NULL,
  `user_email` varchar(145) NOT NULL,
  `user_password` text NOT NULL,
  `user_phone` char(15) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `token` text DEFAULT NULL,
  `token_expiry` bigint(20) DEFAULT NULL,
  `theme_mode` enum('1','0') NOT NULL DEFAULT '0',
  `login_status` enum('on','off') NOT NULL DEFAULT 'off',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `ID_company`, `user_role`, `user_unique_id`, `user_profile`, `user_fullname`, `user_email`, `user_password`, `user_phone`, `user_address`, `token`, `token_expiry`, `theme_mode`, `login_status`, `created`, `updated`) VALUES
(1, 1, 'direktur', 'DIRUTM39542', 'default-avatar.jpg', 'Rizqi Setiaji', 'rizqisetiaji9@gmail.com', '$2y$10$OQPFbuCTg1modHfYa1qaFeTE437ApFz2slZxxY9Fnlg5EeT0Hwgka', '08766889388', 'Kota Banjar, Jabar', NULL, NULL, '0', 'on', '2022-05-10 14:06:07', '2022-06-11 09:44:04'),
(3, 2, 'direktur', 'DIRUTM103872', 'efb1ae2c2552c5e93266265d3a109783.jpg', 'Om Jay', 'omjay@gmail.com', '$2y$10$Roey8h73Xam7pzc.HHnFHe/vfjFtQHCN2evfmEAfXJiTIiG1epG1a', '087321445778', NULL, NULL, NULL, '0', 'off', '2022-05-19 23:00:34', '2022-05-23 18:29:25'),
(7, 2, 'direktur', 'MDRM189760', 'default-avatar.jpg', 'Azhar Gunawan', 'gunawanazhar6@gmail.com', '$2y$10$ZqXNbZntAs7xx4Lw0eZ6BuTiwTchrj7XVmd9tVesdUVqA9ueu9opy', '081778554326', NULL, NULL, NULL, '0', 'off', '2022-05-24 12:27:42', NULL),
(8, 2, 'direktur', 'MDRM102657', 'default-avatar.jpg', 'Hari Nurdin', 'harnurdin@gmail.com', '$2y$10$H4GvUHgMbOItaoyTCY7cmuT0uf0lnD5/8CoocLprDWApb7TXLGKnm', NULL, 'Banjarsari, Kab. Ciamis', NULL, NULL, '0', 'off', '2022-05-24 12:27:42', NULL),
(9, 3, 'direktur', 'DIRUTM283140', '0a42c31ca7985807b73cc1f69c244195.jpg', 'Anya Forger', 'anyakawai@gmail.com', '$2y$10$8p9mkVyIJxS50Al7CMuJ6uVhhXHOTTLnj.Is6papl2yL26gKLn1vy', '0991887556', 'Ostania, Germany', NULL, NULL, '0', 'off', '2022-05-24 13:15:00', '2022-05-24 13:16:33'),
(18, 1, 'pm', 'PMM79540', 'default-avatar.jpg', 'User PM 669', 'userpm3@gmail.com', '$2y$10$yvB.WA9Y.yp036eE5Tfo1e.D1nlRJPNGEQ.1yaLl9bnRghfun3W1e', '', '', NULL, NULL, '0', 'off', '2022-06-07 21:46:42', '2022-06-26 15:02:33'),
(22, 1, 'pm', 'PMM79812', 'default-avatar.jpg', 'Hari Nurdin', 'harister@gmail.com', '$2y$10$dUtPCptmXo1SuNcV53EdJOLhtBKIcLxoHWbdhW2bEEMQdDA4sRkeS', '', '', NULL, NULL, '0', 'off', '2022-06-10 16:34:53', NULL),
(24, 1, 'pm', 'PMM87690', 'default-avatar.jpg', 'Rizqi PM', 'rizqisetiaji1@gmail.com', '$2y$10$qvZ49TmU1QrSSxfaKyiCN.x7p8AA6Zt8eOOCgFRMsUHIL1074aoTa', '089519598888', '', NULL, NULL, '0', 'on', '2022-06-11 18:39:13', '2022-06-26 20:01:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_company`
--
ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `tb_livechat`
--
ALTER TABLE `tb_livechat`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `ID_project` (`ID_project`),
  ADD KEY `ID_sender` (`ID_sender`),
  ADD KEY `ID_receiver` (`ID_receiver`);

--
-- Indexes for table `tb_photo`
--
ALTER TABLE `tb_photo`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `ID_project` (`ID_project`),
  ADD KEY `ID_subproject` (`ID_subproject`);

--
-- Indexes for table `tb_priority`
--
ALTER TABLE `tb_priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indexes for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `ID_mandor` (`ID_pm`),
  ADD KEY `ID_company` (`ID_company`);

--
-- Indexes for table `tb_project_task`
--
ALTER TABLE `tb_project_task`
  ADD PRIMARY KEY (`project_task_id`),
  ADD KEY `ID_subproject` (`ID_subproject`),
  ADD KEY `ID_priority` (`ID_priority`),
  ADD KEY `ID_subproject_2` (`ID_subproject`);

--
-- Indexes for table `tb_subproject`
--
ALTER TABLE `tb_subproject`
  ADD PRIMARY KEY (`subproject_id`),
  ADD KEY `ID_project` (`ID_project`),
  ADD KEY `ID_priority` (`ID_priority`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `ID_company` (`ID_company`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_company`
--
ALTER TABLE `tb_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_livechat`
--
ALTER TABLE `tb_livechat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_photo`
--
ALTER TABLE `tb_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `tb_priority`
--
ALTER TABLE `tb_priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tb_project_task`
--
ALTER TABLE `tb_project_task`
  MODIFY `project_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tb_subproject`
--
ALTER TABLE `tb_subproject`
  MODIFY `subproject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_project_task`
--
ALTER TABLE `tb_project_task`
  ADD CONSTRAINT `tb_project_task_ibfk_1` FOREIGN KEY (`ID_subproject`) REFERENCES `tb_subproject` (`subproject_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
