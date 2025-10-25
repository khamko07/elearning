-- Fix tất cả câu hỏi NULL CategoryID
-- Phân loại dựa trên LessonID và nội dung câu hỏi

-- Business/Marketing questions (LessonID = 11)
UPDATE tblexercise SET CategoryID = 4, TopicID = 11 
WHERE LessonID = 11 AND (CategoryID IS NULL OR CategoryID = 0);

-- Mathematics/Algebra questions (LessonID = 8)  
UPDATE tblexercise SET CategoryID = 3, TopicID = 8
WHERE LessonID = 8 AND (CategoryID IS NULL OR CategoryID = 0);

-- Language/English questions (LessonID = 13)
UPDATE tblexercise SET CategoryID = 5, TopicID = 13
WHERE LessonID = 13 AND (CategoryID IS NULL OR CategoryID = 0);

-- Kiểm tra kết quả
SELECT 
    c.CategoryName,
    COUNT(e.ExerciseID) as QuestionCount
FROM tblcategories c 
LEFT JOIN tblexercise e ON c.CategoryID = e.CategoryID
WHERE c.IsActive = 1 
GROUP BY c.CategoryID, c.CategoryName
ORDER BY c.CategoryName;