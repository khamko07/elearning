<?php
		check_message(); 
		?> 
<?php
// Get students with additional statistics
$query = "SELECT s.*, 
          (SELECT COUNT(*) FROM tblstudentlesson sl WHERE sl.StudentID = s.StudentID) as lessons_enrolled,
          (SELECT AVG(sl.Progress) FROM tblstudentlesson sl WHERE sl.StudentID = s.StudentID) as avg_progress,
          (SELECT COUNT(*) FROM tblscore sc WHERE sc.StudentID = s.StudentID) as quiz_attempts,
          (SELECT AVG(sc.Score) FROM tblscore sc WHERE sc.StudentID = s.StudentID) as avg_score,
          (SELECT MAX(sl.DateTaken) FROM tblstudentlesson sl WHERE sl.StudentID = s.StudentID) as last_activity
          FROM `tblstudent` s 
          ORDER BY s.StudentID DESC";
$mydb->setQuery($query);
$students = $mydb->loadResultList();

// Get statistics
$totalStudents = count($students);
$activeStudents = 0;
$totalLessons = 0;
$totalQuizzes = 0;

foreach ($students as $student) {
    if ($student->lessons_enrolled > 0) $activeStudents++;
    $totalLessons += $student->lessons_enrolled;
    $totalQuizzes += $student->quiz_attempts;
}
?>

