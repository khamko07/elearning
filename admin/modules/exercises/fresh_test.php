<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fresh Test - No Cache</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-card { margin: 15px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .count { font-size: 24px; font-weight: bold; color: #007bff; }
    </style>
</head>
<body style="padding: 20px;">

<h1>Fresh Test - Categories with Question Counts</h1>
<p><strong>Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>

<?php
// Direct query - no cache
$sql = "SELECT c.CategoryName, 
        (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c 
        WHERE c.IsActive = 1 
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$categories = $mydb->loadResultList();

foreach($categories as $category) {
?>
<div class="category-card">
    <h3><?php echo $category->CategoryName; ?></h3>
    <div class="count"><?php echo $category->QuestionCount; ?> Questions</div>
    <p>Direct query result - no cache involved</p>
</div>
<?php } ?>

<hr>
<h2>Raw Database Check:</h2>
<?php
$sql = "SELECT CategoryID, COUNT(*) as count FROM tblexercise WHERE CategoryID IS NOT NULL GROUP BY CategoryID ORDER BY CategoryID";
$mydb->setQuery($sql);
$raw = $mydb->loadResultList();

echo "<table border='1'>";
echo "<tr><th>CategoryID</th><th>Count</th><th>Category Name</th></tr>";
foreach($raw as $r) {
    $catName = "Unknown";
    if($r->CategoryID == 1) $catName = "Technology";
    if($r->CategoryID == 2) $catName = "Science"; 
    if($r->CategoryID == 3) $catName = "Mathematics";
    if($r->CategoryID == 4) $catName = "Business";
    if($r->CategoryID == 5) $catName = "Language";
    
    echo "<tr><td>{$r->CategoryID}</td><td><strong>{$r->count}</strong></td><td>{$catName}</td></tr>";
}
echo "</table>";
?>

<p><a href="index.php?t=<?php echo time(); ?>">Back to Admin (with timestamp)</a></p>

</body>
</html>