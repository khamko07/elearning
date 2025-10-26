<?php
	 if (!isset($_SESSION['USERID'])){
      redirect(web_root."admin/index.php");
     }

?>
<?php
// Get exercises with additional statistics
$mydb->setQuery("SELECT e.*, c.CategoryName, t.TopicName,
                 (SELECT COUNT(*) FROM tblscore s WHERE s.ExerciseID = e.ExerciseID) as attempt_count,
                 (SELECT AVG(s.Score) FROM tblscore s WHERE s.ExerciseID = e.ExerciseID) as avg_score
                 FROM `tblexercise` e 
                 LEFT JOIN `tblcategories` c ON e.CategoryID = c.CategoryID 
                 LEFT JOIN `tbltopics` t ON e.TopicID = t.TopicID 
                 ORDER BY c.CategoryName, t.TopicName, e.ExerciseID DESC");
$exercises = $mydb->loadResultList();

// Get statistics
$totalQuestions = count($exercises);
$categories = array_unique(array_filter(array_column($exercises, 'CategoryName')));
$topics = array_unique(array_filter(array_column($exercises, 'TopicName')));
$totalAttempts = array_sum(array_column($exercises, 'attempt_count'));
?>

<div class="admin-exercise-management">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1 class="page-title">Quản lý câu hỏi</h1>
            <p class="page-subtitle">Tạo, chỉnh sửa và tổ chức ngân hàng câu hỏi</p>
        </div>
        
        <div class="header-actions">
            <a href="index.php" class="btn btn-ghost">
                <i class="fas fa-arrow-left"></i>
                <span>Về danh mục</span>
            </a>
            <a href="index.php?view=categories" class="btn btn-secondary">
                <i class="fas fa-cog"></i>
                <span>Quản lý danh mục</span>
            </a>
            <a href="index.php?view=add" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Thêm câu hỏi</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalQuestions; ?></h3>
                <p>Tổng câu hỏi</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-folder"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo count($categories); ?></h3>
                <p>Danh mục</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo count($topics); ?></h3>
                <p>Chủ đề</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $totalAttempts; ?></h3>
                <p>Lượt làm bài</p>
            </div>
        </div>
    </div>

    <!-- Question Bank Organization -->
    <div class="question-bank-nav">
        <div class="bank-tabs">
            <button class="bank-tab active" data-view="all">
                <i class="fas fa-list"></i>
                <span>Tất cả câu hỏi</span>
                <span class="tab-count"><?php echo $totalQuestions; ?></span>
            </button>
            <button class="bank-tab" data-view="categories">
                <i class="fas fa-folder-open"></i>
                <span>Theo danh mục</span>
                <span class="tab-count"><?php echo count($categories); ?></span>
            </button>
            <button class="bank-tab" data-view="topics">
                <i class="fas fa-tags"></i>
                <span>Theo chủ đề</span>
                <span class="tab-count"><?php echo count($topics); ?></span>
            </button>
            <button class="bank-tab" data-view="recent">
                <i class="fas fa-clock"></i>
                <span>Gần đây</span>
            </button>
        </div>
        
        <div class="bank-actions">
            <button class="btn btn-ghost" id="importQuestions">
                <i class="fas fa-upload"></i>
                <span>Import</span>
            </button>
            <button class="btn btn-ghost" id="exportQuestions">
                <i class="fas fa-download"></i>
                <span>Export</span>
            </button>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="table-controls">
        <div class="search-section">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Tìm kiếm câu hỏi..." id="questionSearch">
                <button class="search-clear" id="clearSearch" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Danh mục:</label>
                <select class="filter-select" id="categoryFilter">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Chủ đề:</label>
                <select class="filter-select" id="topicFilter">
                    <option value="">Tất cả chủ đề</option>
                    <?php foreach ($topics as $topic): ?>
                        <option value="<?php echo htmlspecialchars($topic); ?>"><?php echo htmlspecialchars($topic); ?></option>
                    <?php endforeach; ?>
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
            <span id="selectedCount">0</span> câu hỏi được chọn
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
            <button class="btn btn-info" id="bulkDuplicate">
                <i class="fas fa-copy"></i>
                <span>Nhân bản</span>
            </button>
            <button class="btn btn-danger" id="bulkDelete">
                <i class="fas fa-trash"></i>
                <span>Xóa</span>
            </button>
        </div>
    </div>

    <!-- Questions Table -->
    <div class="modern-table-container">
        <form action="controller.php?action=delete" method="POST" id="questionsForm">
            <div class="table-wrapper">
                <table class="modern-table" id="questionsTable">
                    <thead>
                        <tr>
                            <th class="checkbox-column">
                                <label class="checkbox-container">
                                    <input type="checkbox" id="selectAll">
                                    <span class="checkmark"></span>
                                </label>
                            </th>
                            <th class="sortable" data-sort="category">
                                <span>Danh mục</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="topic">
                                <span>Chủ đề</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="question-column sortable" data-sort="question">
                                <span>Câu hỏi</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="answer">
                                <span>Đáp án</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="attempts">
                                <span>Lượt làm</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-sort="accuracy">
                                <span>Độ chính xác</span>
                                <i class="fas fa-sort sort-icon"></i>
                            </th>
                            <th class="actions-column">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($exercises)): ?>
                            <?php foreach ($exercises as $index => $exercise): ?>
                                <?php
                                $accuracy = $exercise->attempt_count > 0 ? round(($exercise->avg_score * 100), 1) : 0;
                                $questionPreview = strlen($exercise->Question) > 80 ? substr($exercise->Question, 0, 80) . '...' : $exercise->Question;
                                ?>
                                <tr class="question-row" 
                                    data-category="<?php echo strtolower($exercise->CategoryName ?: ''); ?>"
                                    data-topic="<?php echo strtolower($exercise->TopicName ?: ''); ?>"
                                    data-question="<?php echo strtolower($exercise->Question); ?>"
                                    data-answer="<?php echo $exercise->Answer; ?>"
                                    data-attempts="<?php echo $exercise->attempt_count; ?>"
                                    data-accuracy="<?php echo $accuracy; ?>">
                                    
                                    <td class="checkbox-column">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="selected_questions[]" value="<?php echo $exercise->ExerciseID; ?>" class="question-checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    
                                    <td class="category-cell">
                                        <div class="category-badge">
                                            <?php echo htmlspecialchars($exercise->CategoryName ?: 'Chưa phân loại'); ?>
                                        </div>
                                    </td>
                                    
                                    <td class="topic-cell">
                                        <div class="topic-badge">
                                            <?php echo htmlspecialchars($exercise->TopicName ?: 'Chưa có chủ đề'); ?>
                                        </div>
                                    </td>
                                    
                                    <td class="question-cell">
                                        <div class="question-content">
                                            <div class="question-text" title="<?php echo htmlspecialchars($exercise->Question); ?>">
                                                <?php echo htmlspecialchars($questionPreview); ?>
                                            </div>
                                            <div class="question-meta">
                                                <span class="question-id">ID: <?php echo $exercise->ExerciseID; ?></span>
                                                <button class="btn btn-ghost btn-xs preview-btn" onclick="previewQuestion(<?php echo $exercise->ExerciseID; ?>)">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Xem trước</span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="answer-cell">
                                        <div class="answer-badge answer-<?php echo strtolower($exercise->Answer); ?>">
                                            <?php echo $exercise->Answer; ?>
                                        </div>
                                    </td>
                                    
                                    <td class="attempts-cell">
                                        <div class="attempts-count">
                                            <i class="fas fa-users"></i>
                                            <span><?php echo $exercise->attempt_count; ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="accuracy-cell">
                                        <div class="accuracy-display">
                                            <div class="accuracy-bar">
                                                <div class="accuracy-fill" style="width: <?php echo $accuracy; ?>%"></div>
                                            </div>
                                            <span class="accuracy-text"><?php echo $accuracy; ?>%</span>
                                        </div>
                                    </td>
                                    
                                    <td class="actions-cell">
                                        <div class="action-buttons">
                                            <button class="btn btn-ghost btn-sm" onclick="previewQuestion(<?php echo $exercise->ExerciseID; ?>)" title="Xem trước">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="index.php?view=edit&id=<?php echo $exercise->ExerciseID; ?>" class="btn btn-ghost btn-sm" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-ghost btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="duplicateQuestion(<?php echo $exercise->ExerciseID; ?>)">
                                                        <i class="fas fa-copy"></i> Nhân bản
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="exportQuestion(<?php echo $exercise->ExerciseID; ?>)">
                                                        <i class="fas fa-download"></i> Xuất file
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="viewStatistics(<?php echo $exercise->ExerciseID; ?>)">
                                                        <i class="fas fa-chart-bar"></i> Thống kê
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteQuestion(<?php echo $exercise->ExerciseID; ?>, '<?php echo htmlspecialchars($questionPreview); ?>')">
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
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <h3 class="empty-title">Chưa có câu hỏi nào</h3>
                                        <p class="empty-description">Bắt đầu bằng cách thêm câu hỏi đầu tiên</p>
                                        <a href="index.php?view=add" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                            <span>Thêm câu hỏi</span>
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
            Hiển thị <span id="showingStart">1</span> - <span id="showingEnd">25</span> trong tổng số <span id="totalEntries"><?php echo $totalQuestions; ?></span> câu hỏi
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