<div class="admin-student-management">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1 class="page-title">Quản lý học viên</h1>
            <p class="page-subtitle">Theo dõi tiến độ và quản lý thông tin học viên</p>
        </div>
        
        <div class="header-actions">
            <button class="btn btn-ghost" id="exportStudents">
                <i class="fas fa-download"></i>
                <span>Xuất danh sách</span>
            </button>
            <button class="btn btn-secondary" id="importStudents">
                <i class="fas fa-upload"></i>
                <span>Import học viên</span>
            </button>
            <a href="index.php?view=add" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                <span>Thêm học viên</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalStudents; ?></h3>
                <p>Tổng học viên</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $activeStudents; ?></h3>
                <p>Học viên hoạt động</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalLessons; ?></h3>
                <p>Lượt học bài</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalQuizzes; ?></h3>
                <p>Lượt làm quiz</p>
            </div>
        </div>
    </div>

    <!-- Student Analytics -->
    <div class="student-analytics">
        <div class="analytics-header">
            <h3 class="analytics-title">Phân tích học viên</h3>
            <div class="analytics-controls">
                <select class="filter-select" id="analyticsFilter">
                    <option value="all">Tất cả học viên</option>
                    <option value="active">Học viên hoạt động</option>
                    <option value="inactive">Học viên không hoạt động</option>
                    <option value="high-performers">Học viên xuất sắc</option>
                </select>
            </div>
        </div>
        
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="analytics-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="analytics-content">
                    <h4>Tiến độ trung bình</h4>
                    <div class="analytics-value">
                        <?php 
                        $avgProgress = 0;
                        $progressCount = 0;
                        foreach ($students as $student) {
                            if ($student->avg_progress > 0) {
                                $avgProgress += $student->avg_progress;
                                $progressCount++;
                            }
                        }
                        echo $progressCount > 0 ? round($avgProgress / $progressCount, 1) : 0;
                        ?>%
                    </div>
                    <div class="analytics-description">Tiến độ học tập trung bình của tất cả học viên</div>
                </div>
            </div>
            
            <div class="analytics-card">
                <div class="analytics-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="analytics-content">
                    <h4>Điểm trung bình</h4>
                    <div class="analytics-value">
                        <?php 
                        $avgScore = 0;
                        $scoreCount = 0;
                        foreach ($students as $student) {
                            if ($student->avg_score > 0) {
                                $avgScore += $student->avg_score;
                                $scoreCount++;
                            }
                        }
                        echo $scoreCount > 0 ? round(($avgScore / $scoreCount) * 100, 1) : 0;
                        ?>%
                    </div>
                    <div class="analytics-description">Điểm số trung bình trong các bài quiz</div>
                </div>
            </div>
            
            <div class="analytics-card">
                <div class="analytics-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="analytics-content">
                    <h4>Tỷ lệ hoạt động</h4>
                    <div class="analytics-value">
                        <?php echo $totalStudents > 0 ? round(($activeStudents / $totalStudents) * 100, 1) : 0; ?>%
                    </div>
                    <div class="analytics-description">Tỷ lệ học viên có hoạt động học tập</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="table-controls">
        <div class="search-section">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Tìm kiếm học viên..." id="studentSearch">
                <button class="search-clear" id="clearSearch" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Trạng thái:</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">Tất cả</option>
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Tiến độ:</label>
                <select class="filter-select" id="progressFilter">
                    <option value="">Tất cả</option>
                    <option value="high">Cao (>80%)</option>
                    <option value="medium">Trung bình (40-80%)</option>
                    <option value="low">Thấp (<40%)</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Hiển thị:</label>
                <select class="filter-select" id="entriesPerPage">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
        <div class="bulk-info">
            <span id="selectedCount">0</span> học viên được chọn
        </div>
        <div class="bulk-buttons">
            <button class="btn btn-secondary" id="bulkMessage">
                <i class="fas fa-envelope"></i>
                <span>Gửi thông báo</span>
            </button>
            <button class="btn btn-warning" id="bulkExport">
                <i class="fas fa-download"></i>
                <span>Xuất file</span>
            </button>
            <button class="btn btn-info" id="bulkProgress">
                <i class="fas fa-chart-line"></i>
                <span>Xem tiến độ</span>
            </button>
            <button class="btn btn-danger" id="bulkDelete">
                <i class="fas fa-user-times"></i>
                <span>Vô hiệu hóa</span>
            </button>
        </div>
    </div>

    <!-- Students Table -->
    <div class="modern-table-container">
        <form action="controller.php?action=delete" method="POST" id="studentsForm">
            <div class="table-wrapper">
                <table class="modern-table" id="studentsTable">
                    <thead>
                        <tr>
                            <th class="checkbox-column">
                                <label class="checkbox-container">
                                    <input type="checkbox" id="selectAll">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th class="sortable" data-sort="name">
                                <span>Học viên</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="contact">
                                <span>Liên hệ</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="lessons">
                                <span>Bài học</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="progress">
                                <span>Tiến độ</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="score">
                                <span>Điểm TB</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="activity">
                                <span>Hoạt động gần nhất</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="actions-column">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)): ?>
                            <?php foreach ($students as $index => $student): ?>
                                <?php
                                $fullName = trim($student->Fname . ' ' . $student->Lname);
                                $progress = $student->avg_progress ? round($student->avg_progress, 1) : 0;
                                $score = $student->avg_score ? round($student->avg_score * 100, 1) : 0;
                                $isActive = $student->lessons_enrolled > 0;
                                $lastActivity = $student->last_activity ? date('d/m/Y', strtotime($student->last_activity)) : 'Chưa có';
                                ?>
                                <tr class="student-row" 
                                    data-name="<?php echo strtolower($fullName); ?>"
                                    data-lessons="<?php echo $student->lessons_enrolled; ?>"
                                    data-progress="<?php echo $progress; ?>"
                                    data-score="<?php echo $score; ?>"
                                    data-status="<?php echo $isActive ? 'active' : 'inactive'; ?>"
                                    data-activity="<?php echo $student->last_activity ?: ''; ?>">
                                    
                                    <td class="checkbox-column">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="selected_students[]" value="<?php echo $student->StudentID; ?>" class="student-checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    
                                    <td class="student-cell">
                                        <div class="student-info">
                                            <div class="student-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="student-details">
                                                <h4 class="student-name"><?php echo htmlspecialchars($fullName); ?></h4>
                                                <div class="student-meta">
                                                    <span class="student-id">ID: <?php echo $student->StudentID; ?></span>
                                                    <span class="student-status <?php echo $isActive ? 'active' : 'inactive'; ?>">
                                                        <i class="fas fa-circle"></i>
                                                        <?php echo $isActive ? 'Hoạt động' : 'Không hoạt động'; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="contact-cell">
                                        <div class="contact-info">
                                            <?php if (!empty($student->Address)): ?>
                                                <div class="contact-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span><?php echo htmlspecialchars($student->Address); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($student->MobileNo)): ?>
                                                <div class="contact-item">
                                                    <i class="fas fa-phone"></i>
                                                    <span><?php echo htmlspecialchars($student->MobileNo); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td class="lessons-cell">
                                        <div class="lessons-count">
                                            <div class="count-display">
                                                <i class="fas fa-book"></i>
                                                <span class="count-number"><?php echo $student->lessons_enrolled; ?></span>
                                            </div>
                                            <div class="count-label">bài học</div>
                                        </div>
                                    </td>
                                    
                                    <td class="progress-cell">
                                        <div class="progress-display">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
                                            </div>
                                            <span class="progress-text"><?php echo $progress; ?>%</span>
                                        </div>
                                    </td>
                                    
                                    <td class="score-cell">
                                        <div class="score-display">
                                            <div class="score-badge <?php 
                                                if ($score >= 80) echo 'excellent';
                                                elseif ($score >= 60) echo 'good';
                                                elseif ($score > 0) echo 'average';
                                                else echo 'no-score';
                                            ?>">
                                                <?php echo $score > 0 ? $score . '%' : 'N/A'; ?>
                                            </div>
                                            <div class="quiz-count">
                                                <?php echo $student->quiz_attempts; ?> quiz
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="activity-cell">
                                        <div class="activity-info">
                                            <div class="activity-date"><?php echo $lastActivity; ?></div>
                                            <?php if ($student->last_activity): ?>
                                                <div class="activity-time">
                                                    <?php 
                                                    $daysDiff = floor((time() - strtotime($student->last_activity)) / (60 * 60 * 24));
                                                    if ($daysDiff == 0) echo 'Hôm nay';
                                                    elseif ($daysDiff == 1) echo 'Hôm qua';
                                                    elseif ($daysDiff < 7) echo $daysDiff . ' ngày trước';
                                                    elseif ($daysDiff < 30) echo floor($daysDiff / 7) . ' tuần trước';
                                                    else echo floor($daysDiff / 30) . ' tháng trước';
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td class="actions-cell">
                                        <div class="action-buttons">
                                            <a href="index.php?view=view&id=<?php echo $student->StudentID; ?>" class="btn btn-ghost btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-ghost btn-sm" onclick="viewProgress(<?php echo $student->StudentID; ?>)" title="Xem tiến độ">
                                                <i class="fas fa-chart-line"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-ghost btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="index.php?view=edit&id=<?php echo $student->StudentID; ?>">
                                                        <i class="fas fa-edit"></i> Chỉnh sửa
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="sendMessage(<?php echo $student->StudentID; ?>)">
                                                        <i class="fas fa-envelope"></i> Gửi thông báo
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="resetProgress(<?php echo $student->StudentID; ?>)">
                                                        <i class="fas fa-redo"></i> Reset tiến độ
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deactivateStudent(<?php echo $student->StudentID; ?>, '<?php echo htmlspecialchars($fullName); ?>')">
                                                        <i class="fas fa-user-times"></i> Vô hiệu hóa
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="empty-row">
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h3 class="empty-title">Chưa có học viên nào</h3>
                                        <p class="empty-description">Bắt đầu bằng cách thêm học viên đầu tiên</p>
                                        <a href="index.php?view=add" class="btn btn-primary">
                                            <i class="fas fa-user-plus"></i>
                                            <span>Thêm học viên</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Pagination -->
    <div class="table-pagination" id="tablePagination">
        <div class="pagination-info">
            Hiển thị <span id="showingStart">1</span> - <span id="showingEnd">25</span> trong tổng số <span id="totalEntries"><?php echo $totalStudents; ?></span> học viên
        </div>
        <div class="pagination-controls">
            <button class="btn btn-ghost btn-sm" id="prevPage" disabled>
                <i class="fas fa-chevron-left"></i>
                <span>Trước</span>
            </button>
            <div class="page-numbers" id="pageNumbers">
                <button class="page-btn active" data-page="1">1</button>
            </div>
            <button class="btn btn-ghost btn-sm" id="nextPage">
                <span>Sau</span>
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Student Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-chart-line"></i>
                    Tiến độ học tập
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="progressContent">
                <!-- Progress content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="exportProgress">
                    <i class="fas fa-download"></i>
                    <span>Xuất báo cáo</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize student management
    initializeStudentManagement();
    
    function initializeStudentManagement() {
        setupSearch();
        setupFilters();
        setupSorting();
        setupBulkActions();
        setupPagination();
        setupAnalytics();
    }
    
    function setupSearch() {
        const searchInput = document.getElementById('studentSearch');
        const clearSearch = document.getElementById('clearSearch');
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            if (query) {
                clearSearch.style.display = 'block';
            } else {
                clearSearch.style.display = 'none';
            }
            
            filterTable();
        });
        
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            this.style.display = 'none';
            filterTable();
        });
    }
    
    function setupFilters() {
        const statusFilter = document.getElementById('statusFilter');
        const progressFilter = document.getElementById('progressFilter');
        const entriesPerPage = document.getElementById('entriesPerPage');
        
        [statusFilter, progressFilter, entriesPerPage].forEach(filter => {
            filter.addEventListener('change', filterTable);
        });
    }
    
    function setupSorting() {
        const sortableHeaders = document.querySelectorAll('.sortable');
        let currentSort = { column: '', direction: 'asc' };
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.sort;
                
                if (currentSort.column === column) {
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort.column = column;
                    currentSort.direction = 'asc';
                }
                
                // Update sort icons
                sortableHeaders.forEach(h => {
                    const icon = h.querySelector('.sort-icon');
                    icon.className = 'fas fa-sort sort-icon';
                });
                
                const activeIcon = this.querySelector('.sort-icon');
                activeIcon.className = `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'} sort-icon active`;
                
                sortTable(column, currentSort.direction);
            });
        });
    }
    
    function setupBulkActions() {
        const selectAll = document.getElementById('selectAll');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        
        selectAll.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
        
        studentCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });
        
        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            const count = checkedBoxes.length;
            
            if (count > 0) {
                bulkActionsBar.style.display = 'flex';
                selectedCount.textContent = count;
            } else {
                bulkActionsBar.style.display = 'none';
            }
            
            selectAll.indeterminate = count > 0 && count < studentCheckboxes.length;
            selectAll.checked = count === studentCheckboxes.length;
        }
    }
    
    function setupAnalytics() {
        const analyticsFilter = document.getElementById('analyticsFilter');
        
        analyticsFilter.addEventListener('change', function() {
            const filter = this.value;
            updateAnalytics(filter);
        });
    }
    
    function filterTable() {
        const searchQuery = document.getElementById('studentSearch').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const progressFilter = document.getElementById('progressFilter').value;
        const rows = document.querySelectorAll('.student-row');
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const name = row.dataset.name;
            const status = row.dataset.status;
            const progress = parseFloat(row.dataset.progress);
            
            const matchesSearch = !searchQuery || name.includes(searchQuery);
            const matchesStatus = !statusFilter || status === statusFilter;
            
            let matchesProgress = true;
            if (progressFilter === 'high') matchesProgress = progress > 80;
            else if (progressFilter === 'medium') matchesProgress = progress >= 40 && progress <= 80;
            else if (progressFilter === 'low') matchesProgress = progress < 40;
            
            if (matchesSearch && matchesStatus && matchesProgress) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        updatePagination(visibleCount);
    }
    
    function sortTable(column, direction) {
        const tbody = document.querySelector('#studentsTable tbody');
        const rows = Array.from(tbody.querySelectorAll('.student-row'));
        
        rows.sort((a, b) => {
            let aVal, bVal;
            
            switch (column) {
                case 'name':
                    aVal = a.dataset.name;
                    bVal = b.dataset.name;
                    break;
                case 'lessons':
                    aVal = parseInt(a.dataset.lessons);
                    bVal = parseInt(b.dataset.lessons);
                    break;
                case 'progress':
                    aVal = parseFloat(a.dataset.progress);
                    bVal = parseFloat(b.dataset.progress);
                    break;
                case 'score':
                    aVal = parseFloat(a.dataset.score);
                    bVal = parseFloat(b.dataset.score);
                    break;
                case 'activity':
                    aVal = new Date(a.dataset.activity || '1970-01-01');
                    bVal = new Date(b.dataset.activity || '1970-01-01');
                    break;
                default:
                    return 0;
            }
            
            if (typeof aVal === 'string') {
                return direction === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
            } else {
                return direction === 'asc' ? aVal - bVal : bVal - aVal;
            }
        });
        
        rows.forEach(row => tbody.appendChild(row));
    }
    
    function setupPagination() {
        // Pagination logic would be implemented here
    }
    
    function updatePagination(visibleCount) {
        document.getElementById('totalEntries').textContent = visibleCount;
        document.getElementById('showingEnd').textContent = Math.min(25, visibleCount);
    }
    
    function updateAnalytics(filter) {
        // Update analytics based on filter
        console.log('Update analytics for filter:', filter);
    }
    
    // Global functions for actions
    window.viewProgress = function(studentId) {
        // Load student progress
        fetch(`controller.php?action=progress&id=${studentId}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('progressContent').innerHTML = html;
                new bootstrap.Modal(document.getElementById('progressModal')).show();
            })
            .catch(error => {
                console.error('Error loading progress:', error);
                alert('Không thể tải tiến độ học viên');
            });
    };
    
    window.sendMessage = function(studentId) {
        // Send message to student
        const message = prompt('Nhập nội dung thông báo:');
        if (message) {
            // Send message logic
            alert('Thông báo đã được gửi!');
        }
    };
    
    window.resetProgress = function(studentId) {
        if (confirm('Bạn có chắc chắn muốn reset tiến độ học tập của học viên này?')) {
            // Reset progress logic
            window.location.href = `controller.php?action=resetProgress&id=${studentId}`;
        }
    };
    
    window.deactivateStudent = function(studentId, studentName) {
        if (confirm(`Bạn có chắc chắn muốn vô hiệu hóa học viên: "${studentName}"?`)) {
            window.location.href = `controller.php?action=deactivate&id=${studentId}`;
        }
    };
});
</script> 