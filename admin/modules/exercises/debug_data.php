<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

echo "<h2>Debug Information</h2>";

// Check categories
echo "<h3>Categories:</h3>";
$sql = "SELECT * FROM tblcategories WHERE IsActive = 1";
$mydb->setQuery($sql);
$categories = $mydb->loadResultList();
echo "<pre>";
print_r($categories);
echo "</pre>";

// Check topics
echo "<h3>Topics:</h3>";
$sql = "SELECT * FROM tbltopics WHERE IsActive = 1";
$mydb->setQuery($sql);
$topics = $mydb->loadResultList();
echo "<pre>";
print_r($topics);
echo "</pre>";

// Check exercises
echo "<h3>Recent Exercises:</h3>";
$sql = "SELECT ExerciseID, CategoryID, TopicID, Question FROM tblexercise ORDER BY ExerciseID DESC LIMIT 5";
$mydb->setQuery($sql);
$exercises = $mydb->loadResultList();
echo "<pre>";
print_r($exercises);
echo "</pre>";

// Check if tables exist
echo "<h3>Table Structure Check:</h3>";
$sql = "SHOW TABLES LIKE 'tblcategories'";
$mydb->setQuery($sql);
$result = $mydb->loadResultList();
echo "tblcategories exists: " . (count($result) > 0 ? "YES" : "NO") . "<br>";

$sql = "SHOW TABLES LIKE 'tbltopics'";
$mydb->setQuery($sql);
$result = $mydb->loadResultList();
echo "tbltopics exists: " . (count($result) > 0 ? "YES" : "NO") . "<br>";

$sql = "SHOW COLUMNS FROM tblexercise LIKE 'CategoryID'";
$mydb->setQuery($sql);
$result = $mydb->loadResultList();
echo "tblexercise has CategoryID: " . (count($result) > 0 ? "YES" : "NO") . "<br>";

$sql = "SHOW COLUMNS FROM tblexercise LIKE 'TopicID'";
$mydb->setQuery($sql);
$result = $mydb->loadResultList();
echo "tblexercise has TopicID: " . (count($result) > 0 ? "YES" : "NO") . "<br>";
?>