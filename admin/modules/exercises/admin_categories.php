<?php
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}
?>

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-question-circle me-2"></i>Questions Management
      </h1>
      <div class="btn-group">
        <a href="index.php?view=add" class="btn btn-success">
          <i class="fas fa-plus me-2"></i>Add New Question
        </a>
        <a href="index.php?view=categories" class="btn btn-info">
          <i class="fas fa-cog me-2"></i>Manage Categories
        </a>
        <a href="index.php?view=list" class="btn btn-outline-secondary">
          <i class="fas fa-list me-2"></i>Legacy View
        </a>
      </div>
    </div>
    <div class="alert alert-info mt-3">
      <i class="fas fa-info-circle me-2"></i>
      <strong>New Structure:</strong> Questions are now organized by Categories and Topics. Click on a category below to manage its topics and questions.
    </div>
  </div>
</div>

<?php 
$sql = "SELECT c.*, 
        (SELECT COUNT(*) FROM tbltopics t WHERE t.CategoryID = c.CategoryID AND t.IsActive = 1) as TopicCount,
        (SELECT COUNT(*) FROM tblexercise e 
         JOIN tbltopics t ON e.TopicID = t.TopicID 
         WHERE t.CategoryID = c.CategoryID) as QuestionCount
        FROM tblcategories c 
        WHERE c.IsActive = 1 
        ORDER BY c.CategoryName";
$mydb->setQuery($sql);
$categories = $mydb->loadResultList();
?>

<?php if (!empty($categories)): ?>
  <div class="content-grid">
    <?php foreach ($categories as $category): ?>
      <div class="category-card">
        <div class="card-icon">
          <i class="fas fa-folder"></i>
        </div>
        <h3 class="card-title"><?php echo htmlspecialchars($category->CategoryName); ?></h3>
        <?php if ($category->CategoryDescription): ?>
          <p class="card-description"><?php echo htmlspecialchars($category->CategoryDescription); ?></p>
        <?php else: ?>
          <p class="card-description">Manage questions in this category</p>
        <?php endif; ?>
        
        <div class="card-stats">
          <div class="stat">
            <span class="stat-value"><?php echo $category->TopicCount; ?></span>
            <span class="stat-label">Topics</span>
          </div>
          <div class="stat">
            <span class="stat-value"><?php echo $category->QuestionCount; ?></span>
            <span class="stat-label">Questions</span>
          </div>
        </div>
        
        <a href="index.php?view=topics&category=<?php echo $category->CategoryID; ?>" 
           class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Manage Topics & Questions
        </a>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="empty-state">
    <i class="fas fa-inbox"></i>
    <h3>No Categories Available</h3>
    <p>Create categories first to organize your questions.</p>
    <a href="index.php?view=categories" class="btn btn-primary mt-3">
      <i class="fas fa-plus me-2"></i>Create Categories
    </a>
  </div>
<?php endif; ?>
