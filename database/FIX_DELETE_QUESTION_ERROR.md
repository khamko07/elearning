# Fix: Table 'tblstudentquestion' doesn't exist Error

## Vấn đề
Khi xóa câu hỏi (question) trong admin panel, hệ thống báo lỗi:
```
Fatal error: Table 'fim_db.tblstudentquestion' doesn't exist
```

## Nguyên nhân
Table `tblstudentquestion` chưa được tạo trong database nhưng code đang cố gắng sử dụng nó.

## Giải pháp

### Option 1: Tạo table tblstudentquestion (Khuyến nghị)

Table này dùng để lưu trữ câu hỏi được phân bổ cho từng học sinh riêng biệt.

**Cách làm:**

1. Mở phpMyAdmin: http://localhost/phpmyadmin
2. Chọn database `fim_db`
3. Click tab "SQL"
4. Copy và paste nội dung từ file: `database/create_tblstudentquestion.sql`
5. Click "Go" để thực thi

Hoặc chạy lệnh SQL trực tiếp:

```sql
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
```

### Option 2: Code đã được fix tự động

File `admin/modules/exercises/controller.php` đã được cập nhật để:
- Xóa an toàn với `@$mydb->executeQuery()` - không báo lỗi nếu table chưa tồn tại
- Xóa theo thứ tự đúng:
  1. Xóa `tblstudentquestion` (nếu có)
  2. Xóa `tblscore` (điểm số của học sinh)
  3. Xóa `tblexercise` (câu hỏi chính)

## Kiểm tra sau khi fix

1. Vào trang: http://localhost/elearning/admin/modules/exercises/index.php?view=topics&category=1
2. Thử xóa một câu hỏi bất kỳ
3. Kiểm tra xem có còn lỗi không

## Lưu ý

- Nếu bạn dùng tính năng "Bulk Insert Questions" hoặc phân phối câu hỏi cho từng học sinh riêng, **BẮT BUỘC** phải tạo table `tblstudentquestion`
- Nếu chỉ dùng chức năng questions cơ bản, có thể bỏ qua việc tạo table này
- Data trong `tblstudentquestion` và `tblscore` sẽ bị xóa khi xóa câu hỏi (cascade delete)

## Files đã được sửa

✅ `admin/modules/exercises/controller.php` - Function `doDelete()`
✅ `database/create_tblstudentquestion.sql` - SQL migration file

## Support

Nếu vẫn gặp lỗi, kiểm tra:
1. Database name trong `include/config.php` có đúng là `fim_db` không
2. User database có quyền CREATE TABLE không
3. Xem log lỗi trong `C:\xampp\apache\logs\error.log`
