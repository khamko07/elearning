# E-Learning System Using PHP/MySQLi

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 📖 Tổng quan

Hệ thống E-Learning là một nền tảng học trực tuyến toàn diện được thiết kế để hỗ trợ giáo viên tạo, quản lý và phân phối nội dung giáo dục một cách dễ dàng. Hệ thống cung cấp trải nghiệm liền mạch cho cả giáo viên và học sinh, bao gồm quản lý bài học, tạo bài tập trắc nghiệm và công cụ đánh giá học sinh.

### 🎯 Mục đích

Hệ thống này nhằm:
- Đơn giản hóa quy trình tạo và quản lý bài học trực tuyến
- Cho phép giáo viên tải lên nội dung đa phương tiện (video, PDF)
- Cung cấp bài tập trắc nghiệm và đánh giá tương tác
- Theo dõi tiến độ và hiệu suất học tập của học sinh
- Tạo nền tảng tập trung cho việc phân phối nội dung giáo dục

## ✨ Tính năng

### 👨‍💼 Tính năng dành cho Quản trị viên/Giáo viên

#### 📚 Quản lý Bài học
- **Danh sách Bài học**: Xem tất cả bài học có sẵn một cách có tổ chức
- **Tải lên Bài học**: Thêm nội dung giáo dục mới (video, file PDF)
- **Chỉnh sửa Bài học**: Sửa đổi nội dung và chi tiết bài học hiện có
- **Thay đổi File**: Thay thế file bài học bằng phiên bản cập nhật
- **Xem Bài học**: Xem trước bài học trước khi xuất bản
- **Xóa Bài học**: Xóa nội dung lỗi thời hoặc không cần thiết

#### 📝 Quản lý Bài tập & Câu hỏi
- **Danh sách Câu hỏi**: Xem tất cả câu hỏi trắc nghiệm và bài tập
- **Thêm Câu hỏi**: Tạo câu hỏi trắc nghiệm mới với các lựa chọn
- **Chỉnh sửa Câu hỏi**: Sửa đổi câu hỏi và đáp án hiện có
- **Xóa Câu hỏi**: Xóa câu hỏi lỗi thời hoặc không chính xác
- **Quản lý Danh mục**: Tổ chức câu hỏi theo danh mục (Technology, Science, Mathematics, Business, Language, Coding)
- **Quản lý Chủ đề**: Phân loại câu hỏi theo chủ đề cụ thể

#### 👥 Quản lý Học sinh
- **Danh sách Học sinh**: Xem tất cả học sinh đã đăng ký
- **Theo dõi Tiến độ**: Giám sát hiệu suất học tập của từng học sinh
- **Xem Kết quả**: Xem điểm số và kết quả bài tập của học sinh

#### 🔧 Quản lý Người dùng
- **Danh sách Người dùng**: Xem tất cả người dùng hệ thống (giáo viên, quản trị viên)
- **Thêm Người dùng**: Tạo tài khoản người dùng mới
- **Chỉnh sửa Người dùng**: Sửa đổi thông tin và quyền hạn người dùng
- **Xóa Người dùng**: Xóa người dùng không hoạt động hoặc không được ủy quyền

### 👨‍🎓 Tính năng dành cho Học sinh

#### 🔐 Quản lý Tài khoản
- **Tạo Tài khoản**: Đăng ký tài khoản học sinh mới
- **Đăng nhập/Đăng xuất**: Hệ thống xác thực an toàn
- **Quản lý Hồ sơ**: Cập nhật thông tin cá nhân

#### 📖 Tính năng Học tập
- **Xem Bài học**: Truy cập nội dung giáo dục đã tải lên
- **Xem Nội dung**: Đọc nội dung bài học chi tiết với định dạng Markdown
- **Làm Bài tập**: Tham gia đánh giá trắc nghiệm tương tác
- **Xem Kết quả**: Hệ thống chấm điểm và phản hồi tự động
- **Tải xuống Bài học**: Lưu nội dung để học offline
- **Xem Video**: Phát video bài giảng trực tiếp trên hệ thống
- **Xem PDF**: Đọc tài liệu PDF ngay trên trình duyệt

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

### Dành cho Giáo viên/Quản trị viên:
1. Đăng nhập vào bảng điều khiển quản trị tại `http://localhost/elearning/admin/`
2. Điều hướng đến **"Lessons"** để tải lên nội dung giáo dục (video, PDF)
3. Sử dụng **"Exercises"** để tạo câu hỏi trắc nghiệm và đánh giá
4. Quản lý **"Categories"** để tổ chức câu hỏi theo danh mục
5. Quản lý **"Topics"** để phân loại câu hỏi theo chủ đề
6. Theo dõi tiến độ học sinh qua **"Students"**
7. Quản lý người dùng hệ thống qua **"Users"**

### Dành cho Học sinh:
1. Đăng ký tài khoản mới tại `http://localhost/elearning/register.php`
2. Đăng nhập với thông tin đăng nhập của bạn
3. Duyệt các bài học có sẵn trong **"Lesson"**
4. Xem nội dung chi tiết bài học với định dạng Markdown
5. Chọn **"Categories"** để xem danh mục bài tập
6. Chọn **"Topics"** để xem chủ đề cụ thể
7. Làm bài tập trắc nghiệm để kiểm tra kiến thức
8. Xem kết quả và điểm số ngay lập tức
9. Tải xuống tài liệu để học offline
10. Xem video bài giảng trực tiếp trên hệ thống

