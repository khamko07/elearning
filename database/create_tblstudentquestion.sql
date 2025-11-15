-- Create tblstudentquestion table
-- This table stores individual student's question assignments
-- Used when questions are distributed to students

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

-- Add foreign key constraints (optional, for data integrity)
ALTER TABLE `tblstudentquestion`
  ADD CONSTRAINT `fk_studentquestion_exercise` FOREIGN KEY (`ExerciseID`) REFERENCES `tblexercise` (`ExerciseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_studentquestion_lesson` FOREIGN KEY (`LessonID`) REFERENCES `tbllesson` (`LessonID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_studentquestion_student` FOREIGN KEY (`StudentID`) REFERENCES `tblstudent` (`StudentID`) ON DELETE CASCADE;
