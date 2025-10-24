-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 11:33 PM
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
-- Database: `dbcaiwl`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblautonumbers`
--

CREATE TABLE `tblautonumbers` (
  `AUTOID` int(11) NOT NULL,
  `AUTOSTART` varchar(30) NOT NULL,
  `AUTOEND` int(11) NOT NULL,
  `AUTOINC` int(11) NOT NULL,
  `AUTOKEY` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcontent`
--

CREATE TABLE `tblcontent` (
  `ContentID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Topic` varchar(255) DEFAULT '',
  `Body` mediumtext NOT NULL,
  `CreatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblexercise`
--

CREATE TABLE `tblexercise` (
  `ExerciseID` int(11) NOT NULL,
  `LessonID` int(11) NOT NULL,
  `Question` text NOT NULL,
  `ChoiceA` text NOT NULL,
  `ChoiceB` text NOT NULL,
  `ChoiceC` text NOT NULL,
  `ChoiceD` text NOT NULL,
  `Answer` varchar(90) NOT NULL,
  `ExercisesDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblexercise`
--

INSERT INTO `tblexercise` (`ExerciseID`, `LessonID`, `Question`, `ChoiceA`, `ChoiceB`, `ChoiceC`, `ChoiceD`, `Answer`, `ExercisesDate`) VALUES
(20250001, 0, 'Which of the following is NOT typically considered one of the \'3 Vs\' (or common expanded Vs) that define Big Data?', 'Volume', 'Velocity', 'Variety', 'Visualization', 'D', '0000-00-00'),
(20250002, 0, 'Which technology is widely recognized for its open-source framework that allows for distributed storage and processing of massive datasets across clusters of computers?', 'Microsoft Excel', 'Apache Hadoop', 'Oracle Database', 'Adobe Photoshop', 'B', '0000-00-00'),
(20250003, 0, 'A primary benefit of leveraging Big Data analytics in business is to:', 'Reduce the overall quantity of data collected to save storage space.', 'Enable manual data entry and processing for greater human oversight.', 'Discover hidden patterns, trends, and correlations to improve decision-making.', 'Strictly limit data access to only a few high-level executives.', 'C', '0000-00-00'),
(20250004, 0, 'In the context of Big Data, the term \'Veracity\' primarily addresses which of the following issues?', 'The sheer amount of data being generated.', 'The speed at which data needs to be processed.', 'The diverse range of data formats and sources.', 'The uncertainty, incompleteness, and unreliability of the data.', 'D', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tbllesson`
--

CREATE TABLE `tbllesson` (
  `LessonID` int(11) NOT NULL,
  `LessonChapter` varchar(90) NOT NULL,
  `LessonTitle` varchar(90) NOT NULL,
  `FileLocation` text NOT NULL,
  `Category` varchar(90) NOT NULL
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

--
-- Dumping data for table `tblscore`
--

INSERT INTO `tblscore` (`ScoreID`, `LessonID`, `ExerciseID`, `StudentID`, `NoItems`, `Score`, `Submitted`, `Answer`) VALUES
(124, 0, 20250001, 7, 1, 0, 0, NULL),
(125, 0, 20250003, 7, 1, 0, 0, NULL),
(126, 0, 20250004, 7, 1, 1, 0, NULL);

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
(7, 'User', 'Demo', '', '', 'user', '12dea96fec20593566ab75692c9949596833adc9');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudentquestion`
--

CREATE TABLE `tblstudentquestion` (
  `SQID` int(11) NOT NULL,
  `ExerciseID` int(11) NOT NULL,
  `LessonID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Question` varchar(90) NOT NULL,
  `CA` varchar(90) NOT NULL,
  `CB` varchar(90) NOT NULL,
  `CC` varchar(90) NOT NULL,
  `CD` varchar(90) NOT NULL,
  `QA` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudentquestion`
--

INSERT INTO `tblstudentquestion` (`SQID`, `ExerciseID`, `LessonID`, `StudentID`, `Question`, `CA`, `CB`, `CC`, `CD`, `QA`) VALUES
(12, 20250024, 8, 7, 'Which Laravel feature provides an expressive, fluent interface for interacting with databa', 'Eloquent ORM', 'Blade Templating Engine', 'Artisan Console', 'Service Container', 'A'),
(13, 20250025, 8, 7, 'What is the primary purpose of Laravel\'s \'Artisan\' command-line tool?', 'To compile CSS and JavaScript assets.', 'To manage database migrations and generate boilerplate code.', 'To handle user authentication and authorization.', 'To optimize server performance and caching.', 'B'),
(14, 20250026, 8, 7, 'Which directory in a standard Laravel project typically holds view files?', 'app/', 'config/', 'resources/views/', 'routes/', 'C'),
(15, 20250027, 8, 7, 'Which Laravel feature provides an expressive, fluent interface for interacting with databa', 'Eloquent ORM', 'Blade Templating Engine', 'Artisan Console', 'Service Container', 'A'),
(16, 20250028, 8, 7, 'What is the primary purpose of Laravel\'s \'Artisan\' command-line tool?', 'To compile CSS and JavaScript assets.', 'To manage database migrations and generate boilerplate code.', 'To handle user authentication and authorization.', 'To optimize server performance and caching.', 'B'),
(17, 20250029, 8, 7, 'Which directory in a standard Laravel project typically holds view files?', 'app/', 'config/', 'resources/views/', 'routes/', 'C'),
(18, 20250030, 8, 7, 'Which of the following is NOT typically considered one of the \'Vs\' of Big Data?', 'Volume', 'Velocity', 'Veracity', 'Variety', 'E'),
(19, 20250031, 8, 7, 'What is the primary function of Hadoop Distributed File System (HDFS) in the Hadoop ecosys', 'Data processing and analysis', 'Resource management and job scheduling', 'Distributed storage of large datasets', 'Data visualization and reporting', 'C'),
(20, 20250032, 8, 7, 'Which of the following programming languages is commonly used for data analysis and statis', 'Java', 'C++', 'Python', 'Assembly', 'C'),
(21, 20250033, 8, 7, 'What is the term for the process of extracting valuable insights and knowledge from large ', 'Data Mining', 'Data Cleansing', 'Data Warehousing', 'Data Encryption', 'A'),
(22, 20250034, 8, 7, 'Which of the following is an example of a NoSQL database often used in Big Data environmen', 'MySQL', 'PostgreSQL', 'MongoDB', 'Oracle', 'C'),
(65, 20250001, 0, 7, 'Which of the following is NOT typically considered one of the \'3 Vs\' (or common expanded V', 'Volume', 'Velocity', 'Variety', 'Visualization', 'D'),
(66, 20250002, 0, 7, 'Which technology is widely recognized for its open-source framework that allows for distri', 'Microsoft Excel', 'Apache Hadoop', 'Oracle Database', 'Adobe Photoshop', 'B'),
(67, 20250003, 0, 7, 'A primary benefit of leveraging Big Data analytics in business is to:', 'Reduce the overall quantity of data collected to save storage space.', 'Enable manual data entry and processing for greater human oversight.', 'Discover hidden patterns, trends, and correlations to improve decision-making.', 'Strictly limit data access to only a few high-level executives.', 'C'),
(68, 20250004, 0, 7, 'In the context of Big Data, the term \'Veracity\' primarily addresses which of the following', 'The sheer amount of data being generated.', 'The speed at which data needs to be processed.', 'The diverse range of data formats and sources.', 'The uncertainty, incompleteness, and unreliability of the data.', 'D');

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
-- Indexes for table `tblautonumbers`
--
ALTER TABLE `tblautonumbers`
  ADD PRIMARY KEY (`AUTOID`);

--
-- Indexes for table `tblcontent`
--
ALTER TABLE `tblcontent`
  ADD PRIMARY KEY (`ContentID`);

--
-- Indexes for table `tblexercise`
--
ALTER TABLE `tblexercise`
  ADD PRIMARY KEY (`ExerciseID`);

--
-- Indexes for table `tbllesson`
--
ALTER TABLE `tbllesson`
  ADD PRIMARY KEY (`LessonID`);

--
-- Indexes for table `tblscore`
--
ALTER TABLE `tblscore`
  ADD PRIMARY KEY (`ScoreID`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`StudentID`) USING BTREE;

--
-- Indexes for table `tblstudentquestion`
--
ALTER TABLE `tblstudentquestion`
  ADD PRIMARY KEY (`SQID`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblautonumbers`
--
ALTER TABLE `tblautonumbers`
  MODIFY `AUTOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblcontent`
--
ALTER TABLE `tblcontent`
  MODIFY `ContentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblexercise`
--
ALTER TABLE `tblexercise`
  MODIFY `ExerciseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20250035;

--
-- AUTO_INCREMENT for table `tbllesson`
--
ALTER TABLE `tbllesson`
  MODIFY `LessonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblscore`
--
ALTER TABLE `tblscore`
  MODIFY `ScoreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblstudentquestion`
--
ALTER TABLE `tblstudentquestion`
  MODIFY `SQID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
