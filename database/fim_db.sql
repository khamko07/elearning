-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 05:14 AM
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

--
-- Dumping data for table `tblcontent`
--

INSERT INTO `tblcontent` (`ContentID`, `Title`, `Topic`, `CategoryID`, `TopicID`, `Body`, `CreatedAt`, `CreatedBy`) VALUES
(10, 'PHP Basics', 'PHP Basics', NULL, NULL, '# PHP Basics\r\n\r\n## ແນະນຳ\r\n\r\nPHP ຫຼື Hypertext Preprocessor ເປັນພາສາ scripting ທີ່ນິຍົມໃຊ້ກັນຢ່າງກວ້າງຂວາງ ເໝາະສຳລັບການພັດທະນາເວັບໄຊທ໌ແບບ dynamic ແລະ ແອັບພລິເຄຊັນເວັບຕ່າງໆ. ພາສາ PHP ເປັນພາສາຝັ່ງເຊີເວີ (server-side scripting language), ໝາຍຄວາມວ່າລະຫັດ PHP ຈະຖືກປະມວນຜົນຢູ່ເທິງເຊີເວີກ່ອນທີ່ຈະສົ່ງຜົນລັບ (HTML) ໃຫ້ກັບ browser ຂອງຜູ້ໃຊ້. ດ້ວຍຄວາມງ່າຍໃນການຮຽນຮູ້ ແລະ ຊຸມຊົນຜູ້ໃຊ້ທີ່ເຂັ້ມແຂງ, PHP ຈຶ່ງເປັນທາງເລືອກທີ່ດີສຳລັບນັກພັດທະນາເວັບທັງມືໃໝ່ ແລະ ມືອາຊີບ.\r\n\r\nເນື້ອໃນຂອງ \"PHP Basics\" ນີ້ຈະພາທ່ານໄປສຳຫຼວດພື້ນຖານທີ່ຈຳເປັນຂອງ PHP. ພວກເຮົາຈະປົກຄຸມແນວຄວາມຄິດຫຼັກໆ ເຊັ່ນ: ຕົວແປ, ປະເພດຂໍ້ມູນ, ໂຕປະຕິບັດການ (operators), ໂຄງສ້າງຄວບຄຸມ (control structures), ຟັງຊັນ, ແລະອື່ນໆ. ພ້ອມທັງຍົກຕົວຢ່າງທີ່ນຳໄປໃຊ້ໄດ້ຈິງເພື່ອໃຫ້ທ່ານສາມາດເຂົ້າໃຈ ແລະ ນຳໃຊ້ PHP ໃນໂຄງການຂອງທ່ານໄດ້ຢ່າງມີປະສິດທິພາບ. ການເຂົ້າໃຈພື້ນຖານທີ່ດີຈະຊ່ວຍໃຫ້ທ່ານສາມາດສ້າງເວັບໄຊທ໌ທີ່ເຂັ້ມແຂງ ແລະ ມີຄວາມສາມາດຫຼາຍຂຶ້ນ.\r\n\r\n## ແນວຄວາມຄິດຫຼັກ\r\n\r\n*   **ຕົວແປ (Variables):** ຕົວແປແມ່ນພື້ນທີ່ເກັບຂໍ້ມູນໃນໜ່ວຍຄວາມຈຳ. ໃນ PHP, ຕົວແປຈະຂຶ້ນຕົ້ນດ້ວຍເຄື່ອງໝາຍ `$` (ໂດລາ) ເຊັ່ນ: `$ຊື່`, `$ອາຍຸ`.\r\n*   **ປະເພດຂໍ້ມູນ (Data Types):** PHP ຮອງຮັບປະເພດຂໍ້ມູນຫຼາຍຢ່າງ, ລວມທັງ:\r\n    *   *Integer:* ຕົວເລກຈຳນວນເຕັມ ເຊັ່ນ: `10`, `-5`, `0`.\r\n    *   *Float:* ຕົວເລກທົດສະນິຍົມ ເຊັ່ນ: `3.14`, `-2.5`, `0.0`.\r\n    *   *String:* ຂໍ້ຄວາມທີ່ຢູ່ໃນເຄື່ອງໝາຍວົງຢືມ ເຊັ່ນ: `\"Hello\"`, `\'World\'`.\r\n    *   *Boolean:* ຄ່າຄວາມຈິງ ທີ່ມີພຽງ `true` (ຈິງ) ຫຼື `false` (ບໍ່ຈິງ).\r\n    *   *Array:* ກຸ່ມຂອງຂໍ້ມູນທີ່ສາມາດເກັບຂໍ້ມູນຫຼາຍໆຢ່າງໄວ້ພາຍໃນຕົວແປດຽວ.\r\n    *   *Object:* ໂຄງສ້າງຂໍ້ມູນທີ່ສັບສົນກວ່າ, ມັກໃຊ້ໃນການຂຽນໂປຣແກຣມແບບ Object-Oriented.\r\n*   **ໂຕປະຕິບັດການ (Operators):** ສັນຍາລັກທີ່ໃຊ້ໃນການປະມວນຜົນຂໍ້ມູນ ເຊັ່ນ:\r\n    *   *Arithmetic Operators:* `+` (ບວກ), `-` (ລົບ), `*` (ຄູນ), `/` (ຫານ), `%` (ຫານເອົາເສດ).\r\n    *   *Assignment Operators:* `=` (ກຳນົດຄ່າ), `+=`, `-=`, `*=`, `/=`.\r\n    *   *Comparison Operators:* `==` (ເທົ່າກັນ), `!=` (ບໍ່ເທົ່າກັນ), `>` (ຫຼາຍກວ່າ), `<` (ໜ້ອຍກວ່າ), `>=` (ຫຼາຍກວ່າ ຫຼື ເທົ່າກັນ), `<=` (ໜ້ອຍກວ່າ ຫຼື ເທົ່າກັນ).\r\n    *   *Logical Operators:* `&&` (AND), `||` (OR), `!` (NOT).\r\n*   **ໂຄງສ້າງຄວບຄຸມ (Control Structures):** ກຳນົດການໄຫຼຂອງການປະມວນຜົນໃນໂປຣແກຣມ.\r\n    *   *`if`, `else`, `elseif`:* ສຳລັບການເລືອກປະຕິບັດຕາມເງື່ອນໄຂ.\r\n    *   *`for` loop:* ສຳລັບການປະຕິບັດຊ້ຳໆຕາມຈຳນວນເທື່ອທີ່ກຳນົດ.\r\n    *   *`while` loop:* ສຳລັບການປະຕິບັດຊ້ຳໆຈົນກວ່າເງື່ອນໄຂຈະເປັນ false.\r\n    *   *`foreach` loop:* ສຳລັບການ loop ຜ່ານ array.\r\n    *   *`switch` statement:* ສຳລັບການເລືອກປະຕິບັດຕາມຄ່າຂອງຕົວແປ.\r\n*   **ຟັງຊັນ (Functions):** ກຸ່ມຂອງລະຫັດທີ່ສາມາດນຳມາກັບມາໃຊ້ໃໝ່ໄດ້.\r\n\r\n## ເນື້ອຫາຫຼັກ\r\n\r\n### Section 1: ຕົວແປ ແລະ ປະເພດຂໍ້ມູນ\r\n\r\nໃນ PHP, ຕົວແປຈະຂຶ້ນຕົ້ນດ້ວຍເຄື່ອງໝາຍ `$` (ໂດລາ). ທ່ານບໍ່ຈຳເປັນຕ້ອງປະກາດປະເພດຂໍ້ມູນຂອງຕົວແປກ່ອນທີ່ຈະນຳໃຊ້. PHP ຈະກຳນົດປະເພດຂໍ້ມູນໂດຍອັດຕະໂນມັດຕາມຄ່າທີ່ກຳນົດໃຫ້.\r\n\r\n```php\r\n<?php\r\n$ຊື່ = \"ສົມຊາຍ\"; // ຕົວແປປະເພດ string\r\n$ອາຍຸ = 30;       // ຕົວແປປະເພດ integer\r\n$ສ່ວນສູງ = 175.5;   // ຕົວແປປະເພດ float\r\n$ເປັນນັກຮຽນ = true; // ຕົວແປປະເພດ boolean\r\n\r\necho \"ຊື່: \" . $ຊື່ . \"<br>\";\r\necho \"ອາຍຸ: \" . $ອາຍຸ . \"<br>\";\r\necho \"ສ່ວນສູງ: \" . $ສ່ວນສູງ . \"<br>\";\r\necho \"ເປັນນັກຮຽນ: \" . ($ເປັນນັກຮຽນ ? \"ແມ່ນແລ້ວ\" : \"ບໍ່ແມ່ນ\") . \"<br>\";\r\n?>\r\n```\r\n\r\n### Section 2: ໂຄງສ້າງຄວບຄຸມ\r\n\r\nໂຄງສ້າງຄວບຄຸມຊ່ວຍໃຫ້ທ່ານສາມາດກຳນົດການໄຫຼຂອງໂປຣແກຣມໄດ້.\r\n\r\n**ຕົວຢ່າງ `if`, `else`, `elseif`:**\r\n\r\n```php\r\n<?php\r\n$ຄະແນນ = 75;\r\n\r\nif ($ຄະແນນ >= 80) {\r\n  echo \"ໄດ້ເກຣດ A\";\r\n} elseif ($ຄະແນນ >= 70) {\r\n  echo \"ໄດ້ເກຣດ B\";\r\n} elseif ($ຄະແນນ >= 60) {\r\n  echo \"ໄດ້ເກຣດ C\";\r\n} else {\r\n  echo \"ໄດ້ເກຣດ D\";\r\n}\r\n?>\r\n```\r\n\r\n**ຕົວຢ່າງ `for` loop:**\r\n\r\n```php\r\n<?php\r\nfor ($i = 1; $i <= 5; $i++) {\r\n  echo \"ຕົວເລກ: \" . $i . \"<br>\";\r\n}\r\n?>\r\n```\r\n\r\n**ຕົວຢ່າງ `while` loop:**\r\n\r\n```php\r\n<?php\r\n$i = 1;\r\nwhile ($i <= 5) {\r\n  echo \"ຕົວເລກ: \" . $i . \"<br>\";\r\n  $i++;\r\n}\r\n?>\r\n```\r\n\r\n### Section 3: ຟັງຊັນ\r\n\r\nຟັງຊັນແມ່ນກຸ່ມຂອງລະຫັດທີ່ສາມາດນຳມາກັບມາໃຊ້ໃໝ່ໄດ້. ທ່ານສາມາດສ້າງຟັງຊັນຂອງທ່ານເອງໄດ້.\r\n\r\n```php\r\n<?php\r\nfunction ທັກທາຍ($ຊື່) {\r\n  echo \"ສະບາຍດີ, \" . $ຊື່ . \"!\";\r\n}\r\n\r\nທັກທາຍ(\"ສົມສີ\"); // ຜົນລັບ: ສະບາຍດີ, ສົມສີ!\r\n?>\r\n```\r\n\r\n### Section 4: Array\r\n\r\nArray ແມ່ນໂຄງສ້າງຂໍ້ມູນທີ່ສາມາດເກັບຂໍ້ມູນຫຼາຍຢ່າງພາຍໃນຕົວແປດຽວ. PHP ຮອງຮັບທັງ indexed arrays ແລະ associative arrays.\r\n\r\n```php\r\n<?php\r\n// Indexed array\r\n$ສີ = array(\"ແດງ\", \"ຂຽວ\", \"ຟ້າ\");\r\necho \"ສີທີ່ມັກ: \" . $ສີ[0] . \"<br>\"; // ຜົນລັບ: ສີທີ່ມັກ: ແດງ\r\n\r\n// Associative array\r\n$ນັກຮຽນ = array(\"ຊື່\" => \"ສົມຊາຍ\", \"ອາຍຸ\" => 20, \"ເກຣດ\" => \"A\");\r\necho \"ຊື່ນັກຮຽນ: \" . $ນັກຮຽນ[\"ຊື່\"] . \"<br>\"; // ຜົນລັບ: ຊື່ນັກຮຽນ: ສົມຊາຍ\r\n?>\r\n```\r\n\r\n## ຕົວຢ່າງການປະຕິບັດ\r\n\r\n```php\r\n<?php\r\n// ການກວດສອບການເຂົ້າສູ່ລະບົບແບບງ່າຍໆ\r\n$ຊື່ຜູ້ໃຊ້ = \"admin\";\r\n$ລະຫັດຜ່ານ = \"password123\";\r\n\r\nif ($_POST[\"ຊື່ຜູ້ໃຊ້\"] == $ຊື່ຜູ້ໃຊ້ && $_POST[\"ລະຫັດຜ່ານ\"] == $ລະຫັດຜ່ານ) {\r\n  echo \"ເຂົ້າສູ່ລະບົບສຳເລັດ!\";\r\n} else {\r\n  echo \"ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ.\";\r\n}\r\n?>\r\n\r\n<form method=\"post\">\r\n  ຊື່ຜູ້ໃຊ້: <input type=\"text\" name=\"ຊື່ຜູ້ໃຊ້\"><br>\r\n  ລະຫັດຜ່ານ: <input type=\"password\" name=\"ລະຫັດຜ່ານ\"><br>\r\n  <input type=\"submit\" value=\"ເຂົ້າສູ່ລະບົບ\">\r\n</form>\r\n```\r\n\r\n## ການປະຕິບັດທີ່ດີທີ່ສຸດ\r\n\r\n- ໃຊ້ຊື່ຕົວແປທີ່ສື່ຄວາມໝາຍ ເພື່ອເຮັດໃຫ້ລະຫັດອ່ານງ່າຍຂຶ້ນ.\r\n- ໃຊ້ຄຳເຫັນ (comments) ເພື່ອອະທິບາຍລະຫັດຂອງທ່ານ.\r\n- ຈັດຮູບແບບລະຫັດຂອງທ່ານໃຫ້ເປັນລະບຽບຮຽບຮ້ອຍ ເພື່ອເພີ່ມຄວາມສາມາດໃນການອ່ານ.\r\n- ຫຼີກລ່ຽງການຂຽນລະຫັດທີ່ຊັບຊ້ອນເກີນໄປ.\r\n- ທົດສອບລະຫັດຂອງທ່ານຢ່າງລະອຽດ ເພື່ອຊອກຫາຂໍ້ຜິດພາດ.\r\n- ໃຊ້ຟັງຊັນທີ່ມີຢູ່ແລ້ວໃນ PHP ເພື່ອປະຢັດເວລາ ແລະ ຫຼຸດຜ່ອນຄວາມສັບສົນ.\r\n- ໃຊ້ prepared statements ເພື່ອປ້ອງກັນ SQL injection attacks.\r\n\r\n## ຄວາມຜິດພາດທົ່ວໄປທີ່ຄວນຫຼີກເວັ້ນ\r\n\r\n- **ລືມເຄື່ອງໝາຍ semicolon (;)**: PHP ຕ້ອງການເຄື່ອງໝາຍ semicolon ໃນຕອນທ້າຍຂອງແຕ່ລະຄຳສັ່ງ.\r\n- **ການປຽບທຽບແບບບໍ່ຖືກຕ້ອງ**: ໃຊ້ `==` ສຳລັບການປຽບທຽບຄ່າ ແລະ `===` ສຳລັບການປຽບທຽບທັງຄ່າ ແລະ ປະເພດຂໍ້ມູນ.\r\n- **ການບໍ່ໄດ້ຮັບປະກັນຂໍ້ມູນທີ່ປ້ອນເຂົ້າ**: ຮັບປະກັນວ່າຂໍ້ມູນທີ່ປ້ອນເຂົ້າຈາກຜູ້ໃຊ້ຖືກກວດສອບ ແລະ ປ້ອງກັນການໂຈມຕີ.\r\n- **ລືມເຄື່ອງໝາຍ `.` (dot) ສຳລັບການຕໍ່ string**: ໃຊ້ `.` ເພື່ອຕໍ່ strings ເຂົ້າກັນ.\r\n- **ການບໍ່ເຂົ້າໃຈຂອບເຂດຂອງຕົວແປ**: ຕົວແປທີ່ປະກາດພາຍໃນຟັງຊັນຈະບໍ່ສາມາດເຂົ້າເຖິງໄດ້ຈາກພາຍນອກຟັງຊັນ.\r\n\r\n## ສະຫຼຸບ\r\n\r\nໃນບົດຮຽນນີ້, ພວກເຮົາໄດ້ປົກຄຸມພື້ນຖານຂອງ PHP, ລວມທັງຕົວແປ, ປະເພດຂໍ້ມູນ, ໂຕປະຕິບັດການ, ໂຄງສ້າງຄວບຄຸມ, ແລະຟັງຊັນ. ພ້ອມທັງໄດ້ຍົກຕົວຢ່າງການນຳໃຊ້ທີ່ເປັນປະໂຫຍດ. ຄວາມເຂົ້າໃຈພື້ນຖານເຫຼົ່ານີ້ຈະຊ່ວຍໃຫ້ທ່ານສາມາດເລີ່ມຕົ້ນພັດທະນາເວັບໄຊທ໌ ແລະ ແອັບພລິເຄຊັນເວັບດ້ວຍ PHP ໄດ້.\r\n\r\nການຮຽນຮູ້ PHP ແມ່ນຂະບວນການຕໍ່ເນື່ອງ. ຢ່າຢ້ານທີ່ຈະທົດລອງ ແລະ ສ້າງໂຄງການຂອງທ່ານເອງ. ການປະຕິບັດຕົວຈິງຈະຊ່ວຍໃຫ້ທ່ານເຂົ້າໃຈ PHP ໄດ້ເລິກເຊິ່ງຂຶ້ນ. ຂໍໃຫ້ທ່ານມ່ວນຊື່ນກັບການຮຽນຮູ້ PHP!\r\n\r\n## ອ່ານຕື່ມ\r\n\r\n- **PHP Arrays:** ຮຽນຮູ້ເພີ່ມເຕີມກ່ຽວກັບ arrays ແລະ ການນຳໃຊ້ທີ່ຫຼາກຫຼາຍ.\r\n- **PHP Functions:** ເຈາະເລິກກ່ຽວກັບການສ້າງ ແລະ ນຳໃຊ້ຟັງຊັນ.\r\n- **PHP and Databases:** ຮຽນຮູ້ວິທີການເຊື່ອມຕໍ່ PHP ກັບຖານຂໍ້ມູນເຊັ່ນ MySQL.\r\n- **Object-Oriented Programming in PHP:** ສຳຫຼວດແນວຄວາມຄິດຂອງ OOP ໃນ PHP.', '2025-11-15 15:43:19', NULL);

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

