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
?>

<div class="container-fluid">
  <!-- Page Header -->
  <div class="mb-5">
    <h1 class="mb-3"><?php echo isset($title) ? $title : 'Exercise Categories'; ?></h1>
    <p class="lead text-muted">Choose a category to start practicing questions and improve your skills</p>
  </div>

  <!-- Categories Grid -->
  <?php if (!empty($categories)): ?>
    <div class="content-grid mb-5">
      <?php 
      $categoryIcons = [
        'fa-folder',
        'fa-book',
        'fa-graduation-cap',
        'fa-lightbulb',
        'fa-star',
        'fa-trophy'
      ];
      $iconIndex = 0;
      
      foreach ($categories as $category): 
        $icon = $categoryIcons[$iconIndex % count($categoryIcons)];
        $iconIndex++;
      ?>
        <div class="category-card">
          <div class="card-icon">
            <i class="fas <?php echo $icon; ?>"></i>
          </div>
          <h3 class="card-title"><?php echo htmlspecialchars($category->CategoryName); ?></h3>
          <?php if ($category->CategoryDescription): ?>
            <p class="card-description"><?php echo htmlspecialchars($category->CategoryDescription); ?></p>
          <?php else: ?>
            <p class="card-description">Practice questions in this category</p>
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
          
          <a href="index.php?q=topics&category=<?php echo $category->CategoryID; ?>" 
             class="btn btn-primary btn-block">
            <i class="fas fa-arrow-right me-2"></i>View Topics
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Summary Statistics -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">
          <i class="fas fa-chart-bar me-2"></i>Summary Statistics
        </h3>
      </div>
      <div class="card-body">
        <div class="row text-center">
          <?php
          $totalCategories = count($categories);
          $totalTopics = array_sum(array_map(function($cat) { return $cat->TopicCount; }, $categories));
          $totalQuestions = array_sum(array_map(function($cat) { return $cat->QuestionCount; }, $categories));
          ?>
          <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-item">
              <i class="fas fa-folder-open text-primary" style="font-size: var(--text-3xl);"></i>
              <div class="stat-value" style="font-size: var(--text-3xl); margin-top: var(--space-3);">
                <?php echo $totalCategories; ?>
              </div>
              <div class="stat-label">Total Categories</div>
            </div>
          </div>
          <div class="col-md-4 mb-3 mb-md-0">
            <div class="stat-item">
              <i class="fas fa-tags text-info" style="font-size: var(--text-3xl);"></i>
              <div class="stat-value" style="font-size: var(--text-3xl); margin-top: var(--space-3);">
                <?php echo $totalTopics; ?>
              </div>
              <div class="stat-label">Total Topics</div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stat-item">
              <i class="fas fa-question-circle text-success" style="font-size: var(--text-3xl);"></i>
              <div class="stat-value" style="font-size: var(--text-3xl); margin-top: var(--space-3);">
                <?php echo $totalQuestions; ?>
              </div>
              <div class="stat-label">Total Questions</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state">
      <i class="fas fa-inbox"></i>
      <h3>No Categories Available</h3>
      <p>Exercise categories will appear here once they are created by administrators.</p>
    </div>
  <?php endif; ?>
</div>
