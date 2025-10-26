# Tài liệu Thiết kế - Refactor Giao diện UX/UI Hệ thống E-Learning

## Tổng quan

Tài liệu này mô tả thiết kế chi tiết cho việc refactor giao diện UX/UI của hệ thống E-Learning, chuyển từ Bootstrap 3 sang thiết kế hiện đại với Bootstrap 5, đồng thời cải thiện trải nghiệm người dùng toàn diện.

## Kiến trúc Thiết kế

### Design System Foundation

#### Color Palette
```css
/* Primary Colors */
--primary-blue: #2563eb;
--primary-blue-light: #3b82f6;
--primary-blue-dark: #1d4ed8;

/* Secondary Colors */
--secondary-green: #10b981;
--secondary-orange: #f59e0b;
--secondary-red: #ef4444;

/* Neutral Colors */
--gray-50: #f9fafb;
--gray-100: #f3f4f6;
--gray-200: #e5e7eb;
--gray-300: #d1d5db;
--gray-500: #6b7280;
--gray-700: #374151;
--gray-900: #111827;

/* Dark Mode Colors */
--dark-bg: #0f172a;
--dark-surface: #1e293b;
--dark-border: #334155;
--dark-text: #f1f5f9;
```

#### Typography Scale
```css
/* Font Families */
--font-primary: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
--font-heading: 'Poppins', sans-serif;

/* Font Sizes */
--text-xs: 0.75rem;
--text-sm: 0.875rem;
--text-base: 1rem;
--text-lg: 1.125rem;
--text-xl: 1.25rem;
--text-2xl: 1.5rem;
--text-3xl: 1.875rem;
--text-4xl: 2.25rem;
```

#### Spacing System
```css
/* Spacing Scale */
--space-1: 0.25rem;
--space-2: 0.5rem;
--space-3: 0.75rem;
--space-4: 1rem;
--space-6: 1.5rem;
--space-8: 2rem;
--space-12: 3rem;
--space-16: 4rem;
```

### Component Architecture

#### Layout Components
1. **Header Navigation**
   - Sticky header với logo và navigation
   - User avatar dropdown
   - Search functionality
   - Mobile hamburger menu

2. **Sidebar Navigation** (Admin)
   - Collapsible sidebar
   - Icon + text navigation items
   - Active state indicators
   - Mobile overlay

3. **Main Content Area**
   - Responsive container
   - Breadcrumb navigation
   - Page title section
   - Content cards/sections

4. **Footer**
   - Minimal footer với links
   - Copyright information
   - Social links (nếu có)

## Thiết kế Chi tiết theo Components

### 1. Authentication Pages

#### Login Page Design
```html
<!-- Layout Structure -->
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <img src="logo.png" alt="Logo" class="auth-logo">
      <h1 class="auth-title">Đăng nhập</h1>
      <p class="auth-subtitle">Chào mừng trở lại!</p>
    </div>
    
    <form class="auth-form">
      <div class="form-group">
        <label class="form-label">Email hoặc Tên đăng nhập</label>
        <input type="text" class="form-input" placeholder="Nhập email...">
      </div>
      
      <div class="form-group">
        <label class="form-label">Mật khẩu</label>
        <div class="input-group">
          <input type="password" class="form-input" placeholder="Nhập mật khẩu...">
          <button type="button" class="input-addon">
            <i class="fas fa-eye"></i>
          </button>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary btn-full">
        Đăng nhập
      </button>
    </form>
    
    <div class="auth-footer">
      <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
      <a href="admin/login.php" class="admin-link">Đăng nhập Admin</a>
    </div>
  </div>
</div>
```

#### Styling Approach
```css
.auth-container {
  min-height: 100vh;
  background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--space-4);
}

.auth-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  padding: var(--space-8);
  width: 100%;
  max-width: 400px;
}

.form-input {
  border: 2px solid var(--gray-200);
  border-radius: 8px;
  padding: var(--space-3) var(--space-4);
  transition: all 0.2s ease;
}

.form-input:focus {
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
```

### 2. Dashboard Design

