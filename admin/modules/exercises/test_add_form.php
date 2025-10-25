<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Test Add Form</h1>";

if (isset($_POST['test_add'])) {
    echo "<h2>Form Data Received:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    // Test direct insert
    $autonum = new Autonumber();
    $resauto = $autonum->set_autonumber('ExerciseID');
    $ExerciseID = date('Y') . (isset($resauto->AUTO) ? $resauto->AUTO : '0001');
    
    $categoryId = (int)$_POST['Category'];
    $topicId = (int)$_POST['Topic'];
    $question = $mydb->escape_value($_POST['Question']);
    
    $sql = "INSERT INTO tblexercise (ExerciseID, LessonID, CategoryID, TopicID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
            VALUES ('{$ExerciseID}', 0, {$categoryId}, {$topicId}, '{$question}', 'A', 'B', 'C', 'D', 'A', '0000-00-00')";
    $mydb->setQuery($sql);
    $result = $mydb->executeQuery();
    
    if ($result) {
        echo "<p style='color: green;'>✅ Test insert successful! ExerciseID: {$ExerciseID}</p>";
        
        $autonum = new Autonumber();
        $autonum->auto_update('ExerciseID');
    } else {
        echo "<p style='color: red;'>❌ Test insert failed!</p>";
    }
}
?>

<form method="post">
    <h2>Test Add Form:</h2>
    <p>Category: 
        <select name="Category" required>
            <option value="">Select</option>
            <option value="2">Science</option>
            <option value="3">Mathematics</option>
        </select>
    </p>
    <p>Topic: 
        <select name="Topic" required>
            <option value="">Select</option>
            <option value="5">Physics</option>
            <option value="8">Algebra</option>
        </select>
    </p>
    <p>Question: <input type="text" name="Question" value="Test Question" required></p>
    <button type="submit" name="test_add">Test Add</button>
</form>

<p><a href="index.php">Back to Admin</a></p>