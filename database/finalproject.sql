-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2023 at 09:08 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_status`) VALUES
(0, 'ทั้งหมด', 1),
(1, 'ฝ่ายวิชาการ', 1),
(2, 'ฝ่ายบริหาร', 1),
(3, 'ฝ่ายกิจกรรมทั่วไป', 1),
(4, 'sdfsdfsd', 0),
(5, 'test', 0),
(7, 'ฝ่ายการทำงาน', 0),
(8, 'test เพิ่มฝ่าย 20/5', 0),
(9, 'เพิ่มฝ่าย_ทดสอบ', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`details_id`, `project_id`, `task_id`, `comment`, `date_detalis`, `state_details`, `progress_details`, `usersenddetails`, `send_status`, `status_timedetails`, `detail`) VALUES
(391, 66001, 66001, 'ฟหกดหฟกดฟหกดหฟกดหฟกด', '2023-05-20 13:49:00', 'N', 70, 23, 1, 0, 0),
(392, 66001, 66001, 'ฟหกดฟดฟหดหฟกดหฟกดฟหกดหฟ', '2023-05-20 13:49:00', 'N', 70, 23, 2, 0, NULL),
(393, 66001, 66001, 'กฟดฟกหฟกฟ', '2023-05-20 14:32:00', 'N', 90, 23, 1, 0, 0),
(394, 66001, 66001, 'ดหกเหกดเหกดเกหดเหกดเกหดเ', '2023-05-20 14:32:00', 'N', 90, 23, 2, 0, NULL),
(395, 66001, 66001, 'อดผกหแฟหกฟหกฟหกฟหก', '2023-05-20 14:37:00', 'N', 100, 23, 1, 0, 0),
(396, 66001, 66002, 'กดเฟหดฟหกดฟหกดห', '2023-05-20 15:27:00', 'N', 70, 23, 1, 0, 0),
(397, 66001, 66002, 'ฟหกดฟหกดฟหก', '2023-05-20 15:27:00', 'N', 70, 23, 2, 0, NULL),
(398, 66001, 66002, 'ertertert', '2023-05-20 15:52:00', 'N', 90, 23, 1, 0, 0),
(399, 66001, 66002, 'sdfgsdfgsdfgsdfg', '2023-05-20 15:52:00', 'N', 90, 23, 2, 0, NULL),
(400, 66002, 66003, 'ส่ง1', '2023-05-20 19:44:00', 'N', 30, 78, 1, 0, 0),
(402, 66002, 66004, 'ส่ง1 คนที่2', '2023-05-20 19:48:00', 'N', 50, 82, 1, 0, 0),
(403, 66002, 66005, 'ส่ง1 คนที่ 3', '2023-05-20 19:49:00', 'N', 100, 89, 1, 0, 0),
(404, 66002, 66003, 'แก้1 คน1', '2023-05-20 19:51:00', 'N', 30, 79, 2, 0, NULL),
(405, 66002, 66004, 'แก้1 คน2', '2023-05-20 19:52:00', 'N', 50, 79, 2, 0, NULL),
(406, 66002, 66003, 'เสร็จ1', '2023-05-20 19:54:00', 'N', 100, 78, 1, 0, 0),
(407, 66002, 66004, 'เสร็จ2', '2023-05-20 19:56:00', 'N', 100, 82, 1, 0, 0),
(408, 66003, 66006, 'ทดสอบส่งงาน 20-5', '2023-05-20 21:10:00', 'N', 30, 78, 1, 0, 0),
(409, 66003, 66006, 'แก้1', '2023-05-20 21:11:00', 'N', 30, 74, 2, 0, NULL),
(411, 66004, 66007, 'ทดสอบส่งงาน ครั้้งแรก', '2023-05-20 21:20:00', 'N', 50, 78, 1, 0, 0),
(413, 66004, 66007, 'อย่าเพิ่งแก้กลับมา รอส่งพรุ่งนี้ดึก จะดูแจ้งเตือนเลยกำหนดส่ง', '2023-05-20 21:26:00', 'N', 50, 74, 2, 0, NULL),
(414, 66004, 66007, '01', '2023-05-20 21:28:00', 'N', 70, 78, 1, 1, 0),
(418, 66003, 66006, 'ปิด', '2023-05-20 21:36:00', 'N', 100, 74, 1, 0, 0),
(420, 66004, 66007, 'แก้2', '2023-05-21 21:41:00', 'N', 70, 79, 2, 1, NULL),
(421, 66004, 66007, 'ส่ง2', '2023-05-21 21:43:00', 'N', 80, 78, 1, 2, 4),
(422, 66004, 66007, 'แก้3', '2023-05-21 22:47:00', 'N', 80, 74, 2, 2, NULL),
(423, 66004, 66011, 'ขนมชั้นดอกกุหลาบ ขนมไทยใส่ไอเดีย แปลงโฉมขนมชั้นเป็นชั้น ๆ ทั่ว ๆ ไปให้เป็นดอกกุหลาบสีหวาน ๆ มอบเป็นของขวัญสำหรับคนพิเศษก็น่าจะดีไม่น้อย รับรองสวยล้ำน่ารักสุด ๆ แถมยังมีแค่ชิ้นเดียวในโลกอีกด้วย', '2023-05-21 23:11:00', 'Y', 0, 78, 1, 0, 0),
(424, 66014, 66017, 'ทดสอบส่งงาน', '2023-05-21 23:22:00', 'N', 100, 78, 1, 0, 0),
(425, 66014, 66016, 'ทดสองส่งงานรอบที่ 2', '2023-05-21 23:22:00', 'N', 40, 78, 1, 0, 0),
(426, 66014, 66016, 'แก้ไข', '2023-05-21 23:23:00', 'N', 40, 74, 2, 0, NULL),
(428, 66017, 66018, 'ส่ง01', '2023-05-25 00:15:00', 'Y', 0, 74, 1, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `file_item_details`
--

INSERT INTO `file_item_details` (`file_details_id`, `project_id`, `task_id`, `filename_details`, `details_id`, `newname_filedetails`) VALUES
(229, 66001, 66001, '346977499_631969938453065_6227502885285704682_n.jpg', 392, '2023-05-20D2029774727.jpg'),
(230, 66002, 66003, 'สำเนา LETMEIN_Ballot_Box (present) (1).pptx', 400, '2023-05-20ST1764620683.pptx'),
(231, 66002, 66004, 'map.pdf', 407, '2023-05-20ST1853366619.pdf'),
(232, 66003, 66006, '660411_คู่มือการเข้าใช้งานระบบรับสมัครนักศึกษา_V1.pdf', 408, '2023-05-20ST344780322.pdf'),
(233, 66003, 66006, 'การจารีตประเพณี(แก้ไข)ปี2 เทอม 64.pdf', 409, '2023-05-20D1148848100.pdf'),
(235, 66004, 66007, 'บทที่ 3 งบกระแสเงินสด1-64.pdf', 411, '2023-05-20ST1190447597.pdf'),
(237, 66004, 66007, 'FVIFA.jpg', 413, '2023-05-20D306705718.jpg'),
(238, 66004, 66007, 'ทดสอบadmin.docx', 414, '2023-05-20ST1154399164.docx'),
(240, 66004, 66011, 'ทดสอบadmin.docx', 423, '2023-05-21ST670335983.docx'),
(241, 66014, 66017, 'ทดสอบadmin.docx', 424, '2023-05-21ST525280400.docx'),
(242, 66014, 66016, 'อัตราการเก็บเงินรับเข้า2566-ปริญญาตรี_V4_24Mar23.pdf', 425, '2023-05-21ST1394963481.pdf'),
(243, 66014, 66016, 'RMUTK_Admission66_PartTimeProgram_v4_31Mar23.pdf', 425, '2023-05-21ST214330410.pdf'),
(244, 66014, 66016, '660411_คู่มือการเข้าใช้งานระบบรับสมัครนักศึกษา_V1.pdf', 425, '2023-05-21ST361912319.pdf'),
(247, 66017, 66018, 'joke.PNG', 428, '2023-05-25ST643928478.PNG'),
(248, 66017, 66018, 'joker.jpg', 428, '2023-05-25ST1795053164.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `file_item_project`
--

CREATE TABLE `file_item_project` (
  `file_item_project` int NOT NULL,
  `project_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `newname_filepro` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `file_item_project`
