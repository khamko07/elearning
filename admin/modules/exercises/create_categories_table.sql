-- Tạo bảng Categories để quản lý phân loại câu hỏi
CREATE TABLE `tblcategories` (
    `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
    `CategoryName` varchar(100) NOT NULL,
    `CategoryDescription` text,
    `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
    `IsActive` tinyint(1) DEFAULT 1,
    PRIMARY KEY (`CategoryID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Thêm dữ liệu mẫu
INSERT INTO
    `tblcategories` (
        `CategoryName`,
        `CategoryDescription`
    )
VALUES (
        'Technology',
        'Câu hỏi về công nghệ thông tin, lập trình, AI'
    ),
    (
        'Science',
        'Câu hỏi về khoa học tự nhiên, vật lý, hóa học'
    ),
    (
        'Mathematics',
        'Câu hỏi về toán học các cấp độ'
    ),
    (
        'Business',
        'Câu hỏi về kinh doanh, quản lý, marketing'
    ),
    (
        'Language',
        'Câu hỏi về ngôn ngữ, văn học, ngoại ngữ'
    );

-- Tạo bảng Topics để quản lý chủ đề con
CREATE TABLE `tbltopics` (
    `TopicID` int(11) NOT NULL AUTO_INCREMENT,
    `CategoryID` int(11) NOT NULL,
    `TopicName` varchar(100) NOT NULL,
    `TopicDescription` text,
    `CreatedAt` datetime DEFAULT CURRENT_TIMESTAMP,
    `IsActive` tinyint(1) DEFAULT 1,
    PRIMARY KEY (`TopicID`),
    FOREIGN KEY (`CategoryID`) REFERENCES `tblcategories` (`CategoryID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Thêm dữ liệu mẫu cho Topics
INSERT INTO
    `tbltopics` (
        `CategoryID`,
        `TopicName`,
        `TopicDescription`
    )
VALUES
    -- Technology topics
    (
        1,
        'Artificial Intelligence',
        'Câu hỏi về AI, Machine Learning, Deep Learning'
    ),
    (
        1,
        'Web Development',
        'Câu hỏi về HTML, CSS, JavaScript, PHP'
    ),
    (
        1,
        'Database',
        'Câu hỏi về SQL, MySQL, MongoDB'
    ),
    (
        1,
        'Programming Languages',
        'Câu hỏi về Java, Python, C++, etc.'
    ),
    -- Science topics  
    (
        2,
        'Physics',
        'Câu hỏi về vật lý'
    ),
    (
        2,
        'Chemistry',
        'Câu hỏi về hóa học'
    ),
    (
        2,
        'Biology',
        'Câu hỏi về sinh học'
    ),
    -- Mathematics topics
    (
        3,
        'Algebra',
        'Câu hỏi về đại số'
    ),
    (
        3,
        'Geometry',
        'Câu hỏi về hình học'
    ),
    (
        3,
        'Calculus',
        'Câu hỏi về giải tích'
    ),
    -- Business topics
    (
        4,
        'Marketing',
        'Câu hỏi về marketing'
    ),
    (
        4,
        'Management',
        'Câu hỏi về quản lý'
    ),
    -- Language topics
    (
        5,
        'English',
        'Câu hỏi tiếng Anh'
    ),
    (
        5,
        'Vietnamese Literature',
        'Câu hỏi văn học Việt Nam'
    );

-- Thêm cột CategoryID và TopicID vào bảng tblexercise
ALTER TABLE `tblexercise`
ADD COLUMN `CategoryID` int(11) DEFAULT NULL AFTER `LessonID`,
ADD COLUMN `TopicID` int(11) DEFAULT NULL AFTER `CategoryID`,
ADD FOREIGN KEY (`CategoryID`) REFERENCES `tblcategories` (`CategoryID`) ON DELETE SET NULL,
ADD FOREIGN KEY (`TopicID`) REFERENCES `tbltopics` (`TopicID`) ON DELETE SET NULL;

-- Cập nhật dữ liệu hiện có (gán vào Technology -> AI)
UPDATE `tblexercise`
SET
    `CategoryID` = 1,
    `TopicID` = 1
WHERE
    `CategoryID` IS NULL;