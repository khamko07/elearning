-- Quick Fix for Delete Question Error
-- Run this script in phpMyAdmin to create missing table
-- Database: fim_db

-- Check and create tblstudentquestion table
CREATE TABLE IF NOT EXISTS `tblstudentquestion` (
  `StudentQuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `ExerciseID` int(11) NOT NULL,
  `LessonID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Question` text NOT NULL,
  `CA` varchar(255) DEFAULT NULL,
  `CB` varchar(255) DEFAULT NULL,
  `CC` varchar(255) DEFAULT NULL,
  `CD` varchar(255) DEFAULT NULL,
  `QA` varchar(10) NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`StudentQuestionID`),
  KEY `ExerciseID` (`ExerciseID`),
  KEY `LessonID` (`LessonID`),
  KEY `StudentID` (`StudentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Success message
SELECT 'Table tblstudentquestion created successfully!' AS Status;
