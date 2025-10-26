<?php
// Get current user information
$currentUser = null;
$userName = 'Admin';
$userAvatar = 'images/default-avatar.png';

if (isset($_SESSION['USERID'])) {
    $user = new User();
    $currentUser = $user->single_user($_SESSION['USERID']);
    if ($currentUser) {
        $userName = $currentUser->FNAME . ' ' . $currentUser->LNAME;
    }
}

// Get current page for active navigation
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$currentPath = $_SERVER['REQUEST_URI'];
?>

<aside class="admin-sidebar" id="adminSidebar" role="navigation" aria-label="Điều hướng quản trị">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo Đại học Sư phạm" class="sidebar-logo">
            <div class="brand-info">
                <h3 class="brand-title">Admin Panel</h3>
                <small class="brand-subtitle">Hệ thống quản trị</small>
            </div>
        </div>
        
        <button 
            class="sidebar-toggle" 
            id="sidebarToggle" 
            aria-label="Thu gọn/mở rộng sidebar"
            aria-expanded="true"
            aria-controls="adminSidebar"
            title="Thu gọn sidebar">
            <i class="fas fa-angle-left" aria-hidden="true"></i>
        </button>
    </div>

    <!-- Admin User Info -->
    <div class="sidebar-user" role="complementary" aria-label="Thông tin người dùng">
        <div class="user-avatar-container">
            <img src="<?php echo web_root . $userAvatar; ?>" alt="Ảnh đại diện của <?php echo htmlspecialchars($userName); ?>" class="sidebar-user-avatar">
            <div class="user-status online" aria-label="Trạng thái: Đang hoạt động"></div>
        </div>
        <div class="user-details">
            <h4 class="user-name"><?php echo htmlspecialchars($userName); ?></h4>
            <small class="user-role">Quản trị viên</small>
        </div>
        <div class="user-actions">
            <button 
                class="user-action-btn" 
                aria-label="Cài đặt tài khoản"
                title="Cài đặt">
                <i class="fas fa-cog" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <div class="nav-section">
            <h5 class="nav-section-title">Tổng quan</h5>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/index.php" class="nav-link <?php echo ($currentPage === 'index') ? 'active' : ''; ?>">
                        <div class="nav-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <span class="nav-text">Dashboard</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/statistics/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <span class="nav-text">Thống kê</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <h5 class="nav-section-title">Quản lý nội dung</h5>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/lesson/index.php" class="nav-link <?php echo (strpos($currentPath, 'lesson') !== false) ? 'active' : ''; ?>">
                        <div class="nav-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <span class="nav-text">Bài học</span>
                        <span class="nav-badge">12</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="nav-link <?php echo (strpos($currentPath, 'exercises') !== false) ? 'active' : ''; ?>">
                        <div class="nav-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <span class="nav-text">Bài tập</span>
                        <span class="nav-badge">8</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/categories/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-folder"></i>
                        </div>
                        <span class="nav-text">Danh mục</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <h5 class="nav-section-title">Quản lý người dùng</h5>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/students/index.php" class="nav-link <?php echo (strpos($currentPath, 'students') !== false) ? 'active' : ''; ?>">
                        <div class="nav-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="nav-text">Học viên</span>
                        <span class="nav-badge">156</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/instructors/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <span class="nav-text">Giảng viên</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/admins/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <span class="nav-text">Quản trị viên</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="nav-section">
            <h5 class="nav-section-title">Hệ thống</h5>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/settings/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <span class="nav-text">Cài đặt</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/backup/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <span class="nav-text">Sao lưu</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo web_root; ?>admin/modules/logs/index.php" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="nav-text">Nhật ký</span>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="footer-actions">
            <a href="<?php echo web_root; ?>index.php" class="footer-action" title="Xem trang chủ">
                <i class="fas fa-external-link-alt"></i>
                <span>Trang chủ</span>
            </a>
            <button class="footer-action theme-toggle" data-theme-toggle title="Chuyển đổi giao diện">
                <i class="fas fa-moon"></i>
                <span>Giao diện</span>
            </button>
        </div>
        
        <div class="footer-info">
            <small class="version-info">v2.0.0</small>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Mobile Sidebar Toggle -->
<button class="mobile-sidebar-toggle" id="mobileSidebarToggle">
    <i class="fas fa-bars"></i>
</button>