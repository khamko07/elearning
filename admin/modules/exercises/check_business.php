<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Check Business Questions</h1>";

// Check recent questions
echo "<h2>Recent Questions:</h2>";
$sql = "SELECT ExerciseID, CategoryID, TopicID, LEFT(Question, 100) as Question FROM tblexercise ORDER BY ExerciseID DESC LIMIT 10";
$mydb->setQuery($sql);
$recent = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>ExerciseID</th><th>CategoryID</th><th>TopicID</th><th>Question</th></tr>";
foreach($recent as $q) {
    $style = ($q->CategoryID == 4) ? 'background-color: yellow;' : '';
    echo "<tr style='{$style}'><td>{$q->ExerciseID}</td><td>{$q->CategoryID}</td><td>{$q->TopicID}</td><td>{$q->Question}</td></tr>";
}
echo "</table>";

// Check Business questions specifically
echo "<h2>Business Questions (CategoryID=4):</h2>";
$sql = "SELECT COUNT(*) as count FROM tblexercise WHERE CategoryID = 4";
$mydb->setQuery($sql);
$businessCount = $mydb->loadSingleResult();
echo "<p><strong>Business questions count: {$businessCount->count}</strong></p>";

// Check Management questions specifically  
echo "<h2>Management Questions (TopicID=12):</h2>";
$sql = "SELECT COUNT(*) as count FROM tblexercise WHERE TopicID = 12";
$mydb->setQuery($sql);
$managementCount = $mydb->loadSingleResult();
echo "<p><strong>Management questions count: {$managementCount->count}</strong></p>";

// Test the exact subquery
echo "<h2>Test Subquery for Business:</h2>";
$sql = "SELECT (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = 4) as QuestionCount";
$mydb->setQuery($sql);
$subqueryResult = $mydb->loadSingleResult();
echo "<p><strong>Subquery result: {$subqueryResult->QuestionCount}</strong></p>";

// Test full admin query for Business only
echo "<h2>Full Admin Query for Business:</h2>";
$sql = "SELECT c.CategoryName, 
        (SELECT COUNT(*) FROM tbltopics t WHERE t.CategoryID = c.CategoryID AND t.IsActive = 1) as TopicCount,
        (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c 
        WHERE c.CategoryID = 4 AND c.IsActive = 1";
$mydb->setQuery($sql);
$adminResult = $mydb->loadSingleResult();

if ($adminResult) {
    echo "<p><strong>{$adminResult->CategoryName}: {$adminResult->TopicCount} topics, {$adminResult->QuestionCount} questions</strong></p>";
} else {
    echo "<p style='color: red;'>No result from admin query!</p>";
}

echo "<p><a href='index.php'>Back to Admin</a></p>";
?>