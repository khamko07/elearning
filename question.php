<?php
$studentid = $_SESSION['StudentID'];
$score = 0;
$id = isset($_GET['id']) ? $_GET['id'] : '';
$topicId = isset($_GET['topic']) ? (int)$_GET['topic'] : 0;

if($id == '' && $topicId == 0){
    redirect("index.php");
}

// Check if this is for all exercises, specific topic, or specific lesson
if($topicId > 0) {
	// For specific topic, check if student has already taken the quiz
	$sql = "SELECT SUM(Score) as 'SCORE' FROM tblscore s 
	        JOIN tblexercise e ON s.ExerciseID = e.ExerciseID 
	        WHERE e.TopicID = {$topicId} AND s.StudentID='{$studentid}' AND s.Submitted=1";
	$mydb->setQuery($sql);
	$row = $mydb->executeQuery(); 
    $ans = $mydb->loadSingleResult();
    $score  = $ans->SCORE;
} else if($id == 'all') {
	// For all exercises, check if student has already taken the quiz
	$sql = "SELECT SUM(Score) as 'SCORE' FROM tblscore WHERE StudentID='{$studentid}' AND Submitted=1";
	$mydb->setQuery($sql);
	$row = $mydb->executeQuery(); 
    $ans = $mydb->loadSingleResult();
    $score  = $ans->SCORE;
} else {
	// For specific lesson
	$sql = "SELECT SUM(Score) as 'SCORE' FROM tblscore  WHERE LessonID='{$id}' and StudentID='{$studentid}' AND Submitted=1";
	$mydb->setQuery($sql);
	$row = $mydb->executeQuery(); 
    $ans = $mydb->loadSingleResult();
    $score  = $ans->SCORE;
}

if ($score!=null && $id != 'all') {
	# code...   
	redirect("index.php?q=quizresult&id={$id}&score={$score}");
}
?>

<?php
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
// Get questions data
if($topicId > 0) {
    $sql = "SELECT * FROM tblexercise WHERE TopicID = {$topicId} ORDER BY ExerciseID";
} else if($id == 'all') {
    $sql = "SELECT * FROM tblexercise ORDER BY ExerciseID";
} else {
    $sql = "SELECT * FROM tblexercise WHERE LessonID = '{$id}'";
}
$mydb->setQuery($sql);
$questions = $mydb->loadResultList();
$totalQuestions = count($questions);
$estimatedTime = $totalQuestions * 2; // 2 minutes per question
?>

