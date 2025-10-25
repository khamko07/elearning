<?php
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

// Debug: Check if this file is being loaded
echo "<!-- DEBUG: admin_categories.php loaded at " . date('Y-m-d H:i:s') . " -->";
?>

<div class="row">
    <div class="col-lg-12"> 
        <h1 class="page-header">Questions Management 
            <small>| <a href="index.php?view=add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add New Question</a> | <a href="index.php?view=categories" class="btn btn-xs btn-info"><i class="fa fa-cog"></i> Manage Categories</a> | <a href="index.php?view=list" class="btn btn-xs btn-default"><i class="fa fa-list"></i> Legacy View</a> |</small>
        </h1>
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> 
            <strong>New Structure:</strong> Questions are now organized by Categories and Topics. Click on a category below to manage its topics and questions.
        </div>
    </div>
</div>

<div class="row">
    <?php 
    $sql = "SELECT c.*, 
            (SELECT COUNT(*) FROM tbltopics t WHERE t.CategoryID = c.CategoryID AND t.IsActive = 1) as TopicCount,
            (SELECT COUNT(*) FROM tblexercise e WHERE e.CategoryID = c.CategoryID) as QuestionCount
            FROM tblcategories c 
            WHERE c.IsActive = 1 
            ORDER BY c.CategoryName";
    $mydb->setQuery($sql);
    $categories = $mydb->loadResultList();
    
    // DEBUG: Force show correct data
    echo "<!-- DEBUG: Query executed at " . date('Y-m-d H:i:s') . " -->";
    foreach($categories as $cat) {
        echo "<!-- DEBUG: {$cat->CategoryName} = {$cat->QuestionCount} questions -->";
    }
    
    // FORCE REFRESH: Add timestamp to prevent cache
    echo "<script>console.log('Admin page loaded at: " . date('Y-m-d H:i:s') . "');</script>";
    
    foreach ($categories as $category) {
    ?>
    <div class="col-md-4 col-sm-6" style="margin-bottom: 20px;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-folder"></i> <?php echo $category->CategoryName; ?>
                </h3>
            </div>
            <div class="panel-body">
                <?php if ($category->CategoryDescription): ?>
                    <p class="text-muted"><?php echo $category->CategoryDescription; ?></p>
                <?php endif; ?>
                
                <div class="row text-center">
                    <div class="col-xs-6">
                        <h4 class="text-info"><?php echo $category->TopicCount; ?></h4>
                        <small>Topics</small>
                    </div>
                    <div class="col-xs-6">
                        <h4 class="text-success"><?php echo $category->QuestionCount; ?></h4>
                        <small>Questions</small>
                    </div>
                </div>
                
                <div class="text-center" style="margin-top: 15px;">
                    <a href="index.php?view=topics&category=<?php echo $category->CategoryID; ?>" 
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-right"></i> Manage Topics & Questions
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<?php if (empty($categories)): ?>
<div class="alert alert-info text-center">
    <i class="fa fa-info-circle"></i> No categories available. 
    <a href="index.php?view=categories" class="btn btn-sm btn-info">Create Categories First</a>
</div>
<?php endif; ?>

<style>
.panel {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.panel:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.panel-body h4 {
    margin: 0;
    font-weight: bold;
}

.panel-body small {
    color: #666;
    text-transform: uppercase;
    font-size: 11px;
}
</style>