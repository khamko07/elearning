<?php
// Get admin statistics (you may need to create these methods)
$totalStudents = 0; // This should be fetched from database
$totalLessons = 0; // This should be fetched from database
$totalExercises = 0; // This should be fetched from database
$totalUsers = 0; // This should be fetched from database

// Mock data for demonstration
$totalStudents = 156;
$totalLessons = 24;
$totalExercises = 18;
$totalUsers = 8;

// Recent activities
$recentActivities = [
    ['type' => 'student', 'title' => 'Học viên mới đăng ký: Nguyễn Văn A', 'time' => '30 phút trước', 'icon' => 'fas fa-user-plus'],
    ['type' => 'lesson', 'title' => 'Bài học mới được thêm: PHP Basics', 'time' => '2 giờ trước', 'icon' => 'fas fa-book'],
    ['type' => 'exercise', 'title' => 'Bài tập được cập nhật: HTML Forms', 'time' => '4 giờ trước', 'icon' => 'fas fa-edit'],
    ['type' => 'system', 'title' => 'Backup hệ thống hoàn tất', 'time' => '1 ngày trước', 'icon' => 'fas fa-database']
];

$adminName = $_SESSION['NAME'];
?>

<!-- Skip to main content link -->
<a href="#admin-main-content" class="skip-link">Bỏ qua đến nội dung chính</a>

