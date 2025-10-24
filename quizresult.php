<?php 
$studentid = $_SESSION['StudentID'];
$score = isset($_GET['score']) ? $_GET['score'] : 0;
$correct = isset($_GET['correct']) ? $_GET['correct'] : 0;
$total = isset($_GET['total']) ? $_GET['total'] : 0;
$id = $_GET['id'];

if($id==''){
    redirect("index.php");
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Quiz Results</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <h2>Your Score: <?php echo $score; ?>%</h2>
                    <p>You answered <strong><?php echo $correct; ?></strong> out of <strong><?php echo $total; ?></strong> questions correctly.</p>
                    
                    <?php if($score >= 80): ?>
                        <div class="alert alert-success">
                            <strong>Excellent!</strong> You passed the quiz with flying colors!
                        </div>
                    <?php elseif($score >= 60): ?>
                        <div class="alert alert-warning">
                            <strong>Good job!</strong> You passed the quiz.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <strong>Keep studying!</strong> You need to score at least 60% to pass.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<h3>Review Your Answers</h3>
<div style="max-height:400px;overflow-y:auto;"> 
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
      // Get user's answer for this question
      $sql = "SELECT * FROM tblscore WHERE ExerciseID='{$res->ExerciseID}' AND StudentID='{$studentid}'";
      $mydb->setQuery($sql);
      $userScore = $mydb->loadSingleResult();
      $isCorrect = ($userScore && $userScore->Score == 1);
?> 
<div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; <?php echo $isCorrect ? 'background-color: #d4edda;' : 'background-color: #f8d7da;'; ?>">
    <h4>Question <?php echo $questionNum; ?>: 
        <?php if($isCorrect): ?>
            <span class="label label-success">Correct</span>
        <?php else: ?>
            <span class="label label-danger">Incorrect</span>
        <?php endif; ?>
    </h4>
    <p><strong><?php echo $res->Question; ?></strong></p>
    
    <div class="row">
        <div class="col-md-6">
            <label style="<?php echo ($res->Answer == 'A') ? 'color: green; font-weight: bold;' : ''; ?>">
                A. <?php echo $res->ChoiceA; ?>
                <?php if($res->Answer == 'A'): ?><span class="label label-success">Correct Answer</span><?php endif; ?>
            </label>
        </div>
        <div class="col-md-6">
            <label style="<?php echo ($res->Answer == 'B') ? 'color: green; font-weight: bold;' : ''; ?>">
                B. <?php echo $res->ChoiceB; ?>
                <?php if($res->Answer == 'B'): ?><span class="label label-success">Correct Answer</span><?php endif; ?>
            </label>
        </div>
        <div class="col-md-6">
            <label style="<?php echo ($res->Answer == 'C') ? 'color: green; font-weight: bold;' : ''; ?>">
                C. <?php echo $res->ChoiceC; ?>
                <?php if($res->Answer == 'C'): ?><span class="label label-success">Correct Answer</span><?php endif; ?>
            </label>
        </div>
        <div class="col-md-6">
            <label style="<?php echo ($res->Answer == 'D') ? 'color: green; font-weight: bold;' : ''; ?>">
                D. <?php echo $res->ChoiceD; ?>
                <?php if($res->Answer == 'D'): ?><span class="label label-success">Correct Answer</span><?php endif; ?>
            </label>
        </div>
    </div>
</div>
<?php 
    $questionNum++;
} ?>
</div>

<div style="text-align: center; margin-top: 20px;">
    <a href="index.php?q=exercises" class="btn btn-primary">Back to Exercises</a>
    <a href="index.php" class="btn btn-default">Home</a>
</div>