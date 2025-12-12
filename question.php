<?php
require_once("include/initialize.php");

if (!isset($_SESSION['StudentID'])) {
    redirect('login.php');
}

$studentid = $_SESSION['StudentID'];
$score = 0;
$id = isset($_GET['id']) ? $_GET['id'] : '';
$topicId = isset($_GET['topic']) ? (int)$_GET['topic'] : 0;

if($id == '' && $topicId == 0){
    redirect("index.php");
}

// Check if this is for all exercises, specific topic, or specific lesson
if($topicId > 0) {
	$sql = "SELECT SUM(Score) as 'SCORE' FROM tblscore s 
	        JOIN tblexercise e ON s.ExerciseID = e.ExerciseID 
	        WHERE e.TopicID = {$topicId} AND s.StudentID='{$studentid}' AND s.Submitted=1";
	$mydb->setQuery($sql);
	$row = $mydb->executeQuery(); 
    $ans = $mydb->loadSingleResult();
    $score  = $ans->SCORE;
} else if($id == 'all') {
	$sql = "SELECT SUM(Score) as 'SCORE' FROM tblscore WHERE StudentID='{$studentid}' AND Submitted=1";
	$mydb->setQuery($sql);
	$row = $mydb->executeQuery(); 
    $ans = $mydb->loadSingleResult();
    $score  = $ans->SCORE;
} else {
	$sql = "SELECT SUM(Score) as 'SCORE' FROM tblscore  WHERE LessonID='{$id}' and StudentID='{$studentid}' AND Submitted=1";
	$mydb->setQuery($sql);
	$row = $mydb->executeQuery(); 
    $ans = $mydb->loadSingleResult();
    $score  = $ans->SCORE;
}

$retake = isset($_GET['retake']) && $_GET['retake'] == '1';

