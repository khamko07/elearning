<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h1>Check Latest Questions</h1>";

// Check 5 most recent questions
echo "<h2>5 Most Recent Questions:</h2>";
$sql = "SELECT ExerciseID, CategoryID, TopicID, LEFT(Question, 100) as Question, ExercisesDate FROM tblexercise ORDER BY ExerciseID DESC LIMIT 5";
$mydb->setQuery($sql);
$recent = $mydb->loadResultList();

echo "<table border='1' style='width: 100%;'>";
echo "<tr><th>ExerciseID</th><th>CategoryID</th><th>TopicID</th><th>Question</th><th>Status</th></tr>";
foreach($recent as $q) {
    $status = "Unknown";
    $color = "white";
    
    if ($q->CategoryID == 1) { $status = "Technology"; $color = "#e8f5e8"; }
    elseif ($q->CategoryID == 2) { $status = "Science"; $color = "#e8f5e8"; }
    elseif ($q->CategoryID == 3) { $status = "Mathematics"; $color = "#fff3cd"; }
    elseif ($q->CategoryID == 4) { $status = "Business"; $color = "#e8f5e8"; }
    elseif ($q->CategoryID == 5) { $status = "Language"; $color = "#e8f5e8"; }
    elseif ($q->CategoryID == null || $q->CategoryID == 0) { $status = "NULL/0 - NOT SAVED!"; $color = "#f8d7da"; }
    
    echo "<tr style='background-color: {$color};'>";
    echo "<td>{$q->ExerciseID}</td>";
    echo "<td>{$q->CategoryID}</td>";
    echo "<td>{$q->TopicID}</td>";
    echo "<td>{$q->Question}</td>";
    echo "<td><strong>{$status}</strong></td>";
    echo "</tr>";
}
echo "</table>";

// Count by category
echo "<h2>Current Count by Category:</h2>";
$sql = "SELECT 
        c.CategoryName,
        COUNT(e.ExerciseID) as QuestionCount
        FROM tblcategories c 
        LEFT JOIN tblexercise e ON c.CategoryID = e.CategoryID
        WHERE c.IsActive = 1 
        GROUP BY c.CategoryID, c.CategoryName
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$counts = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>Category</th><th>Question Count</th></tr>";
foreach($counts as $count) {
    echo "<tr><td>{$count->CategoryName}</td><td><strong>{$count->QuestionCount}</strong></td></tr>";
}
echo "</table>";

// Fix NULL CategoryID if any
echo "<h2>Fix NULL CategoryID:</h2>";
$sql = "SELECT COUNT(*) as count FROM tblexercise WHERE CategoryID IS NULL OR CategoryID = 0";
$mydb->setQuery($sql);
$nullCount = $mydb->loadSingleResult();

if ($nullCount->count > 0) {
    echo "<p style='color: red;'>Found {$nullCount->count} questions with NULL/0 CategoryID</p>";
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_null' style='background: red; color: white; padding: 10px;'>Fix NULL CategoryID (Move to Technology)</button>";
    echo "</form>";
    
    if (isset($_POST['fix_null'])) {
        $sql = "UPDATE tblexercise SET CategoryID = 1, TopicID = 1 WHERE CategoryID IS NULL OR CategoryID = 0";
        $mydb->setQuery($sql);
        $result = $mydb->executeQuery();
        if ($result) {
            echo "<p style='color: green;'>✅ Fixed NULL CategoryID!</p>";
            echo "<script>setTimeout(function(){ location.reload(); }, 2000);</script>";
        }
    }
} else {
    echo "<p style='color: green;'>✅ No NULL CategoryID found</p>";
}

echo "<p><a href='index.php'>Back to Admin</a></p>";
?>