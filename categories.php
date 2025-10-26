<?php
// Get categories with statistics
$sql = "SELECT c.*, COUNT(DISTINCT t.TopicID) as TopicCount, COUNT(DISTINCT e.ExerciseID) as QuestionCount
        FROM tblcategories c 
        LEFT JOIN tbltopics t ON c.CategoryID = t.CategoryID AND t.IsActive = 1
        LEFT JOIN tblexercise e ON t.TopicID = e.TopicID
        WHERE c.IsActive = 1 
        GROUP BY c.CategoryID 
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$categories = $mydb->loadResultList();

// Calculate totals
$totalCategories = count($categories ?: []);
$totalTopics = 0;
$totalQuestions = 0;

if ($categories) {
    $totalTopics = array_sum(array_column($categories, 'TopicCount'));
    $totalQuestions = array_sum(array_column($categories, 'QuestionCount'));
}

// Category icons mapping
$categoryIcons = [
    'HTML' => 'fab fa-html5',
    'CSS' => 'fab fa-css3-alt',
    'JavaScript' => 'fab fa-js-square',
    'PHP' => 'fab fa-php',
    'Database' => 'fas fa-database',
    'Programming' => 'fas fa-code',
    'Web Design' => 'fas fa-palette',
    'General' => 'fas fa-book',
    'default' => 'fas fa-folder'
];

function getCategoryIcon($categoryName) {
    global $categoryIcons;
    foreach ($categoryIcons as $key => $icon) {
        if (stripos($categoryName, $key) !== false) {
            return $icon;
        }
    }
    return $categoryIcons['default'];
}
?>

<div class="quiz-categories-container">
    <!-- Page Header -->
    <div class="quiz-header">
        <div class="header-content">
            <h1 class="page-title"><?php echo isset($title) ? $title : 'Danh mục bài tập'; ?></h1>
            <p class="page-subtitle">Chọn danh mục để bắt đầu luyện tập với <?php echo $totalQuestions; ?> câu hỏi</p>
        </div>
        <div class="header-stats">
            <div class="stat-item">
                <i class="fas fa-folder"></i>
                <span><?php echo $totalCategories; ?> danh mục</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-list"></i>
                <span><?php echo $totalTopics; ?> chủ đề</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-question-circle"></i>
                <span><?php echo $totalQuestions; ?> câu hỏi</span>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="quiz-controls">
        <div class="search-section">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Tìm kiếm danh mục..." id="categorySearch">
                <button class="search-clear" id="clearSearch" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Sắp xếp:</label>
                <select class="filter-select" id="sortFilter">
                    <option value="name">Theo tên</option>
                    <option value="questions">Theo số câu hỏi</option>
                    <option value="topics">Theo số chủ đề</option>
                </select>
            </div>
            
            <button class="view-toggle" id="viewToggle" title="Chuyển đổi hiển thị">
                <i class="fas fa-th-large"></i>
            </button>
        </div>
    </div>

    <!-- Categories Grid -->
    <?php if (!empty($categories)): ?>
    <div class="categories-grid" id="categoriesGrid">
        <?php foreach ($categories as $index => $category): 
            $categoryIcon = getCategoryIcon($category->CategoryName);
            $progressPercentage = rand(0, 100); // Mock progress data
        ?>
        <div class="category-card" data-name="<?php echo strtolower($category->CategoryName); ?>" data-questions="<?php echo $category->QuestionCount; ?>" data-topics="<?php echo $category->TopicCount; ?>">
            <div class="category-header">
                <div class="category-icon">
                    <i class="<?php echo $categoryIcon; ?>"></i>
                </div>
                <div class="category-badge">
                    <span class="badge badge-primary"><?php echo $category->QuestionCount; ?> câu hỏi</span>
                </div>
            </div>
            
            <div class="category-content">
                <h3 class="category-title"><?php echo htmlspecialchars($category->CategoryName); ?></h3>
                
                <?php if ($category->CategoryDescription): ?>
                    <p class="category-description"><?php echo htmlspecialchars($category->CategoryDescription); ?></p>
                <?php else: ?>
                    <p class="category-description">Luyện tập các câu hỏi trong danh mục <?php echo htmlspecialchars($category->CategoryName); ?></p>
                <?php endif; ?>
                
                <div class="category-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number"><?php echo $category->TopicCount; ?></span>
                            <span class="stat-label">Chủ đề</span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number"><?php echo $category->QuestionCount; ?></span>
                            <span class="stat-label">Câu hỏi</span>
                        </div>
                    </div>
                </div>
                
                <div class="category-progress">
                    <div class="progress-info">
                        <span class="progress-label">Tiến độ hoàn thành</span>
                        <span class="progress-percentage"><?php echo $progressPercentage; ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo $progressPercentage; ?>%"></div>
                    </div>
                </div>
            </div>
            
            <div class="category-actions">
                <a href="index.php?q=topics&category=<?php echo $category->CategoryID; ?>" class="btn btn-primary category-btn">
                    <i class="fas fa-play"></i>
                    <span>Bắt đầu luyện tập</span>
                </a>
                <button class="btn btn-ghost category-bookmark" title="Đánh dấu">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Overall Statistics -->
    <div class="quiz-statistics">
        <div class="stats-header">
            <h2 class="stats-title">Thống kê tổng quan</h2>
            <p class="stats-subtitle">Tổng quan về hệ thống bài tập</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card categories">
                <div class="stat-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo $totalCategories; ?></h3>
                    <p class="stat-label">Danh mục</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up text-success"></i>
                        <small>Đang hoạt động</small>
                    </div>
                </div>
            </div>
            
            <div class="stat-card topics">
                <div class="stat-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo $totalTopics; ?></h3>
                    <p class="stat-label">Chủ đề</p>
                    <div class="stat-trend">
                        <i class="fas fa-chart-line text-info"></i>
                        <small>Đa dạng nội dung</small>
                    </div>
                </div>
            </div>
            
            <div class="stat-card questions">
                <div class="stat-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo $totalQuestions; ?></h3>
                    <p class="stat-label">Câu hỏi</p>
                    <div class="stat-trend">
                        <i class="fas fa-fire text-warning"></i>
                        <small>Sẵn sàng luyện tập</small>
                    </div>
                </div>
            </div>
            
            <div class="stat-card progress">
                <div class="stat-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">65%</h3>
                    <p class="stat-label">Tiến độ trung bình</p>
                    <div class="stat-trend">
                        <i class="fas fa-trophy text-success"></i>
                        <small>Kết quả tốt</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-folder-open"></i>
        </div>
        <h3 class="empty-title">Chưa có danh mục bài tập</h3>
        <p class="empty-description">Các danh mục bài tập sẽ xuất hiện ở đây khi được tạo bởi quản trị viên.</p>
        <a href="index.php" class="btn btn-primary">
            <i class="fas fa-home"></i>
            Về trang chủ
        </a>
    </div>
    <?php endif; ?>

    <!-- Empty Search State -->
    <div class="empty-state" id="emptySearchState" style="display: none;">
        <div class="empty-icon">
            <i class="fas fa-search"></i>
        </div>
        <h3 class="empty-title">Không tìm thấy danh mục</h3>
        <p class="empty-description">Thử thay đổi từ khóa tìm kiếm</p>
        <button class="btn btn-primary" onclick="clearSearch()">
            <i class="fas fa-refresh"></i>
            Xóa tìm kiếm
        </button>
    </div>
</div>