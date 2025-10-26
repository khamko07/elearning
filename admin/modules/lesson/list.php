<?php
	if(!isset($_SESSION['USERID'])){
	redirect(web_root."admin/index.php");
}

?>

<?php
// Get lessons with additional statistics
$mydb->setQuery("SELECT l.*, 
                 (SELECT COUNT(*) FROM tblstudentlesson sl WHERE sl.LessonID = l.LessonID) as student_count,
                 (SELECT AVG(sl.Progress) FROM tblstudentlesson sl WHERE sl.LessonID = l.LessonID) as avg_progress
                 FROM tbllesson l 
                 ORDER BY l.LessonChapter, l.LessonTitle");
$lessons = $mydb->loadResultList();

// Get total statistics
$totalLessons = count($lessons);
$videoLessons = 0;
$pdfLessons = 0;
$totalStudents = 0;

foreach ($lessons as $lesson) {
    if ($lesson->Category == 'Video') $videoLessons++;
    else $pdfLessons++;
    $totalStudents += $lesson->student_count;
}
?>

<div class="admin-lesson-management">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1 class="page-title">Quản lý bài học</h1>
            <p class="page-subtitle">Tổng quan và quản lý tất cả bài học trong hệ thống</p>
        </div>
        
        <div class="header-actions">
            <button class="btn btn-ghost" id="bulkActionsBtn" style="display: none;">
                <i class="fas fa-tasks"></i>
                <span>Thao tác hàng loạt</span>
            </button>
            <a href="index.php?view=add" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Thêm bài học</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalLessons; ?></h3>
                <p>Tổng bài học</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $videoLessons; ?></h3>
                <p>Video bài học</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $pdfLessons; ?></h3>
                <p>Tài liệu PDF</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalStudents; ?></h3>
                <p>Lượt học</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="table-controls">
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
                    <option value="">Tất cả</option>
                    <option value="Video">Video</option>
                    <option value="PDF">PDF</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Chương:</label>
                <select class="filter-select" id="chapterFilter">
                    <option value="">Tất cả chương</option>
                    <?php
                    $chapters = array_unique(array_column($lessons, 'LessonChapter'));
                    sort($chapters);
                    foreach ($chapters as $chapter) {
                        echo "<option value='{$chapter}'>{$chapter}</option>";
                    }
                    ?>
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
            <span id="selectedCount">0</span> bài học được chọn
        </div>
        <div class="bulk-buttons">
            <button class="btn btn-secondary" id="bulkEdit">
                <i class="fas fa-edit"></i>
                <span>Chỉnh sửa</span>
            </button>
            <button class="btn btn-warning" id="bulkExport">
                <i class="fas fa-download"></i>
                <span>Xuất file</span>
            </button>
            <button class="btn btn-danger" id="bulkDelete">
                <i class="fas fa-trash"></i>
                <span>Xóa</span>
            </button>
        </div>
    </div>

    <!-- Lessons Table -->
    <div class="modern-table-container">
        <form action="controller.php?action=delete" method="POST" id="lessonsForm">
            <div class="table-wrapper">
                <table class="modern-table" id="lessonsTable">
                    <thead>
                        <tr>
                            <th class="checkbox-column">
                                <label class="checkbox-container">
                                    <input type="checkbox" id="selectAll">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th class="sortable" data-sort="chapter">
                                <span>Chương</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="title">
                                <span>Tiêu đề</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="type">
                                <span>Loại</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="students">
                                <span>Học viên</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="progress">
                                <span>Tiến độ TB</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="actions-column">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($lessons)): ?>
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <?php
                                $viewUrl = ($lesson->Category == "Video") 
                                    ? "index.php?view=playvideo&id={$lesson->LessonID}"
                                    : "index.php?view=viewpdf&id={$lesson->LessonID}";
                                $avgProgress = $lesson->avg_progress ? round($lesson->avg_progress, 1) : 0;
                                ?>
                                <tr class="lesson-row" 
                                    data-chapter="<?php echo strtolower($lesson->LessonChapter); ?>"
                                    data-title="<?php echo strtolower($lesson->LessonTitle); ?>"
                                    data-type="<?php echo $lesson->Category; ?>"
                                    data-students="<?php echo $lesson->student_count; ?>"
                                    data-progress="<?php echo $avgProgress; ?>">
                                    
                                    <td class="checkbox-column">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="selected_lessons[]" value="<?php echo $lesson->LessonID; ?>" class="lesson-checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    
                                    <td class="chapter-cell">
                                        <div class="chapter-badge">
                                            <?php echo htmlspecialchars($lesson->LessonChapter); ?>
                                        </div>
                                    </td>
                                    
                                    <td class="title-cell">
                                        <div class="lesson-info">
                                            <h4 class="lesson-title"><?php echo htmlspecialchars($lesson->LessonTitle); ?></h4>
                                            <div class="lesson-meta">
                                                <span class="lesson-id">ID: <?php echo $lesson->LessonID; ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="type-cell">
                                        <div class="type-badge <?php echo strtolower($lesson->Category); ?>">
                                            <?php if ($lesson->Category == 'Video'): ?>
                                                <i class="fas fa-play-circle"></i>
                                            <?php else: ?>
                                                <i class="fas fa-file-pdf"></i>
                                            <?php endif; ?>
                                            <span><?php echo $lesson->Category; ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="students-cell">
                                        <div class="student-count">
                                            <i class="fas fa-users"></i>
                                            <span><?php echo $lesson->student_count; ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="progress-cell">
                                        <div class="progress-display">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: <?php echo $avgProgress; ?>%"></div>
                                            </div>
                                            <span class="progress-text"><?php echo $avgProgress; ?>%</span>
                                        </div>
                                    </td>
                                    
                                    <td class="actions-cell">
                                        <div class="action-buttons">
                                            <a href="<?php echo $viewUrl; ?>" class="btn btn-ghost btn-sm" title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="index.php?view=edit&id=<?php echo $lesson->LessonID; ?>" class="btn btn-ghost btn-sm" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="index.php?view=uploadfile&id=<?php echo $lesson->LessonID; ?>" class="btn btn-ghost btn-sm" title="Thay đổi file">
                                                <i class="fas fa-upload"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-ghost btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="duplicateLesson(<?php echo $lesson->LessonID; ?>)">
                                                        <i class="fas fa-copy"></i> Nhân bản
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="exportLesson(<?php echo $lesson->LessonID; ?>)">
                                                        <i class="fas fa-download"></i> Xuất file
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteLesson(<?php echo $lesson->LessonID; ?>, '<?php echo htmlspecialchars($lesson->LessonTitle); ?>')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="empty-row">
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <h3 class="empty-title">Chưa có bài học nào</h3>
                                        <p class="empty-description">Bắt đầu bằng cách thêm bài học đầu tiên</p>
                                        <a href="index.php?view=add" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                            <span>Thêm bài học</span>
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
            Hiển thị <span id="showingStart">1</span> - <span id="showingEnd">25</span> trong tổng số <span id="totalEntries"><?php echo $totalLessons; ?></span> bài học
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

