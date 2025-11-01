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

// Check if user wants to retake the quiz
$retake = isset($_GET['retake']) && $_GET['retake'] == '1';

if ($score!=null && $id != 'all' && !$retake) {
	# Redirect to result page showing previous score with option to retake
	
	// Get total number of questions for this quiz
	$totalQuestions = 0;
	if($topicId > 0) {
		$sql = "SELECT COUNT(*) as total FROM tblexercise WHERE TopicID = {$topicId}";
	} else {
		$sql = "SELECT COUNT(*) as total FROM tblexercise WHERE LessonID = '{$id}'";
	}
	$mydb->setQuery($sql);
	$totalResult = $mydb->loadSingleResult();
	$totalQuestions = $totalResult ? $totalResult->total : 0;
	
	// Calculate percentage
	$correctAnswers = $score;
	$scorePercentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
	
	$redirectUrl = "index.php?q=quizresult&id={$id}";
	if($topicId > 0) {
		$redirectUrl .= "&topic={$topicId}";
	}
	$redirectUrl .= "&score={$scorePercentage}&correct={$correctAnswers}&total={$totalQuestions}";
	redirect($redirectUrl);
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

<?php if($topicId > 0 && $topicInfo): ?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="index.php?q=categories">Exercise Categories</a></li>
            <li><a href="index.php?q=topics&category=<?php echo $topicInfo->CategoryID; ?>"><?php echo $topicInfo->CategoryName; ?></a></li>
            <li class="active"><?php echo $topicInfo->TopicName; ?> Quiz</li>
        </ol>
    </div>
</div>
<h1><?php echo $topicInfo->TopicName; ?> Quiz</h1>
<h5>Choose the correct answer for each question.</h5>
<?php else: ?>
<h1>Quiz</h1>
<h5>Choose the correct answer.</h5>
<?php endif; ?>
<form action="processscore.php" method="POST">
	<input type="hidden" name="LessonID" value="<?php echo $id ?>">
	<input type="hidden" name="TopicID" value="<?php echo $topicId ?>">
	
	<div style="height:400px;overflow-y:auto;"> 
	<?php   
	  if($topicId > 0) {
	  	$sql = "SELECT * FROM tblexercise WHERE TopicID = {$topicId} ORDER BY ExerciseID";
	  } else if($id == 'all') {
	  	$sql = "SELECT * FROM tblexercise ORDER BY ExerciseID";
	  } else {
	  	$sql = "SELECT * FROM tblexercise WHERE LessonID = '{$id}'";
	  }
	  $mydb->setQuery($sql);
	  $cur = $mydb->loadResultList();

	  $questionNum = 1;
	  foreach ($cur as $res) {
	?> 
	<div style="margin-bottom: 30px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
		<h4>Question <?php echo $questionNum; ?>:</h4>
		<p><strong><?php echo $res->Question ; ?></strong></p>
		<div class="row">
			<div class="col-md-6">
				<label><input class="radios" type="radio" data-id="<?php echo $res->ExerciseID;?>" name="choices_<?php echo $res->ExerciseID;?>" value="A"> A. <?php echo $res->ChoiceA; ?></label>
			</div>
			<div class="col-md-6">
				<label><input class="radios" type="radio" data-id="<?php echo $res->ExerciseID;?>" name="choices_<?php echo $res->ExerciseID;?>" value="B"> B. <?php echo $res->ChoiceB; ?></label>
			</div>
			<div class="col-md-6">
				<label><input class="radios" type="radio" data-id="<?php echo $res->ExerciseID;?>" name="choices_<?php echo $res->ExerciseID;?>" value="C"> C. <?php echo $res->ChoiceC; ?></label>
			</div>
			<div class="col-md-6">
				<label><input class="radios" type="radio" data-id="<?php echo $res->ExerciseID;?>" name="choices_<?php echo $res->ExerciseID;?>" value="D"> D. <?php echo $res->ChoiceD; ?></label>
			</div>
		</div>
	</div>
	<?php 
		$questionNum++;
	} ?>
	</div>
	
	<div style="margin-top: 20px;text-align: right;">
		<button class="btn btn-md btn-primary" type="submit" name="btnSubmit">Submit Quiz <i class="fa fa-arrow-right"></i></button>
	</div>
</form>