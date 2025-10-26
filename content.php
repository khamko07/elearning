<?php
if (!isset($_SESSION['StudentID'])) {
    redirect('login.php');
}

$contentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($contentId > 0) {
    // Show specific content
    $sql = "SELECT * FROM tblcontent WHERE ContentID = {$contentId}";
    $mydb->setQuery($sql);
    $content = $mydb->loadSingleResult();
    
    if (!$content) {
        redirect('index.php?q=content');
    }
    
    // Get next and previous content for navigation
    $sqlNext = "SELECT ContentID, Title FROM tblcontent WHERE ContentID > {$contentId} ORDER BY ContentID ASC LIMIT 1";
    $mydb->setQuery($sqlNext);
    $nextContent = $mydb->loadSingleResult();
    
    $sqlPrev = "SELECT ContentID, Title FROM tblcontent WHERE ContentID < {$contentId} ORDER BY ContentID DESC LIMIT 1";
    $mydb->setQuery($sqlPrev);
    $prevContent = $mydb->loadSingleResult();
    ?>
    
    <div class="content-reader-container">
        <!-- Content Header -->
        <div class="content-reader-header">
            <div class="header-navigation">
                <a href="index.php?q=content" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    <span>Quay lại danh sách</span>
                </a>
                
                <div class="reading-controls">
                    <button class="control-btn" id="fontSizeBtn" title="Kích thước chữ">
                        <i class="fas fa-text-height"></i>
                    </button>
                    <button class="control-btn" id="darkModeBtn" title="Chế độ đọc">
                        <i class="fas fa-moon"></i>
                    </button>
                    <button class="control-btn" id="bookmarkBtn" title="Đánh dấu">
                        <i class="far fa-bookmark"></i>
                    </button>
                </div>
            </div>
            
            <div class="content-meta">
                <div class="breadcrumb">
                    <a href="index.php">Trang chủ</a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="index.php?q=content">Nội dung học tập</a>
                    <i class="fas fa-chevron-right"></i>
                    <span><?php echo htmlspecialchars($content->Title); ?></span>
                </div>
                
                <div class="reading-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" id="readingProgress"></div>
                    </div>
                    <span class="progress-text">0%</span>
                </div>
            </div>
        </div>

        <!-- Content Body -->
        <article class="content-article" id="contentArticle">
            <header class="article-header">
                <h1 class="article-title"><?php echo htmlspecialchars($content->Title); ?></h1>
                
                <?php if ($content->Topic): ?>
                    <div class="article-meta">
                        <span class="topic-badge">
                            <i class="fas fa-tag"></i>
                            <?php echo htmlspecialchars($content->Topic); ?>
                        </span>
                        <span class="publish-date">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo date('d/m/Y', strtotime($content->CreatedAt)); ?>
                        </span>
                        <span class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span id="estimatedTime">5 phút đọc</span>
                        </span>
                    </div>
                <?php endif; ?>
            </header>
            
            <div class="article-content" id="articleContent">
                <?php echo markdownToHtml($content->Body); ?>
            </div>
            
            <footer class="article-footer">
                <div class="content-actions">
                    <button class="action-btn helpful" data-action="helpful">
                        <i class="fas fa-thumbs-up"></i>
                        <span>Hữu ích</span>
                        <span class="count">0</span>
                    </button>
                    <button class="action-btn share" data-action="share">
                        <i class="fas fa-share-alt"></i>
                        <span>Chia sẻ</span>
                    </button>
                    <button class="action-btn print" data-action="print">
                        <i class="fas fa-print"></i>
                        <span>In</span>
                    </button>
                </div>
                
                <div class="content-info">
                    <small class="last-updated">
                        Cập nhật lần cuối: <?php echo date('d/m/Y H:i', strtotime($content->CreatedAt)); ?>
                    </small>
                </div>
            </footer>
        </article>

        <!-- Content Navigation -->
        <nav class="content-navigation">
            <div class="nav-item prev">
                <?php if ($prevContent): ?>
                    <a href="index.php?q=content&id=<?php echo $prevContent->ContentID; ?>" class="nav-link">
                        <div class="nav-direction">
                            <i class="fas fa-chevron-left"></i>
                            <span>Bài trước</span>
                        </div>
                        <div class="nav-title"><?php echo htmlspecialchars($prevContent->Title); ?></div>
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="nav-item next">
                <?php if ($nextContent): ?>
                    <a href="index.php?q=content&id=<?php echo $nextContent->ContentID; ?>" class="nav-link">
                        <div class="nav-direction">
                            <span>Bài tiếp</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="nav-title"><?php echo htmlspecialchars($nextContent->Title); ?></div>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reading progress tracking
        const progressFill = document.getElementById('readingProgress');
        const progressText = document.querySelector('.progress-text');
        const article = document.getElementById('contentArticle');
        
        function updateReadingProgress() {
            const articleRect = article.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            const articleHeight = article.offsetHeight;
            
            // Calculate how much of the article has been scrolled past
            const scrolled = Math.max(0, -articleRect.top);
            const maxScroll = articleHeight - windowHeight;
            const progress = Math.min(100, Math.max(0, (scrolled / maxScroll) * 100));
            
            progressFill.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';
        }
        
        window.addEventListener('scroll', updateReadingProgress);
        updateReadingProgress();
        
        // Estimate reading time
        const articleContent = document.getElementById('articleContent');
        const wordCount = articleContent.textContent.split(/\s+/).length;
        const readingTime = Math.ceil(wordCount / 200); // 200 words per minute
        const estimatedTimeElement = document.getElementById('estimatedTime');
        if (estimatedTimeElement) {
            estimatedTimeElement.textContent = readingTime + ' phút đọc';
        }
        
        // Font size control
        const fontSizeBtn = document.getElementById('fontSizeBtn');
        let currentFontSize = 0; // 0: normal, 1: large, 2: xlarge, 3: back to small
        const fontSizes = ['', 'font-large', 'font-xlarge', 'font-small'];
        
        fontSizeBtn.addEventListener('click', function() {
            // Remove current font size class
            article.classList.remove('font-small', 'font-large', 'font-xlarge');
            
            // Cycle to next font size
            currentFontSize = (currentFontSize + 1) % fontSizes.length;
            
            if (fontSizes[currentFontSize]) {
                article.classList.add(fontSizes[currentFontSize]);
            }
            
            // Update button state
            this.classList.toggle('active', currentFontSize !== 0);
        });
        
        // Reading mode (dark mode for content)
        const darkModeBtn = document.getElementById('darkModeBtn');
        darkModeBtn.addEventListener('click', function() {
            article.classList.toggle('reading-mode');
            this.classList.toggle('active');
            
            const icon = this.querySelector('i');
            if (article.classList.contains('reading-mode')) {
                icon.className = 'fas fa-sun';
            } else {
                icon.className = 'fas fa-moon';
            }
        });
        
        // Bookmark functionality
        const bookmarkBtn = document.getElementById('bookmarkBtn');
        const contentId = new URLSearchParams(window.location.search).get('id');
        
        // Check if already bookmarked (you can implement localStorage or server-side)
        const isBookmarked = localStorage.getItem('bookmark_' + contentId) === 'true';
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
                localStorage.removeItem('bookmark_' + contentId);
            } else {
                this.classList.add('active');
                icon.className = 'fas fa-bookmark';
                localStorage.setItem('bookmark_' + contentId, 'true');
            }
        });
        
        // Content actions
        const actionBtns = document.querySelectorAll('.action-btn');
        actionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                
                switch (action) {
                    case 'helpful':
                        this.classList.toggle('active');
                        const count = this.querySelector('.count');
                        let currentCount = parseInt(count.textContent);
                        count.textContent = this.classList.contains('active') ? currentCount + 1 : Math.max(0, currentCount - 1);
                        break;
                        
                    case 'share':
                        if (navigator.share) {
                            navigator.share({
                                title: document.querySelector('.article-title').textContent,
                                url: window.location.href
                            });
                        } else {
                            // Fallback: copy to clipboard
                            navigator.clipboard.writeText(window.location.href).then(() => {
                                alert('Đã sao chép liên kết!');
                            });
                        }
                        break;
                        
                    case 'print':
                        window.print();
                        break;
                }
            });
        });
        
        // Smooth scrolling for navigation links
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Add a subtle loading effect
                this.style.opacity = '0.7';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 200);
            });
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + D for bookmark
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                bookmarkBtn.click();
            }
            
            // Ctrl/Cmd + P for print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                document.querySelector('[data-action="print"]').click();
            }
        });
    });
    </script>
    
    <?php
} else {
    // Show content list
    $sql = "SELECT * FROM tblcontent ORDER BY CreatedAt DESC";
    $mydb->setQuery($sql);
    $contents = $mydb->loadResultList();
    ?>
    
    <div class="page-header">
        <h1><i class="fa fa-book"></i> Learning Content</h1>
    </div>
    
    <?php if (empty($contents)): ?>
        <div class="empty-state">
            <i class="fa fa-book"></i>
            <h3>No Content Available</h3>
            <p>Learning content will appear here once created by administrators.</p>
        </div>
    <?php else: ?>
        <div class="content-grid">
            <?php foreach ($contents as $content): ?>
                <div class="content-card">
                    <div class="content-header">
                        <h3><a href="index.php?q=content&id=<?php echo $content->ContentID; ?>"><?php echo htmlspecialchars($content->Title); ?></a></h3>
                        <?php if ($content->Topic): ?>
                            <div class="topic-badge"><?php echo htmlspecialchars($content->Topic); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="content-preview">
                        <?php 
                        $preview = strip_tags($content->Body);
                        echo htmlspecialchars(substr($preview, 0, 120)) . (strlen($preview) > 120 ? '...' : '');
                        ?>
                    </div>
                    <div class="content-footer">
                        <small class="text-muted">
                            <i class="fa fa-calendar"></i> <?php echo date('M j, Y', strtotime($content->CreatedAt)); ?>
                        </small>
                        <a href="index.php?q=content&id=<?php echo $content->ContentID; ?>" class="btn btn-sm">
                            Read More <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <style>
    /* Override the blue background for content page */
    body {
        background: #f5f7fb !important;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin: -15px -15px 30px -15px;
        text-align: center;
        border-radius: 0;
    }
    
    .page-header h1 {
        margin: 0;
        font-size: 2.5em;
        font-weight: 300;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }
    
    .content-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
    
    .content-header {
        padding: 25px 25px 15px 25px;
        background: linear-gradient(45deg, #f8f9fa, #fff);
    }
    
    .content-header h3 {
        margin: 0 0 12px 0;
        font-size: 20px;
        font-weight: 600;
        line-height: 1.3;
    }
    
    .content-header h3 a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .content-header h3 a:hover {
        color: #667eea;
    }
    
    .topic-badge {
        display: inline-block;
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .content-preview {
        padding: 20px 25px;
        color: #5a6c7d;
        line-height: 1.6;
        font-size: 14px;
        border-top: 1px solid #f1f3f4;
    }
    
    .content-footer {
        padding: 15px 25px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .content-footer .text-muted {
        color: #6c757d;
        font-size: 13px;
    }
    
    .content-footer .btn {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .content-footer .btn:hover {
        transform: translateX(2px);
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    }
    
    .empty-state i {
        font-size: 4em;
        color: #dee2e6;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        color: #6c757d;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: #adb5bd;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .page-header h1 {
            font-size: 2em;
        }
        
        .content-header, .content-preview, .content-footer {
            padding-left: 20px;
            padding-right: 20px;
        }
    }
    </style>
    
    <?php
}

// PHP function to convert markdown (server-side backup)
function markdownToHtml($markdown) {
    $html = $markdown;
    $html = preg_replace('/^### (.*$)/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.*$)/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^# (.*$)/m', '<h1>$1</h1>', $html);
    $html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $html);
    $html = preg_replace('/```(.*?)```/s', '<pre><code>$1</code></pre>', $html);
    $html = preg_replace('/`(.*?)`/', '<code>$1</code>', $html);
    $html = preg_replace('/^\* (.*$)/m', '<li>$1</li>', $html);
    $html = preg_replace('/^- (.*$)/m', '<li>$1</li>', $html);
    $html = preg_replace('/^> (.*$)/m', '<blockquote>$1</blockquote>', $html);
    $html = str_replace("\n\n", '</p><p>', $html);
    $html = str_replace("\n", '<br>', $html);
    $html = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $html);
    if ($html && !preg_match('/^<[h|u|p]/', $html)) {
        $html = '<p>' . $html . '</p>';
    }
    return $html;
}
?>