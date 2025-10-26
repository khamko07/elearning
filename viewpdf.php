<?php  
@$id = $_GET['id'];
if($id == '') {
    redirect("index.php");
}

$lesson = New Lesson();
$res = $lesson->single_lesson($id);

if (!$res) {
    redirect("index.php?q=lesson");
}

// Get next and previous lessons for navigation
$sqlNext = "SELECT LessonID, LessonTitle FROM tbllesson WHERE LessonID > {$id} AND Category='Docs' ORDER BY LessonID ASC LIMIT 1";
$mydb->setQuery($sqlNext);
$nextLesson = $mydb->loadSingleResult();

$sqlPrev = "SELECT LessonID, LessonTitle FROM tbllesson WHERE LessonID < {$id} AND Category='Docs' ORDER BY LessonID DESC LIMIT 1";
$mydb->setQuery($sqlPrev);
$prevLesson = $mydb->loadSingleResult();

$pdfUrl = web_root.'admin/modules/lesson/'.$res->FileLocation;
?>

<div class="pdf-viewer-container">
    <!-- PDF Viewer Header -->
    <div class="pdf-header">
        <div class="header-navigation">
            <a href="index.php?q=lesson" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Quay lại danh sách</span>
            </a>
            
            <div class="pdf-controls">
                <button class="control-btn" id="downloadBtn" title="Tải xuống">
                    <i class="fas fa-download"></i>
                </button>
                <button class="control-btn" id="printBtn" title="In tài liệu">
                    <i class="fas fa-print"></i>
                </button>
                <button class="control-btn" id="bookmarkBtn" title="Đánh dấu">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
        </div>
        
        <div class="pdf-meta">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <a href="index.php?q=lesson">Bài học</a>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo htmlspecialchars($res->LessonTitle); ?></span>
            </div>
            
            <div class="pdf-info">
                <div class="info-item">
                    <i class="fas fa-book"></i>
                    <span>Chương <?php echo htmlspecialchars($res->LessonChapter); ?></span>
                </div>
                <div class="info-item">
                    <i class="fas fa-file-pdf"></i>
                    <span>PDF Document</span>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Viewer -->
    <div class="pdf-viewer-wrapper">
        <div class="pdf-toolbar">
            <div class="toolbar-left">
                <button class="toolbar-btn" id="zoomOutBtn" title="Thu nhỏ">
                    <i class="fas fa-search-minus"></i>
                </button>
                <span class="zoom-level" id="zoomLevel">100%</span>
                <button class="toolbar-btn" id="zoomInBtn" title="Phóng to">
                    <i class="fas fa-search-plus"></i>
                </button>
                <button class="toolbar-btn" id="fitWidthBtn" title="Vừa chiều rộng">
                    <i class="fas fa-arrows-alt-h"></i>
                </button>
                <button class="toolbar-btn" id="fitPageBtn" title="Vừa trang">
                    <i class="fas fa-expand-arrows-alt"></i>
                </button>
            </div>
            
            <div class="toolbar-center">
                <button class="toolbar-btn" id="prevPageBtn" title="Trang trước">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="page-info">
                    <input type="number" id="currentPageInput" value="1" min="1">
                    <span>/ <span id="totalPages">1</span></span>
                </div>
                <button class="toolbar-btn" id="nextPageBtn" title="Trang sau">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="toolbar-right">
                <button class="toolbar-btn" id="rotateBtn" title="Xoay trang">
                    <i class="fas fa-redo"></i>
                </button>
                <button class="toolbar-btn" id="fullscreenBtn" title="Toàn màn hình">
                    <i class="fas fa-expand"></i>
                </button>
                <button class="toolbar-btn" id="toggleSidebarBtn" title="Hiện/ẩn sidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        
        <div class="pdf-content">
            <div class="pdf-sidebar" id="pdfSidebar">
                <div class="sidebar-header">
                    <h3>Trang</h3>
                    <button class="sidebar-close" id="sidebarClose">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="sidebar-content">
                    <div class="page-thumbnails" id="pageThumbnails">
                        <!-- Thumbnails will be generated here -->
                    </div>
                </div>
            </div>
            
            <div class="pdf-main">
                <div class="pdf-container" id="pdfContainer">
                    <div class="pdf-loading" id="pdfLoading">
                        <div class="loading-spinner"></div>
                        <p>Đang tải tài liệu PDF...</p>
                    </div>
                    
                    <div class="pdf-error" id="pdfError" style="display: none;">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3>Không thể tải tài liệu PDF</h3>
                        <p>Vui lòng thử lại sau hoặc liên hệ hỗ trợ.</p>
                        <button class="btn btn-primary" onclick="location.reload()">
                            <i class="fas fa-refresh"></i>
                            Thử lại
                        </button>
                    </div>
                    
                    <!-- Fallback iframe for browsers that don't support PDF.js -->
                    <iframe 
                        id="pdfIframe" 
                        src="<?php echo $pdfUrl; ?>" 
                        style="display: none;"
                        width="100%" 
                        height="100%"
                        frameborder="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Information -->
    <div class="pdf-info-section">
        <div class="pdf-details">
            <div class="pdf-main-info">
                <h1 class="pdf-title"><?php echo htmlspecialchars($res->LessonTitle); ?></h1>
                
                <div class="pdf-meta-info">
                    <div class="meta-item">
                        <i class="fas fa-book"></i>
                        <span>Chương <?php echo htmlspecialchars($res->LessonChapter); ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-file-pdf"></i>
                        <span>PDF Document</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-eye"></i>
                        <span>1,234 lượt xem</span>
                    </div>
                </div>
                
                <div class="pdf-actions">
                    <button class="action-btn helpful-btn" id="helpfulBtn">
                        <i class="far fa-thumbs-up"></i>
                        <span>Hữu ích</span>
                        <span class="count">0</span>
                    </button>
                    <button class="action-btn share-btn" id="shareBtn">
                        <i class="fas fa-share-alt"></i>
                        <span>Chia sẻ</span>
                    </button>
                    <a href="<?php echo $pdfUrl; ?>" download class="action-btn download-btn">
                        <i class="fas fa-download"></i>
                        <span>Tải xuống</span>
                    </a>
                </div>
            </div>
            
            <div class="pdf-description">
                <h3>Mô tả</h3>
                <p>
                    Tài liệu PDF <?php echo htmlspecialchars($res->LessonTitle); ?> 
                    thuộc chương <?php echo htmlspecialchars($res->LessonChapter); ?>. 
                    Nội dung được trình bày một cách chi tiết và có hệ thống, 
                    giúp học viên nắm vững kiến thức một cách hiệu quả.
                </p>
            </div>
        </div>
    </div>

    <!-- PDF Navigation -->
    <nav class="pdf-navigation">
        <div class="nav-item prev">
            <?php if ($prevLesson): ?>
                <a href="index.php?q=viewpdf&id=<?php echo $prevLesson->LessonID; ?>" class="nav-link">
                    <div class="nav-direction">
                        <i class="fas fa-chevron-left"></i>
                        <span>Tài liệu trước</span>
                    </div>
                    <div class="nav-title"><?php echo htmlspecialchars($prevLesson->LessonTitle); ?></div>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="nav-item next">
            <?php if ($nextLesson): ?>
                <a href="index.php?q=viewpdf&id=<?php echo $nextLesson->LessonID; ?>" class="nav-link">
                    <div class="nav-direction">
                        <span>Tài liệu tiếp</span>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="nav-title"><?php echo htmlspecialchars($nextLesson->LessonTitle); ?></div>
                </a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pdfContainer = document.getElementById('pdfContainer');
    const pdfLoading = document.getElementById('pdfLoading');
    const pdfError = document.getElementById('pdfError');
    const pdfIframe = document.getElementById('pdfIframe');
    const pdfSidebar = document.getElementById('pdfSidebar');
    
    // Control elements
    const downloadBtn = document.getElementById('downloadBtn');
    const printBtn = document.getElementById('printBtn');
    const bookmarkBtn = document.getElementById('bookmarkBtn');
    const zoomOutBtn = document.getElementById('zoomOutBtn');
    const zoomInBtn = document.getElementById('zoomInBtn');
    const zoomLevel = document.getElementById('zoomLevel');
    const fitWidthBtn = document.getElementById('fitWidthBtn');
    const fitPageBtn = document.getElementById('fitPageBtn');
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');
    const currentPageInput = document.getElementById('currentPageInput');
    const totalPages = document.getElementById('totalPages');
    const rotateBtn = document.getElementById('rotateBtn');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
    const sidebarClose = document.getElementById('sidebarClose');
    
    let currentZoom = 100;
    let currentPage = 1;
    let totalPageCount = 1;
    let rotation = 0;
    
    // Initialize PDF viewer
    function initializePDF() {
        // Show loading state
        pdfLoading.style.display = 'flex';
        pdfError.style.display = 'none';
        
        // For now, we'll use the iframe fallback
        // In a real implementation, you would use PDF.js here
        setTimeout(() => {
            pdfLoading.style.display = 'none';
            pdfIframe.style.display = 'block';
            
            // Simulate PDF loading
            totalPageCount = Math.floor(Math.random() * 20) + 5; // Random page count for demo
            totalPages.textContent = totalPageCount;
            currentPageInput.max = totalPageCount;
            
            updatePageControls();
        }, 2000);
    }
    
    // Update page controls
    function updatePageControls() {
        prevPageBtn.disabled = currentPage <= 1;
        nextPageBtn.disabled = currentPage >= totalPageCount;
        currentPageInput.value = currentPage;
    }
    
    // Zoom controls
    zoomOutBtn.addEventListener('click', function() {
        if (currentZoom > 25) {
            currentZoom -= 25;
            updateZoom();
        }
    });
    
    zoomInBtn.addEventListener('click', function() {
        if (currentZoom < 300) {
            currentZoom += 25;
            updateZoom();
        }
    });
    
    function updateZoom() {
        zoomLevel.textContent = currentZoom + '%';
        // In a real PDF.js implementation, you would update the PDF scale here
        pdfIframe.style.transform = `scale(${currentZoom / 100})`;
        pdfIframe.style.transformOrigin = 'top left';
    }
    
    // Fit controls
    fitWidthBtn.addEventListener('click', function() {
        currentZoom = 100; // This would be calculated based on container width
        updateZoom();
    });
    
    fitPageBtn.addEventListener('click', function() {
        currentZoom = 85; // This would be calculated to fit the entire page
        updateZoom();
    });
    
    // Page navigation
    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            updatePageControls();
            // In PDF.js, you would navigate to the previous page
        }
    });
    
    nextPageBtn.addEventListener('click', function() {
        if (currentPage < totalPageCount) {
            currentPage++;
            updatePageControls();
            // In PDF.js, you would navigate to the next page
        }
    });
    
    currentPageInput.addEventListener('change', function() {
        const page = parseInt(this.value);
        if (page >= 1 && page <= totalPageCount) {
            currentPage = page;
            updatePageControls();
            // In PDF.js, you would navigate to the specified page
        } else {
            this.value = currentPage;
        }
    });
    
    // Rotate
    rotateBtn.addEventListener('click', function() {
        rotation = (rotation + 90) % 360;
        pdfIframe.style.transform = `scale(${currentZoom / 100}) rotate(${rotation}deg)`;
    });
    
    // Fullscreen
    fullscreenBtn.addEventListener('click', function() {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            pdfContainer.requestFullscreen();
        }
    });
    
    document.addEventListener('fullscreenchange', function() {
        const icon = fullscreenBtn.querySelector('i');
        if (document.fullscreenElement) {
            icon.className = 'fas fa-compress';
        } else {
            icon.className = 'fas fa-expand';
        }
    });
    
    // Sidebar toggle
    toggleSidebarBtn.addEventListener('click', function() {
        pdfSidebar.classList.toggle('show');
    });
    
    sidebarClose.addEventListener('click', function() {
        pdfSidebar.classList.remove('show');
    });
    
    // Print functionality
    printBtn.addEventListener('click', function() {
        // In a real implementation, you would print the PDF content
        window.print();
    });
    
    // Bookmark functionality
    const pdfId = new URLSearchParams(window.location.search).get('id');
    const isBookmarked = localStorage.getItem('pdf_bookmark_' + pdfId) === 'true';
    
    if (isBookmarked) {
        bookmarkBtn.classList.add('active');
        bookmarkBtn.querySelector('i').className = 'fas fa-bookmark';
    }
    
    bookmarkBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        const isCurrentlyBookmarked = this.classList.contains('active');
        
        if (isCurrentlyBookmarked) {
            this.classList.remove('active');
            icon.className = 'far fa-bookmark';
            localStorage.removeItem('pdf_bookmark_' + pdfId);
        } else {
            this.classList.add('active');
            icon.className = 'fas fa-bookmark';
            localStorage.setItem('pdf_bookmark_' + pdfId, 'true');
        }
    });
    
    // PDF actions
    const helpfulBtn = document.getElementById('helpfulBtn');
    const shareBtn = document.getElementById('shareBtn');
    
    helpfulBtn.addEventListener('click', function() {
        this.classList.toggle('active');
        const count = this.querySelector('.count');
        let currentCount = parseInt(count.textContent);
        count.textContent = this.classList.contains('active') ? currentCount + 1 : Math.max(0, currentCount - 1);
    });
    
    shareBtn.addEventListener('click', function() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo htmlspecialchars($res->LessonTitle); ?>',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Đã sao chép liên kết!');
            });
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.target.tagName.toLowerCase() === 'input') return;
        
        switch(e.code) {
            case 'ArrowLeft':
                e.preventDefault();
                prevPageBtn.click();
                break;
            case 'ArrowRight':
                e.preventDefault();
                nextPageBtn.click();
                break;
            case 'ArrowUp':
                e.preventDefault();
                zoomInBtn.click();
                break;
            case 'ArrowDown':
                e.preventDefault();
                zoomOutBtn.click();
                break;
            case 'KeyF':
                e.preventDefault();
                fullscreenBtn.click();
                break;
            case 'KeyR':
                e.preventDefault();
                rotateBtn.click();
                break;
            case 'KeyS':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    toggleSidebarBtn.click();
                }
                break;
            case 'KeyP':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    printBtn.click();
                }
                break;
        }
    });
    
    // Initialize
    initializePDF();
    
    // Handle iframe load error
    pdfIframe.addEventListener('error', function() {
        pdfLoading.style.display = 'none';
        pdfError.style.display = 'flex';
        pdfIframe.style.display = 'none';
    });
    
    // Handle iframe load success
    pdfIframe.addEventListener('load', function() {
        pdfLoading.style.display = 'none';
        pdfError.style.display = 'none';
        pdfIframe.style.display = 'block';
    });
});
</script> 