-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2023 at 10:52 AM
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
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `details_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date_detalis` datetime DEFAULT NULL,
  `state_details` char(1) NOT NULL,
  `progress_details` float NOT NULL,
  `usersenddetails` int(30) NOT NULL,
  `send_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`details_id`, `project_id`, `task_id`, `comment`, `date_detalis`, `state_details`, `progress_details`, `usersenddetails`, `send_status`) VALUES
(154, 66001, 66003, '1111111111111111111111111111111111111111111111111', '2023-03-24 16:35:00', 'N', 50, 2, 1),
(155, 66001, 66003, 'หกดกหดกหดกหดกหดกหด', '2023-03-24 16:35:00', 'N', 60, 1, 2),
(156, 66001, 66003, 'sdfsdfdsfdsfds', '2023-03-24 21:28:00', 'N', 60, 2, 1),
(157, 66001, 66003, '222222222222222222222222222222222222222222', '2023-03-24 21:28:00', 'N', 80, 1, 2),
(159, 66001, 66003, 'dfgdgfdfg', '2023-03-27 18:23:00', 'N', 50, 2, 1),
(160, 66001, 66003, '564824248254444444444422222222', '2023-03-28 22:19:00', 'y', 80, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `file_item_details`
--

CREATE TABLE `file_item_details` (
  `file_details_id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `filename_details` varchar(200) NOT NULL,
  `details_id` int(30) NOT NULL,
  `newname_filedetails` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_item_details`
--

INSERT INTO `file_item_details` (`file_details_id`, `project_id`, `task_id`, `filename_details`, `details_id`, `newname_filedetails`) VALUES
(102, 66001, 66003, '334905070_2527666600724293_4874601570530760713_n (1).jpg', 154, '2023-03-2443871338.jpg'),
(103, 66001, 66003, 'messageImage_1678097778769 (1).jpg', 154, '2023-03-241277866416.jpg'),
(104, 66001, 66003, '2023-03-211075674713.jpg', 155, '2023-03-241352630762.jpg'),
(106, 66001, 66003, '2023-03-22T1847041618.jpg', 156, '2023-03-24751760931.jpg'),
(107, 66001, 66003, '2023-03-22T225333098.jpg', 156, '2023-03-241349006073.jpg'),
(108, 66001, 66003, 'EC013_ทบทวน.pdf', 157, '2023-03-24312575471.pdf'),
(111, 66001, 66003, '2023-03-21582637952 (1).pdf', 160, '2023-03-29d1877338571.pdf'),
(112, 66001, 66003, 'GL รวมลอง.xlsx', 160, '2023-03-29d1340333359.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `file_item_project`
--

CREATE TABLE `file_item_project` (
  `file_item_project` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `newname_filepro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_item_project`
--

INSERT INTO `file_item_project` (`file_item_project`, `project_id`, `filename`, `newname_filepro`) VALUES
(266, 66001, 'คิดตามงาน.pdf', '2023-03-221516791807.pdf'),
(267, 66001, 'Lab06 (1) (2).pdf', '2023-03-221762047449.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `file_item_task`
--

CREATE TABLE `file_item_task` (
  `file_item_task` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `filename_task` varchar(255) NOT NULL,
  `project_id` int(30) NOT NULL,
  `newname_filetask` varchar(255) NOT NULL
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
(8, 'รับสมัครคนศประจำปี', 1);

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
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `manager_id` int(30) NOT NULL,
  `status_2` int(30) NOT NULL,
  `id_jobtype` int(30) NOT NULL,
  `progress_project` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name_project`, `description`, `status_1`, `create_project`, `start_date`, `end_date`, `manager_id`, `status_2`, `id_jobtype`, `progress_project`) VALUES
(66001, 'test', 'sdfsdf254245555555524245278245245245245254245245214527272452542424524512752542452452425425424524524', 4, '2023-03-29 08:08:29', '2023-03-22 00:00:00', '2023-03-31 00:00:00', 1, 3, 3, 80);

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
(66001, 2),
(66001, 3),
(66001, 4),
(66001, 6),
(66001, 7);

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
  `project_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `progress_task` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`task_id`, `name_tasklist`, `description_task`, `status_task`, `strat_date_task`, `end_date_task`, `project_id`, `user_id`, `progress_task`) VALUES
(66003, 'test', '2452425452', 4, '2023-03-22 00:00:00', '2023-03-30 22:16:00', 66001, 2, 80);

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
(2, 'ball', '3', 'honhon8989@hotmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 5, '62505120009-9.jpg', '2023-03-19 16:53:51'),
(3, 'cat', '4', 'joey16461@gmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 4, 'd3.jpg', '2023-02-06 12:57:08'),
(4, 'pang', '5', 'honhon16461@sss.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 5, 'รูปคนอ้วน.png', '2023-02-06 12:57:11'),
(6, 'bas', '2', 'joey1646111@gmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 2, '01.jpg', '2023-02-06 12:57:20'),
(7, 'aeng', '7', 'honhon16461@gmail.com', '$2y$10$nSq5KOwMP1SsEebkwEPiG.PIvFm4GzjGMS8v7NhqjLyMiME37Caqm', 7, 'S__68296732.jpg', '2023-02-06 12:57:22'),
(9, 'joey', '4', 'admin4@admin.com', '$2y$10$4F8x08ukzfVyZIsfxsqtreedLMGOHcTPfE2TsYJtFVi4QBsfof2J2', 1, 'ครุย copy (1).jpg', '2023-03-19 11:41:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `file_item_details`
--
ALTER TABLE `file_item_details`
  ADD PRIMARY KEY (`file_details_id`);

--
-- Indexes for table `file_item_project`
--
ALTER TABLE `file_item_project`
  ADD PRIMARY KEY (`file_item_project`),
  ADD KEY `project_id_pj_idx` (`project_id`);

--
-- Indexes for table `file_item_task`
--
ALTER TABLE `file_item_task`
  ADD PRIMARY KEY (`file_item_task`),
  ADD KEY `task_id_fk` (`task_id`),
  ADD KEY `project_id_fk2` (`project_id`);

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
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `file_item_details`
--
ALTER TABLE `file_item_details`
  MODIFY `file_details_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `file_item_project`
--
ALTER TABLE `file_item_project`
  MODIFY `file_item_project` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `file_item_task`
--
ALTER TABLE `file_item_task`
  MODIFY `file_item_task` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id_jobtype` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `task_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66005;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `file_item_project`
--
ALTER TABLE `file_item_project`
  ADD CONSTRAINT `project_id_pj` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `file_item_task`
--
ALTER TABLE `file_item_task`
  ADD CONSTRAINT `project_id_fk2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`),
  ADD CONSTRAINT `task_id_fk` FOREIGN KEY (`task_id`) REFERENCES `task_list` (`task_id`);

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