<!-- File Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Tải lên file bài học
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h4>Kéo thả file vào đây</h4>
                    <p>hoặc <button class="btn btn-link" id="browseFiles">chọn file từ máy tính</button></p>
                    <input type="file" id="fileInput" multiple accept=".pdf,.mp4,.avi,.mov" style="display: none;">
                    <div class="upload-info">
                        <small>Hỗ trợ: PDF, MP4, AVI, MOV (tối đa 100MB)</small>
                    </div>
                </div>
                <div class="upload-progress" id="uploadProgress" style="display: none;">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>
                    <div class="progress-text" id="progressText">0%</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="startUpload" disabled>Tải lên</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize lesson management
    initializeLessonManagement();
    
    function initializeLessonManagement() {
        setupSearch();
        setupFilters();
        setupSorting();
        setupBulkActions();
        setupPagination();
        setupFileUpload();
    }
    
    function setupSearch() {
        const searchInput = document.getElementById('lessonSearch');
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
        const typeFilter = document.getElementById('typeFilter');
        const chapterFilter = document.getElementById('chapterFilter');
        const entriesPerPage = document.getElementById('entriesPerPage');
        
        [typeFilter, chapterFilter, entriesPerPage].forEach(filter => {
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
        const lessonCheckboxes = document.querySelectorAll('.lesson-checkbox');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const bulkActionsBtn = document.getElementById('bulkActionsBtn');
        const selectedCount = document.getElementById('selectedCount');
        
        selectAll.addEventListener('change', function() {
            lessonCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
        
        lessonCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });
        
        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.lesson-checkbox:checked');
            const count = checkedBoxes.length;
            
            if (count > 0) {
                bulkActionsBar.style.display = 'flex';
                bulkActionsBtn.style.display = 'flex';
                selectedCount.textContent = count;
            } else {
                bulkActionsBar.style.display = 'none';
                bulkActionsBtn.style.display = 'none';
            }
            
            selectAll.indeterminate = count > 0 && count < lessonCheckboxes.length;
            selectAll.checked = count === lessonCheckboxes.length;
        }
        
        // Bulk action handlers
        document.getElementById('bulkDelete').addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.lesson-checkbox:checked');
            if (checkedBoxes.length > 0) {
                if (confirm(`Bạn có chắc chắn muốn xóa ${checkedBoxes.length} bài học đã chọn?`)) {
                    document.getElementById('lessonsForm').submit();
                }
            }
        });
    }
    
    function filterTable() {
        const searchQuery = document.getElementById('lessonSearch').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value;
        const chapterFilter = document.getElementById('chapterFilter').value;
        const rows = document.querySelectorAll('.lesson-row');
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const title = row.dataset.title;
            const chapter = row.dataset.chapter;
            const type = row.dataset.type;
            
            const matchesSearch = !searchQuery || title.includes(searchQuery) || chapter.includes(searchQuery);
            const matchesType = !typeFilter || type === typeFilter;
            const matchesChapter = !chapterFilter || row.querySelector('.chapter-badge').textContent === chapterFilter;
            
            if (matchesSearch && matchesType && matchesChapter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update pagination
        updatePagination(visibleCount);
    }
    
    function sortTable(column, direction) {
        const tbody = document.querySelector('#lessonsTable tbody');
        const rows = Array.from(tbody.querySelectorAll('.lesson-row'));
        
        rows.sort((a, b) => {
            let aVal, bVal;
            
            switch (column) {
                case 'chapter':
                    aVal = a.dataset.chapter;
                    bVal = b.dataset.chapter;
                    break;
                case 'title':
                    aVal = a.dataset.title;
                    bVal = b.dataset.title;
                    break;
                case 'type':
                    aVal = a.dataset.type;
                    bVal = b.dataset.type;
                    break;
                case 'students':
                    aVal = parseInt(a.dataset.students);
                    bVal = parseInt(b.dataset.students);
                    break;
                case 'progress':
                    aVal = parseFloat(a.dataset.progress);
                    bVal = parseFloat(b.dataset.progress);
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
        // For now, we'll just show basic pagination
    }
    
    function updatePagination(visibleCount) {
        document.getElementById('totalEntries').textContent = visibleCount;
        document.getElementById('showingEnd').textContent = Math.min(25, visibleCount);
    }
    
    function setupFileUpload() {
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const browseFiles = document.getElementById('browseFiles');
        
        browseFiles.addEventListener('click', () => fileInput.click());
        
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            handleFiles(files);
        });
        
        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });
        
        function handleFiles(files) {
            // File handling logic would be implemented here
            console.log('Files selected:', files);
        }
    }
    
    // Global functions for actions
    window.deleteLesson = function(id, title) {
        if (confirm(`Bạn có chắc chắn muốn xóa bài học "${title}"?`)) {
            window.location.href = `controller.php?action=delete&id=${id}`;
        }
    };
    
    window.duplicateLesson = function(id) {
        // Duplicate lesson logic
        console.log('Duplicate lesson:', id);
    };
    
    window.exportLesson = function(id) {
        // Export lesson logic
        console.log('Export lesson:', id);
    };
});
</script>
	 