<div class="quiz-container">
    <!-- Quiz Header -->
    <div class="quiz-header">
        <?php if($topicId > 0 && $topicInfo): ?>
            <!-- Breadcrumb -->
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
                <span class="breadcrumb-item active">
                    <i class="fas fa-question-circle"></i>
                    <span><?php echo $topicInfo->TopicName; ?> Quiz</span>
                </span>
            </nav>
            
            <div class="quiz-title-section">
                <h1 class="quiz-title"><?php echo $topicInfo->TopicName; ?> Quiz</h1>
                <p class="quiz-subtitle">Kiểm tra kiến thức của bạn với <?php echo $totalQuestions; ?> câu hỏi</p>
            </div>
        <?php else: ?>
            <div class="quiz-title-section">
                <h1 class="quiz-title">Quiz</h1>
                <p class="quiz-subtitle">Kiểm tra kiến thức của bạn</p>
            </div>
        <?php endif; ?>
        
        <!-- Quiz Stats -->
        <div class="quiz-stats">
            <div class="stat-item">
                <i class="fas fa-question-circle"></i>
                <span><?php echo $totalQuestions; ?> câu hỏi</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-clock"></i>
                <span>~<?php echo $estimatedTime; ?> phút</span>
            </div>
            <div class="stat-item">
                <i class="fas fa-trophy"></i>
                <span>Điểm tối đa: <?php echo $totalQuestions * 10; ?></span>
            </div>
        </div>
    </div>

    <!-- Quiz Progress -->
    <div class="quiz-progress-container">
        <div class="progress-header">
            <span class="progress-text">Câu hỏi <span id="currentQuestion">1</span> / <?php echo $totalQuestions; ?></span>
            <div class="quiz-timer" id="quizTimer">
                <i class="fas fa-clock"></i>
                <span id="timeDisplay">00:00</span>
            </div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
    </div>

    <!-- Quiz Form -->
    <form action="processscore.php" method="POST" id="quizForm">
        <input type="hidden" name="LessonID" value="<?php echo $id ?>">
        <input type="hidden" name="TopicID" value="<?php echo $topicId ?>">
        <input type="hidden" name="TimeSpent" id="timeSpentInput" value="0">
        
        <!-- Questions Container -->
        <div class="questions-container" id="questionsContainer">
            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question-card" data-question="<?php echo $index + 1; ?>" <?php echo $index === 0 ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                        <div class="question-header">
                            <div class="question-number">
                                <span class="question-badge">Câu <?php echo $index + 1; ?></span>
                                <div class="question-type">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Trắc nghiệm</span>
                                </div>
                            </div>
                            <div class="question-actions">
                                <button type="button" class="btn btn-ghost question-bookmark" title="Đánh dấu câu hỏi">
                                    <i class="far fa-bookmark"></i>
                                </button>
                                <button type="button" class="btn btn-ghost question-flag" title="Báo cáo câu hỏi">
                                    <i class="far fa-flag"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="question-content">
                            <h3 class="question-text"><?php echo htmlspecialchars($question->Question); ?></h3>
                            
                            <div class="choices-container">
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
                                        <label class="choice-option" for="choice_<?php echo $question->ExerciseID; ?>_<?php echo $letter; ?>">
                                            <input type="radio" 
                                                   id="choice_<?php echo $question->ExerciseID; ?>_<?php echo $letter; ?>"
                                                   class="choice-input" 
                                                   data-id="<?php echo $question->ExerciseID; ?>" 
                                                   name="choices_<?php echo $question->ExerciseID; ?>" 
                                                   value="<?php echo $letter; ?>">
                                            <div class="choice-indicator">
                                                <span class="choice-letter"><?php echo $letter; ?></span>
                                                <div class="choice-radio">
                                                    <div class="radio-inner"></div>
                                                </div>
                                            </div>
                                            <div class="choice-text"><?php echo htmlspecialchars($choice); ?></div>
                                        </label>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="question-navigation">
                            <?php if ($index > 0): ?>
                                <button type="button" class="btn btn-secondary nav-btn" onclick="previousQuestion()">
                                    <i class="fas fa-chevron-left"></i>
                                    <span>Câu trước</span>
                                </button>
                            <?php endif; ?>
                            
                            <div class="question-status">
                                <span class="answered-indicator" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Đã trả lời</span>
                                </span>
                            </div>
                            
                            <?php if ($index < $totalQuestions - 1): ?>
                                <button type="button" class="btn btn-primary nav-btn" onclick="nextQuestion()">
                                    <span>Câu tiếp</span>
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3 class="empty-title">Không có câu hỏi</h3>
                    <p class="empty-description">Hiện tại chưa có câu hỏi nào cho bài quiz này.</p>
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-home"></i>
                        <span>Về trang chủ</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Quiz Navigation -->
        <?php if (!empty($questions)): ?>
            <div class="quiz-navigation">
                <div class="question-overview">
                    <h4 class="overview-title">Tổng quan câu hỏi</h4>
                    <div class="question-grid">
                        <?php for ($i = 1; $i <= $totalQuestions; $i++): ?>
                            <button type="button" 
                                    class="question-nav-btn" 
                                    data-question="<?php echo $i; ?>"
                                    onclick="goToQuestion(<?php echo $i; ?>)">
                                <?php echo $i; ?>
                            </button>
                        <?php endfor; ?>
                    </div>
                    
                    <div class="overview-legend">
                        <div class="legend-item">
                            <div class="legend-indicator current"></div>
                            <span>Câu hiện tại</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-indicator answered"></div>
                            <span>Đã trả lời</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-indicator unanswered"></div>
                            <span>Chưa trả lời</span>
                        </div>
                    </div>
                </div>
                
                <div class="quiz-actions">
                    <div class="action-stats">
                        <div class="stat-item">
                            <span class="stat-label">Đã trả lời:</span>
                            <span class="stat-value" id="answeredCount">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Còn lại:</span>
                            <span class="stat-value" id="remainingCount"><?php echo $totalQuestions; ?></span>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button type="button" class="btn btn-ghost" onclick="reviewAnswers()">
                            <i class="fas fa-eye"></i>
                            <span>Xem lại</span>
                        </button>
                        <button type="button" class="btn btn-warning" onclick="resetQuiz()">
                            <i class="fas fa-redo"></i>
                            <span>Làm lại</span>
                        </button>
                        <button type="submit" class="btn btn-success submit-btn" name="btnSubmit" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            <span>Nộp bài</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>