#### Student Dashboard
```html
<div class="dashboard-container">
  <div class="dashboard-header">
    <h1 class="dashboard-title">Chào mừng, [Tên học viên]!</h1>
    <p class="dashboard-subtitle">Hãy tiếp tục hành trình học tập của bạn</p>
  </div>
  
  <div class="dashboard-stats">
    <div class="stat-card">
      <div class="stat-icon">
        <i class="fas fa-book"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-number">12</h3>
        <p class="stat-label">Bài học đã hoàn thành</p>
      </div>
    </div>
    
    <div class="stat-card">
      <div class="stat-icon">
        <i class="fas fa-trophy"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-number">85%</h3>
        <p class="stat-label">Điểm trung bình</p>
      </div>
    </div>
  </div>
  
  <div class="dashboard-actions">
    <a href="index.php?q=content" class="action-card">
      <div class="action-icon">
        <i class="fas fa-play-circle"></i>
      </div>
      <h3 class="action-title">Nội dung học tập</h3>
      <p class="action-description">Xem video bài giảng và tài liệu</p>
    </a>
    
    <a href="index.php?q=categories" class="action-card">
      <div class="action-icon">
        <i class="fas fa-clipboard-check"></i>
      </div>
      <h3 class="action-title">Bài tập</h3>
      <p class="action-description">Làm bài tập và kiểm tra</p>
    </a>
  </div>
</div>
```

#### Admin Dashboard
```html
<div class="admin-layout">
  <aside class="admin-sidebar">
    <div class="sidebar-header">
      <img src="logo.png" alt="Logo" class="sidebar-logo">
      <h2 class="sidebar-title">Admin Panel</h2>
    </div>
    
    <nav class="sidebar-nav">
      <a href="#" class="nav-item active">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </a>
      <a href="#" class="nav-item">
        <i class="fas fa-book"></i>
        <span>Quản lý bài học</span>
      </a>
      <a href="#" class="nav-item">
        <i class="fas fa-question-circle"></i>
        <span>Quản lý bài tập</span>
      </a>
      <a href="#" class="nav-item">
        <i class="fas fa-users"></i>
        <span>Quản lý học viên</span>
      </a>
    </nav>
  </aside>
  
  <main class="admin-main">
    <header class="admin-header">
      <button class="sidebar-toggle">
        <i class="fas fa-bars"></i>
      </button>
      <div class="header-actions">
        <div class="user-menu">
          <img src="avatar.jpg" alt="Avatar" class="user-avatar">
          <span class="user-name">[Tên Admin]</span>
        </div>
      </div>
    </header>
    
    <div class="admin-content">
      <!-- Dashboard content -->
    </div>
  </main>
</div>
```

### 3. Lesson Management Interface

#### Lesson List Design
```html
<div class="lesson-container">
  <div class="lesson-header">
    <h1 class="page-title">Nội dung học tập</h1>
    <div class="lesson-filters">
      <input type="search" class="search-input" placeholder="Tìm kiếm bài học...">
      <select class="filter-select">
        <option>Tất cả loại</option>
        <option>Video</option>
        <option>PDF</option>
      </select>
    </div>
  </div>
  
  <div class="lesson-grid">
    <div class="lesson-card">
      <div class="lesson-thumbnail">
        <i class="fas fa-play-circle"></i>
        <span class="lesson-type">Video</span>
      </div>
      <div class="lesson-content">
        <h3 class="lesson-title">Chương 1: Giới thiệu</h3>
        <p class="lesson-description">Tổng quan về khóa học...</p>
        <div class="lesson-meta">
          <span class="lesson-duration">15 phút</span>
          <span class="lesson-status">Chưa xem</span>
        </div>
      </div>
      <div class="lesson-actions">
        <button class="btn btn-primary">Xem ngay</button>
      </div>
    </div>
  </div>
</div>
```

### 4. Quiz Interface Design

