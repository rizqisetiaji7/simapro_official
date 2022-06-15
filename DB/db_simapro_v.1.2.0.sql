-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2022 at 01:59 PM
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
  `chat_status` enum('ok','pending') NOT NULL,
  `chat_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 10, NULL, 'project_doc/doc-1.jpg', '2022-06-09 09:04:22', NULL),
(2, 12, NULL, 'project_doc/doc-2.jpg', '2022-06-09 09:04:22', NULL),
(3, 12, NULL, 'project_doc/doc-3.jpg', '2022-06-09 09:04:22', NULL),
(4, 12, 18, 'subproject_doc/subdoc-1.jpg', '2022-06-09 12:54:26', NULL),
(5, 12, 18, 'subproject_doc/subdoc-2.jpg', '2022-06-09 12:54:26', NULL);

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
(1, 'Rendah', 'bg-inverse-success'),
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
  `project_status` enum('pending','archive','review','finish','revision','on_progress','approved') DEFAULT NULL,
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
(10, 22, 1, 'PROYM48329', 'Rumah Sakit Kawali', 'b782e0cd9b78ed899e3453ff74651f11.jpg', 'Desa Kawali, Kab. Ciamis', 'Proyek pembangunan Rumah Sakit umum daerah Kawali.', '2022-06-09', '2022-06-14', '2022-06-09', 'finish', NULL, '2022-06', 100, '0', '2022-06-08 17:12:36', '2022-06-11 15:04:30'),
(11, 18, 1, 'PROYM65027', 'Pembangunan SDN 1 Kujangsari', 'placeholder.jpg', 'Kota Banjar, Jawa Barat', '', '2022-06-14', '2022-06-26', '2022-10-03', 'finish', NULL, '2022-10', 100, '0', '2022-06-08 20:05:39', '2022-06-10 15:31:13'),
(12, 18, 1, 'PROYM60172', 'Proyek Pembangunan SMPN 8 Banjar', '5e1e26a2b79e3c8c3e162cfa9acd4c47.jpg', 'Jl. Raya Kujang No. 77, Kota Banjar', 'Pembangunan proyek sekolah menengah negeri, yang dibagun di wilayah pedesaan di kota banjar', '2022-06-08', '2022-12-02', '2022-06-09', 'pending', NULL, '2022-06', 100, '1', '2022-06-08 20:06:55', '2022-06-09 20:21:43'),
(13, 18, 1, 'PROYM27016', 'dsgdhsgd', 'placeholder.jpg', 'jhdjshjds', 'sdssjhds', '2022-06-09', '2022-06-30', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-09 21:09:47', NULL),
(14, 22, 1, 'PROYM56814', 'Perbaikan Jembatan Cirahong', '7cb6a6ba38b9f0ce568688b1488afcff.jpg', 'Desa Cirahong, Kab. Ciamis', 'Project Perbaikan jembatan', '2022-06-09', '2023-07-14', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-09 21:25:03', '2022-06-10 16:38:46'),
(15, 24, 1, 'PROYM78439', 'Proyek anu 1', 'placeholder.jpg', 'Banjar', '', '2022-06-03', '2022-07-09', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 16:00:02', NULL),
(16, 24, 1, 'PROYM06217', 'Proyek PT.Anu 003', 'placeholder.jpg', 'Bandung, Jabar', '', '2022-06-10', '2022-08-26', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 16:00:43', NULL),
(17, 24, 1, 'PROYM58169', 'Pembangunan Pesantren Darussalam', '11ea7189c53d10192a317ffb27bfec22.jpg', 'Kab. Ciamis, Jawa Barat', '', '2022-06-15', '2022-11-26', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 19:15:15', NULL),
(18, 24, 1, 'PROYM69413', 'okeokok', 'placeholder.jpg', 'anjay alamat', '', '2022-06-03', '2022-09-24', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 20:15:22', NULL),
(19, 22, 1, 'PROYM93468', 'oke lagi', '8de2fdbfab275a58d06eccc7c419522c.jpg', 'banjarsari', '', '2022-06-08', '2024-01-04', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 20:26:25', NULL),
(20, 24, 1, 'PROYM79158', 'tes lagi', '5651f82d8b9dd2da46e0c52f681303ab.png', 'okeokeoko', '', '2022-08-17', '2023-05-25', NULL, 'on_progress', NULL, NULL, 0, '0', '2022-06-15 20:35:15', NULL);

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
  `project_task_status` enum('pending','onprogress','finish') DEFAULT NULL,
  `project_task_progress` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_project_task`
