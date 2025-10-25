<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h2>Fix Existing Questions</h2>";

// Update existing questions to have CategoryID and TopicID
// Assign all existing questions to Technology -> AI (CategoryID=1, TopicID=1)

$sql = "UPDATE tblexercise SET CategoryID = 1, TopicID = 1 WHERE CategoryID IS NULL OR CategoryID = 0";
$mydb->setQuery($sql);
$result = $mydb->executeQuery();

if ($result) {
    echo "<div style='color: green;'>✅ Successfully updated existing questions to Technology -> AI category</div>";
} else {
    echo "<div style='color: red;'>❌ Failed to update existing questions</div>";
}

// Show count
$sql = "SELECT COUNT(*) as count FROM tblexercise WHERE CategoryID = 1 AND TopicID = 1";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();
echo "<p>Questions in Technology -> AI: " . $result->count . "</p>";

echo "<p><a href='index.php'>Back to Admin</a></p>";
?>