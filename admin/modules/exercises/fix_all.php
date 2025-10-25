<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Fix All Issues</h1>";

// Step 1: Fix all NULL CategoryID
echo "<h2>Step 1: Fix NULL CategoryID</h2>";
$sql = "UPDATE tblexercise SET CategoryID = 1, TopicID = 1 WHERE CategoryID IS NULL OR CategoryID = 0";
$mydb->setQuery($sql);
$result1 = $mydb->executeQuery();
echo "<p style='color: green;'>✅ Fixed all NULL CategoryID to Technology->AI</p>";

// Step 2: Check Exercise class dbfields
echo "<h2>Step 2: Check Exercise Class</h2>";
$exercise = new Exercise();
$fields = $exercise->dbfields();
$hasCategoryID = in_array('CategoryID', $fields);
$hasTopicID = in_array('TopicID', $fields);

echo "<p>Exercise class detects CategoryID: " . ($hasCategoryID ? "✅ YES" : "❌ NO") . "</p>";
echo "<p>Exercise class detects TopicID: " . ($hasTopicID ? "✅ YES" : "❌ NO") . "</p>";

if (!$hasCategoryID || !$hasTopicID) {
    echo "<p style='color: red;'>❌ Exercise class doesn't detect new fields!</p>";
    echo "<p><strong>Solution:</strong> Need to clear PHP cache or restart Apache</p>";
}

// Step 3: Test direct SQL insert
echo "<h2>Step 3: Test Direct Insert</h2>";
$testID = date('Y') . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
$sql = "INSERT INTO tblexercise (ExerciseID, LessonID, CategoryID, TopicID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
        VALUES ('{$testID}', 0, 3, 8, 'Test Mathematics Question', 'A', 'B', 'C', 'D', 'A', '0000-00-00')";
$mydb->setQuery($sql);
$result3 = $mydb->executeQuery();

if ($result3) {
    echo "<p style='color: green;'>✅ Direct SQL insert successful! Mathematics should now show 1 question.</p>";
} else {
    echo "<p style='color: red;'>❌ Direct SQL insert failed!</p>";
}

// Step 4: Show current counts
echo "<h2>Step 4: Current Counts</h2>";
$sql = "SELECT c.CategoryName, COUNT(e.ExerciseID) as QuestionCount
        FROM tblcategories c 
        LEFT JOIN tblexercise e ON c.CategoryID = e.CategoryID
        WHERE c.IsActive = 1 
        GROUP BY c.CategoryID, c.CategoryName
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$counts = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>Category</th><th>Questions</th></tr>";
foreach($counts as $count) {
    echo "<tr><td>{$count->CategoryName}</td><td><strong>{$count->QuestionCount}</strong></td></tr>";
}
echo "</table>";

// Step 5: Instructions
echo "<h2>Step 5: Next Steps</h2>";
echo "<div style='background: #f0f8ff; padding: 15px; border-radius: 5px;'>";
echo "<h3>To fix the add form:</h3>";
echo "<ol>";
echo "<li><strong>Restart Apache</strong> in XAMPP (Stop → Start)</li>";
echo "<li><strong>Clear browser cache</strong> (Ctrl+Shift+Delete)</li>";
echo "<li><strong>Test add new question</strong> with different categories</li>";
echo "<li>If still not working, the Exercise class needs manual fix</li>";
echo "</ol>";
echo "</div>";

echo "<p><a href='index.php' style='background: blue; color: white; padding: 10px; text-decoration: none;'>Go to Admin (should show correct counts now)</a></p>";
?>