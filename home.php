<?php
// Get student info for welcome message
$student = new Student();
$stud = null;
if(isset($_SESSION['StudentID'])) {
  $stud = $student->single_students($_SESSION['StudentID']);
}
?>

<div class="dashboard-section">
  <!-- Welcome Section -->
  <div class="welcome-section">
    <div class="container-fluid">
      <img src="<?php echo web_root; ?>images/text-ued-1.png" alt="Logo" class="logo mb-4" style="max-height: 80px;">
      <h1>Welcome<?php echo $stud ? ', ' . htmlspecialchars($stud->Fname ?? 'Student') : ''; ?>!</h1>
      <p>Continue your learning journey and practice with exercises</p>
    </div>
  </div>

  <!-- Feature Cards -->
  <div class="container-fluid mt-5">
    <div class="content-grid">
      <div class="category-card">
        <div class="card-icon">
          <i class="fas fa-book"></i>
        </div>
        <h3 class="card-title">Learning Content</h3>
        <p class="card-description">Access educational materials, videos, and PDFs to enhance your knowledge</p>
        <a href="index.php?q=content" class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Explore Content
        </a>
      </div>

      <div class="category-card">
        <div class="card-icon">
          <i class="fas fa-check-square"></i>
        </div>
        <h3 class="card-title">Exercises</h3>
        <p class="card-description">Practice with quizzes and exercises to test your understanding</p>
        <a href="index.php?q=categories" class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Start Exercises
        </a>
      </div>

      <div class="category-card">
        <div class="card-icon">
          <i class="fas fa-info-circle"></i>
        </div>
        <h3 class="card-title">About Us</h3>
        <p class="card-description">Learn more about our e-learning platform and mission</p>
        <a href="index.php?q=about" class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Learn More
        </a>
      </div>
    </div>
  </div>

  <!-- Statistics Section (Optional - can be populated with real data) -->
  <?php
  // Get student statistics if needed
  // This is a placeholder - you can add real statistics here
  ?>
  <div class="container-fluid mt-5">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-card-icon">
          <i class="fas fa-book-open"></i>
        </div>
        <div class="stat-card-value">0</div>
        <div class="stat-card-label">Lessons Completed</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-card-value">0</div>
        <div class="stat-card-label">Exercises Completed</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-icon">
          <i class="fas fa-trophy"></i>
        </div>
        <div class="stat-card-value">0%</div>
        <div class="stat-card-label">Average Score</div>
      </div>
      <div class="stat-card">
        <div class="stat-card-icon">
          <i class="fas fa-clock"></i>
        </div>
        <div class="stat-card-value">0h</div>
        <div class="stat-card-label">Study Time</div>
      </div>
    </div>
  </div>
</div>