<!-- Question Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i>
                    Xem trước câu hỏi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="editFromPreview">
                    <i class="fas fa-edit"></i>
                    <span>Chỉnh sửa</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize exercise management
    initializeExerciseManagement();
    
    function initializeExerciseManagement() {
        setupSearch();
        setupFilters();
        setupSorting();
        setupBulkActions();
        setupQuestionBank();
        setupPagination();
    }
    
    function setupSearch() {
        const searchInput = document.getElementById('questionSearch');
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
        const categoryFilter = document.getElementById('categoryFilter');
        const topicFilter = document.getElementById('topicFilter');
        const entriesPerPage = document.getElementById('entriesPerPage');
        
        [categoryFilter, topicFilter, entriesPerPage].forEach(filter => {
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
        const questionCheckboxes = document.querySelectorAll('.question-checkbox');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        
        selectAll.addEventListener('change', function() {
            questionCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
        
        questionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });
        
        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.question-checkbox:checked');
            const count = checkedBoxes.length;
            
            if (count > 0) {
                bulkActionsBar.style.display = 'flex';
                selectedCount.textContent = count;
            } else {
                bulkActionsBar.style.display = 'none';
            }
            
            selectAll.indeterminate = count > 0 && count < questionCheckboxes.length;
            selectAll.checked = count === questionCheckboxes.length;
        }
        
        // Bulk action handlers
        document.getElementById('bulkDelete').addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.question-checkbox:checked');
            if (checkedBoxes.length > 0) {
                if (confirm(`Bạn có chắc chắn muốn xóa ${checkedBoxes.length} câu hỏi đã chọn?`)) {
                    document.getElementById('questionsForm').submit();
                }
            }
        });
    }
    
    function setupQuestionBank() {
        const bankTabs = document.querySelectorAll('.bank-tab');
        
        bankTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                bankTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.dataset.view;
                filterByView(view);
            });
        });
    }
    
    function filterByView(view) {
        // Implement view-specific filtering logic
        console.log('Filter by view:', view);
    }
    
    function filterTable() {
        const searchQuery = document.getElementById('questionSearch').value.toLowerCase();
        const categoryFilter = document.getElementById('categoryFilter').value;
        const topicFilter = document.getElementById('topicFilter').value;
        const rows = document.querySelectorAll('.question-row');
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const question = row.dataset.question;
            const category = row.dataset.category;
            const topic = row.dataset.topic;
            
            const matchesSearch = !searchQuery || question.includes(searchQuery);
            const matchesCategory = !categoryFilter || row.querySelector('.category-badge').textContent.trim() === categoryFilter;
            const matchesTopic = !topicFilter || row.querySelector('.topic-badge').textContent.trim() === topicFilter;
            
            if (matchesSearch && matchesCategory && matchesTopic) {
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
        const tbody = document.querySelector('#questionsTable tbody');
        const rows = Array.from(tbody.querySelectorAll('.question-row'));
        
        rows.sort((a, b) => {
            let aVal, bVal;
            
            switch (column) {
                case 'category':
                    aVal = a.dataset.category;
                    bVal = b.dataset.category;
                    break;
                case 'topic':
                    aVal = a.dataset.topic;
                    bVal = b.dataset.topic;
                    break;
                case 'question':
                    aVal = a.dataset.question;
                    bVal = b.dataset.question;
                    break;
                case 'answer':
                    aVal = a.dataset.answer;
                    bVal = b.dataset.answer;
                    break;
                case 'attempts':
                    aVal = parseInt(a.dataset.attempts);
                    bVal = parseInt(b.dataset.attempts);
                    break;
                case 'accuracy':
                    aVal = parseFloat(a.dataset.accuracy);
                    bVal = parseFloat(b.dataset.accuracy);
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
    
    // Global functions for actions
    window.previewQuestion = function(id) {
        // Load question preview
        fetch(`controller.php?action=preview&id=${id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('previewContent').innerHTML = html;
                document.getElementById('editFromPreview').onclick = () => {
                    window.location.href = `index.php?view=edit&id=${id}`;
                };
                new bootstrap.Modal(document.getElementById('previewModal')).show();
            })
            .catch(error => {
                console.error('Error loading preview:', error);
                alert('Không thể tải xem trước câu hỏi');
            });
    };
    
    window.deleteQuestion = function(id, questionText) {
        if (confirm(`Bạn có chắc chắn muốn xóa câu hỏi: "${questionText}"?`)) {
            window.location.href = `controller.php?action=delete&id=${id}`;
        }
    };
    
    window.duplicateQuestion = function(id) {
        if (confirm('Bạn có muốn nhân bản câu hỏi này?')) {
            window.location.href = `controller.php?action=duplicate&id=${id}`;
        }
    };
    
    window.exportQuestion = function(id) {
        window.location.href = `controller.php?action=export&id=${id}`;
    };
    
    window.viewStatistics = function(id) {
        window.open(`controller.php?action=statistics&id=${id}`, '_blank');
    };
});
</script>

<script>
function confirmDelete(exerciseId, questionText) {
    // Truncate question text if too long  
    var displayText = questionText.length > 30 ? questionText.substring(0, 30) + '...' : questionText;
    
    var confirmMessage = 'Xóa câu hỏi: "' + displayText + '"?\n\nThao tác này không thể hoàn tác!';
    
    return confirm(confirmMessage);
}

// Select All functionality
function toggleSelectAll(selectAllCheckbox) {
    console.log('Toggle select all clicked:', selectAllCheckbox.checked);
    const checkboxes = document.querySelectorAll('.question-checkbox');
    console.log('Found checkboxes:', checkboxes.length);
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkActions();
}



// Update bulk actions visibility and count
function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.question-checkbox:checked');
    const selectedCount = checkboxes.length;
    const bulkActions = document.getElementById('bulkActions');
    const countSpan = document.getElementById('selectedCount');
    
    if (selectedCount > 0) {
        bulkActions.style.display = 'block';
        countSpan.textContent = selectedCount;
    } else {
        bulkActions.style.display = 'none';
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    if (allCheckboxes.length > 0) {
        selectAllCheckbox.checked = selectedCount === allCheckboxes.length;
        selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < allCheckboxes.length;
    }
}

// Clear all selections
function clearSelection() {
    document.querySelectorAll('.question-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

// Bulk delete function
function bulkDelete() {
    const checkboxes = document.querySelectorAll('.question-checkbox:checked');
    const selectedIds = Array.from(checkboxes).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('Vui lòng chọn ít nhất một câu hỏi để xóa!');
        return;
    }
    
    const confirmMessage = `Xóa ${selectedIds.length} câu hỏi đã chọn?\n\nThao tác này không thể hoàn tác!`;
    
    if (confirm(confirmMessage)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'controller.php?action=bulkDelete';
        
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selectedIds[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Style the confirm dialog (works in some browsers)
window.addEventListener('load', function() {
    // Add some CSS for better button styling
    var style = document.createElement('style');
    style.innerHTML = `
        .btn-danger:hover {
            background-color: #c9302c !important;
            border-color: #ac2925 !important;
            transform: scale(1.05);
            transition: all 0.2s;
        }
        #bulkActions .alert {
            margin: 0;
            padding: 10px 15px;
        }
        .question-checkbox, #selectAll {
            transform: scale(1.2);
            cursor: pointer;
        }
        #selectAll {
            margin-bottom: 5px;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        th {
            vertical-align: middle !important;
        }
        .question-checkbox {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        /* Force show checkboxes */
        input[type="checkbox"] {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
        }
    `;
    document.head.appendChild(style);
});
</script>
	 