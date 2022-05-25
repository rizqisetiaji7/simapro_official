-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2022 at 12:48 PM
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
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(128) NOT NULL,
  `category_slug` text NOT NULL,
  `category_icon` varchar(80) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_company`
--

CREATE TABLE `tb_company` (
  `company_id` int(11) NOT NULL,
  `comp_parent_id` int(11) NOT NULL DEFAULT 0,
  `comp_code_ID` text DEFAULT NULL,
  `comp_handle_ID` varchar(5) NOT NULL,
  `comp_name` varchar(255) NOT NULL,
  `comp_logo` varchar(255) DEFAULT NULL,
  `comp_slug` text NOT NULL,
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

INSERT INTO `tb_company` (`company_id`, `comp_parent_id`, `comp_code_ID`, `comp_handle_ID`, `comp_name`, `comp_logo`, `comp_slug`, `comp_email`, `comp_phone`, `comp_address`, `comp_type`, `comp_desc`, `comp_since`, `created`, `updated`) VALUES
(1, 0, 'COMP2002111351086392', 'A', 'PT. Arya Bakti Saluyu', 'ptaryabakti-logo.png', 'pt-arya-bakti-saluyu', 'aryabakti@gmail.com', '087665332445', 'Kab. Ciamis, Jawa Barat', 'PT', '', '2002-11-13', '2022-05-11 13:07:40', '2022-05-18 15:01:06'),
(2, 1, 'COMP2017070570462518', 'M1', 'CV. Lima Utama', 'limautama-logo.jpg', 'cv-lima-utama', 'didu_ciamis@yahoo.com', '087665778990', '', 'CV', '', '2017-07-05', '2022-05-11 13:07:40', '2022-05-23 12:46:03'),
(3, 1, NULL, 'M2', 'CV. Berkah Jaya Buana', 'berkahjayabuana-logo.jpg', 'cv-berkah-jaya-buana', '', NULL, NULL, 'CV', NULL, NULL, '2022-05-11 13:07:40', NULL),
(4, 1, NULL, 'M3', 'CV. Putra Jaya', 'putrajaya-logo.jpg', 'cv-putra-jaya', 'cvputrajaya51@gmail.com', NULL, NULL, 'CV', NULL, NULL, '2022-05-11 13:07:40', NULL);

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
  `chat_type` enum('text','attachment') NOT NULL DEFAULT 'text',
  `chat_status` enum('read') NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `tb_priority`
--

CREATE TABLE `tb_priority` (
  `priority_id` int(11) NOT NULL,
  `priority_name` varchar(128) NOT NULL,
  `priority_color` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_project`
--