#### Quiz Taking Interface
```html
<div class="quiz-container">
  <div class="quiz-header">
    <div class="quiz-progress">
      <div class="progress-bar">
        <div class="progress-fill" style="width: 40%"></div>
      </div>
      <span class="progress-text">Câu 4/10</span>
    </div>
    <div class="quiz-timer">
      <i class="fas fa-clock"></i>
      <span>15:30</span>
    </div>
  </div>
  
  <div class="quiz-content">
    <div class="question-card">
      <h2 class="question-text">Câu hỏi số 4</h2>
      <p class="question-content">Đây là nội dung câu hỏi...</p>
      
      <div class="answer-options">
        <label class="option-item">
          <input type="radio" name="answer" value="A">
          <span class="option-marker">A</span>
          <span class="option-text">Đáp án A</span>
        </label>
        
        <label class="option-item">
          <input type="radio" name="answer" value="B">
          <span class="option-marker">B</span>
          <span class="option-text">Đáp án B</span>
        </label>
      </div>
    </div>
  </div>
  
  <div class="quiz-actions">
    <button class="btn btn-secondary">Câu trước</button>
    <button class="btn btn-primary">Câu tiếp</button>
  </div>
</div>
```

## Data Models và Interfaces

### Theme Configuration
```typescript
interface ThemeConfig {
  mode: 'light' | 'dark';
  primaryColor: string;
  fontSize: 'small' | 'medium' | 'large';
  animations: boolean;
}

interface UserPreferences {
  theme: ThemeConfig;
  language: string;
  notifications: boolean;
}
```

### Component State Management
```typescript
interface UIState {
  sidebarCollapsed: boolean;
  currentPage: string;
  loading: boolean;
  notifications: Notification[];
}

interface Notification {
  id: string;
  type: 'success' | 'error' | 'warning' | 'info';
  message: string;
  duration?: number;
}
```

## Error Handling và User Feedback

### Error States Design
```html
<!-- Loading State -->
<div class="loading-container">
  <div class="loading-spinner"></div>
  <p class="loading-text">Đang tải...</p>
</div>

<!-- Empty State -->
<div class="empty-state">
  <div class="empty-icon">
    <i class="fas fa-inbox"></i>
  </div>
  <h3 class="empty-title">Chưa có bài học nào</h3>
  <p class="empty-description">Hãy liên hệ giáo viên để được cập nhật bài học mới</p>
</div>

<!-- Error State -->
<div class="error-state">
  <div class="error-icon">
    <i class="fas fa-exclamation-triangle"></i>
  </div>
  <h3 class="error-title">Có lỗi xảy ra</h3>
  <p class="error-description">Không thể tải nội dung. Vui lòng thử lại.</p>
  <button class="btn btn-primary">Thử lại</button>
</div>
```

### Toast Notifications
```html
<div class="toast-container">
  <div class="toast toast-success">
    <div class="toast-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    <div class="toast-content">
      <h4 class="toast-title">Thành công!</h4>
      <p class="toast-message">Đã lưu thay đổi</p>
    </div>
    <button class="toast-close">
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>
```

## Testing Strategy

### Visual Regression Testing
- Screenshot testing cho các components chính
- Cross-browser compatibility testing
- Mobile responsiveness testing

### Accessibility Testing
- Keyboard navigation testing
- Screen reader compatibility
- Color contrast validation
- ARIA labels verification

### Performance Testing
- Page load time optimization
- Image optimization và lazy loading
- CSS và JS minification
- Critical CSS inlining

## Implementation Approach

### Phase 1: Foundation
1. Setup Bootstrap 5 và design system
2. Implement theme switching functionality
3. Create base components và layouts

### Phase 2: Core Pages
1. Refactor authentication pages
2. Implement new dashboard designs
3. Update navigation components

### Phase 3: Feature Pages
1. Redesign lesson management
2. Update quiz interface
3. Improve admin panel

### Phase 4: Polish & Optimization
1. Add animations và micro-interactions
2. Optimize performance
3. Accessibility improvements
4. Cross-browser testing

Thiết kế này đảm bảo trải nghiệm người dùng hiện đại, responsive và accessible trong khi vẫn giữ nguyên toàn bộ logic nghiệp vụ hiện tại của hệ thống.