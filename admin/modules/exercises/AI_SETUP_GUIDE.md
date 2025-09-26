# AI Question Generator Setup Guide

## Hướng dẫn thiết lập tính năng tự động tạo câu hỏi bằng AI

### 🚀 Tính năng mới

Hệ thống E-Learning giờ đây hỗ trợ tự động tạo câu hỏi trắc nghiệm bằng **Gemini AI**!

### ✨ Tính năng

- 🤖 **Tự động tạo câu hỏi**: Sử dụng AI để tạo câu hỏi theo chủ đề
- 🎯 **Điều chỉnh độ khó**: Easy, Medium, Hard
- 📝 **Tự động điền form**: AI sẽ tự động điền tất cả các trường
- 🔒 **Bảo mật**: API key được lưu trữ an toàn
- ⚡ **Nhanh chóng**: Tạo câu hỏi chỉ trong vài giây

### 🛠️ Cách thiết lập

#### Bước 1: Lấy Gemini API Key

1. Truy cập [Google AI Studio](https://aistudio.google.com/app/apikey)
2. Đăng nhập với tài khoản Google
3. Click **"Create API Key"**
4. Sao chép API key được tạo

#### Bước 2: Cấu hình API Key

**Phương pháp 1: Qua giao diện web (Khuyên dùng)**
1. Vào trang **Admin → Exercises → Add New Question**
2. Click nút **"Setup API Key"**
3. Nhập API key vào modal popup
4. Click **"Save"**

**Phương pháp 2: Cấu hình trong file (Cho admin)**
1. Mở file `admin/modules/exercises/gemini_config.php`
2. Thay thế `YOUR_GEMINI_API_KEY_HERE` bằng API key thực
3. Lưu file

#### Bước 3: Sử dụng

1. Vào **Admin Panel → Exercises → Add New Question**
2. Trong phần **"AI Question Generator"**:
   - Nhập chủ đề (ví dụ: "JavaScript", "Toán học", "Khoa học")
   - Chọn độ khó
   - Click **"Generate Question"**
3. Chờ vài giây để AI tạo câu hỏi
4. Kiểm tra và chỉnh sửa nếu cần
5. Chọn lesson và lưu

### 📋 Ví dụ sử dụng

**Input:**
- Topic: "JavaScript Variables"
- Difficulty: "Medium"

**Output:**
```
Question: Which keyword is used to declare a block-scoped variable in JavaScript?

A: var
B: let
C: const
D: function

Answer: B
```

### 🔧 Tùy chỉnh

#### Thay đổi prompt tạo câu hỏi
Có thể chỉnh sửa prompt trong file `gemini_api.php` để:
- Thay đổi ngôn ngữ câu hỏi
- Thêm yêu cầu đặc biệt
- Điều chỉnh định dạng output

#### Thêm chọn lựa độ khó
Trong file `add.php`, có thể thêm các mức độ khó:
```html
<option value="beginner">Beginner</option>
<option value="intermediate">Intermediate</option>
<option value="advanced">Advanced</option>
<option value="expert">Expert</option>
```

### ⚠️ Lưu ý bảo mật

1. **API Key**: Không chia sẻ API key với người khác
2. **Giới hạn sử dụng**: Gemini API có giới hạn request/ngày
3. **Kiểm tra nội dung**: Luôn kiểm tra câu hỏi do AI tạo trước khi lưu
4. **Backup**: Nên backup dữ liệu thường xuyên

### 🐛 Xử lý lỗi

**Lỗi "API Key not configured"**
- Kiểm tra API key đã được nhập chưa
- Đảm bảo API key còn hiệu lực

**Lỗi "Failed to generate question"**
- Kiểm tra kết nối internet
- Thử với chủ đề khác
- Kiểm tra quota API

**Lỗi "Invalid response format"**
- AI có thể trả về format không đúng
- Thử lại hoặc thay đổi prompt

### 📞 Hỗ trợ

Nếu gặp vấn đề, hãy:
1. Kiểm tra console browser (F12)
2. Kiểm tra error log của server
3. Thử với chủ đề đơn giản trước

### 🔄 Cập nhật

Để cập nhật tính năng:
1. Backup các file đã chỉnh sửa
2. Download phiên bản mới
3. Merge các thay đổi tùy chỉnh

---

**Phát triển bởi**: E-Learning System Team
**Phiên bản**: 1.0.0
**Cập nhật**: September 2025