<!-- Submit Confirmation Modal -->
<div class="modal fade" id="submitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane"></i>
                    Xác nhận nộp bài
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="submit-summary">
                    <div class="summary-item">
                        <i class="fas fa-question-circle"></i>
                        <span>Tổng số câu hỏi: <strong><?php echo $totalQuestions; ?></strong></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Đã trả lời: <strong id="modalAnsweredCount">0</strong></span>
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-clock"></i>
                        <span>Thời gian làm bài: <strong id="modalTimeSpent">00:00</strong></span>
                    </div>
                </div>
                
                <div class="warning-message" id="incompleteWarning" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Bạn chưa trả lời hết tất cả câu hỏi. Bạn có chắc chắn muốn nộp bài không?</p>
                </div>
                
                <p class="confirmation-text">Sau khi nộp bài, bạn sẽ không thể thay đổi câu trả lời. Bạn có chắc chắn muốn nộp bài không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    <span>Hủy</span>
                </button>
                <button type="button" class="btn btn-success" onclick="confirmSubmit()">
                    <i class="fas fa-paper-plane"></i>
                    <span>Xác nhận nộp bài</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentQuestionIndex = 0;
    const totalQuestions = <?php echo $totalQuestions; ?>;
    let startTime = Date.now();
    let timerInterval;
    let answeredQuestions = new Set();
    
    // Initialize quiz
    initializeQuiz();
    
    function initializeQuiz() {
        updateProgress();
        startTimer();
        setupEventListeners();
        updateNavigationButtons();
    }
    
    function startTimer() {
        timerInterval = setInterval(function() {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            const minutes = Math.floor(elapsed / 60);
            const seconds = elapsed % 60;
            const timeDisplay = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            
            document.getElementById('timeDisplay').textContent = timeDisplay;
            document.getElementById('timeSpentInput').value = elapsed;
        }, 1000);
    }
    
    function setupEventListeners() {
        // Choice selection
        document.querySelectorAll('.choice-input').forEach(input => {
            input.addEventListener('change', function() {
                const questionCard = this.closest('.question-card');
                const questionNum = parseInt(questionCard.dataset.question);
                
                // Mark question as answered
                answeredQuestions.add(questionNum);
                
                // Update UI
                updateAnsweredStatus(questionCard);
                updateNavigationButtons();
                updateQuestionOverview();
                updateStats();
                
                // Auto-advance to next question (optional)
                setTimeout(() => {
                    if (currentQuestionIndex < totalQuestions - 1) {
                        nextQuestion();
                    }
                }, 500);
            });
        });
        
        // Submit form
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            showSubmitModal();
        });
        
        // Bookmark and flag buttons
        document.querySelectorAll('.question-bookmark').forEach(btn => {
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
        
        document.querySelectorAll('.question-flag').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.classList.add('flagged');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.classList.remove('flagged');
                }
            });
        });
    }
    
    function updateProgress() {
        const progress = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        document.getElementById('progressFill').style.width = progress + '%';
        document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;
    }
    
    function updateAnsweredStatus(questionCard) {
        const statusIndicator = questionCard.querySelector('.answered-indicator');
        statusIndicator.style.display = 'flex';
    }
    
    function updateNavigationButtons() {
        const questionNavBtns = document.querySelectorAll('.question-nav-btn');
        questionNavBtns.forEach((btn, index) => {
            btn.classList.remove('current', 'answered');
            
            if (index === currentQuestionIndex) {
                btn.classList.add('current');
            } else if (answeredQuestions.has(index + 1)) {
                btn.classList.add('answered');
            }
        });
    }
    
    function updateQuestionOverview() {
        updateNavigationButtons();
    }
    
    function updateStats() {
        document.getElementById('answeredCount').textContent = answeredQuestions.size;
        document.getElementById('remainingCount').textContent = totalQuestions - answeredQuestions.size;
    }
    
    function showSubmitModal() {
        document.getElementById('modalAnsweredCount').textContent = answeredQuestions.size;
        document.getElementById('modalTimeSpent').textContent = document.getElementById('timeDisplay').textContent;
        
        const incompleteWarning = document.getElementById('incompleteWarning');
        if (answeredQuestions.size < totalQuestions) {
            incompleteWarning.style.display = 'block';
        } else {
            incompleteWarning.style.display = 'none';
        }
        
        const modal = new bootstrap.Modal(document.getElementById('submitModal'));
        modal.show();
    }
    
    // Global functions for navigation
    window.nextQuestion = function() {
        if (currentQuestionIndex < totalQuestions - 1) {
            document.querySelectorAll('.question-card')[currentQuestionIndex].style.display = 'none';
            currentQuestionIndex++;
            document.querySelectorAll('.question-card')[currentQuestionIndex].style.display = 'block';
            updateProgress();
            updateNavigationButtons();
        }
    };
    
    window.previousQuestion = function() {
        if (currentQuestionIndex > 0) {
            document.querySelectorAll('.question-card')[currentQuestionIndex].style.display = 'none';
            currentQuestionIndex--;
            document.querySelectorAll('.question-card')[currentQuestionIndex].style.display = 'block';
            updateProgress();
            updateNavigationButtons();
        }
    };
    
    window.goToQuestion = function(questionNum) {
        document.querySelectorAll('.question-card')[currentQuestionIndex].style.display = 'none';
        currentQuestionIndex = questionNum - 1;
        document.querySelectorAll('.question-card')[currentQuestionIndex].style.display = 'block';
        updateProgress();
        updateNavigationButtons();
    };
    
    window.reviewAnswers = function() {
        // Show all answered questions for review
        alert('Chức năng xem lại đang được phát triển');
    };
    
    window.resetQuiz = function() {
        if (confirm('Bạn có chắc chắn muốn làm lại từ đầu? Tất cả câu trả lời sẽ bị xóa.')) {
            // Reset all answers
            document.querySelectorAll('.choice-input').forEach(input => {
                input.checked = false;
            });
            
            // Reset state
            answeredQuestions.clear();
            currentQuestionIndex = 0;
            
            // Reset UI
            document.querySelectorAll('.question-card').forEach((card, index) => {
                card.style.display = index === 0 ? 'block' : 'none';
                card.querySelector('.answered-indicator').style.display = 'none';
            });
            
            updateProgress();
            updateNavigationButtons();
            updateStats();
            
            // Reset timer
            clearInterval(timerInterval);
            startTime = Date.now();
            startTimer();
        }
    };
    
    window.confirmSubmit = function() {
        clearInterval(timerInterval);
        document.getElementById('quizForm').submit();
    };
    
    // Prevent accidental page refresh
    window.addEventListener('beforeunload', function(e) {
        if (answeredQuestions.size > 0) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
});
</script>