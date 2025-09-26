# 🔧 Khắc phục lỗi HTTP 404 - Gemini API

## 🐛 Lỗi: "API lỗi: HTTP 404"

### ❓ Nguyên nhân
- **Model không tồn tại** hoặc không khả dụng
- **API URL sai**
- **API key không có quyền** truy cập model

### ✅ Giải pháp đã triển khai

#### 1. **Cập nhật Model từ `gemini-2.0-flash` → `gemini-1.5-flash`**
```php
// Cũ (404 error)
'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent'

// Mới (working)
'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent' 
```

#### 2. **Tạo Fallback System** - `gemini_api_fallback.php`
Thử nhiều models theo thứ tự:
1. `gemini-1.5-flash` (fastest)
2. `gemini-1.5-pro` (better quality) 
3. `gemini-pro` (legacy)

#### 3. **Model Testing Tool** - `test_models.php`
Kiểm tra model nào hoạt động với API key của bạn.

### 🧪 Cách test

1. **Test models**: `http://localhost/elearning/admin/modules/exercises/test_models.php`
2. **Test API**: `http://localhost/elearning/admin/modules/exercises/test_page.html`

### 📋 Models khả dụng (tháng 9/2025)

| Model | Speed | Quality | Status |
|-------|-------|---------|--------|
| `gemini-1.5-flash` | ⚡ Fast | 📊 Good | ✅ Working |
| `gemini-1.5-pro` | 🐌 Slow | 🏆 Best | ✅ Working |
| `gemini-pro` | 📈 Medium | 📊 Good | ✅ Legacy |
| `gemini-2.0-flash` | ⚡ Fast | 🏆 Best | ❌ Not available |

### 🔍 Debug steps

1. **Kiểm tra API key**:
   ```php
   // File: gemini_config.php
   define('GEMINI_API_KEY', 'YOUR_ACTUAL_API_KEY');
   ```

2. **Test từng model**:
   - Truy cập `test_models.php`
   - Xem model nào return HTTP 200

3. **Kiểm tra quota**:
   - Vào [Google AI Studio](https://aistudio.google.com)
   - Check API usage & limits

### 🚀 Features mới

1. **Auto-fallback**: Tự động thử model khác nếu 1 model fail
2. **Better error messages**: Hiển thị model nào được sử dụng
3. **Debug info**: Show models tried và lỗi cụ thể

### 💡 Tips

- **Gemini 1.5 Flash** = Tốc độ cao, quality tốt
- **Gemini 1.5 Pro** = Quality cao nhất nhưng chậm hơn
- **Fallback system** = Đảm bảo luôn có model hoạt động

### 🔄 Nếu vẫn lỗi 404

1. **Tạo API key mới** tại Google AI Studio
2. **Check model availability** cho region của bạn
3. **Sử dụng Gemini Pro** thay vì Gemini 1.5

---

**✅ Hiện tại system đã fix và sử dụng fallback để đảm bảo stability!**