--

INSERT INTO `tb_project_task` (`project_task_id`, `ID_subproject`, `ID_priority`, `project_task_name`, `project_task_deadline`, `project_task_status`, `project_task_progress`, `created`, `updated`) VALUES
(10, 13, 1, 'List 2', '2022-06-25', NULL, 0, '2022-06-08 23:32:51', NULL),
(12, 14, 1, 'List 1', '2022-07-01', NULL, 0, '2022-06-08 23:34:47', NULL),
(13, 14, 3, 'List 2', '2022-06-22', NULL, 0, '2022-06-08 23:35:03', NULL),
(14, 18, 1, 'llk yes', '2022-06-14', 'onprogress', 50, '2022-06-09 01:16:52', '2022-06-09 13:04:20'),
(15, 19, 1, 'Ngecor', '2022-06-29', NULL, 0, '2022-06-11 16:25:50', NULL);

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
(13, 10, 2, 'oke subproyek 1', '2022-06-25', NULL, 0, 'kanban-success', '2022-06-08 23:27:58', '2022-06-08 23:28:31'),
(14, 10, 2, 'Subproyek 2', '2022-07-22', NULL, 0, 'kanban-danger', '2022-06-08 23:34:30', NULL),
(15, 12, 3, 'oke', '2022-06-17', NULL, 0, 'kanban-success', '2022-06-09 01:08:32', NULL),
(17, 12, 1, 'ofok', '2022-06-23', NULL, 0, 'kanban-danger', '2022-06-09 01:10:44', '2022-06-09 01:16:09'),
(18, 12, 1, 'oke yeyeyey', '2022-06-17', NULL, 0, 'kanban-info', '2022-06-09 01:16:37', '2022-06-09 12:43:56'),
(19, 14, 1, 'Pondasi', '2022-06-17', NULL, 0, 'kanban-danger', '2022-06-11 16:24:16', NULL),
(20, 14, 1, 'Pemasangan rangka besi', '2022-06-30', NULL, 0, 'kanban-success', '2022-06-11 16:42:10', NULL);

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
(18, 1, 'pm', 'PMM79540', 'default-avatar.jpg', 'User PM 3 3', 'userpm3@gmail.com', '$2y$10$yvB.WA9Y.yp036eE5Tfo1e.D1nlRJPNGEQ.1yaLl9bnRghfun3W1e', '', '', NULL, NULL, '0', 'off', '2022-06-07 21:46:42', '2022-06-11 15:44:31'),
(22, 1, 'pm', 'PMM79812', 'default-avatar.jpg', 'Hari Nurdin', 'harister@gmail.com', '$2y$10$dUtPCptmXo1SuNcV53EdJOLhtBKIcLxoHWbdhW2bEEMQdDA4sRkeS', '', '', NULL, NULL, '0', 'off', '2022-06-10 16:34:53', NULL),
(24, 1, 'pm', 'PMM87690', 'default-avatar.jpg', 'Rizqi PM', 'rizqisetiaji1@gmail.com', '$2y$10$qvZ49TmU1QrSSxfaKyiCN.x7p8AA6Zt8eOOCgFRMsUHIL1074aoTa', '089519598888', '', NULL, NULL, '0', 'on', '2022-06-11 18:39:13', '2022-06-15 17:48:15');

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
  ADD KEY `ID_priority` (`ID_priority`);

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
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_photo`
--
ALTER TABLE `tb_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_priority`
--
ALTER TABLE `tb_priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_project_task`
--
ALTER TABLE `tb_project_task`
  MODIFY `project_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_subproject`
--
ALTER TABLE `tb_subproject`
  MODIFY `subproject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
