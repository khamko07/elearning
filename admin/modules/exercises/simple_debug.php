<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Debug</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h1>Debug Information</h1>

<h2>1. Check if tables exist</h2>
<?php
try {
    $sql = "SHOW TABLES LIKE 'tblcategories'";
    $mydb->setQuery($sql);
    $result = $mydb->loadResultList();
    echo "<p class='info'>tblcategories exists: " . (count($result) > 0 ? "✅ YES" : "❌ NO") . "</p>";
    
    $sql = "SHOW TABLES LIKE 'tbltopics'";
    $mydb->setQuery($sql);
    $result = $mydb->loadResultList();
    echo "<p class='info'>tbltopics exists: " . (count($result) > 0 ? "✅ YES" : "❌ NO") . "</p>";
    
    $sql = "DESCRIBE tblexercise";
    $mydb->setQuery($sql);
    $columns = $mydb->loadResultList();
    $hasCategoryID = false;
    $hasTopicID = false;
    foreach($columns as $col) {
        if($col->Field == 'CategoryID') $hasCategoryID = true;
        if($col->Field == 'TopicID') $hasTopicID = true;
    }
    echo "<p class='info'>tblexercise has CategoryID: " . ($hasCategoryID ? "✅ YES" : "❌ NO") . "</p>";
    echo "<p class='info'>tblexercise has TopicID: " . ($hasTopicID ? "✅ YES" : "❌ NO") . "</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>Error checking tables: " . $e->getMessage() . "</p>";
}
?>

<h2>2. Categories Data</h2>
<?php
try {
    $sql = "SELECT * FROM tblcategories WHERE IsActive = 1";
    $mydb->setQuery($sql);
    $categories = $mydb->loadResultList();
    
    if (count($categories) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Description</th></tr>";
        foreach($categories as $cat) {
            echo "<tr><td>{$cat->CategoryID}</td><td>{$cat->CategoryName}</td><td>{$cat->CategoryDescription}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>❌ No categories found!</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}
?>

<h2>3. Topics Data</h2>
<?php
try {
    $sql = "SELECT * FROM tbltopics WHERE IsActive = 1";
    $mydb->setQuery($sql);
    $topics = $mydb->loadResultList();
    
    if (count($topics) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>CategoryID</th><th>Name</th><th>Description</th></tr>";
        foreach($topics as $topic) {
            echo "<tr><td>{$topic->TopicID}</td><td>{$topic->CategoryID}</td><td>{$topic->TopicName}</td><td>{$topic->TopicDescription}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>❌ No topics found!</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}
?>

<h2>4. Recent Exercises</h2>
<?php
try {
    $sql = "SELECT ExerciseID, CategoryID, TopicID, LEFT(Question, 50) as Question FROM tblexercise ORDER BY ExerciseID DESC LIMIT 10";
    $mydb->setQuery($sql);
    $exercises = $mydb->loadResultList();
    
    if (count($exercises) > 0) {
        echo "<table>";
        echo "<tr><th>ExerciseID</th><th>CategoryID</th><th>TopicID</th><th>Question</th></tr>";
        foreach($exercises as $ex) {
            echo "<tr><td>{$ex->ExerciseID}</td><td>{$ex->CategoryID}</td><td>{$ex->TopicID}</td><td>{$ex->Question}...</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>❌ No exercises found!</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
}
?>

<h2>5. Test Query (Same as admin page)</h2>
<?php
try {
    $sql = "SELECT c.*, COUNT(DISTINCT t.TopicID) as TopicCount, COUNT(DISTINCT e.ExerciseID) as QuestionCount
            FROM tblcategories c 
            LEFT JOIN tbltopics t ON c.CategoryID = t.CategoryID AND t.IsActive = 1
            LEFT JOIN tblexercise e ON t.TopicID = e.TopicID
            WHERE c.IsActive = 1 
            GROUP BY c.CategoryID 
            ORDER BY c.CategoryName";
    $mydb->setQuery($sql);
    $result = $mydb->loadResultList();
    
    if (count($result) > 0) {
        echo "<table>";
        echo "<tr><th>CategoryID</th><th>CategoryName</th><th>TopicCount</th><th>QuestionCount</th></tr>";
        foreach($result as $row) {
            echo "<tr><td>{$row->CategoryID}</td><td>{$row->CategoryName}</td><td>{$row->TopicCount}</td><td>{$row->QuestionCount}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>❌ Query returned no results!</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Query Error: " . $e->getMessage() . "</p>";
}
?>

<p><a href="index.php">← Back to Admin</a></p>

</body>
</html>