--

INSERT INTO `file_item_project` (`file_item_project`, `project_id`, `filename`, `newname_filepro`) VALUES
(677, 66002, 'เครื่องคำนวณหาค่าดัชนีมวลกาย (BMI) - Lovefitt.pdf', '2023-05-20P761357634.pdf'),
(679, 66002, 'wallhaven-md3vjm.jpg', '2023-05-20EP1560613437.jpg'),
(680, 66002, 'wallhaven-j535ww.jpg', '2023-05-20EP395244966.jpg'),
(681, 66002, 'wallhaven-kxzvj6.jpg', '2023-05-20EP1976399902.jpg'),
(682, 66003, 'ทดสอบadmin.docx', '2023-05-20P1031092842.docx'),
(683, 66003, 'map (1).pdf', '2023-05-20P1925325163.pdf'),
(684, 66003, 'FVIFA (1).jpg', '2023-05-20P1592559647.jpg'),
(685, 66004, 'โมฆะและโมฆียะ.PNG', '2023-05-20P2101211430.PNG'),
(686, 66005, 'บทที่ 3 งบกระแสเงินสด1-64.pdf', '2023-05-20P1039144795.pdf'),
(687, 66010, '7d000bc6cd131b8f27aa424605b917c9.jpg', '2023-05-21P1220235073.jpg'),
(688, 66010, 'joke.PNG', '2023-05-21P277693580.PNG'),
(689, 66010, 'joker.jpg', '2023-05-21P1177376224.jpg'),
(690, 66017, '660411_คู่มือการเข้าใช้งานระบบรับสมัครนักศึกษา_V1.pdf', '2023-05-24P1482452783.pdf'),
(691, 66017, 'ทดสอบadmin.docx', '2023-05-24P1875091355.docx'),
(692, 66017, 'map (1).pdf', '2023-05-24P1741447644.pdf'),
(693, 66017, 'joker.jpg', '2023-05-24P855708773.jpg'),
(694, 66017, 'avataaars.png', '2023-05-24P1054229378.png'),
(695, 66017, 'สำเนา LETMEIN_Ballot_Box (present) (1).pptx', '2023-05-24P803285233.pptx'),
(696, 66017, 'topic_final.jpg', '2023-05-24P83483592.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `file_item_task`
--

INSERT INTO `file_item_task` (`file_item_task`, `task_id`, `filename_task`, `project_id`, `newname_filetask`) VALUES
(229, 66001, '346977499_631969938453065_6227502885285704682_n.jpg', 66001, '2023-05-19AT45786959.jpg'),
(230, 66003, '96319_nb.jpg', 66002, '2023-05-20AT1428034631.jpg'),
(231, 66004, 'FVIFA.jpg', 66002, '2023-05-20AT1182111314.jpg'),
(232, 66004, 'FVIF.jpg', 66002, '2023-05-20AT1923937521.jpg'),
(233, 66004, 'บทที่ 3 งบกระแสเงินสด1-64.pdf', 66002, '2023-05-20AT127812105.pdf'),
(234, 66005, '1.docx', 66002, '2023-05-20AT112004360.docx'),
(235, 66006, '96319_nb (1).jpg', 66003, '2023-05-20AT469415157.jpg'),
(237, 66008, 'บทที่ 3 งบกระแสเงินสด1-64.pdf', 66005, '2023-05-20AT1603028890.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `job_type`
--

CREATE TABLE `job_type` (
  `id_jobtype` int NOT NULL,
  `name_jobtype` varchar(200) NOT NULL,
  `status` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `job_type`
--

INSERT INTO `job_type` (`id_jobtype`, `name_jobtype`, `status`) VALUES
(3, 'งานประจำ', 1),
(4, 'การจัดการความรู้', 1),
(5, 'งานประจำ', 2),
(6, 'งานวิจัย', 1),
(7, 'การบริการวิชาการ', 1),
(8, 'รับสมัครคนศประจำปี', 1),
(14, 'test', 2),
(21, 'asdfasdf', 2),
(22, 'การจัดการความรู้', 2),
(23, 'test', 2),
(24, 'ทดสอบเพิ่มประเภท', 2),
(25, 'ทดสอบเพิ่มประเภท 8/5', 2),
(26, 'test20/5', 2),
(27, 'ทดสอบเพิ่มประเภทงาน 20/5', 2),
(28, 'ทดสอบปะละ', 2),
(29, 'ทดสอบเพิ่มโดยรองคณะ', 2),
(30, 'Testประเภท21/5', 2),
(31, 'Test24/5', 2),
(32, 'ทดสอบ01', 2),
(33, 'ทั่วไป_กิจกรรม', 2);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `role_id` int NOT NULL,
  `position_name` varchar(200) NOT NULL,
  `level` int NOT NULL,
  `position_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(27, 'test', 5, 2),
(28, 'test2', 7, 2),
(29, 'แม่บ้าน', 6, 2),
(30, 'คนสวน', 6, 1),
(31, 'แม่บ้าน', 7, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `name_project`, `description`, `status_1`, `create_project`, `start_date`, `end_date`, `manager_id`, `status_2`, `id_jobtype`, `progress_project`) VALUES
(66001, 'test', 'safasdfsadfsadfasdfsdafsadfsadfsadfsadfasdfasdfsadfsdfsadfasdfsafasdf', 1, '2023-05-22 17:00:42', '2023-05-21 00:00:00', '2023-06-10 00:00:00', 23, 3, 4, 95),
(66002, 'ทดสอบ admin เพิ่มหัวข้องาน', 'ทดสอบหัวข้องาน01', 3, '2023-05-20 12:59:54', '2023-05-20 00:00:00', '2023-05-31 00:00:00', 79, 1, 8, 100),
(66003, 'ทดสอบ user', 'ทดสอบระบบ user', 3, '2023-05-21 15:08:02', '2023-05-20 00:00:00', '2024-01-01 00:00:00', 74, 1, 4, 100),
(66004, 'ทดสอบ user 02', 'ทดสอบ2', 1, '2023-05-21 15:53:01', '2023-05-20 00:00:00', '2023-05-30 00:00:00', 74, 3, 6, 16),
(66005, 'test01', 'ทดสองสร้างงาน 20-5', 1, '2023-05-20 14:44:14', '2023-05-20 00:00:00', '2023-05-24 00:00:00', 73, 2, 6, 0),
(66006, 'งานกิจกรรม_ทดสอบวันที่21/5', 'ทดสอบปะละ', 1, '2023-05-21 16:02:11', '2023-05-21 00:00:00', '2023-08-21 00:00:00', 74, 1, 30, 0),
(66008, 'งานพักผ่อน_ทดสอบวันที่21/5', 'ทดสอบยาวไป', 1, '2023-05-21 16:04:46', '2023-05-21 00:00:00', '2023-07-31 00:00:00', 74, 2, 8, 0),
(66010, 'พักก่อนไหมเผื่ออะไรจะดีขึ้น_ทดสอบวันที่21/5', 'หลับ', 1, '2023-05-21 16:14:38', '2023-05-21 00:00:00', '2029-01-01 00:00:00', 74, 1, 4, 0),
(66014, 'ครั้งสุดท้าย_ทดสอบวันที่21/5', 'โดนลบจาก...', 1, '2023-05-21 16:25:40', '2023-05-21 00:00:00', '2023-05-31 00:00:00', 74, 3, 30, 70),
(66015, 'ข้าวใหม่ปลามัน 0933', 'sfasdfasdfasdfas', 1, '2023-05-23 16:03:01', '2023-05-23 00:00:00', '2023-06-03 00:00:00', 76, 2, 7, 0),
(66016, 'ssss', 'sdgfsdfgsdfgsdfgsdfgsdfg', 1, '2023-05-23 16:11:50', '2023-05-23 00:00:00', '2023-06-03 00:00:00', 77, 3, 3, 0),
(66017, 'ประจำปี_ทดสอบ24/5', 'ทดสอบระบบก่อนสอบ', 1, '2023-05-24 17:53:29', '2023-05-24 00:00:00', '2023-06-30 00:00:00', 79, 1, 31, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `project_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`project_id`, `user_id`) VALUES
(66001, 99),
(66002, 78),
(66002, 82),
(66002, 89),
(66003, 78),
(66003, 99),
(66004, 75),
(66004, 76),
(66004, 77),
(66004, 78),
(66004, 99),
(66005, 74),
(66005, 84),
(66006, 75),
(66006, 76),
(66006, 77),
(66006, 78),
(66008, 75),
(66008, 77),
(66008, 78),
(66010, 78),
(66010, 99),
(66014, 77),
(66014, 78),
(66015, 78),
(66016, 78),
(66017, 73),
(66017, 74),
(66017, 75),
(66017, 77);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`task_id`, `name_tasklist`, `description_task`, `status_task`, `strat_date_task`, `end_date_task`, `project_id`, `user_id`, `progress_task`, `status_timetask`, `status_task2`) VALUES
(66001, 'test', 'asdfasdfasdfasdfasdfasdfasdfasdfasdf', 5, '2023-05-19 16:00:00', '2023-05-26 16:00:00', 66001, 99, 100, 0, 0),
(66002, 'test 2', 'ฟหกดฟหกดฟหกดฟหกดหฟกดฟหด', 3, '2023-05-20 15:15:00', '2023-05-27 15:15:00', 66001, 99, 90, 1, 0),
(66003, 'งานย่อย01', 'ย่อย1', 5, '2023-05-20 19:32:00', '2023-05-22 19:32:00', 66002, 78, 100, 0, 0),
(66004, 'งานย่อย02', 'ย่อย2', 5, '2023-05-20 19:33:00', '2023-05-24 19:33:00', 66002, 82, 100, 0, 0),
(66005, 'งานย่อย03', 'ย่อย3', 5, '2023-05-20 19:34:00', '2023-05-26 11:38:00', 66002, 89, 100, 0, 0),
(66006, 'งานย่อย01', 'ย่อย1', 5, '2023-05-20 21:09:00', '2023-05-31 21:09:00', 66003, 78, 100, 0, 0),
(66007, 'งานวิชาการ1', 'ย่อย1', 3, '2023-05-20 21:18:00', '2023-05-21 21:19:00', 66004, 78, 80, 2, 0),
(66008, 'ทดสอบงานย่อย 20-5', '', 1, '2023-05-20 21:44:00', '2023-05-22 00:47:00', 66005, 74, 0, 2, 0),
(66009, 'งานย่อย01', 'งานประชุม', 1, '2023-05-21 22:45:00', '2023-05-24 22:45:00', 66004, 78, 0, 2, 0),
(66010, 'งานชมรม', 'ทดสอบ3', 1, '2023-05-21 22:48:00', '2023-05-26 22:48:00', 66004, 78, 0, 1, 0),
(66011, 'งานกีฬาสี', 'ทดสอบ4', 2, '2023-05-21 22:49:00', '2023-05-27 22:49:00', 66004, 78, 0, 0, 0),
(66012, 'รายชื่่อนศ.ใหม่', 'ทดสอบงานด่วน', 1, '2023-05-21 22:51:00', '2023-05-22 10:30:00', 66004, 78, 0, 2, 0),
(66013, 'โบโบ้', 'วันเบื่อๆ', 1, '2023-05-21 23:19:00', '2023-05-24 23:19:00', 66010, 78, 0, 2, 0),
(66014, 'คิมิโนะโตะ', 'in love', 1, '2023-05-21 23:19:00', '2023-05-25 23:19:00', 66010, 78, 0, 2, 0),
(66015, 'ฉันเหนื่อย', 'ฉันท้อ ฉันพอ ฉันก็ต้องทำ', 1, '2023-05-21 23:20:00', '2023-05-31 23:20:00', 66010, 78, 0, 0, 0),
(66016, 'บาบา', 'ทด123..', 3, '2023-05-21 23:21:00', '2023-05-23 23:21:00', 66014, 78, 40, 2, 0),
(66017, 'ทดทด', 'ad;adkf', 5, '2023-05-21 23:21:00', '2023-05-24 23:21:00', 66014, 78, 100, 0, 0),
(66018, 'งานกีฬา', 'ทดสอบงานย่อย', 2, '2023-05-25 00:09:00', '2023-06-25 00:09:00', 66017, 74, 0, 0, 0);

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
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_user` int NOT NULL,
  `tel` varchar(255) NOT NULL,
  `line_token` varchar(255) NOT NULL,
  `idcard` varchar(13) NOT NULL,
  `department_id` int NOT NULL,
  `shortname_id` int NOT NULL,
  `status_user2` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `role_id`, `avatar`, `date_created`, `status_user`, `tel`, `line_token`, `idcard`, `department_id`, `shortname_id`, `status_user2`) VALUES
(23, 'joey', 'admin', 'admin@admin.com', '$2y$10$gjKzu6b5z.jz9VxRp2Irv.tHidOjJdpqHJuRo9PwPXkwjrWx6gzS.', 1, NULL, '2023-05-25 05:28:42', 1, '0641693159', 'yj58om1G5huMwz0d17bSLROoY3CcCSa8BRWmHCfH1rx', '1111111111111', 0, 1, 1),
(73, 'กิตติพงษ์', 'โสภณธรรมภาณ', 'kittipong.s@mail.rmutk.ac.th', '$2y$10$kfJeZH8K5w2L0kCIJvKumOZU/2EeEPR9cb6LMDWbRR2UQ5y.XYnvq', 2, '2023-05-12U1171734199.jpg', '2023-05-19 07:11:00', 1, '0999999999', '', '4003584178340', 0, 3, 1),
(74, 'สมศักดิ์', 'บุตรสาคร', 'Somsak@mail.rmutk.ac.th', '$2y$10$DRbrUeS8GItVrE2Kopy0G.Bajzb4TqOlKaCey1wygOX9.uvGubJd2', 3, '2023-05-12U1395894619.jpg', '2023-05-20 14:06:51', 1, '0999999999', 'RbQVynyzlfe3sxR0d9l9GwoxS1Dx2B8ll1qbqJz63t6', '7503283007201', 1, 3, 1),
(75, 'อธิพันธ์', 'วรรณสุริยะ', 'atipan.v@mail.rmutk.ac.th', '$2y$10$HTNvi6fEe75qnuhBqhfH0.lgyqZ2aMFlRsRedkKliA1A2au0HBXK.', 5, '2023-05-12U162504577.jpg', '2023-05-19 07:11:06', 1, '0999999999', '', '7722508644545', 1, 3, 1),
(76, 'น้ำเพชร', 'เพชรใหม่', 'namphet@mail.rmutk.ac.th', '$2y$10$v1YIOScBj1Rx/OdWbPGhVuxZL1A8qDDLaHIE1xkto.29kma/GMd0a', 4, '2023-05-12U476885287.jpg', '2023-05-25 10:46:52', 1, '0999999999', '', '6712216353828', 1, 10, 1),
(77, 'ปริญญา', 'สีม่วง', 'parinya.si@mail.rmutk.ac.th', '$2y$10$ysj9ehsqkirmDQDdjAWCVuC8ij6kiLzKDSmzC6ZLzChcwZZzmaCde', 5, '2023-05-12U1169814238.jpg', '2023-05-19 07:11:08', 1, '0999999999', '', '2502453055251', 1, 3, 1),
(78, 'บุญรอด', 'พาหา', 'bunrot@mail.rmutk.ac.th', '$2y$10$2/w1tH6j2.VzvKI.di1FV.haXcP/htagq8EXr0f2nCpbmjhcFAPxq', 7, '2023-05-16U117700410.jpg', '2023-05-20 14:06:28', 1, '0999999999', '78wnOt3fCqhW1QKGhtHyA1OvyKscMyKN78eX9zCvwZl', '2831889330158', 1, 2, 1),
(79, 'สมัชญ์', 'อ้นอัมพร', 'admin01@gmail.com', '$2y$10$lm6WGZyfv3qEYE6lXup2ae8fY7kHmKPqYtfQOJdkogfWZi/y2INOa', 1, '2023-05-24U1877377566.png', '2023-05-24 16:20:15', 1, '0841615365', 'RbQVynyzlfe3sxR0d9l9GwoxS1Dx2B8ll1qbqJz63t6', '1101501077896', 0, 1, 1),
(80, 'พรฤพา', 'ทับสุข', 'admin02@gmail.com', '$2y$10$UEhXItZye2UMlHg1Vx1AseKHlOJRq525zme2lUdu9jKmrqfdDnwfq', 1, '2023-05-18U38922661.jpg', '2023-05-19 07:11:13', 1, '0840030012', '', '0102345678902', 0, 2, 1),
(82, 'พรนิภา ', ' เชิดชู', 'pornnipa@gmail.com', '$2y$10$1vsQRRqgmaynhNyqELUA0eYYl.vB4Iv7cW8VGSfP.fRfBg45G7UTe', 7, NULL, '2023-05-22 18:22:49', 1, '0952481111', 'RbQVynyzlfe3sxR0d9l9GwoxS1Dx2B8ll1qbqJz63t6', '1100201561651', 2, 7, 1),
(84, 'รอง', 'แคโอชา', 'long@gmail.com', '$2y$10$vBmDleNQd0TY2qPwiG9HF.nspHpgvFqdlfGJjtn0cSbAm3R.TAx6q', 7, '2023-05-18U781934497.png', '2023-05-20 14:59:50', 1, '0952481111', 'ojpXWz8qIjS7rtvSFC29Z43H7GX6Z4Gk1q3VomduWeT', '1100201561651', 0, 9, 1),
(85, 'รองนา', 'เขียวขจี', 'longna@gmail.com', '$2y$10$lDOTkXW3VWzSh2ren2t3M.h.IuPpYcZyeZiodPhRn9kYUnlFcsl5m', 7, '2023-05-18U412316207.png', '2023-05-20 14:54:55', 0, '0952481111', '', '1100201561651', 7, 1, 0),
(86, 'สมัชญ์', 'อ้น', 'poon@gmail.com', '$2y$10$YARFgT7qhSkeoBQcSLfJ9.I434KoDc9j3Bcp4IC0d.PPIMSU8oVl.', 1, NULL, '2023-05-19 07:11:19', 1, '0840030044', '', '0123456789105', 0, 3, 1),
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
(99, 'test', 'test', 'test@gmail.com', '$2y$10$8Zb0ylxJeyjvTZdLxmK.teBQqKIpxAgKst359d4XQa4UITY2SGhHm', 7, NULL, '2023-05-23 16:48:18', 1, '0952481111', '', '1199210561651', 1, 2, 1),
(100, 'เอกภพ ', 'เสสันเทียะ', 'honhon16461@gmail.com', '$2y$10$FYpY5tIDU/FofZdO2Sf86Oyub5j0Vgb0xwa6EXL1nX8accrKvMLfC', 7, '2023-05-22U1207494387.jpg', '2023-05-22 18:12:31', 0, '0641693159', '', '7774804932331', 3, 1, 1),
(101, 'babun', 'kung', 'babun@gmail.coom', '$2y$10$mqGaJO6tmLddH5eXlxkWcuf5Ur92Mjc9Qi0Y8Of7vXMXyIZP/S6cu', 30, '2023-05-24U1960376077.jpg', '2023-05-24 15:41:24', 1, '0897762830', 'RbQVynyzlfe3sxR0d9l9GwoxS1Dx2B8ll1qbqJz63t6', '9876543210123', 0, 11, 1),
(102, 'Test', 'Admin', 'admin03@gmail.com', '$2y$10$0hrUh4ae01M3qYm1PjGBKOFoQHpp.SroDxdGpM8IQ.gm3s19hpZJ.', 1, '2023-05-24U563121574.jpg', '2023-05-24 15:37:24', 1, '0952481111', '', '1199210561651', 3, 1, 1);

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
  MODIFY `details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429;

--
-- AUTO_INCREMENT for table `file_item_details`
--
ALTER TABLE `file_item_details`
  MODIFY `file_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `file_item_project`
--
ALTER TABLE `file_item_project`
  MODIFY `file_item_project` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=697;

--
-- AUTO_INCREMENT for table `file_item_task`
--
ALTER TABLE `file_item_task`
  MODIFY `file_item_task` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `job_type`
--
ALTER TABLE `job_type`
  MODIFY `id_jobtype` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66019;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

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
