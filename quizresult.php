<?php 
$studentid = $_SESSION['StudentID'];
$score = isset($_GET['score']) ? (int)$_GET['score'] : 0;
$correct = isset($_GET['correct']) ? (int)$_GET['correct'] : 0;
$total = isset($_GET['total']) ? (int)$_GET['total'] : 0;
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

// Get questions for review
if($topicId > 0) {
    $sql = "SELECT * FROM tblexercise WHERE TopicID = {$topicId} ORDER BY ExerciseID";
} else if($id == 'all') {
    $sql = "SELECT * FROM tblexercise ORDER BY ExerciseID";
} else {
    $sql = "SELECT * FROM tblexercise WHERE LessonID = '{$id}'";
}
$mydb->setQuery($sql);
$cur = $mydb->loadResultList();

$wrong = $total - $correct;
?>

<div class="result-container">
	<!-- Breadcrumb Navigation -->
	<?php if($topicId > 0 && $topicInfo): ?>
	<nav aria-label="breadcrumb" class="mb-4">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="index.php?q=categories">Exercise Categories</a>
			</li>
			<li class="breadcrumb-item">
				<a href="index.php?q=topics&category=<?php echo $topicInfo->CategoryID; ?>"><?php echo htmlspecialchars($topicInfo->CategoryName); ?></a>
			</li>
			<li class="breadcrumb-item">
				<a href="index.php?q=question&topic=<?php echo $topicId; ?>"><?php echo htmlspecialchars($topicInfo->TopicName); ?> Quiz</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Results</li>
		</ol>
	</nav>
	<?php endif; ?>

	<!-- Score Card -->
	<div class="score-card">
		<div class="score-circle">
			<svg class="score-ring" width="200" height="200">
				<circle class="score-ring-bg" cx="100" cy="100" r="90"></circle>
				<circle class="score-ring-fill" 
				        cx="100" cy="100" r="90"
				        style="stroke-dashoffset: <?php echo 565.48 - (565.48 * $score / 100); ?>"></circle>
			</svg>
			<div class="score-text">
				<span class="score-value"><?php echo $score; ?>%</span>
				<span class="score-label">Score</span>
			</div>
		</div>
		
		<div class="score-stats">
			<div class="stat-item">
				<i class="fas fa-check-circle text-success"></i>
				<span class="stat-value"><?php echo $correct; ?></span>
				<span class="stat-label">Correct</span>
			</div>
			<div class="stat-item">
				<i class="fas fa-times-circle text-danger"></i>
				<span class="stat-value"><?php echo $wrong; ?></span>
				<span class="stat-label">Wrong</span>
			</div>
			<div class="stat-item">
				<i class="fas fa-list"></i>
				<span class="stat-value"><?php echo $total; ?></span>
				<span class="stat-label">Total</span>
			</div>
		</div>
		
		<!-- Score Message -->
		<div class="mt-4">
			<?php if($score >= 80): ?>
				<div class="alert alert-success">
					<h4><i class="fas fa-trophy me-2"></i>Excellent!</h4>
					<p class="mb-0">You passed the quiz with flying colors! Keep up the great work!</p>
				</div>
			<?php elseif($score >= 60): ?>
				<div class="alert alert-info">
					<h4><i class="fas fa-check-circle me-2"></i>Good Job!</h4>
					<p class="mb-0">You passed the quiz. Well done!</p>
				</div>
			<?php else: ?>
				<div class="alert alert-warning">
					<h4><i class="fas fa-exclamation-triangle me-2"></i>Keep Studying!</h4>
					<p class="mb-0">You need to score at least 60% to pass. Review the material and try again!</p>
				</div>
			<?php endif; ?>
		</div>
		
		<!-- Action Buttons -->
		<div class="result-actions">
			<?php if($topicId > 0 && $topicInfo): ?>
				<button onclick="confirmRetake(<?php echo $topicId; ?>)" class="btn btn-warning btn-lg">
					<i class="fas fa-redo me-2"></i>Retry Quiz
				</button>
				<a href="index.php?q=topics&category=<?php echo $topicInfo->CategoryID; ?>" class="btn btn-secondary btn-lg">
					<i class="fas fa-arrow-left me-2"></i>Back to Topics
				</a>
			<?php else: ?>
				<a href="index.php?q=categories" class="btn btn-secondary btn-lg">
					<i class="fas fa-arrow-left me-2"></i>Back to Categories
				</a>
			<?php endif; ?>
			<a href="index.php" class="btn btn-outline-primary btn-lg">
				<i class="fas fa-home me-2"></i>Home
			</a>
		</div>
	</div>
	
	<!-- Answer Review Section -->
	<div class="answer-review">
		<h3 class="mb-4">
			<i class="fas fa-clipboard-check me-2"></i>Review Your Answers
		</h3>
		
		<?php  
		$questionNum = 1;
		foreach ($cur as $res) {
			// Get user's answer for this question
			$sql = "SELECT * FROM tblscore WHERE ExerciseID='{$res->ExerciseID}' AND StudentID='{$studentid}'";
			$mydb->setQuery($sql);
			$userScore = $mydb->loadSingleResult();
			$isCorrect = ($userScore && $userScore->Score == 1);
			$userAnswer = $userScore ? $userScore->Value : '';
		?> 
		<div class="answer-item <?php echo $isCorrect ? 'correct' : 'incorrect'; ?>">
			<span class="answer-number"><?php echo $questionNum; ?></span>
			<span class="answer-status">
				<?php if($isCorrect): ?>
					<i class="fas fa-check-circle"></i>
				<?php else: ?>
					<i class="fas fa-times-circle"></i>
				<?php endif; ?>
			</span>
			<div class="answer-content">
				<h5><?php echo htmlspecialchars($res->Question); ?></h5>
				<div class="answer-choices">
					<div class="choice-review <?php echo ($res->Answer == 'A') ? 'correct-answer' : (($userAnswer == 'A' && !$isCorrect) ? 'wrong-answer' : ''); ?>">
						<strong>A.</strong> <?php echo htmlspecialchars($res->ChoiceA); ?>
						<?php if($res->Answer == 'A'): ?>
							<span class="badge badge-success ms-2">Correct Answer</span>
						<?php endif; ?>
						<?php if($userAnswer == 'A' && !$isCorrect): ?>
							<span class="badge badge-danger ms-2">Your Answer</span>
						<?php endif; ?>
					</div>
					<div class="choice-review <?php echo ($res->Answer == 'B') ? 'correct-answer' : (($userAnswer == 'B' && !$isCorrect) ? 'wrong-answer' : ''); ?>">
						<strong>B.</strong> <?php echo htmlspecialchars($res->ChoiceB); ?>
						<?php if($res->Answer == 'B'): ?>
							<span class="badge badge-success ms-2">Correct Answer</span>
						<?php endif; ?>
						<?php if($userAnswer == 'B' && !$isCorrect): ?>
							<span class="badge badge-danger ms-2">Your Answer</span>
						<?php endif; ?>
					</div>
					<div class="choice-review <?php echo ($res->Answer == 'C') ? 'correct-answer' : (($userAnswer == 'C' && !$isCorrect) ? 'wrong-answer' : ''); ?>">
						<strong>C.</strong> <?php echo htmlspecialchars($res->ChoiceC); ?>
						<?php if($res->Answer == 'C'): ?>
							<span class="badge badge-success ms-2">Correct Answer</span>
						<?php endif; ?>
						<?php if($userAnswer == 'C' && !$isCorrect): ?>
							<span class="badge badge-danger ms-2">Your Answer</span>
						<?php endif; ?>
					</div>
					<div class="choice-review <?php echo ($res->Answer == 'D') ? 'correct-answer' : (($userAnswer == 'D' && !$isCorrect) ? 'wrong-answer' : ''); ?>">
						<strong>D.</strong> <?php echo htmlspecialchars($res->ChoiceD); ?>
						<?php if($res->Answer == 'D'): ?>
							<span class="badge badge-success ms-2">Correct Answer</span>
						<?php endif; ?>
						<?php if($userAnswer == 'D' && !$isCorrect): ?>
							<span class="badge badge-danger ms-2">Your Answer</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php 
			$questionNum++;
		} 
		?>
	</div>
