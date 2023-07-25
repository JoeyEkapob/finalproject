-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 04, 2023 at 06:43 PM
-- Server version: 8.0.33-0ubuntu0.20.04.2
-- PHP Version: 8.1.18

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
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `department_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_status`) VALUES
(0, 'ทั้งหมด', 1),
(1, 'ฝ่ายวิชาการ', 1),
(2, 'ฝ่ายบริหาร', 1),
(3, 'ฝ่ายกิจกรรมทั่วไป', 1);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `details_id` int NOT NULL,
  `project_id` int NOT NULL,
  `task_id` int NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date_detalis` datetime DEFAULT NULL,
  `state_details` char(1) NOT NULL,
  `progress_details` float NOT NULL,
  `usersenddetails` int NOT NULL,
  `send_status` int NOT NULL,
  `status_timedetails` int NOT NULL,
  `detail` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`details_id`, `project_id`, `task_id`, `comment`, `date_detalis`, `state_details`, `progress_details`, `usersenddetails`, `send_status`, `status_timedetails`, `detail`) VALUES
(440, 66005, 66007, '', '2023-06-03 23:43:00', 'N', 40, 78, 1, 2, 3),
(441, 66005, 66007, 'แก้ไขงาน', '2023-06-03 23:45:00', 'N', 40, 74, 2, 2, NULL),
(442, 66009, 66014, 'เรียบร้อยเเล้ว', '2023-06-04 10:03:00', 'N', 50, 104, 1, 0, 0),
(443, 66009, 66014, 'ยังไม่เรียบร้อย', '2023-06-04 10:05:00', 'N', 50, 74, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file_item_details`
--