CREATE TABLE `tb_project` (
  `project_id` int(11) NOT NULL,
  `ID_mandor` int(11) NOT NULL,
  `ID_category` int(11) NOT NULL,
  `ID_company` int(11) NOT NULL,
  `project_code_ID` text NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_avatar` text DEFAULT NULL,
  `project_address` text DEFAULT NULL,
  `project_desciption` longtext DEFAULT NULL,
  `project_deadline` date NOT NULL,
  `project_current_deadline` date NOT NULL,
  `project_status` enum('pending','archive','review','finish','revision') DEFAULT NULL,
  `project_deadline_status` enum('lebih_awal','tepat_waktu','terlambat') DEFAULT NULL,
  `project_progress` float DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_project_task`
--

CREATE TABLE `tb_project_task` (
  `project_task_id` int(11) NOT NULL,
  `ID_subproject` int(11) NOT NULL,
  `ID_priority` int(11) NOT NULL,
  `project_task_code_ID` text NOT NULL,
  `project_task_name` varchar(150) NOT NULL,
  `project_task_deadline` date NOT NULL,
  `project_task_status` enum('pending','onprogress','finish') DEFAULT NULL,
  `project_task_progress` float NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_subproject`
--

CREATE TABLE `tb_subproject` (
  `subproject_id` int(11) NOT NULL,
  `ID_project` int(11) NOT NULL,
  `ID_priority` int(11) NOT NULL,
  `subproject_code_ID` text NOT NULL,
  `subproject_name` varchar(150) NOT NULL,
  `subproject_deadline` date DEFAULT NULL,
  `subproject_status` enum('onprogress','pending','finish') DEFAULT NULL,
  `subproject_progress` float DEFAULT NULL,
  `panel_color` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `user_id` int(11) NOT NULL,
  `ID_company` int(11) DEFAULT NULL,
  `user_unique_id` varchar(50) DEFAULT NULL,
  `user_role` enum('super_admin','admin','employee') NOT NULL,
  `user_role_name` varchar(50) NOT NULL,
  `user_profile` text DEFAULT NULL,
  `user_fullname` varchar(145) NOT NULL,
  `user_email` varchar(145) NOT NULL,
  `user_password` text NOT NULL,
  `user_phone` char(15) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `token` text DEFAULT NULL,
  `token_expiry` bigint(20) DEFAULT NULL,
  `theme_mode` enum('1','0') NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `ID_company`, `user_unique_id`, `user_role`, `user_role_name`, `user_profile`, `user_fullname`, `user_email`, `user_password`, `user_phone`, `user_address`, `token`, `token_expiry`, `theme_mode`, `created`, `updated`) VALUES
(1, 1, 'DIRUTA39542', 'super_admin', 'Administrator', 'default-avatar.jpg', 'Rizqi Setiaji', 'rizqisetiaji9@gmail.com', '$2y$10$7cGpr4x1bGiUhdCNWf2rC.Dstwd14f4MXzQWkd0xflolHA5F/WTFq', NULL, NULL, NULL, NULL, '0', '2022-05-10 14:06:07', NULL),
(3, 2, 'DIRUTM103872', 'admin', 'Admin', 'efb1ae2c2552c5e93266265d3a109783.jpg', 'Om Jay', 'omjay@gmail.com', '$2y$10$sWu4UUbKFCgzWHxYKbv34.ulvntxhiwnoGP6L4GxYxGgddCkqMcFa', '087321445778', NULL, NULL, NULL, '', '2022-05-19 23:00:34', '2022-05-23 18:29:25'),
(7, 2, 'MDRM189760', 'employee', 'Mandor', 'default-avatar.jpg', 'Azhar Gunawan', 'gunawanazhar6@gmail.com', '$2y$10$ZqXNbZntAs7xx4Lw0eZ6BuTiwTchrj7XVmd9tVesdUVqA9ueu9opy', '081778554326', NULL, NULL, NULL, '0', '2022-05-24 12:27:42', NULL),
(8, 2, 'MDRM102657', 'employee', 'Mandor', 'default-avatar.jpg', 'Hari Nurdin', 'harnurdin@gmail.com', '$2y$10$H4GvUHgMbOItaoyTCY7cmuT0uf0lnD5/8CoocLprDWApb7TXLGKnm', NULL, 'Banjarsari, Kab. Ciamis', NULL, NULL, '0', '2022-05-24 12:27:42', NULL),
(9, 3, 'DIRUTM283140', 'admin', 'Admin', '0a42c31ca7985807b73cc1f69c244195.jpg', 'Anya Forger', 'anyakawai@gmail.com', '$2y$10$8p9mkVyIJxS50Al7CMuJ6uVhhXHOTTLnj.Is6papl2yL26gKLn1vy', '0991887556', 'Ostania, Germany', NULL, NULL, '', '2022-05-24 13:15:00', '2022-05-24 13:16:33'),
(11, 1, 'MDRA34506', 'employee', 'Mandor', 'default-avatar.jpg', 'okok', 'oko@mail.com', '$2y$10$2VvxZgDiR2ogsvYgQLRhHeSdi4oPSKbIODcm1rNp/9RSS8Lfz88VK', '', NULL, NULL, NULL, '', '2022-05-24 17:43:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`);

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
  ADD KEY `ID_mandor` (`ID_mandor`),
  ADD KEY `ID_category` (`ID_category`),
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
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_company`
--
ALTER TABLE `tb_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_livechat`
--
ALTER TABLE `tb_livechat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_photo`
--
ALTER TABLE `tb_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_priority`
--
ALTER TABLE `tb_priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_project_task`
--
ALTER TABLE `tb_project_task`
  MODIFY `project_task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_subproject`
--
ALTER TABLE `tb_subproject`
  MODIFY `subproject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
