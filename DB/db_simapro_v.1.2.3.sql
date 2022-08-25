-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2022 at 05:09 AM
-- Server version: 10.8.3-MariaDB-log
-- PHP Version: 7.4.30

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_livechat`
--

INSERT INTO `tb_livechat` (`chat_id`, `ID_project`, `ID_sender`, `ID_receiver`, `chat_message`, `chat_type`, `chat_status`, `chat_created`) VALUES
(1, 1, 1, 5, 'tes', 'text', NULL, '2022-08-09 11:16:44'),
(2, 1, 5, 1, 'tes lagi', 'text', NULL, '2022-08-09 11:17:58'),
(3, 1, 5, 1, 'Assalamu\\\'alaikum', 'text', NULL, '2022-08-25 11:58:49');

-- --------------------------------------------------------

--
-- Table structure for table `tb_photo`
--

CREATE TABLE `tb_photo` (
  `photo_id` int(11) NOT NULL,
  `ID_project` int(11) DEFAULT NULL,
  `ID_subproject` int(11) DEFAULT NULL,
  `photo_url` text DEFAULT NULL,
  `photo_category` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_photo`
--

INSERT INTO `tb_photo` (`photo_id`, `ID_project`, `ID_subproject`, `photo_url`, `photo_category`, `created`, `updated`) VALUES
(1, 1, NULL, 'project_doc/96cad3b0d66fbc045871cbc9785f0070.JPG', NULL, '2022-08-09 11:14:14', NULL),
(2, 1, 1, 'subproject_doc/b02fa677d036b12fcea91dc51e6f4cdf.jpg', NULL, '2022-08-09 11:15:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_priority`
--

CREATE TABLE `tb_priority` (
  `priority_id` int(11) NOT NULL,
  `priority_name` varchar(128) NOT NULL,
  `priority_color` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_project`
--

INSERT INTO `tb_project` (`project_id`, `ID_pm`, `ID_company`, `project_code_ID`, `project_name`, `project_thumbnail`, `project_address`, `project_description`, `project_start`, `project_deadline`, `project_current_deadline`, `project_status`, `project_deadline_status`, `project_deadline_month`, `project_progress`, `project_archive`, `created`, `updated`) VALUES
(1, 5, 1, 'PROYM39208', 'Projek Rumah Sakit Kawali', '09df04b4521d3034317eabe15f40b4d9.jpg', 'Jl. KH. Ahmad Dahlan, No.30, RT/RW 05/07, Kecamatan Kawali, Kabupaten Ciamis, Jawa Barat', '', '2022-08-09', '2022-08-31', '2022-08-25', 'finish', NULL, '2022-08', 100, '0', '2022-08-09 10:45:48', '2022-08-25 11:55:08');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_project_task`
--

INSERT INTO `tb_project_task` (`project_task_id`, `ID_subproject`, `ID_priority`, `project_task_name`, `project_task_deadline`, `project_task_status`, `project_task_progress`, `created`, `updated`) VALUES
(1, 1, 2, 'Tes 1', '2022-08-10', 'finish', 100, '2022-08-09 10:50:19', '2022-08-09 11:15:18');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_subproject`
--

INSERT INTO `tb_subproject` (`subproject_id`, `ID_project`, `ID_priority`, `subproject_name`, `subproject_deadline`, `subproject_status`, `subproject_progress`, `panel_color`, `created`, `updated`) VALUES
(1, 1, 1, 'Pengadaan Barang', '2022-08-10', NULL, 100, 'kanban-success', '2022-08-09 10:49:59', NULL);

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
  `account_status` enum('disable','enable') DEFAULT 'enable',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `ID_company`, `user_role`, `user_unique_id`, `user_profile`, `user_fullname`, `user_email`, `user_password`, `user_phone`, `user_address`, `token`, `token_expiry`, `theme_mode`, `login_status`, `account_status`, `created`, `updated`) VALUES
(1, 1, 'direktur', 'DIRUTM39542', 'default-avatar.jpg', 'Rizqi Setiaji', 'rizqisetiaji9@gmail.com', '$2y$10$MC8jwY0axinI9fcyhCL2m.ynt68h.V91n.MWLP26SEVIpBlkyf2FS', '08766889388', 'Kota Banjar, Jabar', 'UNK1KkQhLdHhcVBpS6uwTGa0OeX2nrkMNvnDQR9kgpjyNElX', 1660022307, '0', 'off', 'enable', '2022-05-10 14:06:07', '2022-07-06 21:45:32'),
(2, 2, 'direktur', 'DIRUTM103872', 'efb1ae2c2552c5e93266265d3a109783.jpg', 'Om Jay', 'omjay@gmail.com', '$2y$10$Roey8h73Xam7pzc.HHnFHe/vfjFtQHCN2evfmEAfXJiTIiG1epG1a', '087321445778', NULL, NULL, NULL, '0', 'off', 'enable', '2022-05-19 23:00:34', '2022-05-23 18:29:25'),
(3, 3, 'direktur', 'DIRUTM283140', '0a42c31ca7985807b73cc1f69c244195.jpg', 'Sub-Direktur 2', 'subdirektur2@gmail.com', '$2y$10$8p9mkVyIJxS50Al7CMuJ6uVhhXHOTTLnj.Is6papl2yL26gKLn1vy', '0991887556', 'Ostania, Germany', NULL, NULL, '0', 'off', 'enable', '2022-05-24 13:15:00', '2022-05-24 13:16:33'),
(4, 4, 'direktur', 'DIRUTM370546', 'default-avatar.jpg', 'Sub-Direktur 3', 'subdirektur3@gmail.com', '$2y$10$8p9mkVyIJxS50Al7CMuJ6uVhhXHOTTLnj.Is6papl2yL26gKLn1vy', NULL, 'Indonesia', NULL, NULL, '0', 'off', 'enable', '2022-07-10 12:10:00', NULL),
(5, 1, 'pm', 'PMM87690', 'default-avatar.jpg', 'Rizqi PM', 'rizqisetiaji1@gmail.com', '$2y$10$6HxfMgmflpdGrzNr5VqBAeGGnlycPqMQ2UYTnk4n1BGtrdAJnTUiO', '089519598888', '', NULL, NULL, '0', 'on', 'enable', '2022-06-11 18:39:13', '2022-07-06 21:46:11');

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
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_photo`
--
ALTER TABLE `tb_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_priority`
--
ALTER TABLE `tb_priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_project_task`
--
ALTER TABLE `tb_project_task`
  MODIFY `project_task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_subproject`
--
ALTER TABLE `tb_subproject`
  MODIFY `subproject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