</div>

<!-- Retake Confirmation Modal -->
<div class="modal fade" id="retakeModal" tabindex="-1" aria-labelledby="retakeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h5 class="modal-title" id="retakeModalLabel">
					<i class="fas fa-redo me-2"></i>Retake Quiz
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="alert alert-warning">
					<h5><i class="fas fa-exclamation-triangle me-2"></i>Confirm Retake</h5>
					<p><strong>Your current score: <?php echo $score; ?>%</strong></p>
					<p>When you retake the quiz, the system will:</p>
					<ul>
						<li>✅ Save your previous score history</li>
						<li>✅ Allow you to retake the entire quiz</li>
						<li>✅ Update with your new score (may be higher or lower)</li>
						<li>📊 Display both old and new scores for comparison</li>
					</ul>
					<p class="text-info mb-0">
						<i class="fas fa-lightbulb me-2"></i><strong>Note:</strong> You can retake the quiz unlimited times!
					</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
					<i class="fas fa-times me-2"></i>Cancel
				</button>
				<button type="button" class="btn btn-warning" onclick="doRetake()">
					<i class="fas fa-redo me-2"></i>Yes, Retake Quiz
				</button>
			</div>
		</div>
	</div>
</div>

<style>
.score-ring {
	transform: rotate(-90deg);
}

.score-ring-bg {
	fill: none;
	stroke: var(--gray-200);
	stroke-width: 10;
}

.score-ring-fill {
	fill: none;
	stroke: var(--primary-blue);
	stroke-width: 10;
	stroke-linecap: round;
	stroke-dasharray: 565.48;
	transition: stroke-dashoffset 1s ease-in-out;
}

.answer-choices {
	margin-top: var(--space-3);
}

.choice-review {
	padding: var(--space-2) var(--space-3);
	margin-bottom: var(--space-2);
	border-radius: var(--radius-md);
	transition: all var(--transition-base);
}

.choice-review.correct-answer {
	background-color: rgba(40, 167, 69, 0.1);
	border-left: 3px solid var(--success);
	padding-left: calc(var(--space-3) - 3px);
}

.choice-review.wrong-answer {
	background-color: rgba(220, 53, 69, 0.1);
	border-left: 3px solid var(--danger);
	padding-left: calc(var(--space-3) - 3px);
}
</style>

<script>
let retakeTopicId = 0;

function confirmRetake(topicId) {
	retakeTopicId = topicId;
	const retakeModal = new bootstrap.Modal(document.getElementById('retakeModal'));
	retakeModal.show();
}

function doRetake() {
	if(retakeTopicId > 0) {
		window.location.href = 'index.php?q=question&topic=' + retakeTopicId + '&retake=1';
	}
}

// Animate score on page load
document.addEventListener('DOMContentLoaded', function() {
	const scoreValue = document.querySelector('.score-value');
	if (scoreValue) {
		const targetScore = <?php echo $score; ?>;
		let currentScore = 0;
		const increment = targetScore / 50;
		const timer = setInterval(() => {
			currentScore += increment;
			if (currentScore >= targetScore) {
				currentScore = targetScore;
				clearInterval(timer);
			}
			scoreValue.textContent = Math.round(currentScore) + '%';
		}, 20);
	}
});
</script>