--
-- Dumping data for table `tblexercise`
--

INSERT INTO `tblexercise` (`ExerciseID`, `LessonID`, `CategoryID`, `TopicID`, `Question`, `ChoiceA`, `ChoiceB`, `ChoiceC`, `ChoiceD`, `Answer`, `ExercisesDate`, `CreatedBy`) VALUES
(20250521, 0, 1, 2, 'What is the primary purpose of using a CSS preprocessor like Sass or LESS?', 'To execute JavaScript code on the server-side.', 'To enhance the functionality of HTML elements.', 'To extend CSS with features like variables, mixins, and nesting.', 'To manage database connections in a web application.', 'C', '0000-00-00', NULL),
(20251326, 0, 1, 2, 'Which HTTP method is typically used to update an existing resource on a server?', 'GET', 'POST', 'PUT', 'DELETE', 'C', '0000-00-00', NULL),
(20253980, 0, 1, 2, 'Which of the following is NOT a core component of the MEAN stack?', 'MongoDB', 'Express.js', 'Angular', 'PHP', 'D', '0000-00-00', NULL),
(20255617, 0, 1, 2, 'Which of the following is a common technique to improve website performance by reducing the number of HTTP requests?', 'Code minification and bundling', 'Increasing server CPU speed', 'Using more JavaScript libraries', 'Ignoring browser caching', 'A', '0000-00-00', NULL),
(20259360, 0, 1, 2, 'What is the purpose of using version control systems like Git in web development?', 'To automatically optimize website loading speed.', 'To track changes to code, collaborate with others, and revert to previous versions.', 'To encrypt sensitive data transmitted between the client and server.', 'To automatically deploy web applications to production servers.', 'B', '0000-00-00', NULL);

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

