-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2025 at 05:15 PM
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
(20250004, 0, 'What is the purpose of middleware in Laravel?', 'To define database relationships', 'To filter HTTP requests entering your application', 'To generate HTML forms', 'To manage application configuration', 'B', '0000-00-00'),
(20250005, 0, 'Which of the following is NOT typically considered a key characteristic (\'V\') of Big Data?', 'Volume', 'Velocity', 'Variety', 'Validity', 'D', '0000-00-00'),
(20250006, 0, 'Which of these technologies is commonly used for storing and processing Big Data?', 'Microsoft Excel', 'Apache Hadoop', 'Microsoft Access', 'Adobe Photoshop', 'B', '0000-00-00'),
(20250007, 0, 'What does \'Velocity\' refer to in the context of Big Data?', 'The size of the dataset.', 'The speed at which data is generated and processed.', 'The different types of data being collected.', 'The accuracy of the data.', 'B', '0000-00-00');

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
(26, 20250004, 8, 7, 'What does the acronym \'ORM\' stand for in the context of Eloquent?', 'Object Relational Mapping', 'Object Resource Model', 'Original Resource Management', 'Object Routing Mechanism', 'A'),
(27, 20250005, 8, 7, 'Which of the following is the correct way to access a value from the `.env` file in Larave', 'config(\'key\')', 'env(\'KEY\')', 'getEnv(\'KEY\')', 'getenv(\'key\')', 'B'),
(28, 20250006, 8, 7, 'What is the purpose of Laravel\'s \'Blade\' templating engine?', 'To handle database queries.', 'To define routes for the application.', 'To create dynamic HTML views using PHP.', 'To manage user authentication.', 'C'),
(29, 20250007, 8, 7, 'In Laravel, what is a \'Middleware\'?', 'A way to define database relationships.', 'A mechanism for filtering HTTP requests entering your application.', 'A tool for generating API documentation.', 'A component for managing user sessions.', 'B'),
(31, 20250009, 8, 7, 'What is the purpose of Laravel\'s \'Artisan\' console?', 'To manage server configurations.', 'To generate boilerplate code, run migrations, and perform other tasks.', 'To debug PHP code.', 'To compile CSS and JavaScript files.', 'B'),
(32, 20250010, 8, 7, 'Which method is typically used to retrieve all records from a database table using Eloquen', 'Model::find()', 'Model::get()', 'Model::all()', 'Model::select()', 'C'),
(33, 20250011, 8, 7, 'Which of the following is the preferred way to interact with a database in Laravel, provid', 'Raw SQL queries', 'PDO directly', 'Eloquent ORM', 'phpMyAdmin', 'C'),
(34, 20250012, 8, 7, 'What is the purpose of Laravel\'s service container?', 'To store session data.', 'To manage route definitions.', 'To manage class dependencies and perform dependency injection.', 'To handle HTTP requests.', 'C'),
(35, 20250013, 8, 7, 'Which command is used to create a new migration in Laravel?', 'php artisan create:migration', 'php artisan make:migration', 'php artisan migrate:new', 'php artisan db:migrate', 'B'),
(36, 20250014, 8, 7, 'What is the purpose of Laravel\'s \'blade\' templating engine?', 'To compile PHP code into machine code for faster execution.', 'To provide a simple way to create dynamic HTML views using template inheritance and sectio', 'To manage database schemas.', 'To handle user authentication.', 'B'),
(37, 20250015, 0, 7, 'Which of the following is NOT one of the commonly cited characteristics (the \'Vs\') of Big ', 'Volume', 'Velocity', 'Veracity', 'Visibility', 'D'),
(38, 20250016, 0, 7, 'Which of the following technologies is most commonly used for distributed storage and proc', 'Relational Database Management System (RDBMS)', 'Hadoop', 'Microsoft Excel', 'Operating System', 'B'),
(39, 20250017, 0, 7, 'What is the primary benefit of using NoSQL databases in the context of Big Data?', 'Ensuring strict data consistency and ACID properties', 'Providing a standardized SQL query language', 'Handling unstructured and semi-structured data efficiently', 'Minimizing storage space requirements', 'C'),
(40, 20250018, 0, 7, 'Which of the following is a common application of Big Data analytics in the healthcare ind', 'Predicting equipment failure in manufacturing', 'Optimizing supply chain logistics', 'Personalized medicine and patient care', 'Fraud detection in financial transactions', 'C'),
(44, 20250004, 0, 7, 'What is the purpose of middleware in Laravel?', 'To define database relationships', 'To filter HTTP requests entering your application', 'To generate HTML forms', 'To manage application configuration', 'B'),
(45, 20250005, 0, 7, 'Which of the following is NOT typically considered a key characteristic (\'V\') of Big Data?', 'Volume', 'Velocity', 'Variety', 'Validity', 'D'),
(46, 20250006, 0, 7, 'Which of these technologies is commonly used for storing and processing Big Data?', 'Microsoft Excel', 'Apache Hadoop', 'Microsoft Access', 'Adobe Photoshop', 'B'),
(47, 20250007, 0, 7, 'What does \'Velocity\' refer to in the context of Big Data?', 'The size of the dataset.', 'The speed at which data is generated and processed.', 'The different types of data being collected.', 'The accuracy of the data.', 'B');

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
  MODIFY `ScoreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblstudentquestion`
--
ALTER TABLE `tblstudentquestion`
  MODIFY `SQID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
