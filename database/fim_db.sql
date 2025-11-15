-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 09:10 AM
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
-- Database: `fim_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcategories`
--

CREATE TABLE `tblcategories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `CategoryDescription` text DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategories`
--

INSERT INTO `tblcategories` (`CategoryID`, `CategoryName`, `CategoryDescription`, `CreatedAt`, `IsActive`) VALUES
(1, 'Technology', 'Câu hỏi về công nghệ thông tin, lập trình, AI', '2025-10-25 04:37:26', 1),
(2, 'Science', 'Câu hỏi về khoa học tự nhiên, vật lý, hóa học', '2025-10-25 04:37:26', 1),
(3, 'Mathematics', 'Câu hỏi về toán học các cấp độ', '2025-10-25 04:37:26', 1),
(4, 'Business', 'Câu hỏi về kinh doanh, quản lý, marketing', '2025-10-25 04:37:26', 1),
(5, 'Language', 'Câu hỏi về ngôn ngữ, văn học, ngoại ngữ', '2025-10-25 04:37:26', 1),
(6, 'Coding', NULL, '2025-10-26 08:32:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontent`
--

CREATE TABLE `tblcontent` (
  `ContentID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Topic` varchar(255) DEFAULT '',
  `CategoryID` int(11) DEFAULT NULL,
  `TopicID` int(11) DEFAULT NULL,
  `Body` mediumtext NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `CreatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblexercise`
--

CREATE TABLE `tblexercise` (
  `ExerciseID` int(11) NOT NULL,
  `LessonID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `TopicID` int(11) DEFAULT NULL,
  `Question` text NOT NULL,
  `ChoiceA` text NOT NULL,
  `ChoiceB` text NOT NULL,
  `ChoiceC` text NOT NULL,
  `ChoiceD` text NOT NULL,
  `Answer` varchar(90) NOT NULL,
  `ExercisesDate` date NOT NULL,
  `CreatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbllesson`
--

CREATE TABLE `tbllesson` (
  `LessonID` int(11) NOT NULL,
  `LessonChapter` varchar(90) NOT NULL,
  `LessonTitle` varchar(90) NOT NULL,
  `FileLocation` text NOT NULL,
  `Category` varchar(90) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `TopicID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblscore`
--

CREATE TABLE `tblscore` (
  `ScoreID` int(11) NOT NULL,
  `LessonID` int(11) NOT NULL,
  `ExerciseID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `NoItems` int(11) NOT NULL DEFAULT 1,
  `Score` int(11) NOT NULL,
  `Submitted` tinyint(1) NOT NULL,
  `Answer` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `StudentID` int(11) NOT NULL,
  `Fname` varchar(90) NOT NULL,
  `Lname` varchar(90) NOT NULL,
  `Address` varchar(90) NOT NULL,
  `MobileNo` varchar(90) NOT NULL,
  `STUDUSERNAME` varchar(90) NOT NULL,
  `STUDPASS` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`StudentID`, `Fname`, `Lname`, `Address`, `MobileNo`, `STUDUSERNAME`, `STUDPASS`) VALUES
(7, 'User', 'Demo', '', '', 'user', '12dea96fec20593566ab75692c9949596833adc9'),
(8, 'Khamko', 'xaiyasith', 'DonePhay, Sanamxai, Attapeu', '09876545678', 'khamko', '14c196cb7423b42e7e9a528ef038789dccb7a0c1'),
(9, 'Khampasong', 'KBT', 'DonePhay, Sanamxai, Attapeu', '09876545678', 'khampasong', 'f8954cec14a317b0948947513e0ff1d8f144789c');

-- --------------------------------------------------------

--
-- Table structure for table `tbltopics`
--

CREATE TABLE `tbltopics` (
  `TopicID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `TopicName` varchar(100) NOT NULL,
  `TopicDescription` text DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltopics`
--

INSERT INTO `tbltopics` (`TopicID`, `CategoryID`, `TopicName`, `TopicDescription`, `CreatedAt`, `IsActive`) VALUES
(1, 1, 'Artificial Intelligence', 'Câu hỏi về AI, Machine Learning, Deep Learning', '2025-10-25 04:37:26', 1),
(2, 1, 'Web Development', 'Câu hỏi về HTML, CSS, JavaScript, PHP', '2025-10-25 04:37:26', 1),
(3, 1, 'Database', 'Câu hỏi về SQL, MySQL, MongoDB', '2025-10-25 04:37:26', 1),
(4, 1, 'Programming Languages', 'Câu hỏi về Java, Python, C++, etc.', '2025-10-25 04:37:26', 1),
(5, 2, 'Physics', 'Câu hỏi về vật lý', '2025-10-25 04:37:26', 1),
(6, 2, 'Chemistry', 'Câu hỏi về hóa học', '2025-10-25 04:37:26', 1),
(7, 2, 'Biology', 'Câu hỏi về sinh học', '2025-10-25 04:37:26', 1),
(8, 3, 'Algebra', 'Câu hỏi về đại số', '2025-10-25 04:37:26', 1),
(9, 3, 'Geometry', 'Câu hỏi về hình học', '2025-10-25 04:37:26', 1),
(10, 3, 'Calculus', 'Câu hỏi về giải tích', '2025-10-25 04:37:26', 1),
(11, 4, 'Marketing', 'Câu hỏi về marketing', '2025-10-25 04:37:26', 1),
(12, 4, 'Management', 'Câu hỏi về quản lý', '2025-10-25 04:37:26', 1),
(13, 5, 'English', 'Câu hỏi tiếng Anh', '2025-10-25 04:37:26', 1),
(14, 5, 'Vietnamese Literature', 'Câu hỏi văn học Việt Nam', '2025-10-25 04:37:26', 1),
(15, 6, 'Laravel', NULL, '2025-10-26 08:32:46', 1),
(16, 6, 'CSS', NULL, '2025-11-01 15:35:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `USERID` int(11) NOT NULL,
  `NAME` varchar(90) NOT NULL,
  `UEMAIL` varchar(90) NOT NULL,
  `PASS` varchar(90) NOT NULL,
  `TYPE` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`USERID`, `NAME`, `UEMAIL`, `PASS`, `TYPE`) VALUES
(3, 'Administrator', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcategories`
--
ALTER TABLE `tblcategories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `tblcontent`
--
ALTER TABLE `tblcontent`
  ADD PRIMARY KEY (`ContentID`),
  ADD KEY `idx_content_category` (`CategoryID`),
  ADD KEY `idx_content_topic` (`TopicID`),
  ADD KEY `idx_content_user` (`CreatedBy`);

--
-- Indexes for table `tblexercise`
--
ALTER TABLE `tblexercise`
  ADD PRIMARY KEY (`ExerciseID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `TopicID` (`TopicID`),
  ADD KEY `idx_exercise_user` (`CreatedBy`);

--
-- Indexes for table `tbllesson`
--
ALTER TABLE `tbllesson`
  ADD PRIMARY KEY (`LessonID`),
  ADD KEY `idx_lesson_category` (`CategoryID`),
  ADD KEY `idx_lesson_topic` (`TopicID`);

--
-- Indexes for table `tblscore`
--
ALTER TABLE `tblscore`
  ADD PRIMARY KEY (`ScoreID`),
  ADD KEY `idx_score_exercise` (`ExerciseID`),
  ADD KEY `idx_score_student` (`StudentID`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`StudentID`) USING BTREE;

--
-- Indexes for table `tbltopics`
--
ALTER TABLE `tbltopics`
  ADD PRIMARY KEY (`TopicID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcategories`
--
ALTER TABLE `tblcategories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblcontent`
--
ALTER TABLE `tblcontent`
  MODIFY `ContentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblexercise`
--
ALTER TABLE `tblexercise`
  MODIFY `ExerciseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20259891;

--
-- AUTO_INCREMENT for table `tbllesson`
--
ALTER TABLE `tbllesson`
  MODIFY `LessonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblscore`
--
ALTER TABLE `tblscore`
  MODIFY `ScoreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbltopics`
--
ALTER TABLE `tbltopics`
  MODIFY `TopicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcontent`
--
ALTER TABLE `tblcontent`
  ADD CONSTRAINT `fk_content_category` FOREIGN KEY (`CategoryID`) REFERENCES `tblcategories` (`CategoryID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_content_topic` FOREIGN KEY (`TopicID`) REFERENCES `tbltopics` (`TopicID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_content_user` FOREIGN KEY (`CreatedBy`) REFERENCES `tblusers` (`USERID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblexercise`
--
ALTER TABLE `tblexercise`
  ADD CONSTRAINT `fk_exercise_user` FOREIGN KEY (`CreatedBy`) REFERENCES `tblusers` (`USERID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tblexercise_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `tblcategories` (`CategoryID`) ON DELETE SET NULL,
  ADD CONSTRAINT `tblexercise_ibfk_2` FOREIGN KEY (`TopicID`) REFERENCES `tbltopics` (`TopicID`) ON DELETE SET NULL;

--
-- Constraints for table `tbllesson`
--
ALTER TABLE `tbllesson`
  ADD CONSTRAINT `fk_lesson_category` FOREIGN KEY (`CategoryID`) REFERENCES `tblcategories` (`CategoryID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lesson_topic` FOREIGN KEY (`TopicID`) REFERENCES `tbltopics` (`TopicID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblscore`
--
ALTER TABLE `tblscore`
  ADD CONSTRAINT `fk_score_exercise` FOREIGN KEY (`ExerciseID`) REFERENCES `tblexercise` (`ExerciseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_score_student` FOREIGN KEY (`StudentID`) REFERENCES `tblstudent` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbltopics`
--
ALTER TABLE `tbltopics`
  ADD CONSTRAINT `tbltopics_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `tblcategories` (`CategoryID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
