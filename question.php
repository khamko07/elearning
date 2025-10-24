<?php
$studentid = $_SESSION['StudentID'];
$score = 0;
$id = $_GET['id'];
if($id==''){
redirect("index.php");
}

// Check if this is for all exercises or specific lesson
if($id == 'all') {
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

<h1>Question</h1>
<h5>Choose the correct answer.</h5>
<div style="height:400px;overflow-y:auto;"> 
<?php   
  if($id == 'all') {
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
<form action="processscore.php" method="POST" style="margin-top: 20px;text-align: right;">
	<input type="hidden" name="LessonID" value="<?php echo $id ?>">
	<button class="btn btn-md btn-primary" type="submit" name="btnSubmit">Submit Quiz <i class="fa fa-arrow-right"></i></button>
</form>