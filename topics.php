<?php
$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if ($categoryId <= 0) {
    redirect('index.php?q=categories');
}

// Get category info
$sql = "SELECT * FROM tblcategories WHERE CategoryID = {$categoryId} AND IsActive = 1";
$mydb->setQuery($sql);
$category = $mydb->loadSingleResult();

if (!$category) {
    redirect('index.php?q=categories');
}
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="index.php?q=categories">Exercise Categories</a></li>
            <li class="active"><?php echo $category->CategoryName; ?></li>
        </ol>
        
        <h1><?php echo $category->CategoryName; ?> - Topics</h1>
        <?php if ($category->CategoryDescription): ?>
            <p class="lead text-muted"><?php echo $category->CategoryDescription; ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="col-lg-12">
    <div class="row">
        <?php 
        $sql = "SELECT t.*, COUNT(e.ExerciseID) as QuestionCount
                FROM tbltopics t 
                LEFT JOIN tblexercise e ON t.TopicID = e.TopicID
                WHERE t.CategoryID = {$categoryId} AND t.IsActive = 1 
                GROUP BY t.TopicID 
                ORDER BY t.TopicName";
        $mydb->setQuery($sql);
        $topics = $mydb->loadResultList();
        
        foreach ($topics as $topic) {
        ?>
        <div class="col-md-4 col-sm-6" style="margin-bottom: 20px;">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-tag"></i> <?php echo $topic->TopicName; ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <?php if ($topic->TopicDescription): ?>
                        <p class="text-muted"><?php echo $topic->TopicDescription; ?></p>
                    <?php endif; ?>
                    
                    <div class="text-center">
                        <h4 class="text-primary"><?php echo $topic->QuestionCount; ?></h4>
                        <small>Questions Available</small>
                    </div>
                    
                    <div class="text-center" style="margin-top: 15px;">
                        <?php if ($topic->QuestionCount > 0): ?>
                            <a href="index.php?q=question&topic=<?php echo $topic->TopicID; ?>" 
                               class="btn btn-success btn-sm">
                                <i class="fa fa-play"></i> Start Quiz (<?php echo $topic->QuestionCount; ?> questions)
                            </a>
                        <?php else: ?>
                            <span class="text-muted">
                                <i class="fa fa-info-circle"></i> No questions available yet
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <?php if (empty($topics)): ?>
    <div class="alert alert-info text-center">
        <i class="fa fa-info-circle"></i> No topics available in this category yet.
    </div>
    <?php endif; ?>
    
    <div class="text-center" style="margin-top: 30px;">
        <a href="index.php?q=categories" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Back to Exercise Categories
        </a>
    </div>
</div>

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

.breadcrumb {
    background-color: #f5f5f5;
    border-radius: 4px;
}
</style>