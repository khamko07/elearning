<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h2>Quick Fix for Questions</h2>";

// Step 1: Check current state
echo "<h3>Step 1: Current State</h3>";
$sql = "SELECT CategoryID, TopicID, COUNT(*) as count FROM tblexercise GROUP BY CategoryID, TopicID";
$mydb->setQuery($sql);
$current = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>CategoryID</th><th>TopicID</th><th>Count</th></tr>";
foreach($current as $row) {
    echo "<tr><td>{$row->CategoryID}</td><td>{$row->TopicID}</td><td>{$row->count}</td></tr>";
}
echo "</table>";

// Step 2: Fix NULL/0 CategoryID
echo "<h3>Step 2: Fix NULL/0 CategoryID</h3>";
$sql = "UPDATE tblexercise SET CategoryID = 1, TopicID = 1 WHERE CategoryID IS NULL OR CategoryID = 0 OR TopicID IS NULL OR TopicID = 0";
$mydb->setQuery($sql);
$result = $mydb->executeQuery();

if ($result) {
    echo "<p style='color: green;'>✅ Updated questions to CategoryID=1, TopicID=1</p>";
} else {
    echo "<p style='color: red;'>❌ Failed to update</p>";
}

// Step 3: Check after fix
echo "<h3>Step 3: After Fix</h3>";
$sql = "SELECT CategoryID, TopicID, COUNT(*) as count FROM tblexercise GROUP BY CategoryID, TopicID";
$mydb->setQuery($sql);
$after = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>CategoryID</th><th>TopicID</th><th>Count</th></tr>";
foreach($after as $row) {
    echo "<tr><td>{$row->CategoryID}</td><td>{$row->TopicID}</td><td>{$row->count}</td></tr>";
}
echo "</table>";

// Step 4: Test the admin query
echo "<h3>Step 4: Test Admin Query</h3>";
$sql = "SELECT c.CategoryName, 
        (SELECT COUNT(*) FROM tbltopics t WHERE t.CategoryID = c.CategoryID AND t.IsActive = 1) as TopicCount,
        (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c 
        WHERE c.IsActive = 1 
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$adminResult = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>Category</th><th>Topics</th><th>Questions</th></tr>";
foreach($adminResult as $row) {
    echo "<tr><td>{$row->CategoryName}</td><td>{$row->TopicCount}</td><td>{$row->QuestionCount}</td></tr>";
}
echo "</table>";

echo "<p><a href='index.php'>Go to Admin Page</a></p>";
?>