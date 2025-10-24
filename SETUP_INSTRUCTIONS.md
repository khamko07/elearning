# Hướng dẫn cài đặt hệ thống phân loại câu hỏi

## Bước 1: Chạy SQL Script

Truy cập phpMyAdmin và chạy file `admin/modules/exercises/create_categories_table.sql` để:

- Tạo bảng `tblcategories` (quản lý loại câu hỏi)
- Tạo bảng `tbltopics` (quản lý chủ đề con)
- Thêm cột `CategoryID` và `TopicID` vào bảng `tblexercise`
- Thêm dữ liệu mẫu

## Bước 2: Cấu trúc mới

### Admin Panel:

1. **Questions Management**: `/admin/modules/exercises/index.php` - Hiển thị theo Categories
2. **Manage Categories & Topics**: `/admin/modules/exercises/index.php?view=categories`
3. **Thêm câu hỏi mới**: Chọn Category → Topic → Nhập câu hỏi
4. **Quản lý theo Topic**: Click vào Category → Xem Topics và Questions theo từng Topic
5. **Legacy View**: `/admin/modules/exercises/index.php?view=list` - View cũ (list tất cả)

### User Interface:

1. **Categories**: `/index.php?q=categories` - Hiển thị tất cả loại câu hỏi
2. **Topics**: `/index.php?q=topics&category=ID` - Hiển thị chủ đề trong loại
3. **Quiz**: `/index.php?q=question&topic=ID` - Làm bài theo chủ đề

## Cấu trúc phân cấp:

```
Category (Technology)
├── Topic (AI)
│   ├── Question 1
│   ├── Question 2
│   └── Question 3
├── Topic (Web Development)
│   ├── Question 1
│   └── Question 2
└── Topic (Database)
    └── Question 1
```

## Dữ liệu mẫu được tạo:

### Categories:

- Technology
- Science
- Mathematics
- Business
- Language

### Topics (ví dụ):

- Technology → AI, Web Development, Database, Programming Languages
- Science → Physics, Chemistry, Biology
- Mathematics → Algebra, Geometry, Calculus
- Business → Marketing, Management
- Language → English, Vietnamese Literature

## Tính năng mới:

1. **Phân loại có cấu trúc**: Category → Topic → Questions
2. **Quản lý dễ dàng**: Admin có thể thêm/sửa/xóa categories và topics
3. **Giao diện thân thiện**: User chọn loại → chủ đề → làm bài
4. **Thống kê**: Hiển thị số lượng topics và questions trong mỗi category

## Admin Interface Mới:

### Trang chủ Admin (/admin/modules/exercises/index.php):

- Hiển thị tất cả Categories dạng card
- Thống kê số Topics và Questions trong mỗi Category
- Nút "Manage Topics & Questions" để vào chi tiết

### Trang quản lý Topics (admin_topics.php):

- Hiển thị tất cả Topics trong Category
- Mỗi Topic có bảng Questions riêng
- Bulk delete theo từng Topic
- Select All cho từng Topic
- Truncate text dài để gọn gàng

### Tính năng Bulk Operations:

- Select All cho từng Topic riêng biệt
- Bulk delete questions theo Topic
- Confirmation dialog trước khi xóa
- Real-time update số lượng đã chọn

### Navigation:

```
Admin Home → Categories → Topics & Questions → Individual Question Edit
```

Cấu trúc này giúp admin dễ dàng quản lý câu hỏi theo từng chủ đề cụ thể thay vì phải tìm trong danh sách dài tất cả câu hỏi.
