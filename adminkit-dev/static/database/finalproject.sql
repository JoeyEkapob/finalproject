-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2023 at 06:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `file_id` int(30) NOT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp(),
  `filelist` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`file_id`, `create_date`, `filelist`) VALUES
(55, '2023-02-20 13:53:46', NULL),
(56, '2023-02-20 14:08:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_item_project`
--

CREATE TABLE `file_item_project` (
  `file_item_project` int(30) NOT NULL,
  `file_id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_item_project`
--

INSERT INTO `file_item_project` (`file_item_project`, `file_id`, `project_id`, `filename`) VALUES
(90, 55, 163, 'Lab06.pdf'),
(91, 55, 163, 'EC08.pdf'),
(92, 56, 164, '');

-- --------------------------------------------------------

--
-- Table structure for table `file_item_task`
--

CREATE TABLE `file_item_task` (
  `file_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

CREATE TABLE `job_type` (
  `id_jobtype` int(11) NOT NULL,
  `name_jobtype` varchar(200) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_type`
--

INSERT INTO `job_type` (`id_jobtype`, `name_jobtype`, `status`) VALUES
(1, 'พัตนาหลักสูตร', 1),
(2, 'การจัดการความรู้', 1),
(3, 'งานประจำ', 1),
(4, 'การจัดการความรู้', 1),
(5, 'งานประจำ', 1),
(6, 'งานวิจัย', 1),
(7, 'การบริการวิชาการ', 1),
(8, 'รับสมัครคนศประจำปี', 1),
(9, 'test', 2),
(10, 'test', 2),
(11, 'test1', 2),
(12, 'test 2', 2),
(13, 'test', 2);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `role_id` int(30) NOT NULL,
  `position_name` varchar(200) NOT NULL,
  `level` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`role_id`, `position_name`, `level`) VALUES
(1, 'Admin', 1),
(2, 'คณบดี', 2),
(3, 'รองคณบดีฝ่ายวิชาการ', 3),
(4, 'ผู้ชวยรองคณบดีฝ่ายวิชาการ', 4),
(5, 'หัวหน้าหน่วย', 4),
(6, 'หัวสาขา', 5),
(7, 'เจ้าหน้าที่', 5);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(30) NOT NULL,
  `name_project` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status_1` tinyint(2) NOT NULL,
  `create_project` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `file_id` int(30) DEFAULT NULL,
  `manager_id` int(30) NOT NULL,
  `status_2` int(30) NOT NULL,
  `id_jobtype` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name_project`, `description`, `status_1`, `create_project`, `start_date`, `end_date`, `file_id`, `manager_id`, `status_2`, `id_jobtype`) VALUES
(163, 'test', 'test', 1, '2023-02-20 13:53:46', '2023-02-20', '2023-02-25', 55, 1, 3, 3),
(164, 'test 2 ', 'tset', 1, '2023-02-20 14:08:01', '2023-02-20', '2023-02-23', 56, 4, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `project_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`project_id`, `user_id`) VALUES
(163, 2),
(163, 3),
(163, 4),
(163, 6),
(163, 7),
(164, 5),
(164, 7);

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `task_id` int(30) NOT NULL,
  `name_tasklist` varchar(255) NOT NULL,
  `description_task` varchar(200) NOT NULL,
  `status_task` tinyint(2) NOT NULL,
  `strat_date_task` datetime NOT NULL,
  `end_date_task` datetime NOT NULL,
  `file_task` varchar(45) DEFAULT NULL,
  `project_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`task_id`, `name_tasklist`, `description_task`, `status_task`, `strat_date_task`, `end_date_task`, `file_task`, `project_id`, `user_id`) VALUES
(10, 'test', '  test  \r\n                        ', 1, '2023-02-20 20:53:00', '2023-02-28 21:00:00', NULL, 163, 4),
(11, 'test 2', 'test 2', 1, '2023-02-20 20:57:00', '2023-02-25 20:00:00', NULL, 163, 7),
(12, 'test 10', 'fsdfsf', 1, '2023-02-20 21:08:00', '2023-02-23 21:09:00', NULL, 164, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(30) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `role_id`, `avatar`, `date_created`) VALUES
(1, 'joey', '1', 'admin@admin.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 1, '09.jpg', '2023-01-16 18:00:29'),
(2, 'ball', '3', 'honhon8989@hotmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 3, '62505120009-9.jpg', '2023-02-06 12:57:01'),
(3, 'cat', '4', 'joey16461@gmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 4, 'd3.jpg', '2023-02-06 12:57:08'),
(4, 'pang', '5', 'honhon16461@sss.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 5, 'รูปคนอ้วน.png', '2023-02-06 12:57:11'),
(5, 'pong     ', '6', 'admin1@admin.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 6, 'p2.jpg', '2023-02-06 12:57:17'),
(6, 'bas', '2', 'joey1646111@gmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 2, '01.jpg', '2023-02-06 12:57:20'),
(7, 'aeng', '7', 'honhon16461@gmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 7, 'S__68296732.jpg', '2023-02-06 12:57:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `file_item_project`
--
ALTER TABLE `file_item_project`
  ADD PRIMARY KEY (`file_item_project`),
  ADD KEY `file_id_idx` (`file_id`),
  ADD KEY `project_id_pj_idx` (`project_id`);

--
-- Indexes for table `file_item_task`
--
ALTER TABLE `file_item_task`
  ADD PRIMARY KEY (`task_id`,`file_id`),
  ADD KEY `file_id_tk_idx` (`file_id`),
  ADD KEY `task_id_fi_idx` (`task_id`);

--
-- Indexes for table `job_type`
--
ALTER TABLE `job_type`
  ADD PRIMARY KEY (`id_jobtype`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `id_jobtype` (`id_jobtype`);

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`project_id`,`user_id`),
  ADD KEY `project_id_fk_idx` (`project_id`),
  ADD KEY `user_id_fk1` (`user_id`);

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id_fk_idx` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `file_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `file_item_project`
--
ALTER TABLE `file_item_project`
  MODIFY `file_item_project` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id_jobtype` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `task_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `file_item_project`
--
ALTER TABLE `file_item_project`
  ADD CONSTRAINT `file_id_pj` FOREIGN KEY (`file_id`) REFERENCES `file` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_id_pj` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `file_item_task`
--
ALTER TABLE `file_item_task`
  ADD CONSTRAINT `file_id_tk` FOREIGN KEY (`file_id`) REFERENCES `file` (`file_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `task_id_fi` FOREIGN KEY (`task_id`) REFERENCES `task_list` (`task_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `id_jobtype` FOREIGN KEY (`id_jobtype`) REFERENCES `job_type` (`id_jobtype`);

--
-- Constraints for table `project_list`
--
ALTER TABLE `project_list`
  ADD CONSTRAINT `project_id_fk1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_list`
--
ALTER TABLE `task_list`
  ADD CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `position` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
