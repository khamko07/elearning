<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Test Exercise Class</h1>";

// Test dbfields
$exercise = new Exercise();
$fields = $exercise->dbfields();

echo "<h2>Database Fields Detected:</h2>";
echo "<pre>";
print_r($fields);
echo "</pre>";

// Check if CategoryID and TopicID are in fields
$hasCategoryID = in_array('CategoryID', $fields);
$hasTopicID = in_array('TopicID', $fields);

echo "<p>Has CategoryID: " . ($hasCategoryID ? "✅ YES" : "❌ NO") . "</p>";
echo "<p>Has TopicID: " . ($hasTopicID ? "✅ YES" : "❌ NO") . "</p>";

// Test manual insert
echo "<h2>Test Manual Insert:</h2>";
if (isset($_POST['test_insert'])) {
    // Generate unique ID
    $ExerciseID = date('Y') . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    
    $sql = "INSERT INTO tblexercise (ExerciseID, LessonID, CategoryID, TopicID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
            VALUES ('{$ExerciseID}', 0, 4, 12, 'Test Question - Business Management', 'Option A', 'Option B', 'Option C', 'Option D', 'A', '0000-00-00')";
    $mydb->setQuery($sql);
    $result = $mydb->executeQuery();
    
    if ($result) {
        echo "<p style='color: green;'>✅ Manual insert successful! ExerciseID: {$ExerciseID}</p>";
        echo "<p>This question should appear in Business category with 1 question count.</p>";
    } else {
        echo "<p style='color: red;'>❌ Manual insert failed!</p>";
    }
}

echo "<form method='post'>";
echo "<button type='submit' name='test_insert' class='btn btn-primary'>Test Manual Insert (Business/Management)</button>";
echo "</form>";

echo "<p><a href='index.php'>Back to Admin</a></p>";
?>