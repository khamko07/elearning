<?php
require_once("include/initialize.php");  

if (!isset($_SESSION['StudentID'])) {
    redirect('login.php');
}

$score = 0;
$totalQuestions = 0;
$correctAnswers = 0;
$studentid = $_SESSION['StudentID'];
$lessonid = $_POST['LessonID'];

// Get all exercises
if($lessonid == 'all') {
    $sql = "SELECT * FROM tblexercise ORDER BY ExerciseID";
} else {
    $sql = "SELECT * FROM tblexercise WHERE LessonID = '{$lessonid}'";
}
$mydb->setQuery($sql);
$exercises = $mydb->loadResultList();

// Process each answer
foreach ($exercises as $exercise) {
    $totalQuestions++;
    $questionName = 'choices_' . $exercise->ExerciseID;
    
    if (isset($_POST[$questionName])) {
        $userAnswer = $_POST[$questionName];
        $correctAnswer = $exercise->Answer;
        
        if ($userAnswer == $correctAnswer) {
            $correctAnswers++;
            
            // Insert or update score for this exercise
            $sql = "INSERT INTO tblscore (StudentID, LessonID, ExerciseID, Score, Submitted, NoItems) 
                    VALUES ('{$studentid}', '{$lessonid}', '{$exercise->ExerciseID}', 1, 1, 1)
                    ON DUPLICATE KEY UPDATE Score = 1, Submitted = 1";
            $mydb->setQuery($sql);
            $mydb->executeQuery();
        } else {
            // Insert 0 score for wrong answer
            $sql = "INSERT INTO tblscore (StudentID, LessonID, ExerciseID, Score, Submitted, NoItems) 
                    VALUES ('{$studentid}', '{$lessonid}', '{$exercise->ExerciseID}', 0, 1, 1)
                    ON DUPLICATE KEY UPDATE Score = 0, Submitted = 1";
            $mydb->setQuery($sql);
            $mydb->executeQuery();
        }
    }
}

// Calculate final score percentage
$score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

message("Quiz submitted successfully! You scored {$correctAnswers} out of {$totalQuestions} questions.", "success");
redirect("index.php?q=quizresult&id={$lessonid}&score={$score}&correct={$correctAnswers}&total={$totalQuestions}");

?>