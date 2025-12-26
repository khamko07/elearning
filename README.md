# HỆ THỐNG E-LEARNING

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 📖 Tổng quan hhh 

Hệ thống E-Learning là một nền tảng học trực tuyến đơn giản và dễ sử dụng, được xây dựng bằng PHP và MySQL. Hệ thống cung cấp các chức năng cơ bản để quản lý và phân phối nội dung học tập, bao gồm video bài giảng, tài liệu PDF, nội dung bài học dạng văn bản, và bài tập trắc nghiệm.

### 🎯 Mục đích

Hệ thống này được phát triển nhằm:
- **Quản lý nội dung học tập**: Cho phép giáo viên tải lên và quản lý video, PDF và nội dung bài học
- **Tạo bài tập trắc nghiệm**: Hệ thống tạo và quản lý câu hỏi trắc nghiệm với 4 lựa chọn (A, B, C, D)
- **Phân loại nội dung**: Tổ chức bài tập theo danh mục (Categories) và chủ đề (Topics)
- **Chấm điểm tự động**: Hệ thống chấm điểm bài tập trắc nghiệm tự động
- **Quản lý học viên**: Theo dõi thông tin và kết quả học tập của học viên
- **Giao diện thân thiện**: Dễ sử dụng cho cả giáo viên và học viên

## ✨ Tính năng

### 👨‍💼 Tính năng dành cho Quản trị viên/Giáo viên

#### 📚 Quản lý Bài học (Lessons)
- **Danh sách Bài học**: Xem tất cả bài học (Video và PDF)
- **Thêm Bài học mới**: Tải lên video bài giảng hoặc tài liệu PDF
- **Chỉnh sửa Bài học**: Sửa đổi thông tin bài học (Chapter, Title)
- **Thay đổi File**: Cập nhật file video hoặc PDF của bài học
- **Xem Bài học**: Xem trước video hoặc PDF trước khi xuất bản
- **Xóa Bài học**: Xóa bài học không cần thiết

#### 📝 Quản lý Nội dung (Content)
- **Danh sách Nội dung**: Xem tất cả nội dung bài học dạng văn bản
- **Thêm Nội dung**: Tạo nội dung bài học mới với Title, Topic và Body
- **Chỉnh sửa Nội dung**: Sửa đổi nội dung bài học
- **Xóa Nội dung**: Xóa nội dung không cần thiết

#### 📝 Quản lý Bài tập & Câu hỏi (Exercises)
- **Danh sách Câu hỏi**: Xem tất cả câu hỏi trắc nghiệm
- **Thêm Câu hỏi**: Tạo câu hỏi trắc nghiệm với 4 lựa chọn (A, B, C, D)
- **Chỉnh sửa Câu hỏi**: Sửa đổi câu hỏi và đáp án
- **Xóa Câu hỏi**: Xóa câu hỏi đơn lẻ hoặc xóa hàng loạt (Bulk Delete)
- **Quản lý Categories**: Tạo và quản lý danh mục bài tập
- **Quản lý Topics**: Tạo và quản lý chủ đề bài tập

#### 👥 Quản lý Học viên (Students)
- **Danh sách Học viên**: Xem tất cả học viên đã đăng ký
- **Xem Thông tin**: Xem thông tin chi tiết của học viên
- **Quản lý Tài khoản**: Thêm, sửa, xóa tài khoản học viên

#### 🔧 Quản lý Người dùng (Users)
- **Danh sách Người dùng**: Xem tất cả người dùng quản trị
- **Thêm Người dùng**: Tạo tài khoản quản trị viên mới
- **Chỉnh sửa Người dùng**: Sửa đổi thông tin người dùng
- **Xóa Người dùng**: Xóa tài khoản người dùng

### 👨‍🎓 Tính năng dành cho Học viên

#### 🔐 Quản lý Tài khoản
- **Đăng ký**: Tạo tài khoản học viên mới
- **Đăng nhập/Đăng xuất**: Hệ thống xác thực người dùng

#### 📖 Tính năng Học tập
- **Xem Nội dung Bài học**: Đọc nội dung bài học dạng văn bản
- **Xem Video**: Phát video bài giảng
- **Xem PDF**: Đọc tài liệu PDF
- **Chọn Categories**: Chọn danh mục bài tập để làm
- **Chọn Topics**: Chọn chủ đề bài tập cụ thể
- **Làm Bài tập Trắc nghiệm**: Trả lời câu hỏi trắc nghiệm
- **Xem Kết quả**: Xem điểm số và đáp án đúng sau khi hoàn thành

## 🛠️ Công nghệ sử dụng