## 🤖 Tích hợp Gemini API để tạo câu hỏi tự động

Hệ thống có thể tích hợp với Gemini API của Google để sinh tự động các câu hỏi trắc nghiệm dựa trên nội dung bài học hoặc chủ đề bạn cung cấp.

### Yêu cầu
- Tài khoản Google và quyền truy cập [Google AI Studio](https://ai.google.dev/)
- API Key của Gemini (có gói miễn phí)

### Cấu hình nhanh
1. Tạo API Key trong Google AI Studio.
2. Lưu trữ khóa an toàn. Có 2 cách khuyến nghị:
   - Khai báo trong `include/config.php`:
     ```php
     <?php
     // ... các cấu hình sẵn có ...
     define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY_HERE');
     ?>
     ```
   - Hoặc đặt biến môi trường `GEMINI_API_KEY` trên máy chủ và đọc trong PHP (khuyến nghị cho môi trường production).

### Cách hoạt động
Ứng dụng sẽ gọi endpoint `generateContent` của Gemini để tạo danh sách câu hỏi theo prompt bạn đưa vào. Bạn có thể chỉ định số lượng câu hỏi, độ khó, định dạng JSON, và yêu cầu đáp án kèm giải thích.

### Ví dụ PHP (gợi ý tích hợp vào tính năng tạo bài tập)
Ví dụ tối giản dưới đây minh họa cách gọi Gemini để sinh 5 câu hỏi trắc nghiệm theo định dạng JSON dễ lưu vào CSDL.

```php
$apiKey = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : getenv('GEMINI_API_KEY');
$model  = 'gemini-1.5-flash';
$url    = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($apiKey);

$lessonText = "Giải thích chu trình nước và các giai đoạn của nó."; // Thay bằng nội dung bài học
$prompt = "" .
  "Bạn là giáo viên chuyên gia. Hãy tạo 5 câu hỏi trắc nghiệm (MCQ) dựa trên đoạn văn dưới đây.\n" .
  "Mỗi câu gồm: question, options (A-D), correctOption, explanation.\n" .
  "Trả về MỘT mảng JSON thuần gồm các đối tượng: {question, options: {A,B,C,D}, correctOption, explanation}.\n\n" .
  "VĂN BẢN:\n{$lessonText}";

$payload = [
    'contents' => [[
        'parts' => [[ 'text' => $prompt ]]
    ]],
    'generationConfig' => [
        'temperature' => 0.4,
        'maxOutputTokens' => 1024
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$response = curl_exec($ch);
if ($response === false) {
    die('Curl error: ' . curl_error($ch));
}
curl_close($ch);

$data = json_decode($response, true);
$text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

// Cố gắng parse JSON từ phản hồi của model
$questions = json_decode($text, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    if (preg_match('/\[[\s\S]*\]/', $text, $m)) {
        $questions = json_decode($m[0], true);
    }
}

if (!is_array($questions)) {
    die('Không parse được JSON câu hỏi. Nội dung model: ' . htmlspecialchars($text));
}

// $questions là mảng các MCQ có thể lưu vào CSDL của bạn
foreach ($questions as $q) {
    // Lưu $q['question'], $q['options']['A'..'D'], $q['correctOption'], $q['explanation']
}
```

### Mẹo prompt
- **Rõ ràng định dạng**: yêu cầu JSON nghiêm ngặt để dễ parse.
- **Giới hạn độ khó**: chỉ định cấp lớp hoặc mức Bloom.
- **Kiểm soát độ dài**: giới hạn token, độ dài giải thích.
- **Cung cấp ngữ cảnh**: đưa đoạn bài học hoặc mục tiêu.

### Lưu ý
- Bảo mật API key; không commit vào mã nguồn.
- Kiểm tra điều khoản và chi phí của Google AI trước khi dùng production.
- Thêm retry và xử lý lỗi mạng khi triển khai thực tế.

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

- **tblautonumbers**: Quản lý số tự động tăng
- **tblcategories**: Danh mục câu hỏi (Technology, Science, Mathematics, Business, Language, Coding)
- **tblcontent**: Nội dung bài học chi tiết
- **tblexercise**: Bài tập và câu hỏi trắc nghiệm
- **tbllesson**: Thông tin bài học (video, PDF)
- **tblstudent**: Thông tin học sinh
- **tbltopic**: Chủ đề bài tập
- **tbluser**: Người dùng hệ thống (admin, giáo viên)
- **tblscore**: Điểm số và kết quả bài tập

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

- **v1.0.0** - Phát hành ban đầu với các tính năng cốt lõi
  - Quản lý bài học (video, PDF)
  - Hệ thống câu hỏi trắc nghiệm
  - Quản lý người dùng và học sinh
  - Hệ thống danh mục và chủ đề
  - Chấm điểm tự động

## 🚀 Tính năng Tương lai

- [ ] Tích hợp Gemini API để tạo câu hỏi tự động
- [ ] Hệ thống thông báo real-time
- [ ] Diễn đàn thảo luận
- [ ] Hệ thống badge và thành tích
- [ ] Xuất báo cáo PDF
- [ ] Ứng dụng mobile
- [ ] Hỗ trợ đa ngôn ngữ

---

**Lưu ý**: Hệ thống này được thiết kế cho mục đích giáo dục và có thể cần các biện pháp bảo mật bổ sung khi triển khai production.