<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Test Count Direct</h1>";

// Test direct count
echo "<h2>Direct Count Test:</h2>";
$sql = "SELECT CategoryID, COUNT(*) as count FROM tblexercise WHERE CategoryID IS NOT NULL GROUP BY CategoryID";
$mydb->setQuery($sql);
$results = $mydb->loadResultList();

foreach($results as $result) {
    echo "<p>CategoryID {$result->CategoryID}: {$result->count} questions</p>";
}

// Test the exact query from admin page
echo "<h2>Admin Page Query Test:</h2>";
$sql = "SELECT c.CategoryName, 
        (SELECT COUNT(*) FROM tbltopics t WHERE t.CategoryID = c.CategoryID AND t.IsActive = 1) as TopicCount,
        (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c 
        WHERE c.IsActive = 1 
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$adminResults = $mydb->loadResultList();

foreach($adminResults as $result) {
    echo "<p>{$result->CategoryName}: {$result->TopicCount} topics, {$result->QuestionCount} questions</p>";
}

// Fix NULL CategoryID
echo "<h2>Fix NULL CategoryID:</h2>";
$sql = "UPDATE tblexercise SET CategoryID = 1, TopicID = 1 WHERE CategoryID IS NULL";
$mydb->setQuery($sql);
$updateResult = $mydb->executeQuery();

if ($updateResult) {
    echo "<p style='color: green;'>✅ Fixed NULL CategoryID</p>";
} else {
    echo "<p style='color: red;'>❌ Failed to fix</p>";
}

// Test again after fix
echo "<h2>After Fix:</h2>";
$sql = "SELECT c.CategoryName, 
        (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c 
        WHERE c.IsActive = 1 
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$finalResults = $mydb->loadResultList();

foreach($finalResults as $result) {
    echo "<p><strong>{$result->CategoryName}: {$result->QuestionCount} questions</strong></p>";
}

echo "<p><a href='index.php'>Go to Admin (should show correct counts now)</a></p>";
?>