- **Backend**: PHP 7.4+ với MySQLi
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 3/4
- **Thư viện bổ sung**:
  - jQuery - Thư viện JavaScript
  - Bootstrap DatePicker - Chọn ngày tháng
  - DataTables - Bảng dữ liệu tương tác
  - Font Awesome - Icon fonts
  - jQuery UI - Giao diện người dùng
  - Bootstrap WYSIHTML5 - Trình soạn thảo văn bản
  - iCheck - Checkbox và radio button đẹp
  - SlimScroll - Thanh cuộn tùy chỉnh

## 📋 Yêu cầu Hệ thống

- **Web Server**: Apache 2.4+ (khuyến nghị sử dụng XAMPP)
- **PHP**: Phiên bản 7.4 trở lên
- **Database**: MySQL 5.7+ hoặc MariaDB 10.2+
- **Trình duyệt**: Trình duyệt web hiện đại (Chrome, Firefox, Safari, Edge)
- **Dung lượng**: Tối thiểu 500MB cho hệ thống và dữ liệu

## 🚀 Hướng dẫn Cài đặt

### Bước 1: Tải phần mềm cần thiết
1. Tải và cài đặt [XAMPP](https://www.apachefriends.org/download.html) (khuyến nghị phiên bản 8.0+)
2. Tải mã nguồn hệ thống E-Learning

### Bước 2: Thiết lập Web Server
1. Khởi động XAMPP Control Panel
2. Bật dịch vụ **Apache** và **MySQL**
3. Đảm bảo cả hai dịch vụ đang chạy (trạng thái màu xanh)

### Bước 3: Triển khai Mã nguồn
1. Điều hướng đến thư mục `C:\xampp\htdocs\`
2. Giải nén file zip đã tải xuống
3. Đổi tên thư mục thành `elearning` (nếu chưa được đặt tên)

### Bước 4: Thiết lập Cơ sở dữ liệu
1. Mở trình duyệt web
2. Truy cập `http://localhost/phpmyadmin/`
3. Nhấp **"New"** để tạo cơ sở dữ liệu mới
4. Đặt tên cơ sở dữ liệu: `dbcaiwl`
5. Nhấp **"Create"**

### Bước 5: Import Cơ sở dữ liệu
1. Chọn cơ sở dữ liệu `dbcaiwl`
2. Nhấp tab **"Import"**
3. Nhấp **"Choose File"**
4. Chọn file `database/dbcaiwl.sql` từ thư mục dự án
5. Nhấp **"Go"** để import cấu trúc và dữ liệu

### Bước 6: Cấu hình
1. Mở file `include/config.php`
2. Xác minh cài đặt kết nối cơ sở dữ liệu:
   ```php
   defined('server') ? null : define("server", "localhost");
   defined('user') ? null : define("user", "root");
   defined('pass') ? null : define("pass", "");
   defined('database_name') ? null : define("database_name", "dbcaiwl");
   ```

### Bước 7: Truy cập Hệ thống
1. Mở trình duyệt web
2. Truy cập `http://localhost/elearning/`
3. Hệ thống đã sẵn sàng sử dụng

## 🔑 Thông tin Đăng nhập Mặc định

### Truy cập Quản trị viên
- **URL**: `http://localhost/elearning/admin/`
- **Tên đăng nhập**: admin
- **Mật khẩu**: admin

### Truy cập Học sinh
- Học sinh cần đăng ký qua trang đăng ký
- **URL Đăng ký**: `http://localhost/elearning/register.php`
- **URL Đăng nhập**: `http://localhost/elearning/login.php`

## 📁 Cấu trúc Dự án

```
elearning/
├── admin/                      # Thư mục quản trị
│   ├── modules/               # Các module quản trị (lessons, exercises, users, students)
│   ├── adminMenu/             # Các thành phần giao diện quản trị
│   ├── navigation/            # Điều hướng quản trị
│   ├── home.php              # Trang chủ quản trị
│   ├── login.php             # Đăng nhập quản trị
│   └── sidebar.php           # Thanh bên quản trị
├── assets/                    # Tài nguyên CSS, JS và các file khác
│   ├── bootstrap-wysihtml5/  # Trình soạn thảo WYSIHTML5
│   ├── css/                  # File CSS
│   ├── iCheck/               # Thư viện iCheck
│   ├── js/                   # File JavaScript
│   └── slimScroll/           # Thư viện SlimScroll
├── css/                       # Stylesheet bổ sung
├── database/                  # Thư mục cơ sở dữ liệu
│   └── dbcaiwl.sql           # File SQL cơ sở dữ liệu
├── dist/                      # File phân phối
├── fonts/                     # Font chữ
├── images/                    # Hình ảnh hệ thống
├── img/                       # Hình ảnh bổ sung
├── include/                   # File PHP include và cấu hình
│   └── config.php            # File cấu hình chính
├── js/                        # File JavaScript
├── jquery/                    # Thư viện jQuery
├── navigation/                # Các thành phần điều hướng
├── about.php                  # Trang giới thiệu
├── categories.php             # Trang danh mục bài tập
├── content.php                # Trang nội dung bài học
├── download.php               # Trang tải xuống
├── exercises.php              # Trang bài tập
├── home.php                   # Trang chủ (đã đăng nhập)
├── home_public.php            # Trang chủ công khai
├── index.php                  # File chính
├── lesson.php                 # Trang danh sách bài học
├── login.php                  # Đăng nhập học sinh
├── logout.php                 # Đăng xuất
├── playvideo.php              # Phát video
├── question.php               # Trang câu hỏi
├── quizresult.php             # Trang kết quả bài tập
├── register.php               # Đăng ký học sinh
├── topics.php                 # Trang chủ đề
├── validation.php             # Xác thực
├── viewpdf.php                # Xem PDF
└── README.md                  # File tài liệu này
```

## 🔧 Cấu hình

### Cấu hình Cơ sở dữ liệu
Chỉnh sửa `include/config.php` để phù hợp với cài đặt cơ sở dữ liệu của bạn:

```php
<?php
defined('server') ? null : define("server", "localhost");
defined('user') ? null : define("user", "root");
defined('pass') ? null : define("pass", "");
defined('database_name') ? null : define("database_name", "dbcaiwl");
?>
```

### Cài đặt Upload File
Đảm bảo cài đặt PHP cho phép upload file (chỉnh sửa `php.ini`):
- `upload_max_filesize = 50M`
- `post_max_size = 50M`
- `max_execution_time = 300`
- `memory_limit = 256M`

### Cấu hình Web Root
Hệ thống tự động phát hiện web root. Nếu cần thay đổi, chỉnh sửa trong `include/config.php`:
```php
define('web_root', '/elearning/');
define('server_root', 'C:/xampp/htdocs/elearning/');
```

## 🎯 Hướng dẫn Sử dụng

### Dành cho Quản trị viên/Giáo viên:
1. **Đăng nhập**: Truy cập `http://localhost/elearning/admin/` với tài khoản admin
2. **Quản lý Lessons**:
   - Vào menu "Lessons" để xem danh sách bài học
   - Nhấn "New" để thêm bài học mới (Video hoặc PDF)
   - Nhập thông tin: Chapter, Title, chọn loại (Video/Docs)
   - Upload file video hoặc PDF
   - Có thể Edit, Change File, View hoặc Delete bài học
3. **Quản lý Content**:
   - Vào menu "Content" để xem nội dung bài học
   - Nhấn "New" để tạo nội dung mới
   - Nhập Title, Topic và Body (nội dung bài học)
   - Có thể Edit hoặc Delete nội dung
4. **Quản lý Exercises**:
   - Vào menu "Exercises" để xem câu hỏi
   - Nhấn "New" để thêm câu hỏi mới
   - Nhập câu hỏi, 4 lựa chọn (A, B, C, D) và đáp án đúng
   - Chọn Category và Topic cho câu hỏi
   - Có thể Edit hoặc Delete câu hỏi
   - Hỗ trợ xóa hàng loạt (chọn nhiều câu hỏi và xóa cùng lúc)
5. **Quản lý Categories & Topics**:
   - Tạo và quản lý danh mục bài tập
   - Tạo và quản lý chủ đề bài tập
6. **Quản lý Students**: Xem danh sách học viên và thông tin
7. **Quản lý Users**: Thêm/sửa/xóa tài khoản quản trị

### Dành cho Học viên:
1. **Đăng ký**: Tạo tài khoản tại `http://localhost/elearning/register.php`
2. **Đăng nhập**: Truy cập `http://localhost/elearning/login.php`
3. **Xem Learning Content**:
   - Nhấn "Learning Content" để xem nội dung bài học
   - Đọc nội dung bài học theo Title và Topic
4. **Xem Lessons**:
   - Xem danh sách video và PDF
   - Nhấn "Play Video" để xem video
   - Nhấn "View File" để xem PDF
5. **Làm Exercises**:
   - Nhấn "Exercises" để vào trang bài tập
   - Chọn Category (danh mục bài tập)
   - Chọn Topic (chủ đề cụ thể)
   - Làm bài tập trắc nghiệm
   - Xem kết quả và đáp án đúng



## 🐛 Khắc phục Sự cố

### Các vấn đề thường gặp:

**Lỗi Kết nối Cơ sở dữ liệu**
- Xác minh dịch vụ MySQL đang chạy trong XAMPP
- Kiểm tra thông tin đăng nhập cơ sở dữ liệu trong `include/config.php`
- Đảm bảo cơ sở dữ liệu `dbcaiwl` tồn tại
- Kiểm tra port MySQL (mặc định: 3306)

**Vấn đề Upload File**
- Kiểm tra cài đặt upload file trong `php.ini`
- Xác minh quyền truy cập thư mục upload
- Đảm bảo đủ dung lượng đĩa
- Kiểm tra kích thước file không vượt quá giới hạn

**Vấn đề Đăng nhập**
- Xóa cache và cookies trình duyệt
- Xác minh thông tin đăng nhập trong cơ sở dữ liệu
- Kiểm tra cấu hình session trong PHP
- Đảm bảo thư mục session có quyền ghi

**Lỗi 404 Not Found**
- Kiểm tra đường dẫn web root trong `config.php`
- Xác minh Apache đang chạy
- Kiểm tra file `.htaccess` (nếu có)

**Video/PDF không hiển thị**
- Kiểm tra đường dẫn file trong cơ sở dữ liệu
- Xác minh file tồn tại trong thư mục
- Kiểm tra quyền truy cập file

## 📊 Cấu trúc Cơ sở dữ liệu

Hệ thống sử dụng các bảng chính sau:

- **tblautonumbers**: Quản lý số tự động tăng cho các ID
- **tblcategories**: Danh mục bài tập (ví dụ: Technology, Science, Mathematics, Business, Language)
- **tblcontent**: Nội dung bài học dạng văn bản (Title, Topic, Body)
- **tblexercise**: Câu hỏi trắc nghiệm (Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, CategoryID, TopicID)
- **tbllesson**: Thông tin bài học (LessonChapter, LessonTitle, Category: Video/Docs, FileLocation)
- **tblstudent**: Thông tin học viên
- **tbltopics**: Chủ đề bài tập
- **tbluser**: Người dùng quản trị hệ thống

## 🔒 Bảo mật

### Khuyến nghị Bảo mật:
- Thay đổi mật khẩu admin mặc định ngay sau khi cài đặt
- Sử dụng mật khẩu mạnh cho tất cả tài khoản
- Cập nhật PHP và MySQL thường xuyên
- Sao lưu cơ sở dữ liệu định kỳ
- Hạn chế quyền truy cập thư mục admin
- Sử dụng HTTPS trong môi trường production
- Xác thực và làm sạch tất cả input từ người dùng

## 🤝 Đóng góp

1. Fork repository
2. Tạo nhánh tính năng (`git checkout -b feature/tinh-nang-moi`)
3. Commit thay đổi (`git commit -am 'Thêm tính năng mới'`)
4. Push lên nhánh (`git push origin feature/tinh-nang-moi`)
5. Tạo Pull Request

## 📝 Giấy phép

Dự án này là mã nguồn mở và có sẵn theo [Giấy phép MIT](LICENSE).

## 📞 Hỗ trợ

Để được hỗ trợ và đặt câu hỏi:
- Tạo issue trong repository
- Kiểm tra tài liệu hướng dẫn
- Xem lại phần khắc phục sự cố

## 🔄 Lịch sử Phiên bản

- **v1.0.0** (Tháng 11/2025) - Phát hành ban đầu
  - ✅ Hệ thống quản lý bài học (Video và PDF)
  - ✅ Hệ thống quản lý nội dung bài học dạng văn bản
  - ✅ Hệ thống câu hỏi trắc nghiệm
  - ✅ Quản lý Categories và Topics
  - ✅ Quản lý người dùng và học viên
  - ✅ Chấm điểm tự động
  - ✅ Xóa hàng loạt câu hỏi (Bulk Delete)

## 🚀 Tính năng Có thể Phát triển

- [ ] Tích hợp AI để tạo câu hỏi tự động
- [ ] Hệ thống theo dõi tiến độ học tập chi tiết
- [ ] Báo cáo và thống kê kết quả học tập
- [ ] Hệ thống thông báo
- [ ] Forum thảo luận
- [ ] Gamification (badges, điểm thưởng)
- [ ] Ứng dụng mobile
- [ ] Hỗ trợ đa ngôn ngữ giao diện

---

**Lưu ý**: Hệ thống này được thiết kế cho mục đích giáo dục. Khuyến nghị tăng cường bảo mật và tối ưu hóa hiệu suất trước khi triển khai môi trường production.

**Năm**: 2025  
**Phiên bản**: 1.0.0