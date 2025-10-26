<?php
// Get student information and statistics
$studentId = $_SESSION['StudentID'];
$student = new Student();
$currentStudent = $student->single_student($studentId);

// Get student statistics (you may need to create these methods)
$totalLessons = 0; // This should be fetched from database
$completedLessons = 0; // This should be fetched from database
$totalQuizzes = 0; // This should be fetched from database
$averageScore = 0; // This should be fetched from database
$studyTime = 0; // This should be fetched from database

// Calculate progress
$progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

// Get recent activities (mock data for now)
$recentActivities = [
    ['type' => 'lesson', 'title' => 'Bài học: Giới thiệu về PHP', 'time' => '2 giờ trước', 'icon' => 'fas fa-play-circle'],
    ['type' => 'quiz', 'title' => 'Hoàn thành bài tập HTML', 'time' => '1 ngày trước', 'icon' => 'fas fa-check-circle'],
    ['type' => 'achievement', 'title' => 'Đạt điểm 9.5 trong bài kiểm tra', 'time' => '3 ngày trước', 'icon' => 'fas fa-trophy']
];

$userName = $currentStudent ? $currentStudent->Fname . ' ' . $currentStudent->Lname : 'Học viên';
?>

<!-- Skip to main content link -->
<a href="#main-dashboard" class="skip-link">Bỏ qua đến nội dung chính</a>