if ($score!=null && $id != 'all' && !$retake) {
	$totalQuestions = 0;
	if($topicId > 0) {
		$sql = "SELECT COUNT(*) as total FROM tblexercise WHERE TopicID = {$topicId}";
	} else {
		$sql = "SELECT COUNT(*) as total FROM tblexercise WHERE LessonID = '{$id}'";
	}
	$mydb->setQuery($sql);
	$totalResult = $mydb->loadSingleResult();
	$totalQuestions = $totalResult ? $totalResult->total : 0;
	
	$correctAnswers = $score;
	$scorePercentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
	
	$redirectUrl = "index.php?q=quizresult&id={$id}";
	if($topicId > 0) {
		$redirectUrl .= "&topic={$topicId}";
	}
	$redirectUrl .= "&score={$scorePercentage}&correct={$correctAnswers}&total={$totalQuestions}";
	redirect($redirectUrl);
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

// Get questions
if($topicId > 0) {
	$sql = "SELECT * FROM tblexercise WHERE TopicID = {$topicId} ORDER BY ExerciseID";
} else if($id == 'all') {
	$sql = "SELECT * FROM tblexercise ORDER BY ExerciseID";
} else {
	$sql = "SELECT * FROM tblexercise WHERE LessonID = '{$id}'";
}
$mydb->setQuery($sql);
$cur = $mydb->loadResultList();
$totalQuestions = count($cur);
?>

<div class="quiz-container">
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
			<li class="breadcrumb-item active" aria-current="page">
				<?php echo htmlspecialchars($topicInfo->TopicName); ?> Quiz
			</li>
		</ol>
	</nav>
	<?php endif; ?>

	<!-- Quiz Header -->
	<div class="quiz-header">
		<div class="progress-bar">
			<div class="progress-fill" id="quizProgress" style="width: 0%"></div>
		</div>
		<span class="question-counter">
			<span id="currentQuestion">0</span> of <?php echo $totalQuestions; ?> questions
		</span>
	</div>

	<!-- Quiz Title -->
	<div class="mb-4">
		<?php if($topicId > 0 && $topicInfo): ?>
			<h1><?php echo htmlspecialchars($topicInfo->TopicName); ?> Quiz</h1>
		<?php else: ?>
			<h1>Quiz</h1>
		<?php endif; ?>
		<p class="lead text-muted">Choose the correct answer for each question</p>
	</div>

	<!-- Quiz Form -->
	<form action="processscore.php" method="POST" id="quizForm">
		<input type="hidden" name="LessonID" value="<?php echo $id ?>">
		<input type="hidden" name="TopicID" value="<?php echo $topicId ?>">
		
		<?php   
		$questionNum = 1;
		foreach ($cur as $res) {
		?> 
		<div class="question-card" data-question="<?php echo $questionNum; ?>">
			<h3 class="question-text">
				Question <?php echo $questionNum; ?>: <?php echo htmlspecialchars($res->Question); ?>
			</h3>
			
			<div class="choices">
				<label class="choice-item">
					<input type="radio" 
					       class="radios" 
					       data-id="<?php echo $res->ExerciseID;?>" 
					       name="choices_<?php echo $res->ExerciseID;?>" 
					       value="A"
					       required>
					<span class="choice-label">A</span>
					<span class="choice-text"><?php echo htmlspecialchars($res->ChoiceA); ?></span>
					<span class="choice-check"><i class="fas fa-check"></i></span>
				</label>
				
				<label class="choice-item">
					<input type="radio" 
					       class="radios" 
					       data-id="<?php echo $res->ExerciseID;?>" 
					       name="choices_<?php echo $res->ExerciseID;?>" 
					       value="B"
					       required>
					<span class="choice-label">B</span>
					<span class="choice-text"><?php echo htmlspecialchars($res->ChoiceB); ?></span>
					<span class="choice-check"><i class="fas fa-check"></i></span>
				</label>
				
				<label class="choice-item">
					<input type="radio" 
					       class="radios" 
					       data-id="<?php echo $res->ExerciseID;?>" 
					       name="choices_<?php echo $res->ExerciseID;?>" 
					       value="C"
					       required>
					<span class="choice-label">C</span>
					<span class="choice-text"><?php echo htmlspecialchars($res->ChoiceC); ?></span>
					<span class="choice-check"><i class="fas fa-check"></i></span>
				</label>
				
				<label class="choice-item">
					<input type="radio" 
					       class="radios" 
					       data-id="<?php echo $res->ExerciseID;?>" 
					       name="choices_<?php echo $res->ExerciseID;?>" 
					       value="D"
					       required>
					<span class="choice-label">D</span>
					<span class="choice-text"><?php echo htmlspecialchars($res->ChoiceD); ?></span>
					<span class="choice-check"><i class="fas fa-check"></i></span>
				</label>
			</div>
		</div>
		<?php 
			$questionNum++;
		} 
		?>
		
		<!-- Quiz Footer -->
		<div class="quiz-footer">
			<button type="button" class="btn btn-secondary" onclick="window.history.back()">
				<i class="fas fa-arrow-left me-2"></i>Cancel
			</button>
			<button type="submit" name="btnSubmit" class="btn btn-primary btn-lg" id="submitBtn">
				Submit Quiz <i class="fas fa-arrow-right ms-2"></i>
			</button>
		</div>
	</form>
</div>

<!-- Submission Confirmation Modal -->
<div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="submitModalLabel">
					<i class="fas fa-exclamation-triangle me-2"></i>Confirm Submission
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to submit your quiz?</p>
				<p class="text-muted">You have answered <strong id="answeredCount">0</strong> out of <?php echo $totalQuestions; ?> questions.</p>
				<?php if($totalQuestions > 0): ?>
					<div class="alert alert-warning">
						<i class="fas fa-info-circle me-2"></i>
						Please make sure you have reviewed all your answers before submitting.
					</div>
				<?php endif; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="confirmSubmit">
					<i class="fas fa-check me-2"></i>Yes, Submit Quiz
				</button>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const form = document.getElementById('quizForm');
	const submitBtn = document.getElementById('submitBtn');
	const submitModal = new bootstrap.Modal(document.getElementById('submitModal'));
	const progressBar = document.getElementById('quizProgress');
	const currentQuestionSpan = document.getElementById('currentQuestion');
	const answeredCountSpan = document.getElementById('answeredCount');
	
	const totalQuestions = <?php echo $totalQuestions; ?>;
	const questionCards = document.querySelectorAll('.question-card');
	
	// Update progress on answer selection
	function updateProgress() {
		let answered = 0;
		questionCards.forEach((card, index) => {
			const radios = card.querySelectorAll('input[type="radio"]');
			const isAnswered = Array.from(radios).some(radio => radio.checked);
			if (isAnswered) {
				answered++;
			}
		});
		
		const progress = totalQuestions > 0 ? (answered / totalQuestions) * 100 : 0;
		progressBar.style.width = progress + '%';
		currentQuestionSpan.textContent = answered;
		answeredCountSpan.textContent = answered;
	}
	
	// Listen to radio changes
	document.querySelectorAll('.radios').forEach(radio => {
		radio.addEventListener('change', updateProgress);
	});
	
	// Initial progress update
	updateProgress();
	
	// Prevent form submission, show modal instead
	form.addEventListener('submit', function(e) {
		e.preventDefault();
		submitModal.show();
	});
	
	// Confirm submission
	document.getElementById('confirmSubmit').addEventListener('click', function() {
		submitModal.hide();
		form.submit();
	});
	
	// AJAX call for saving answers (existing functionality)
	$(document).on("change", ".radios", function() {
		var exerciseid = $(this).data('id');
		var value = $(this).val();
		
		if ($(this).is(':checked')) {
			$.ajax({
				type: "POST",
				url: "validation.php",
				dataType: "text",
				data: {ExerciseID: exerciseid, Value: value},
				success: function(data) {
					// Answer saved
				}
			});
		}
	});
});
</script>
