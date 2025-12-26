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

// Get topics
$sql = "SELECT t.*, COUNT(e.ExerciseID) as QuestionCount
        FROM tbltopics t 
        LEFT JOIN tblexercise e ON t.TopicID = e.TopicID
        WHERE t.CategoryID = {$categoryId} AND t.IsActive = 1 
        GROUP BY t.TopicID 
        ORDER BY t.TopicName";
$mydb->setQuery($sql);
$topics = $mydb->loadResultList();
?>

<div class="container-fluid">
  <!-- Breadcrumb Navigation -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb" style="background-color: var(--bg-light); padding: var(--space-3) var(--space-4); border-radius: var(--radius-md);">
      <li class="breadcrumb-item">
        <a href="index.php?q=categories" style="color: var(--primary-blue); text-decoration: none;">
          <i class="fas fa-home me-1"></i>Exercise Categories
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        <?php echo htmlspecialchars($category->CategoryName); ?>
      </li>
    </ol>
  </nav>

  <!-- Page Header -->
  <div class="mb-5">
    <h1 class="mb-3"><?php echo htmlspecialchars($category->CategoryName); ?> - Topics</h1>
    <?php if ($category->CategoryDescription): ?>
      <p class="lead text-muted"><?php echo htmlspecialchars($category->CategoryDescription); ?></p>
    <?php endif; ?>
  </div>

  <!-- Topics Grid -->
  <?php if (!empty($topics)): ?>
    <div class="content-grid mb-5">
      <?php foreach ($topics as $topic): ?>
        <div class="category-card">
          <div class="card-icon">
            <i class="fas fa-tag"></i>
          </div>
          <h3 class="card-title"><?php echo htmlspecialchars($topic->TopicName); ?></h3>
          <?php if ($topic->TopicDescription): ?>
            <p class="card-description"><?php echo htmlspecialchars($topic->TopicDescription); ?></p>
          <?php else: ?>
            <p class="card-description">Practice questions in this topic</p>
          <?php endif; ?>
          
          <div class="card-stats">
            <div class="stat">
              <span class="stat-value"><?php echo $topic->QuestionCount; ?></span>
              <span class="stat-label">Questions</span>
            </div>
            <div class="stat">
              <span class="stat-value">
                <?php if ($topic->QuestionCount > 0): ?>
                  <i class="fas fa-check-circle text-success"></i>
                <?php else: ?>
                  <i class="fas fa-clock text-warning"></i>
                <?php endif; ?>
              </span>
              <span class="stat-label">Status</span>
            </div>
          </div>
          
          <?php if ($topic->QuestionCount > 0): ?>
            <a href="index.php?q=question&topic=<?php echo $topic->TopicID; ?>" 
               class="btn btn-success btn-block">
              <i class="fas fa-play me-2"></i>Start Quiz (<?php echo $topic->QuestionCount; ?> questions)
            </a>
          <?php else: ?>
            <button class="btn btn-secondary btn-block" disabled>
              <i class="fas fa-info-circle me-2"></i>No questions available yet
            </button>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state">
      <i class="fas fa-inbox"></i>
      <h3>No Topics Available</h3>
      <p>Topics will appear here once they are created by administrators for this category.</p>
    </div>
  <?php endif; ?>
  
  <!-- Back Button -->
  <div class="text-center mt-5">
    <a href="index.php?q=categories" class="btn btn-outline-secondary btn-lg">
      <i class="fas fa-arrow-left me-2"></i>Back to Exercise Categories
    </a>
  </div>
</div>

<style>
.breadcrumb {
  margin-bottom: var(--space-4);
}

.breadcrumb-item + .breadcrumb-item::before {
  content: ">";
  color: var(--text-muted);
  padding: 0 var(--space-2);
}

.breadcrumb-item a:hover {
  text-decoration: underline;
}
</style>