<main id="main-dashboard" class="dashboard-container" role="main">
    <!-- Dashboard Header -->
    <header class="dashboard-header">
        <div class="welcome-section">
            <h1 class="dashboard-title">Chào mừng trở lại, <?php echo htmlspecialchars($userName); ?>!</h1>
            <p class="dashboard-subtitle">Hãy tiếp tục hành trình học tập của bạn</p>
        </div>
        <div class="dashboard-time" role="complementary" aria-label="Thời gian hiện tại">
            <div class="current-time">
                <i class="fas fa-clock" aria-hidden="true"></i>
                <span id="currentTime" aria-live="polite"></span>
            </div>
            <div class="current-date">
                <span id="currentDate"></span>
            </div>
        </div>
    </header>

    <!-- Dashboard Statistics -->
    <section class="dashboard-stats" aria-labelledby="stats-heading">
        <h2 id="stats-heading" class="sr-only">Thống kê học tập</h2>
        
        <div class="stat-card" role="img" aria-labelledby="lessons-stat">
            <div class="stat-icon lessons">
                <i class="fas fa-book-open" aria-hidden="true"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $completedLessons; ?>/<?php echo $totalLessons; ?></h3>
                <p class="stat-label">Bài học hoàn thành</p>
                <div class="stat-progress">
                    <div class="progress">
                        <div class="progress-bar" style="width: <?php echo $progressPercentage; ?>%"></div>
                    </div>
                    <small><?php echo $progressPercentage; ?>%</small>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon score">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $averageScore; ?>%</h3>
                <p class="stat-label">Điểm trung bình</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                    <small>+5% so với tuần trước</small>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon time">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $studyTime; ?>h</h3>
                <p class="stat-label">Thời gian học</p>
                <div class="stat-trend">
                    <i class="fas fa-target"></i>
                    <small>Mục tiêu: 20h/tuần</small>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon quizzes">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number"><?php echo $totalQuizzes; ?></h3>
                <p class="stat-label">Bài tập đã làm</p>
                <div class="stat-badge">
                    <span class="badge badge-success">Mới</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-actions">
        <h2 class="section-title">Bắt đầu học tập</h2>
        <div class="action-grid">
            <a href="index.php?q=content" class="action-card primary">
                <div class="action-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Nội dung học tập</h3>
                    <p class="action-description">Xem video bài giảng và tài liệu học tập</p>
                    <div class="action-meta">
                        <span class="action-count">12 bài học mới</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <a href="index.php?q=categories" class="action-card secondary">
                <div class="action-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Bài tập</h3>
                    <p class="action-description">Làm bài tập và kiểm tra kiến thức</p>
                    <div class="action-meta">
                        <span class="action-count">5 bài tập mới</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <a href="index.php?q=result" class="action-card tertiary">
                <div class="action-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Kết quả học tập</h3>
                    <p class="action-description">Xem điểm số và tiến độ học tập</p>
                    <div class="action-meta">
                        <span class="action-count">Cập nhật mới</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            <a href="index.php?q=about" class="action-card info">
                <div class="action-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="action-content">
                    <h3 class="action-title">Thông tin</h3>
                    <p class="action-description">Tìm hiểu về hệ thống và hướng dẫn</p>
                    <div class="action-meta">
                        <span class="action-count">Hướng dẫn</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="dashboard-recent">
        <div class="row">
            <div class="col-lg-8">
                <div class="recent-activities">
                    <h2 class="section-title">Hoạt động gần đây</h2>
                    <div class="activity-list">
                        <?php foreach ($recentActivities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="<?php echo $activity['icon']; ?>"></i>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></h4>
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
                    <div class="activity-footer">
                        <a href="#" class="view-all-link">Xem tất cả hoạt động</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="dashboard-sidebar">
                    <!-- Study Progress -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Tiến độ học tập</h3>
                        <div class="progress-circle">
                            <div class="circle-progress" data-progress="<?php echo $progressPercentage; ?>">
                                <div class="circle-progress-inner">
                                    <span class="progress-text"><?php echo $progressPercentage; ?>%</span>
                                </div>
                            </div>
                        </div>
                        <p class="progress-description">
                            Bạn đã hoàn thành <?php echo $completedLessons; ?> trong tổng số <?php echo $totalLessons; ?> bài học
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Liên kết nhanh</h3>
                        <div class="quick-links">
                            <a href="#" class="quick-link">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Lịch học</span>
                            </a>
                            <a href="#" class="quick-link">
                                <i class="fas fa-download"></i>
                                <span>Tài liệu</span>
                            </a>
                            <a href="#" class="quick-link">
                                <i class="fas fa-question-circle"></i>
                                <span>Hỗ trợ</span>
                            </a>
                            <a href="#" class="quick-link">
                                <i class="fas fa-cog"></i>
                                <span>Cài đặt</span>
                            </a>
                        </div>
                    </div>

                    <!-- Motivational Quote -->
                    <div class="sidebar-widget quote-widget">
                        <div class="quote-content">
                            <i class="fas fa-quote-left quote-icon"></i>
                            <p class="quote-text">"Học tập không phải là sự chuẩn bị cho cuộc sống; học tập chính là cuộc sống."</p>
                            <small class="quote-author">- John Dewey</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time and date
    function updateDateTime() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        const dateElement = document.getElementById('currentDate');
        
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('vi-VN', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    }
    
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute
    
    // Animate progress circle
    const progressCircle = document.querySelector('.circle-progress');
    if (progressCircle) {
        const progress = parseInt(progressCircle.dataset.progress);
        const circumference = 2 * Math.PI * 45; // radius = 45
        const offset = circumference - (progress / 100) * circumference;
        
        // Create SVG circle if not exists
        if (!progressCircle.querySelector('svg')) {
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('width', '100');
            svg.setAttribute('height', '100');
            
            const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circle.setAttribute('cx', '50');
            circle.setAttribute('cy', '50');
            circle.setAttribute('r', '45');
            circle.setAttribute('fill', 'none');
            circle.setAttribute('stroke', 'var(--primary-blue)');
            circle.setAttribute('stroke-width', '4');
            circle.setAttribute('stroke-dasharray', circumference);
            circle.setAttribute('stroke-dashoffset', offset);
            circle.setAttribute('stroke-linecap', 'round');
            circle.style.transform = 'rotate(-90deg)';
            circle.style.transformOrigin = '50% 50%';
            circle.style.transition = 'stroke-dashoffset 1s ease-in-out';
            
            svg.appendChild(circle);
            progressCircle.appendChild(svg);
        }
    }
    
    // Add hover effects to action cards
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>