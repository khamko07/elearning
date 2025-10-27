<h1><?php echo isset($title) ? $title : 'Exercise Categories'; ?></h1>
<p class="lead text-muted">Choose a category to start practicing questions</p>
<div class="col-lg-12">
    <div class="row">
        <?php 
        $sql = "SELECT c.*, COUNT(DISTINCT t.TopicID) as TopicCount, COUNT(DISTINCT e.ExerciseID) as QuestionCount
                FROM tblcategories c 
                LEFT JOIN tbltopics t ON c.CategoryID = t.CategoryID AND t.IsActive = 1
                LEFT JOIN tblexercise e ON t.TopicID = e.TopicID
                WHERE c.IsActive = 1 
                GROUP BY c.CategoryID 
                ORDER BY c.CategoryName";
        $mydb->setQuery($sql);
        $categories = $mydb->loadResultList();
        
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
                    
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="text-center">
                                <h4 class="text-info"><?php echo $category->TopicCount; ?></h4>
                                <small>Topics</small>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="text-center">
                                <h4 class="text-success"><?php echo $category->QuestionCount; ?></h4>
                                <small>Questions</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center" style="margin-top: 15px;">
                        <a href="index.php?q=topics&category=<?php echo $category->CategoryID; ?>" 
                           class="btn btn-primary btn-sm">
                            <i class="fa fa-arrow-right"></i> View Topics
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <?php if (empty($categories)): ?>
    <div class="alert alert-info text-center">
        <i class="fa fa-info-circle"></i> No exercise categories available at the moment.
    </div>
    <?php else: ?>
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-body text-center">
                    <?php
                    $totalCategories = count($categories);
                    $totalTopics = array_sum(array_column($categories, 'TopicCount'));
                    $totalQuestions = array_sum(array_column($categories, 'QuestionCount'));
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="text-primary"><?php echo $totalCategories; ?></h3>
                            <p>Categories</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-info"><?php echo $totalTopics; ?></h3>
                            <p>Topics</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="text-success"><?php echo $totalQuestions; ?></h3>
                            <p>Total Questions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
</style>