<main id="admin-main-content" class="admin-dashboard" role="main">
    <!-- Dashboard Header -->
    <header class="admin-dashboard-header">
        <div class="admin-welcome">
            <h1 class="admin-title">Chào mừng, <?php echo htmlspecialchars($adminName); ?>!</h1>
            <p class="admin-subtitle">Quản trị hệ thống E-Learning</p>
        </div>
        <div class="admin-actions" role="toolbar" aria-label="Thao tác nhanh">
            <button 
                class="btn btn-outline" 
                onclick="refreshDashboard()"
                aria-label="Làm mới dữ liệu dashboard">
                <i class="fas fa-sync-alt" aria-hidden="true"></i>
                Làm mới
            </button>
            <button 
                class="btn btn-primary" 
                onclick="showQuickActions()"
                aria-label="Hiển thị menu thêm mới"
                aria-haspopup="true">
                <i class="fas fa-plus" aria-hidden="true"></i>
                Thêm mới
            </button>
        </div>
    </header>

    <!-- Statistics Cards -->
    <section class="admin-stats-grid" aria-labelledby="admin-stats-heading">
        <h2 id="admin-stats-heading" class="sr-only">Thống kê hệ thống</h2>
        
        <article class="admin-stat-card students" role="img" aria-labelledby="students-stat">
            <div class="stat-icon">
                <i class="fas fa-users" aria-hidden="true"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $totalStudents; ?></h3>
                <p class="stat-label">Học viên</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <small>+12 tuần này</small>
                </div>
            </div>
            <div class="stat-chart">
                <div class="mini-chart" data-chart="students"></div>
            </div>
        </div>

        <div class="admin-stat-card lessons">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $totalLessons; ?></h3>
                <p class="stat-label">Bài học</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <small>+3 tuần này</small>
                </div>
            </div>
            <div class="stat-chart">
                <div class="mini-chart" data-chart="lessons"></div>
            </div>
        </div>

        <div class="admin-stat-card exercises">
            <div class="stat-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $totalExercises; ?></h3>
                <p class="stat-label">Bài tập</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <small>+2 tuần này</small>
                </div>
            </div>
            <div class="stat-chart">
                <div class="mini-chart" data-chart="exercises"></div>
            </div>
        </div>

        <?php if($_SESSION['TYPE']=="Administrator"){ ?>
        <div class="admin-stat-card users">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $totalUsers; ?></h3>
                <p class="stat-label">Quản trị viên</p>
                <div class="stat-trend">
                    <i class="fas fa-minus text-muted"></i>
                    <small>Không đổi</small>
                </div>
            </div>
            <div class="stat-chart">
                <div class="mini-chart" data-chart="users"></div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- Main Content Grid -->
    <div class="admin-content-grid">
        <!-- Quick Actions -->
        <div class="admin-widget quick-actions-widget">
            <h2 class="widget-title">Thao tác nhanh</h2>
            <div class="quick-actions-grid">
                <a href="<?php echo web_root; ?>admin/modules/lesson/index.php" class="quick-action-card lessons">
                    <div class="action-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="action-content">
                        <h3>Quản lý bài học</h3>
                        <p>Thêm, sửa, xóa bài học</p>
                        <span class="action-count"><?php echo $totalLessons; ?> bài học</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="quick-action-card exercises">
                    <div class="action-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="action-content">
                        <h3>Quản lý bài tập</h3>
                        <p>Tạo và quản lý bài tập</p>
                        <span class="action-count"><?php echo $totalExercises; ?> bài tập</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="<?php echo web_root; ?>admin/modules/students/index.php" class="quick-action-card students">
                    <div class="action-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="action-content">
                        <h3>Quản lý học viên</h3>
                        <p>Xem và quản lý học viên</p>
                        <span class="action-count"><?php echo $totalStudents; ?> học viên</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <?php if($_SESSION['TYPE']=="Administrator"){ ?>
                <a href="<?php echo web_root; ?>admin/modules/user/index.php" class="quick-action-card users">
                    <div class="action-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="action-content">
                        <h3>Quản lý người dùng</h3>
                        <p>Quản lý tài khoản admin</p>
                        <span class="action-count"><?php echo $totalUsers; ?> người dùng</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                <?php } ?>

                <a href="<?php echo web_root; ?>admin/modules/report/index.php" class="quick-action-card reports">
                    <div class="action-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="action-content">
                        <h3>Báo cáo</h3>
                        <p>Xem báo cáo và thống kê</p>
                        <span class="action-count">Cập nhật</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="<?php echo web_root; ?>admin/modules/settings/index.php" class="quick-action-card settings">
                    <div class="action-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="action-content">
                        <h3>Cài đặt</h3>
                        <p>Cấu hình hệ thống</p>
                        <span class="action-count">Hệ thống</span>
                    </div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="admin-widget recent-activities-widget">
            <h2 class="widget-title">Hoạt động gần đây</h2>
            <div class="activities-list">
                <?php foreach ($recentActivities as $activity): ?>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="<?php echo $activity['icon']; ?>"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></p>
                        <small class="activity-time"><?php echo htmlspecialchars($activity['time']); ?></small>
                    </div>
                    <div class="activity-action">
                        <button class="btn btn-ghost btn-sm">
                            <i class="fas fa-external-link-alt"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="activities-footer">
                <a href="#" class="view-all-link">Xem tất cả hoạt động</a>
            </div>
        </div>

        <!-- System Status -->
        <div class="admin-widget system-status-widget">
            <h2 class="widget-title">Trạng thái hệ thống</h2>
            <div class="status-list">
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <div class="status-content">
                        <h4>Máy chủ</h4>
                        <small>Hoạt động bình thường</small>
                    </div>
                    <div class="status-value">99.9%</div>
                </div>
                
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <div class="status-content">
                        <h4>Cơ sở dữ liệu</h4>
                        <small>Kết nối ổn định</small>
                    </div>
                    <div class="status-value">100%</div>
                </div>
                
                <div class="status-item">
                    <div class="status-indicator warning"></div>
                    <div class="status-content">
                        <h4>Dung lượng</h4>
                        <small>Sử dụng 78% dung lượng</small>
                    </div>
                    <div class="status-value">78%</div>
                </div>
                
                <div class="status-item">
                    <div class="status-indicator online"></div>
                    <div class="status-content">
                        <h4>Backup</h4>
                        <small>Backup cuối: Hôm qua</small>
                    </div>
                    <div class="status-value">OK</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize mini charts (mock data)
    const charts = document.querySelectorAll('.mini-chart');
    charts.forEach(chart => {
        const type = chart.dataset.chart;
        createMiniChart(chart, type);
    });
    
    // Add hover effects to action cards
    const actionCards = document.querySelectorAll('.quick-action-card');
    actionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

function createMiniChart(element, type) {
    // Simple mini chart using CSS (you can replace with Chart.js or similar)
    const data = {
        students: [20, 25, 30, 28, 35, 40, 38],
        lessons: [5, 8, 12, 15, 18, 22, 24],
        exercises: [3, 6, 9, 12, 15, 16, 18],
        users: [5, 6, 7, 7, 8, 8, 8]
    };
    
    const values = data[type] || [];
    const max = Math.max(...values);
    
    element.innerHTML = values.map((value, index) => {
        const height = (value / max) * 100;
        return `<div class="chart-bar" style="height: ${height}%; animation-delay: ${index * 0.1}s;"></div>`;
    }).join('');
}

function refreshDashboard() {
    // Show loading state
    const refreshBtn = document.querySelector('.admin-actions .btn-outline');
    const originalText = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang làm mới...';
    refreshBtn.disabled = true;
    
    // Simulate refresh
    setTimeout(() => {
        refreshBtn.innerHTML = originalText;
        refreshBtn.disabled = false;
        
        // Show success message
        showNotification('Dashboard đã được làm mới!', 'success');
    }, 2000);
}

function showQuickActions() {
    // This could open a modal with quick action options
    alert('Chức năng thêm nhanh sẽ được triển khai!');
}

function showNotification(message, type = 'info') {
    // Simple notification (you can enhance this)
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>