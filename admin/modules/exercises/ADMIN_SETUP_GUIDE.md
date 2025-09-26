# 🚀 Hướng dẫn cài đặt Gemini API cho Admin

## 📝 Thông tin quan trọng

Tính năng **AI Question Generator** đã được tích hợp sẵn trong hệ thống với API key được **hardcode** trong code để đơn giản hóa việc sử dụng.

## 🔑 Cách lấy và cấu hình API Key

### Bước 1: Lấy Gemini API Key

1. Truy cập: **https://aistudio.google.com/app/apikey**
2. Đăng nhập với tài khoản Google
3. Click **"Create API Key"**
4. Copy API key được tạo (dạng: `AIzaSyBcZ9QgW4xHk2Rl5iJqV8mK1oP7fT3N6eU2`)

### Bước 2: Cấu hình API Key trong code

1. Mở file: `admin/modules/exercises/gemini_config.php`
2. Tìm dòng:
   ```php
   define('GEMINI_API_KEY', 'AIzaSyBcZ9QgW4xHk2Rl5iJqV8mK1oP7fT3N6eU2');
   ```
3. Thay thế API key mẫu bằng API key thật của bạn
4. Lưu file

### Bước 3: Bảo mật file config

1. Đảm bảo file `gemini_config.php` không thể truy cập từ web browser
2. Thêm vào file `.htaccess` trong thư mục `admin/modules/exercises/`:
   ```
   <Files "gemini_config.php">
       Order Deny,Allow
       Deny from all
   </Files>
   ```

## ✨ Tính năng đã được đơn giản hóa

### ✅ Những gì đã loại bỏ:
- ❌ Modal popup nhập API key
- ❌ LocalStorage lưu API key
- ❌ Nút "Setup API Key"
- ❌ Phức tạp trong giao diện

### ✅ Những gì người dùng thấy bây giờ:
- ✨ Giao diện đơn giản, dễ sử dụng
- 🎯 Chỉ cần nhập chủ đề và chọn độ khó
- 🚀 Click "Tạo Câu Hỏi" là xong
- 🇻🇳 Giao diện tiếng Việt thân thiện

## 🎯 Cách sử dụng cho giáo viên

1. **Vào trang tạo câu hỏi**:
   - Admin Panel → Exercises → Add New Question

2. **Sử dụng AI Generator**:
   - Nhập chủ đề: "JavaScript", "Toán học", "Vật lý"...
   - Chọn độ khó: Dễ/Trung bình/Khó
   - Click "Tạo Câu Hỏi"

3. **Kiểm tra và lưu**:
   - AI tự động điền toàn bộ form
   - Kiểm tra nội dung
   - Chọn lesson và click "Save"

## 🛠️ Troubleshooting

### Lỗi "API key chưa được cấu hình"
- Kiểm tra file `gemini_config.php`
- Đảm bảo API key đã được thay thế đúng
- Restart web server

### Lỗi "Không thể tạo câu hỏi"
- Kiểm tra kết nối internet
- Thử với chủ đề khác
- Check quota của Gemini API

### Lỗi "Thiếu thông tin chủ đề"
- Đảm bảo đã nhập chủ đề
- Chủ đề không được để trống

## 📊 Ví dụ hoạt động

**Input:**
```
Chủ đề: "Lập trình PHP"
Độ khó: "Trung bình"
```

**AI Output:**
```
Câu hỏi: Hàm nào sau đây được sử dụng để kết nối với database MySQL trong PHP?

A: mysql_connect()
B: mysqli_connect() 
C: db_connect()
D: connect_mysql()

Đáp án: B
```

## 🔒 Bảo mật

- ✅ API key được hardcode an toàn trong server
- ✅ Không expose qua client-side
- ✅ Chỉ admin có thể sử dụng
- ✅ Validation đầy đủ

## 📈 Lợi ích

1. **Đơn giản**: Không cần setup phức tạp
2. **Nhanh chóng**: Tạo câu hỏi trong vài giây  
3. **Chất lượng**: AI tạo câu hỏi educational
4. **Tiện lợi**: Tự động điền form
5. **Tiếng Việt**: Giao diện thân thiện

---

**Lưu ý**: Hãy thay thế API key mẫu bằng API key thật để tính năng hoạt động!