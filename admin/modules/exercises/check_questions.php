<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Check Questions</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<h1>Check Questions Detail</h1>

<h2>1. All Exercises with CategoryID/TopicID</h2>
<?php
$sql = "SELECT ExerciseID, CategoryID, TopicID, LEFT(Question, 80) as Question FROM tblexercise ORDER BY ExerciseID DESC";
$mydb->setQuery($sql);
$exercises = $mydb->loadResultList();

echo "<table>";
echo "<tr><th>ExerciseID</th><th>CategoryID</th><th>TopicID</th><th>Question</th></tr>";
foreach($exercises as $ex) {
    $categoryClass = ($ex->CategoryID == null || $ex->CategoryID == 0) ? 'error' : 'success';
    $topicClass = ($ex->TopicID == null || $ex->TopicID == 0) ? 'error' : 'success';
    echo "<tr>";
    echo "<td>{$ex->ExerciseID}</td>";
    echo "<td class='{$categoryClass}'>{$ex->CategoryID}</td>";
    echo "<td class='{$topicClass}'>{$ex->TopicID}</td>";
    echo "<td>{$ex->Question}</td>";
    echo "</tr>";
}
echo "</table>";
?>

<h2>2. Count by CategoryID</h2>
<?php
$sql = "SELECT CategoryID, COUNT(*) as count FROM tblexercise GROUP BY CategoryID ORDER BY CategoryID";
$mydb->setQuery($sql);
$counts = $mydb->loadResultList();

echo "<table>";
echo "<tr><th>CategoryID</th><th>Question Count</th></tr>";
foreach($counts as $count) {
    echo "<tr><td>{$count->CategoryID}</td><td>{$count->count}</td></tr>";
}
echo "</table>";
?>

<h2>3. Test Individual Subqueries</h2>
<?php
echo "<h3>Technology (CategoryID=1):</h3>";
$sql = "SELECT COUNT(*) as count FROM tblexercise WHERE CategoryID = 1";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();
echo "<p>Questions in Technology: " . $result->count . "</p>";

echo "<h3>All Categories with Question Count:</h3>";
$sql = "SELECT c.CategoryID, c.CategoryName, 
        (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c WHERE c.IsActive = 1";
$mydb->setQuery($sql);
$results = $mydb->loadResultList();

echo "<table>";
echo "<tr><th>CategoryID</th><th>CategoryName</th><th>QuestionCount</th></tr>";
foreach($results as $result) {
    echo "<tr><td>{$result->CategoryID}</td><td>{$result->CategoryName}</td><td>{$result->QuestionCount}</td></tr>";
}
echo "</table>";
?>

<h2>4. Fix NULL CategoryID (if needed)</h2>
<?php
$sql = "SELECT COUNT(*) as count FROM tblexercise WHERE CategoryID IS NULL OR CategoryID = 0";
$mydb->setQuery($sql);
$nullCount = $mydb->loadSingleResult();
echo "<p>Questions with NULL/0 CategoryID: " . $nullCount->count . "</p>";

if ($nullCount->count > 0) {
    echo "<form method='post'>";
    echo "<button type='submit' name='fix_null' style='background: red; color: white; padding: 10px;'>Fix NULL CategoryID (Set to Technology=1)</button>";
    echo "</form>";
    
    if (isset($_POST['fix_null'])) {
        $sql = "UPDATE tblexercise SET CategoryID = 1, TopicID = 1 WHERE CategoryID IS NULL OR CategoryID = 0";
        $mydb->setQuery($sql);
        $result = $mydb->executeQuery();
        if ($result) {
            echo "<p class='success'>✅ Fixed NULL CategoryID!</p>";
            echo "<script>setTimeout(function(){ location.reload(); }, 2000);</script>";
        } else {
            echo "<p class='error'>❌ Failed to fix NULL CategoryID</p>";
        }
    }
}
?>

<p><a href="index.php">← Back to Admin</a></p>

</body>
</html>