--
-- Dumping data for table `tblscore`
--

INSERT INTO `tblscore` (`ScoreID`, `LessonID`, `ExerciseID`, `StudentID`, `NoItems`, `Score`, `Submitted`, `Answer`) VALUES
(248, 0, 20250521, 7, 1, 0, 0, NULL),
(249, 0, 20251326, 7, 1, 0, 0, NULL),
(250, 0, 20253980, 7, 1, 0, 0, NULL),
(251, 0, 20255617, 7, 1, 1, 0, NULL),
(252, 0, 20259360, 7, 1, 1, 0, NULL),
(253, 2, 20250521, 7, 1, 0, 1, NULL),
(254, 2, 20251326, 7, 1, 0, 1, NULL),
(255, 2, 20253980, 7, 1, 0, 1, NULL),
(256, 2, 20255617, 7, 1, 1, 1, NULL),
(257, 2, 20259360, 7, 1, 1, 1, NULL),
(258, 2, 20250521, 7, 1, 0, 1, NULL),
(259, 2, 20251326, 7, 1, 0, 1, NULL),
(260, 2, 20253980, 7, 1, 0, 1, NULL),
(261, 2, 20255617, 7, 1, 1, 1, NULL),
(262, 2, 20259360, 7, 1, 1, 1, NULL);

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
(4, 1, 'Programming Languages', 'Câu hỏi về Java, Python, C++, etc.', '2025-10-25 04:37:26', 0),
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
  MODIFY `ContentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `ScoreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

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
