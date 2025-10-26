<?php
// Get current user information
$currentUser = null;
$userType = 'guest';
$userName = '';
$userAvatar = 'images/default-avatar.png';

if (isset($_SESSION['StudentID'])) {
    $userType = 'student';
    $student = new Student();
    $currentUser = $student->single_student($_SESSION['StudentID']);
    if ($currentUser) {
        $userName = $currentUser->Fname . ' ' . $currentUser->Lname;
    }
} elseif (isset($_SESSION['USERID'])) {
    $userType = 'admin';
    $user = new User();
    $currentUser = $user->single_user($_SESSION['USERID']);
    if ($currentUser) {
        $userName = $currentUser->FNAME . ' ' . $currentUser->LNAME;
    }
}

// Get current page for active navigation
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$currentQuery = isset($_GET['q']) ? $_GET['q'] : '';
?>

<header class="main-header" id="mainHeader">
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Logo and Brand -->
            <div class="navbar-brand">
                <a href="<?php echo web_root; ?>index.php" class="brand-link">
                    <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="UED Logo" class="brand-logo">
                    <span class="brand-text">E-Learning</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="navbar-nav desktop-nav" id="desktopNav">
                <?php if ($userType === 'student'): ?>
                    <a href="<?php echo web_root; ?>index.php" class="nav-link <?php echo ($currentPage === 'index' && !$currentQuery) ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                    <a href="<?php echo web_root; ?>index.php?q=content" class="nav-link <?php echo ($currentQuery === 'content') ? 'active' : ''; ?>">
                        <i class="fas fa-book-open"></i>
                        <span>Nội dung học tập</span>
                    </a>
                    <a href="<?php echo web_root; ?>index.php?q=categories" class="nav-link <?php echo ($currentQuery === 'categories') ? 'active' : ''; ?>">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Bài tập</span>
                    </a>
                    <a href="<?php echo web_root; ?>index.php?q=result" class="nav-link <?php echo ($currentQuery === 'result') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Kết quả</span>
                    </a>
                <?php elseif ($userType === 'admin'): ?>
                    <a href="<?php echo web_root; ?>admin/index.php" class="nav-link <?php echo ($currentPage === 'index') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?php echo web_root; ?>admin/modules/lesson/index.php" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span>Quản lý bài học</span>
                    </a>
                    <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="nav-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Quản lý bài tập</span>
                    </a>
                    <a href="<?php echo web_root; ?>admin/modules/students/index.php" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Quản lý học viên</span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo web_root; ?>login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Đăng nhập</span>
                    </a>
                    <a href="<?php echo web_root; ?>register.php" class="nav-link">
                        <i class="fas fa-user-plus"></i>
                        <span>Đăng ký</span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Search Bar -->
            <?php if ($userType !== 'guest'): ?>
            <div class="navbar-search" id="navbarSearch">
                <form class="search-form" action="" method="GET">
                    <div class="search-input-group">
                        <input type="text" class="search-input" placeholder="Tìm kiếm..." name="search" id="searchInput">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <!-- Right Side Actions -->
            <div class="navbar-actions">
                <!-- Theme Toggle -->
                <button class="action-btn theme-toggle" data-theme-toggle title="Chuyển đổi giao diện">
                    <i class="fas fa-moon"></i>
                </button>

                <?php if ($userType !== 'guest'): ?>
                    <!-- Notifications -->
                    <div class="dropdown notification-dropdown">
                        <button class="action-btn notification-btn" data-bs-toggle="dropdown" title="Thông báo">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="dropdown-menu notification-menu">
                            <div class="notification-header">
                                <h6>Thông báo</h6>
                                <button class="mark-all-read">Đánh dấu đã đọc</button>
                            </div>
                            <div class="notification-list">
                                <div class="notification-item unread">
                                    <div class="notification-icon">
                                        <i class="fas fa-book text-primary"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">Bài học mới đã được thêm</p>
                                        <small class="notification-time">2 giờ trước</small>
                                    </div>
                                </div>
                                <div class="notification-item">
                                    <div class="notification-icon">
                                        <i class="fas fa-trophy text-warning"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text">Bạn đã hoàn thành bài tập</p>
                                        <small class="notification-time">1 ngày trước</small>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-footer">
                                <a href="#" class="view-all-notifications">Xem tất cả</a>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown user-dropdown">
                        <button class="user-menu-btn" data-bs-toggle="dropdown" title="Menu người dùng">
                            <img src="<?php echo web_root . $userAvatar; ?>" alt="Avatar" class="user-avatar">
                            <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu user-menu">
                            <div class="user-menu-header">
                                <img src="<?php echo web_root . $userAvatar; ?>" alt="Avatar" class="user-avatar-large">
                                <div class="user-info">
                                    <h6 class="user-name"><?php echo htmlspecialchars($userName); ?></h6>
                                    <small class="user-type"><?php echo $userType === 'admin' ? 'Quản trị viên' : 'Học viên'; ?></small>
                                </div>
                            </div>
                            <div class="user-menu-body">
                                <a href="#" class="user-menu-item">
                                    <i class="fas fa-user"></i>
                                    <span>Thông tin cá nhân</span>
                                </a>
                                <a href="#" class="user-menu-item">
                                    <i class="fas fa-cog"></i>
                                    <span>Cài đặt</span>
                                </a>
                                <?php if ($userType === 'student'): ?>
                                <a href="<?php echo web_root; ?>index.php?q=result" class="user-menu-item">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Kết quả học tập</span>
                                </a>
                                <?php endif; ?>
                                <div class="user-menu-divider"></div>
                                <a href="<?php echo web_root; ?>logout.php" class="user-menu-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Đăng xuất</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay">
        <div class="mobile-nav-content">
            <div class="mobile-nav-header">
                <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="UED Logo" class="mobile-brand-logo">
                <button class="mobile-nav-close" id="mobileNavClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mobile-nav-body">
                <?php if ($userType !== 'guest'): ?>
                    <!-- Mobile User Info -->
                    <div class="mobile-user-info">
                        <img src="<?php echo web_root . $userAvatar; ?>" alt="Avatar" class="mobile-user-avatar">
                        <div class="mobile-user-details">
                            <h6><?php echo htmlspecialchars($userName); ?></h6>
                            <small><?php echo $userType === 'admin' ? 'Quản trị viên' : 'Học viên'; ?></small>
                        </div>
                    </div>

                    <!-- Mobile Search -->
                    <div class="mobile-search">
                        <form class="mobile-search-form" action="" method="GET">
                            <div class="mobile-search-input-group">
                                <input type="text" class="mobile-search-input" placeholder="Tìm kiếm..." name="search">
                                <button type="submit" class="mobile-search-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Mobile Navigation Links -->
                <nav class="mobile-nav-links">
                    <?php if ($userType === 'student'): ?>
                        <a href="<?php echo web_root; ?>index.php" class="mobile-nav-link <?php echo ($currentPage === 'index' && !$currentQuery) ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i>
                            <span>Trang chủ</span>
                        </a>
                        <a href="<?php echo web_root; ?>index.php?q=content" class="mobile-nav-link <?php echo ($currentQuery === 'content') ? 'active' : ''; ?>">
                            <i class="fas fa-book-open"></i>
                            <span>Nội dung học tập</span>
                        </a>
                        <a href="<?php echo web_root; ?>index.php?q=categories" class="mobile-nav-link <?php echo ($currentQuery === 'categories') ? 'active' : ''; ?>">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Bài tập</span>
                        </a>
                        <a href="<?php echo web_root; ?>index.php?q=result" class="mobile-nav-link <?php echo ($currentQuery === 'result') ? 'active' : ''; ?>">
                            <i class="fas fa-chart-line"></i>
                            <span>Kết quả</span>
                        </a>
                    <?php elseif ($userType === 'admin'): ?>
                        <a href="<?php echo web_root; ?>admin/index.php" class="mobile-nav-link <?php echo ($currentPage === 'index') ? 'active' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="<?php echo web_root; ?>admin/modules/lesson/index.php" class="mobile-nav-link">
                            <i class="fas fa-book"></i>
                            <span>Quản lý bài học</span>
                        </a>
                        <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="mobile-nav-link">
                            <i class="fas fa-question-circle"></i>
                            <span>Quản lý bài tập</span>
                        </a>
                        <a href="<?php echo web_root; ?>admin/modules/students/index.php" class="mobile-nav-link">
                            <i class="fas fa-users"></i>
                            <span>Quản lý học viên</span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo web_root; ?>login.php" class="mobile-nav-link">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Đăng nhập</span>
                        </a>
                        <a href="<?php echo web_root; ?>register.php" class="mobile-nav-link">
                            <i class="fas fa-user-plus"></i>
                            <span>Đăng ký</span>
                        </a>
                    <?php endif; ?>
                </nav>

                <?php if ($userType !== 'guest'): ?>
                    <!-- Mobile User Actions -->
                    <div class="mobile-user-actions">
                        <a href="#" class="mobile-action-link">
                            <i class="fas fa-user"></i>
                            <span>Thông tin cá nhân</span>
                        </a>
                        <a href="#" class="mobile-action-link">
                            <i class="fas fa-cog"></i>
                            <span>Cài đặt</span>
                        </a>
                        <a href="<?php echo web_root; ?>logout.php" class="mobile-action-link text-danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>