<?php 
$studentid = $_SESSION['StudentID'];
$score = isset($_GET['score']) ? $_GET['score'] : 0;
$correct = isset($_GET['correct']) ? $_GET['correct'] : 0;
$total = isset($_GET['total']) ? $_GET['total'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : '';
$topicId = isset($_GET['topic']) ? (int)$_GET['topic'] : 0;

if($id == '' && $topicId == 0){
    redirect("index.php");
}

// Get topic and category info if topicId is provided
if($topicId > 0) {
    $sql = "SELECT t.TopicName, c.CategoryName, c.CategoryID 
            FROM tbltopics t 
            JOIN tblcategories c ON t.CategoryID = c.CategoryID 
            WHERE t.TopicID = {$topicId}";
    $mydb->setQuery($sql);
    $topicInfo = $mydb->loadSingleResult();
}
?>

<?php
// Calculate additional statistics
$percentage = $total > 0 ? round(($correct / $total) * 100, 1) : 0;
$incorrect = $total - $correct;
$timeSpent = isset($_GET['time']) ? (int)$_GET['time'] : 0;
$avgTimePerQuestion = $total > 0 && $timeSpent > 0 ? round($timeSpent / $total, 1) : 0;

// Determine performance level
$performanceLevel = '';
$performanceColor = '';
$performanceIcon = '';
if ($percentage >= 90) {
    $performanceLevel = 'Xuất sắc';
    $performanceColor = 'success';
    $performanceIcon = 'fas fa-trophy';
} elseif ($percentage >= 80) {
    $performanceLevel = 'Tốt';
    $performanceColor = 'primary';
    $performanceIcon = 'fas fa-medal';
} elseif ($percentage >= 70) {
    $performanceLevel = 'Khá';
    $performanceColor = 'info';
    $performanceIcon = 'fas fa-thumbs-up';
} elseif ($percentage >= 60) {
    $performanceLevel = 'Trung bình';
    $performanceColor = 'warning';
    $performanceIcon = 'fas fa-check-circle';
} else {
    $performanceLevel = 'Cần cải thiện';
    $performanceColor = 'danger';
    $performanceIcon = 'fas fa-exclamation-triangle';
}

// Get questions for review
if($topicId > 0) {
    $sql = "SELECT * FROM tblexercise WHERE TopicID = {$topicId} ORDER BY ExerciseID";
} else if($id == 'all') {
    $sql = "SELECT * FROM tblexercise ORDER BY ExerciseID";
} else {
    $sql = "SELECT * FROM tblexercise WHERE LessonID = '{$id}'";
}
$mydb->setQuery($sql);
$questions = $mydb->loadResultList();
?>

<div class="quiz-results-container">
    <!-- Breadcrumb -->
    <?php if($topicId > 0 && $topicInfo): ?>
        <nav class="quiz-breadcrumb">
            <a href="index.php?q=categories" class="breadcrumb-item">
                <i class="fas fa-folder"></i>
                <span>Exercise Categories</span>
            </a>
            <i class="fas fa-chevron-right breadcrumb-separator"></i>
            <a href="index.php?q=topics&category=<?php echo $topicInfo->CategoryID; ?>" class="breadcrumb-item">
                <i class="fas fa-list"></i>
                <span><?php echo $topicInfo->CategoryName; ?></span>
            </a>
            <i class="fas fa-chevron-right breadcrumb-separator"></i>
            <a href="index.php?q=question&topic=<?php echo $topicId; ?>" class="breadcrumb-item">
                <i class="fas fa-question-circle"></i>
                <span><?php echo $topicInfo->TopicName; ?> Quiz</span>
            </a>
            <i class="fas fa-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-item active">
                <i class="fas fa-chart-bar"></i>
                <span>Kết quả</span>
            </span>
        </nav>
    <?php endif; ?>

    <!-- Results Header -->
    <div class="results-header">
        <div class="results-celebration">
            <div class="celebration-icon">
                <i class="<?php echo $performanceIcon; ?>"></i>
            </div>
            <div class="celebration-content">
                <h1 class="results-title">
                    <?php if($topicId > 0 && $topicInfo): ?>
                        Kết quả <?php echo $topicInfo->TopicName; ?>
                    <?php else: ?>
                        Kết quả Quiz
                    <?php endif; ?>
                </h1>
                <p class="results-subtitle">Bạn đã hoàn thành bài quiz!</p>
            </div>
        </div>
        
        <div class="performance-badge">
            <span class="badge badge-<?php echo $performanceColor; ?> performance-level">
                <?php echo $performanceLevel; ?>
            </span>
        </div>
    </div>

    <!-- Score Display -->
    <div class="score-display">
        <div class="score-circle">
            <div class="score-chart" data-score="<?php echo $percentage; ?>">
                <div class="score-percentage"><?php echo $percentage; ?>%</div>
                <div class="score-label">Điểm số</div>
            </div>
        </div>
        
        <div class="score-details">
            <div class="detail-item">
                <div class="detail-icon correct">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-number"><?php echo $correct; ?></div>
                    <div class="detail-label">Đúng</div>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon incorrect">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-number"><?php echo $incorrect; ?></div>
                    <div class="detail-label">Sai</div>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon total">
                    <i class="fas fa-list-ol"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-number"><?php echo $total; ?></div>
                    <div class="detail-label">Tổng</div>
                </div>
            </div>
            
            <?php if($timeSpent > 0): ?>
                <div class="detail-item">
                    <div class="detail-icon time">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="detail-content">
                        <div class="detail-number"><?php echo gmdate("i:s", $timeSpent); ?></div>
                        <div class="detail-label">Thời gian</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Performance Analysis -->
    <div class="performance-analysis">
        <h3 class="analysis-title">Phân tích kết quả</h3>
        
        <div class="analysis-grid">
            <div class="analysis-card">
                <div class="analysis-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="analysis-content">
                    <h4>Tỷ lệ chính xác</h4>
                    <div class="analysis-value"><?php echo $percentage; ?>%</div>
                    <div class="analysis-description">
                        <?php if($percentage >= 80): ?>
                            Tuyệt vời! Bạn đã nắm vững kiến thức.
                        <?php elseif($percentage >= 60): ?>
                            Tốt! Bạn đã đạt mức yêu cầu.
                        <?php else: ?>
                            Cần ôn tập thêm để cải thiện kết quả.
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <?php if($avgTimePerQuestion > 0): ?>
                <div class="analysis-card">
                    <div class="analysis-icon">
                        <i class="fas fa-stopwatch"></i>
                    </div>
                    <div class="analysis-content">
                        <h4>Thời gian trung bình</h4>
                        <div class="analysis-value"><?php echo $avgTimePerQuestion; ?>s</div>
                        <div class="analysis-description">
                            <?php if($avgTimePerQuestion <= 60): ?>
                                Tốc độ làm bài nhanh và hiệu quả.
                            <?php elseif($avgTimePerQuestion <= 120): ?>
                                Thời gian làm bài hợp lý.
                            <?php else: ?>
                                Có thể cải thiện tốc độ làm bài.
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="analysis-card">
                <div class="analysis-icon">
                    <i class="fas fa-target"></i>
                </div>
                <div class="analysis-content">
                    <h4>Mức độ hoàn thành</h4>
                    <div class="analysis-value">100%</div>
                    <div class="analysis-description">
                        Bạn đã trả lời tất cả câu hỏi.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Review -->
    <div class="question-review">
        <div class="review-header">
            <h3 class="review-title">Xem lại câu trả lời</h3>
            <div class="review-controls">
                <button class="btn btn-ghost" id="showCorrectOnly">
                    <i class="fas fa-check"></i>
                    <span>Chỉ câu đúng</span>
                </button>
                <button class="btn btn-ghost" id="showIncorrectOnly">
                    <i class="fas fa-times"></i>
                    <span>Chỉ câu sai</span>
                </button>
                <button class="btn btn-ghost active" id="showAll">
                    <i class="fas fa-list"></i>
                    <span>Tất cả</span>
                </button>
            </div>
        </div>
        
        <div class="review-questions">
            <?php if (!empty($questions)): ?>
                <?php 
                $questionNum = 1;
                foreach ($questions as $question): 
                    // Get user's answer for this question
                    $sql = "SELECT * FROM tblscore WHERE ExerciseID='{$question->ExerciseID}' AND StudentID='{$studentid}'";
                    $mydb->setQuery($sql);
                    $userScore = $mydb->loadSingleResult();
                    $userAnswer = $userScore ? $userScore->Answer : '';
                    $isCorrect = ($userScore && $userScore->Score == 1);
                ?>
                    <div class="review-question-card <?php echo $isCorrect ? 'correct' : 'incorrect'; ?>" data-status="<?php echo $isCorrect ? 'correct' : 'incorrect'; ?>">
                        <div class="question-review-header">
                            <div class="question-number">
                                <span class="question-badge">Câu <?php echo $questionNum; ?></span>
                                <div class="question-status">
                                    <?php if($isCorrect): ?>
                                        <span class="status-badge correct">
                                            <i class="fas fa-check"></i>
                                            <span>Đúng</span>
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge incorrect">
                                            <i class="fas fa-times"></i>
                                            <span>Sai</span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="question-content">
                            <h4 class="question-text"><?php echo htmlspecialchars($question->Question); ?></h4>
                            
                            <div class="choices-review">
                                <?php 
                                $choices = [
                                    'A' => $question->ChoiceA,
                                    'B' => $question->ChoiceB,
                                    'C' => $question->ChoiceC,
                                    'D' => $question->ChoiceD
                                ];
                                ?>
                                <?php foreach ($choices as $letter => $choice): ?>
                                    <?php if (!empty(trim($choice))): ?>
                                        <div class="choice-review <?php 
                                            echo ($letter == $question->Answer) ? 'correct-answer' : '';
                                            echo ($letter == $userAnswer && $letter != $question->Answer) ? 'user-wrong' : '';
                                            echo ($letter == $userAnswer && $letter == $question->Answer) ? 'user-correct' : '';
                                        ?>">
                                            <div class="choice-indicator">
                                                <span class="choice-letter"><?php echo $letter; ?></span>
                                                <div class="choice-icons">
                                                    <?php if($letter == $question->Answer): ?>
                                                        <i class="fas fa-check correct-icon" title="Đáp án đúng"></i>
                                                    <?php endif; ?>
                                                    <?php if($letter == $userAnswer): ?>
                                                        <i class="fas fa-user user-icon" title="Câu trả lời của bạn"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="choice-text"><?php echo htmlspecialchars($choice); ?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="question-explanation">
                                <?php if(!$isCorrect): ?>
                                    <div class="explanation-content">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Đáp án đúng là <strong><?php echo $question->Answer; ?></strong></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php 
                    $questionNum++;
                endforeach; 
                ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3 class="empty-title">Không có câu hỏi</h3>
                    <p class="empty-description">Không tìm thấy câu hỏi để xem lại.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="results-actions">
        <div class="action-buttons">
            <?php if($topicId > 0 && $topicInfo): ?>
                <a href="index.php?q=question&topic=<?php echo $topicId; ?>" class="btn btn-warning">
                    <i class="fas fa-redo"></i>
                    <span>Làm lại</span>
                </a>
                <a href="index.php?q=topics&category=<?php echo $topicInfo->CategoryID; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Về <?php echo $topicInfo->CategoryName; ?></span>
                </a>
            <?php else: ?>
                <a href="index.php?q=categories" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Về danh mục</span>
                </a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-home"></i>
                <span>Trang chủ</span>
            </a>
            <button class="btn btn-ghost" onclick="window.print()">
                <i class="fas fa-print"></i>
                <span>In kết quả</span>
            </button>
        </div>
        
        <div class="share-section">
            <span class="share-label">Chia sẻ kết quả:</span>
            <div class="share-buttons">
                <button class="btn btn-ghost share-btn" data-platform="facebook">
                    <i class="fab fa-facebook-f"></i>
                </button>
                <button class="btn btn-ghost share-btn" data-platform="twitter">
                    <i class="fab fa-twitter"></i>
                </button>
                <button class="btn btn-ghost share-btn" data-platform="copy">
                    <i class="fas fa-link"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize score circle animation
    initializeScoreCircle();
    
    // Setup review filters
    setupReviewFilters();
    
    // Setup share functionality
    setupShareButtons();
    
    function initializeScoreCircle() {
        const scoreChart = document.querySelector('.score-chart');
        const score = parseInt(scoreChart.dataset.score);
        
        // Create circular progress
        const circumference = 2 * Math.PI * 45; // radius = 45
        const offset = circumference - (score / 100) * circumference;
        
        // Add SVG circle if not exists
        if (!scoreChart.querySelector('svg')) {
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.setAttribute('width', '120');
            svg.setAttribute('height', '120');
            svg.style.position = 'absolute';
            svg.style.top = '0';
            svg.style.left = '0';
            svg.style.transform = 'rotate(-90deg)';
            
            const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            circle.setAttribute('cx', '60');
            circle.setAttribute('cy', '60');
            circle.setAttribute('r', '45');
            circle.setAttribute('fill', 'none');
            circle.setAttribute('stroke', getScoreColor(score));
            circle.setAttribute('stroke-width', '8');
            circle.setAttribute('stroke-dasharray', circumference);
            circle.setAttribute('stroke-dashoffset', circumference);
            circle.setAttribute('stroke-linecap', 'round');
            
            svg.appendChild(circle);
            scoreChart.appendChild(svg);
            
            // Animate the circle
            setTimeout(() => {
                circle.style.transition = 'stroke-dashoffset 2s ease-in-out';
                circle.setAttribute('stroke-dashoffset', offset);
            }, 500);
        }
    }
    
    function getScoreColor(score) {
        if (score >= 90) return 'var(--secondary-green)';
        if (score >= 80) return 'var(--primary-blue)';
        if (score >= 70) return 'var(--secondary-blue)';
        if (score >= 60) return 'var(--secondary-orange)';
        return 'var(--secondary-red)';
    }
    
    function setupReviewFilters() {
        const showAll = document.getElementById('showAll');
        const showCorrectOnly = document.getElementById('showCorrectOnly');
        const showIncorrectOnly = document.getElementById('showIncorrectOnly');
        const questionCards = document.querySelectorAll('.review-question-card');
        
        function filterQuestions(filter) {
            questionCards.forEach(card => {
                const status = card.dataset.status;
                
                if (filter === 'all') {
                    card.style.display = 'block';
                } else if (filter === 'correct' && status === 'correct') {
                    card.style.display = 'block';
                } else if (filter === 'incorrect' && status === 'incorrect') {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        showAll.addEventListener('click', function() {
            filterQuestions('all');
            updateActiveFilter(this);
        });
        
        showCorrectOnly.addEventListener('click', function() {
            filterQuestions('correct');
            updateActiveFilter(this);
        });
        
        showIncorrectOnly.addEventListener('click', function() {
            filterQuestions('incorrect');
            updateActiveFilter(this);
        });
        
        function updateActiveFilter(activeBtn) {
            document.querySelectorAll('.review-controls .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            activeBtn.classList.add('active');
        }
    }
    
    function setupShareButtons() {
        const shareButtons = document.querySelectorAll('.share-btn');
        const score = <?php echo $percentage; ?>;
        const quizName = '<?php echo $topicId > 0 && $topicInfo ? $topicInfo->TopicName : "Quiz"; ?>';
        
        shareButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const platform = this.dataset.platform;
                const text = `Tôi vừa hoàn thành ${quizName} với điểm số ${score}%!`;
                const url = window.location.href;
                
                switch(platform) {
                    case 'facebook':
                        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(text)}`, '_blank');
                        break;
                    case 'twitter':
                        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank');
                        break;
                    case 'copy':
                        navigator.clipboard.writeText(`${text} ${url}`).then(() => {
                            // Show success message
                            const originalText = this.innerHTML;
                            this.innerHTML = '<i class="fas fa-check"></i>';
                            setTimeout(() => {
                                this.innerHTML = originalText;
                            }, 2000);
                        });
                        break;
                }
            });
        });
    }
    
    // Add celebration animation for high scores
    const score = <?php echo $percentage; ?>;
    if (score >= 90) {
        setTimeout(() => {
            createCelebration();
        }, 1000);
    }
    
    function createCelebration() {
        // Simple confetti effect
        for (let i = 0; i < 50; i++) {
            createConfetti();
        }
    }
    
    function createConfetti() {
        const confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.width = '10px';
        confetti.style.height = '10px';
        confetti.style.backgroundColor = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57'][Math.floor(Math.random() * 5)];
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.top = '-10px';
        confetti.style.zIndex = '9999';
        confetti.style.borderRadius = '50%';
        
        document.body.appendChild(confetti);
        
        const animation = confetti.animate([
            { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
            { transform: `translateY(100vh) rotate(720deg)`, opacity: 0 }
        ], {
            duration: 3000,
            easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
        });
        
        animation.onfinish = () => confetti.remove();
    }
});
</script>