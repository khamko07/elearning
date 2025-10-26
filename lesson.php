<?php
// Get all lessons and organize by category
$sqlDocs = "SELECT * FROM tbllesson WHERE Category='Docs' ORDER BY LessonChapter, LessonTitle";
$mydb->setQuery($sqlDocs);
$docLessons = $mydb->loadResultList();

$sqlVideos = "SELECT * FROM tbllesson WHERE Category='Video' ORDER BY LessonTitle";
$mydb->setQuery($sqlVideos);
$videoLessons = $mydb->loadResultList();

// Combine all lessons for search functionality
$allLessons = array_merge($docLessons ?: [], $videoLessons ?: []);
$totalLessons = count($allLessons);
$totalDocs = count($docLessons ?: []);
$totalVideos = count($videoLessons ?: []);
?>

<div class="lesson-management-container">
    <!-- Page Header -->
    <div class="lesson-header">
        <div class="header-content">
            <h1 class="page-title"><?php echo $title; ?></h1>
            <p class="page-subtitle">Khám phá và học tập với <?php echo $totalLessons; ?> bài học đa dạng</p>
        </div>
        <div class="header-stats">
            <div class="stat-item">
                <i class="fas fa-file-pdf"></i>
                <span><?php echo $totalDocs; ?> PDF</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-play-circle"></i>
                <span><?php echo $totalVideos; ?> Video</span>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="lesson-controls">
        <div class="search-section">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Tìm kiếm bài học..." id="lessonSearch">
                <button class="search-clear" id="clearSearch" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Loại:</label>
                <select class="filter-select" id="typeFilter">
                    <option value="all">Tất cả</option>
                    <option value="Docs">PDF Documents</option>
                    <option value="Video">Video Lessons</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Sắp xếp:</label>
                <select class="filter-select" id="sortFilter">
                    <option value="title">Theo tên</option>
                    <option value="chapter">Theo chương</option>
                    <option value="type">Theo loại</option>
                </select>
            </div>
            
            <button class="view-toggle" id="viewToggle" title="Chuyển đổi hiển thị">
                <i class="fas fa-th-large"></i>
            </button>
        </div>
    </div>

    <!-- Lesson Grid -->
    <div class="lesson-grid" id="lessonGrid">
        <?php if (!empty($docLessons)): ?>
            <?php foreach ($docLessons as $index => $lesson): ?>
                <div class="lesson-card" data-type="Docs" data-title="<?php echo strtolower($lesson->LessonTitle); ?>" data-chapter="<?php echo $lesson->LessonChapter; ?>">
                    <div class="lesson-thumbnail">
                        <div class="thumbnail-content pdf">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="lesson-type-badge pdf">
                            <i class="fas fa-file-pdf"></i>
                            <span>PDF</span>
                        </div>
                    </div>
                    
                    <div class="lesson-content">
                        <div class="lesson-meta">
                            <span class="lesson-chapter">Chương <?php echo htmlspecialchars($lesson->LessonChapter); ?></span>
                            <span class="lesson-duration">
                                <i class="fas fa-clock"></i>
                                ~15 phút
                            </span>
                        </div>
                        
                        <h3 class="lesson-title"><?php echo htmlspecialchars($lesson->LessonTitle); ?></h3>
                        
                        <p class="lesson-description">
                            Tài liệu học tập dưới dạng PDF với nội dung chi tiết và dễ hiểu.
                        </p>
                        
                        <div class="lesson-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 0%"></div>
                            </div>
                            <small class="progress-text">Chưa bắt đầu</small>
                        </div>
                    </div>
                    
                    <div class="lesson-actions">
                        <a href="index.php?q=viewpdf&id=<?php echo $lesson->LessonID; ?>" class="btn btn-primary lesson-btn">
                            <i class="fas fa-eye"></i>
                            <span>Xem tài liệu</span>
                        </a>
                        <button class="btn btn-ghost lesson-bookmark" title="Đánh dấu">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($videoLessons)): ?>
            <?php foreach ($videoLessons as $index => $lesson): ?>
                <div class="lesson-card" data-type="Video" data-title="<?php echo strtolower($lesson->LessonTitle); ?>" data-chapter="">
                    <div class="lesson-thumbnail">
                        <div class="thumbnail-content video">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="lesson-type-badge video">
                            <i class="fas fa-play-circle"></i>
                            <span>Video</span>
                        </div>
                        <div class="video-duration">
                            <i class="fas fa-clock"></i>
                            <span>25:30</span>
                        </div>
                    </div>
                    
                    <div class="lesson-content">
                        <div class="lesson-meta">
                            <span class="lesson-category">Video Lesson</span>
                            <span class="lesson-views">
                                <i class="fas fa-eye"></i>
                                1,234 lượt xem
                            </span>
                        </div>
                        
                        <h3 class="lesson-title"><?php echo htmlspecialchars($lesson->LessonTitle); ?></h3>
                        
                        <p class="lesson-description">
                            Video bài giảng với hình ảnh sinh động và giải thích chi tiết.
                        </p>
                        
                        <div class="lesson-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 0%"></div>
                            </div>
                            <small class="progress-text">Chưa xem</small>
                        </div>
                    </div>
                    
                    <div class="lesson-actions">
                        <a href="index.php?q=playvideo&id=<?php echo $lesson->LessonID; ?>" class="btn btn-primary lesson-btn">
                            <i class="fas fa-play"></i>
                            <span>Xem video</span>
                        </a>
                        <button class="btn btn-ghost lesson-bookmark" title="Đánh dấu">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="emptyState" style="display: none;">
        <div class="empty-icon">
            <i class="fas fa-search"></i>
        </div>
        <h3 class="empty-title">Không tìm thấy bài học</h3>
        <p class="empty-description">Thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
        <button class="btn btn-primary" onclick="clearAllFilters()">
            <i class="fas fa-refresh"></i>
            Xóa bộ lọc
        </button>
    </div>

    <!-- Loading State -->
    <div class="loading-state" id="loadingState" style="display: none;">
        <div class="loading-spinner"></div>
        <p>Đang tải bài học...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('lessonSearch');
    const clearSearch = document.getElementById('clearSearch');
    const typeFilter = document.getElementById('typeFilter');
    const sortFilter = document.getElementById('sortFilter');
    const viewToggle = document.getElementById('viewToggle');
    const lessonGrid = document.getElementById('lessonGrid');
    const emptyState = document.getElementById('emptyState');
    const lessonCards = document.querySelectorAll('.lesson-card');
    
    let currentView = 'grid'; // grid or list
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        
        if (query) {
            clearSearch.style.display = 'block';
        } else {
            clearSearch.style.display = 'none';
        }
        
        filterLessons();
    });
    
    // Clear search
    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        this.style.display = 'none';
        filterLessons();
    });
    
    // Filter functionality
    typeFilter.addEventListener('change', filterLessons);
    sortFilter.addEventListener('change', sortLessons);
    
    // View toggle
    viewToggle.addEventListener('click', function() {
        if (currentView === 'grid') {
            currentView = 'list';
            lessonGrid.classList.add('list-view');
            this.innerHTML = '<i class="fas fa-th-large"></i>';
            this.title = 'Chuyển sang dạng lưới';
        } else {
            currentView = 'grid';
            lessonGrid.classList.remove('list-view');
            this.innerHTML = '<i class="fas fa-list"></i>';
            this.title = 'Chuyển sang dạng danh sách';
        }
    });
    
    function filterLessons() {
        const query = searchInput.value.toLowerCase().trim();
        const typeValue = typeFilter.value;
        let visibleCount = 0;
        
        lessonCards.forEach(card => {
            const title = card.dataset.title;
            const type = card.dataset.type;
            
            const matchesSearch = !query || title.includes(query);
            const matchesType = typeValue === 'all' || type === typeValue;
            
            if (matchesSearch && matchesType) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide empty state
        if (visibleCount === 0) {
            emptyState.style.display = 'block';
            lessonGrid.style.display = 'none';
        } else {
            emptyState.style.display = 'none';
            lessonGrid.style.display = 'grid';
        }
    }
    
    function sortLessons() {
        const sortValue = sortFilter.value;
        const cardsArray = Array.from(lessonCards);
        
        cardsArray.sort((a, b) => {
            switch (sortValue) {
                case 'title':
                    return a.dataset.title.localeCompare(b.dataset.title);
                case 'chapter':
                    return a.dataset.chapter.localeCompare(b.dataset.chapter);
                case 'type':
                    return a.dataset.type.localeCompare(b.dataset.type);
                default:
                    return 0;
            }
        });
        
        // Re-append sorted cards
        cardsArray.forEach(card => {
            lessonGrid.appendChild(card);
        });
    }
    
    // Bookmark functionality
    const bookmarkBtns = document.querySelectorAll('.lesson-bookmark');
    bookmarkBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.add('bookmarked');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('bookmarked');
            }
        });
    });
    
    // Add hover effects
    lessonCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

function clearAllFilters() {
    document.getElementById('lessonSearch').value = '';
    document.getElementById('clearSearch').style.display = 'none';
    document.getElementById('typeFilter').value = 'all';
    document.getElementById('sortFilter').value = 'title';
    
    // Show all cards
    document.querySelectorAll('.lesson-card').forEach(card => {
        card.style.display = 'block';
    });
    
    document.getElementById('emptyState').style.display = 'none';
    document.getElementById('lessonGrid').style.display = 'grid';
}
</script>