CREATE TABLE `file_item_details` (
  `file_details_id` int NOT NULL,
  `project_id` int NOT NULL,
  `task_id` int NOT NULL,
  `filename_details` varchar(200) NOT NULL,
  `details_id` int NOT NULL,
  `newname_filedetails` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_item_details`
--

INSERT INTO `file_item_details` (`file_details_id`, `project_id`, `task_id`, `filename_details`, `details_id`, `newname_filedetails`) VALUES
(254, 66005, 66007, 'รายงานงบทดลองประจำเดือนกันยายน 2565.pdf', 440, '2023-06-03ST938364040.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `file_item_project`
--

CREATE TABLE `file_item_project` (
  `file_item_project` int NOT NULL,
  `project_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `newname_filepro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_item_project`
--

INSERT INTO `file_item_project` (`file_item_project`, `project_id`, `filename`, `newname_filepro`) VALUES
(710, 66001, '660411_คู่มือการเข้าใช้งานระบบรับสมัครนักศึกษา_V1.pdf', '2023-06-03EP516411093.pdf'),
(711, 66008, '09_บทที่1.docx', '2023-06-04P107787924.docx'),
(712, 66008, 'joker (1).jpg', '2023-06-04P74750638.jpg'),
(713, 66008, 'map (1).pdf', '2023-06-04P1325348491.pdf'),
(714, 66008, 'taku.png', '2023-06-04P145163065.png'),
(715, 66009, 'final_project_all (1) (1).pdf', '2023-06-04P1597577742.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `file_item_task`
--

CREATE TABLE `file_item_task` (
  `file_item_task` int NOT NULL,
  `task_id` int NOT NULL,
  `filename_task` varchar(255) NOT NULL,
  `project_id` int NOT NULL,
  `newname_filetask` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_item_task`
--

INSERT INTO `file_item_task` (`file_item_task`, `task_id`, `filename_task`, `project_id`, `newname_filetask`) VALUES
(253, 66003, 'tn.png', 66001, '2023-06-03AT2035773455.png'),
(254, 66012, 'Homework photographs.docx', 66008, '2023-06-04AT866747112.docx'),
(255, 66013, 'ตารางเรียน.xlsx', 66008, '2023-06-04AT37371789.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

CREATE TABLE `job_type` (
  `id_jobtype` int NOT NULL,
  `name_jobtype` varchar(200) NOT NULL,
  `status` tinyint NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_type`
--

INSERT INTO `job_type` (`id_jobtype`, `name_jobtype`, `status`, `user_id`) VALUES
(3, 'งานประจำ', 2, 74),
(4, 'การจัดการความรู้', 1, 73),
(6, 'งานวิจัย', 1, 75),
(7, 'การบริการวิชาการ', 1, 78),
(8, 'รับสมัครนักศึกษาประจำปี', 1, 73),
(35, 'กิจกรรม', 2, 73),
(36, 'งานประจำ', 1, 23),
(37, 'test', 2, 23),
(38, 'สัมมนา', 1, 23),
(39, 'กิจกรรม', 1, 74);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `role_id` int NOT NULL,
  `position_name` varchar(200) NOT NULL,
  `level` int NOT NULL,
  `position_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`role_id`, `position_name`, `level`, `position_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'คณบดี', 2, 1),
(3, 'รองคณบดี', 3, 1),
(4, 'ผู้ชวยรองคณบดี', 4, 1),
(5, 'หัวหน้าหน่วย', 4, 1),
(6, 'หัวสาขา', 5, 1),
(7, 'เจ้าหน้าที่', 5, 1),
(33, 'เเม่บ้าน', 6, 2),
(34, 'แม่บ้าน', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int NOT NULL,
  `name_project` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status_1` tinyint NOT NULL,
  `create_project` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `manager_id` int NOT NULL,
  `status_2` int NOT NULL,
  `id_jobtype` int NOT NULL,
  `progress_project` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name_project`, `description`, `status_1`, `create_project`, `start_date`, `end_date`, `manager_id`, `status_2`, `id_jobtype`, `progress_project`) VALUES
(66001, 'งานกีฬาประจำคณะ', 'งานกีฬา BA ประจำปีการศึกษา 1/2566 เดือนกรกฎาคม สถานที่มหาวิทยาลัยเทคโนโลยีราชมงคลกรุงเทพ', 1, '2023-06-03 14:16:28', '2023-06-03 00:00:00', '2023-06-30 00:00:00', 73, 2, 35, 0),
(66005, 'ประกาศรับนักศึกษา', 'สำหรับนักศึกษาใหม่ ปี 2566 สามารถเข้า Line open Chat ของกลุ่มนักศึกษาใหม่คณะบริหารธุรกิจ เเละเเต่ละสาขาวิชาได้เเล้ว โดยมีรายละเอียดดังนี้\r\n                               1 Open Chat \"RKBS Students 66\" กลุ่มของนักศึกษาใหม่ ปี 2566 คณะบริหารธุรกิจ (นักศึกษาทุกคนควรเข้า) เพื่อรับข่าวสารกิจกรรม และกำหนดการต่าง ๆ ของคณะและมหาวิทยาลัยสำหรับเเต่ละสาขาวิชา \r\n                              2 สาขาวิชาการเงินและนวัตกรรมทางการเงิน\r\n                              3 สาขาวิชาการเทคโนโลยีสารสนเทศและธุรกิจดิจิทัล\r\n                              4 สาขาวิชานวัตกรรมระบบสารสนเทศ\r\n                              5 สาขาวิชาการประเมินราคาทรัพย์สิน\r\n                              6 สาขาวิชาธุรกิจการบิน\r\n                              7 สาขาวิชาการจัดการธุรกิจสมัยใหม่\r\n                              8 สาขาวิชาการสื่อสารธุรกิจระหว่างประเทศ\r\n                              9 สาขาวิชาการบัญชี\r\n                              10 สาขาวิชาการตลาด\r\n                              11 สาขาวิชา Digital Startup', 3, '2023-06-04 03:25:44', '2023-06-03 00:00:00', '2023-06-30 00:00:00', 74, 2, 8, 8),
(66006, 'พัฒนาหลักสูตร', 'ปรับหลักสูตรการเรียนการสอนคณะบริหารธุรกิจ ประจำปี 2566', 1, '2023-06-03 16:39:08', '2023-06-03 00:00:00', '2023-06-30 00:00:00', 74, 1, 4, 0),
(66007, 'ตารางคุมสอบปลายภาค รายบุคคล แยกตามสาขาวิชา ประจำภาค 2/2565', '', 1, '2023-06-03 17:06:13', '2023-06-04 00:00:00', '2023-06-30 00:00:00', 74, 1, 4, 0),
(66008, 'ปฏิทินกำหนดวันเรียน', 'ปฏิทินกำหนดวันเรียน ฉบับคณะบริหารธธุรกิจ เทอม265-ฉบับแก้ไข ณ 10 11 65', 1, '2023-06-03 17:12:27', '2023-06-04 00:00:00', '2023-06-30 00:00:00', 73, 1, 4, 0),
(66009, 'ทำความสะอาดห้องประชุม', 'เตรียมห้องประชุมก่อนวันประชุมล่วงหน้า 2 วัน', 3, '2023-06-04 03:11:18', '2023-06-04 00:00:00', '2023-06-30 00:00:00', 74, 1, 39, 50);

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `project_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`project_id`, `user_id`) VALUES
(66001, 96),
(66001, 97),
(66001, 98),
(66005, 78),
(66005, 84),
(66006, 78),
(66006, 84),
(66007, 78),
(66007, 84),
(66008, 74),
(66009, 104);

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `task_id` int NOT NULL,
  `name_tasklist` varchar(255) NOT NULL,
  `description_task` varchar(200) NOT NULL,
  `status_task` tinyint NOT NULL,
  `strat_date_task` datetime NOT NULL,
  `end_date_task` datetime NOT NULL,
  `project_id` int NOT NULL,
  `user_id` int NOT NULL,
  `progress_task` float NOT NULL,
  `status_timetask` int NOT NULL,
  `status_task2` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`task_id`, `name_tasklist`, `description_task`, `status_task`, `strat_date_task`, `end_date_task`, `project_id`, `user_id`, `progress_task`, `status_timetask`, `status_task2`) VALUES
(66002, 'รวบรวมรายชื่อตัวแทนสี', 'รวบรวมรายชื่อตัวแทนสีมาจับสลากการแสดงเปิดงาน', 1, '2023-06-03 21:03:00', '2023-06-10 21:04:00', 66001, 98, 0, 2, 0),
(66003, 'รายการประเภทกีฬาที่จัด', 'กีฬาแต่ละประเภท', 1, '2023-06-03 21:05:00', '2023-06-11 21:06:00', 66001, 98, 0, 2, 0),
(66004, 'ของรางวัลในการจัดงานกีฬา', 'ของรางวัลชนิด ของกิน และ ของใช้', 1, '2023-06-03 21:08:00', '2023-06-05 21:09:00', 66001, 96, 0, 2, 0),
(66005, 'การแสดงเปิดงานกีฬา', 'การแสดงความยาวไม่เกิน 30 นาที', 1, '2023-06-03 21:10:00', '2023-06-10 21:10:00', 66001, 96, 0, 2, 0),
(66006, 'รายชื่อนักศึกษา TCAS รอบทที่ 1', '', 1, '2023-06-03 21:41:00', '2023-06-10 21:46:00', 66005, 78, 0, 0, 0),
(66007, 'รายชื่อนักศึกษา TCAS รอบที่ 2', '', 3, '2023-06-03 21:47:00', '2023-06-03 23:33:00', 66005, 78, 40, 2, 0),
(66008, 'รายชื่อนักศึกษาเทียบโอน', '', 1, '2023-06-03 21:47:00', '2023-06-04 21:47:00', 66005, 78, 0, 1, 0),
(66009, 'ผลการสัมภาษณ์นักศึกษา TCAS รอบที่ 3', '', 1, '2023-06-03 21:48:00', '2023-06-24 21:48:00', 66005, 78, 0, 0, 0),
(66010, 'งานปฐมนิเนศนักศึกษาใหม่', '', 1, '2023-06-03 21:48:00', '2023-06-25 21:48:00', 66005, 84, 0, 0, 0),
(66011, 'ตารางสอบของคณะบริหาร', '', 1, '2023-06-04 00:06:00', '2023-06-08 00:06:00', 66007, 78, 0, 2, 0),
(66012, 'กำหนดวันเปิดเทอม', '', 1, '2023-06-04 00:13:00', '2023-06-09 00:15:00', 66008, 74, 0, 2, 0),
(66013, 'ตารางสอบกลาง', '', 1, '2023-06-04 00:16:00', '2023-06-09 00:16:00', 66008, 74, 0, 2, 0),
(66014, 'ทำความสะอาด', '', 3, '2023-06-04 10:00:00', '2023-06-09 10:01:00', 66009, 104, 50, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_user` int NOT NULL,
  `tel` varchar(255) NOT NULL,
  `line_token` varchar(255) NOT NULL,
  `idcard` varchar(13) NOT NULL,
  `department_id` int NOT NULL,
  `shortname_id` int NOT NULL,
  `status_user2` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `role_id`, `avatar`, `date_created`, `status_user`, `tel`, `line_token`, `idcard`, `department_id`, `shortname_id`, `status_user2`) VALUES
(23, 'joey', 'admin', 'admin@admin.com', '$2y$10$gjKzu6b5z.jz9VxRp2Irv.tHidOjJdpqHJuRo9PwPXkwjrWx6gzS.', 1, NULL, '2023-06-03 09:28:26', 1, '0641693159', 'yj58om1G5huMwz0d17bSLROoY3CcCSa8BRWmHCfH1rx', '1111111111111', 0, 1, 1),
(73, 'กิตติพงษ์', 'โสภณธรรมภาณ', 'kittipong.s@mail.rmutk.ac.th', '$2y$10$kfJeZH8K5w2L0kCIJvKumOZU/2EeEPR9cb6LMDWbRR2UQ5y.XYnvq', 2, '2023-05-12U1171734199.jpg', '2023-06-03 17:10:39', 1, '0999999888', 'yj58om1G5huMwz0d17bSLROoY3CcCSa8BRWmHCfH1rx', '4003584178340', 0, 3, 1),
(74, 'สมศักดิ์', 'บุตรสาคร', 'Somsak@mail.rmutk.ac.th', '$2y$10$wljoCwceBPwOvzY.GqR1kOLXnyWVErujkGntUYul7kxxnie91eVwm', 3, '2023-05-12U1395894619.jpg', '2023-06-03 16:35:28', 1, '0999999999', 'yj58om1G5huMwz0d17bSLROoY3CcCSa8BRWmHCfH1rx', '7503283007201', 1, 3, 1),
(75, 'อธิพันธ์', 'วรรณสุริยะ', 'atipan.v@mail.rmutk.ac.th', '$2y$10$HTNvi6fEe75qnuhBqhfH0.lgyqZ2aMFlRsRedkKliA1A2au0HBXK.', 5, '2023-05-12U162504577.jpg', '2023-05-19 07:11:06', 1, '0999999999', '', '7722508644545', 1, 3, 1),
(76, 'น้ำเพชร', 'เพชรใหม่', 'namphet@mail.rmutk.ac.th', '$2y$10$v1YIOScBj1Rx/OdWbPGhVuxZL1A8qDDLaHIE1xkto.29kma/GMd0a', 4, '2023-05-12U476885287.jpg', '2023-05-25 10:46:52', 1, '0999999999', '', '6712216353828', 1, 10, 1),
(77, 'ปริญญา', 'สีม่วง', 'parinya.si@mail.rmutk.ac.th', '$2y$10$ysj9ehsqkirmDQDdjAWCVuC8ij6kiLzKDSmzC6ZLzChcwZZzmaCde', 5, '2023-05-12U1169814238.jpg', '2023-05-19 07:11:08', 1, '0999999999', '', '2502453055251', 1, 3, 1),
(78, 'บุญรอด', 'พาหา', 'bunrot@mail.rmutk.ac.th', '$2y$10$2/w1tH6j2.VzvKI.di1FV.haXcP/htagq8EXr0f2nCpbmjhcFAPxq', 7, '2023-05-16U117700410.jpg', '2023-06-03 17:11:11', 1, '0999999999', 'yj58om1G5huMwz0d17bSLROoY3CcCSa8BRWmHCfH1rx', '2831889330158', 1, 2, 1),
(80, 'พรฤพา', 'ทับสุข', 'admin02@gmail.com', '$2y$10$UEhXItZye2UMlHg1Vx1AseKHlOJRq525zme2lUdu9jKmrqfdDnwfq', 1, '2023-05-18U38922661.jpg', '2023-06-04 01:55:48', 0, '0840030012', '', '0102345678902', 0, 2, 0),
(82, 'พรนิภา ', ' เชิดชู', 'pornnipa@gmail.com', '$2y$10$1vsQRRqgmaynhNyqELUA0eYYl.vB4Iv7cW8VGSfP.fRfBg45G7UTe', 7, NULL, '2023-05-22 18:22:49', 1, '0952481111', 'RbQVynyzlfe3sxR0d9l9GwoxS1Dx2B8ll1qbqJz63t6', '1100201561651', 2, 7, 1),
(84, 'บุญมี', 'ศรีเมฆ', 'long@gmail.com', '$2y$10$vBmDleNQd0TY2qPwiG9HF.nspHpgvFqdlfGJjtn0cSbAm3R.TAx6q', 7, NULL, '2023-06-03 16:41:40', 1, '0952481111', 'ojpXWz8qIjS7rtvSFC29Z43H7GX6Z4Gk1q3VomduWeT', '1100201561651', 0, 9, 1),
(85, 'รองนา', 'เขียวขจี', 'longna@gmail.com', '$2y$10$lDOTkXW3VWzSh2ren2t3M.h.IuPpYcZyeZiodPhRn9kYUnlFcsl5m', 7, '2023-05-18U412316207.png', '2023-05-20 14:54:55', 0, '0952481111', '', '1100201561651', 7, 1, 0),
(89, 'พรนิภา ', 'แคโอชา', 'pornniipa@gmail.com', '$2y$10$wF3E7rU3isGL7bJ.libOUOF3sgiBSxkfFiTwefGTytwYMGQehOLOe', 7, '2023-05-19U1234834569.jpg', '2023-05-20 12:26:09', 1, '0952481111', 'RbQVynyzlfe3sxR0d9l9GwoxS1Dx2B8ll1qbqJz63t6', '1199210561651', 2, 2, 1),
(90, 'มนัสรินทร์', 'กวางวิเศษ', 'manasarin@gmail.com', '$2y$10$pPv76b9rBDubKvMbIfKa5uToBuVfoStAktrUsmCFUgnI27cEmLXDG', 7, '2023-05-19U1665753813.jpg', '2023-05-19 07:11:22', 1, '0952481111', '', '1199210561651', 2, 2, 1),
(91, 'เกียรติศักดิ์', ' พุทธปัญญา', 'keiyrtisak@gmail.com', '$2y$10$bHQEXXpVi.yfqsdCXSwjAO27Eb2K2BHVt71tMGa6OerYUZusRxR0S', 7, '2023-05-19U1314059402.jpg', '2023-05-19 07:11:23', 1, '0952481111', '', '1199210561651', 2, 1, 1),
(92, 'สิทธิชัย', ' สุดใจ', 'siththichia@gmail.com', '$2y$10$AEH6FuSFF.yszud5OB2kAuDPJKtQdyohw/auiF4C7PdDnK6EHhG0K', 7, '2023-05-19U1756093644.jpg', '2023-05-19 07:11:24', 1, '0952481111', '', '1199210561651', 2, 1, 1),
(93, 'พนมขวัญ', 'ปรีเสม', 'phanomkwan@gmail.com', '$2y$10$18PRrFtRpUIYEqzKxQG.GuLrMF25r7iFinjykyNebYNc8ztBug5A6', 7, '2023-05-19U501148226.jpg', '2023-05-19 07:11:26', 1, '0952481111', '', '1199210561651', 2, 2, 1),
(94, 'พนิดา ', 'นิ่มน้อย', 'panida@gmail.com', '$2y$10$S00cJpplkWQU.O45dmfC0ejinL2GGn.pHiQyK5pCDyHe3xbYADgBK', 7, '2023-05-19U1264386315.jpg', '2023-05-19 07:11:27', 1, '0952481111', '', '1199210561651', 2, 2, 1),
(95, 'ณัฐกฤตา', 'ยังดี', 'natthakritta@gmail.com', '$2y$10$kDtoD29dxr4cocdKb4DDTOf/ycmLOh.9yu/GB/aL2OAW4t8QBzWEe', 7, '2023-05-19U1210425575.jpg', '2023-05-19 07:11:29', 1, '0952481111', '', '1199210561651', 2, 2, 1),
(96, 'ประสาน', 'แสนวิเศษ', 'prasan@gmail.com', '$2y$10$TTkejQxvVBCUIktuW9WSJ.nJwXTWfyNOpeoQKhyKOq3h2.AzyzsYW', 7, '2023-05-19U1766665225.jpg', '2023-05-19 07:11:31', 1, '0952481111', '', '1199210561651', 2, 1, 1),
(97, 'ประกายดาว', 'ภู่ทับทิม', 'prakaydaw@gmail.com', '$2y$10$Vs/Kbm/5S.VHKcdgv3BEa.N64aOkxKwa6XFvt1d1hU5ahK7ZSZRSW', 7, '2023-05-19U1197843278.jpg', '2023-05-19 07:11:33', 1, '0952481111', '', '1199210561651', 2, 2, 1),
(98, 'วาริษา', ' เชิดชู', 'varisara@gmail.com', '$2y$10$8Zb0ylxJeyjvTZdLxmK.teBQqKIpxAgKst359d4XQa4UITY2SGhHm', 7, '2023-05-19U1219748356.jpg', '2023-05-19 07:11:34', 1, '0952481111', '', '1199210561651', 3, 2, 1),
(104, 'สุณิสา', 'รัตนาประสิทธิ์', 'Sunisa_Rattanaprasit@mail.rmutk.ac.th', '$2y$10$em4tpQ9uGTLS0rNFpJ5FcuQKJ1KMJvRev7KjuZeDlyw.JxctCWlUC', 34, NULL, '2023-06-04 02:50:07', 1, '0891111111', 'yj58om1G5huMwz0d17bSLROoY3CcCSa8BRWmHCfH1rx', '9193557976401', 0, 9, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

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
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT for table `file_item_details`
--
ALTER TABLE `file_item_details`
  MODIFY `file_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `file_item_project`
--
ALTER TABLE `file_item_project`
  MODIFY `file_item_project` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=716;

--
-- AUTO_INCREMENT for table `file_item_task`
--
ALTER TABLE `file_item_task`
  MODIFY `file_item_task` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id_jobtype` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66020;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

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
  ADD CONSTRAINT `role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `position` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;