<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Final Fix - Assign Categories to All Questions</h1>";

// Fix Business/Marketing questions (LessonID = 11)
echo "<h2>Fixing Business/Marketing Questions...</h2>";
$sql = "UPDATE tblexercise SET CategoryID = 4, TopicID = 11 WHERE LessonID = 11 AND (CategoryID IS NULL OR CategoryID = 0)";
$mydb->setQuery($sql);
$result1 = $mydb->executeQuery();
echo "<p style='color: green;'>✅ Fixed Business/Marketing questions (LessonID = 11)</p>";

// Fix Mathematics/Algebra questions (LessonID = 8)
echo "<h2>Fixing Mathematics/Algebra Questions...</h2>";
$sql = "UPDATE tblexercise SET CategoryID = 3, TopicID = 8 WHERE LessonID = 8 AND (CategoryID IS NULL OR CategoryID = 0)";
$mydb->setQuery($sql);
$result2 = $mydb->executeQuery();
echo "<p style='color: green;'>✅ Fixed Mathematics/Algebra questions (LessonID = 8)</p>";

// Fix Language/English questions (LessonID = 13)
echo "<h2>Fixing Language/English Questions...</h2>";
$sql = "UPDATE tblexercise SET CategoryID = 5, TopicID = 13 WHERE LessonID = 13 AND (CategoryID IS NULL OR CategoryID = 0)";
$mydb->setQuery($sql);
$result3 = $mydb->executeQuery();
echo "<p style='color: green;'>✅ Fixed Language/English questions (LessonID = 13)</p>";

// Show results
echo "<h2>Results After Fix:</h2>";
$sql = "SELECT c.CategoryName, COUNT(e.ExerciseID) as QuestionCount
        FROM tblcategories c 
        LEFT JOIN tblexercise e ON c.CategoryID = e.CategoryID
        WHERE c.IsActive = 1 
        GROUP BY c.CategoryID, c.CategoryName
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$results = $mydb->loadResultList();

echo "<table border='1' style='font-size: 16px;'>";
echo "<tr><th>Category</th><th>Questions</th></tr>";
foreach($results as $result) {
    $color = ($result->QuestionCount > 0) ? 'green' : 'red';
    echo "<tr><td>{$result->CategoryName}</td><td style='color: {$color}; font-weight: bold;'>{$result->QuestionCount}</td></tr>";
}
echo "</table>";

echo "<p><strong>Now go to admin page - it should show correct question counts!</strong></p>";
echo "<p><a href='index.php' style='background: blue; color: white; padding: 15px; text-decoration: none; font-size: 18px;'>Go to Admin Page</a></p>";
?>