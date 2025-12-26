<?php
// Get statistics for dashboard
$contentCount = 0;
$exerciseCount = 0;
$studentCount = 0;
$userCount = 0;

// Count contents
$sql = "SELECT COUNT(*) as total FROM tblcontent";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();
$contentCount = $result ? $result->total : 0;

// Count exercises
$sql = "SELECT COUNT(*) as total FROM tblexercise";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();
$exerciseCount = $result ? $result->total : 0;

// Count students
$sql = "SELECT COUNT(*) as total FROM tblstudent";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();
$studentCount = $result ? $result->total : 0;

// Count users (if admin)
if($_SESSION['TYPE']=="Administrator") {
    $sql = "SELECT COUNT(*) as total FROM tblusers";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $userCount = $result ? $result->total : 0;
}
?>

<div class="admin-dashboard">
  <!-- Dashboard Header -->
  <div class="dashboard-header mb-5">
    <h1 class="mb-2">Administrator Panel</h1>
    <p class="lead text-muted">Welcome back, <?php echo htmlspecialchars($_SESSION['NAME']); ?>!</p>
  </div>

  <!-- Statistics Cards -->
  <div class="stats-grid mb-5">
    <div class="stat-card">
      <div class="stat-card-icon">
        <i class="fas fa-file-text"></i>
      </div>
      <div class="stat-card-value"><?php echo $contentCount; ?></div>
      <div class="stat-card-label">Learning Contents</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-card-icon">
        <i class="fas fa-question-circle"></i>
      </div>
      <div class="stat-card-value"><?php echo $exerciseCount; ?></div>
      <div class="stat-card-label">Questions</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-card-icon">
        <i class="fas fa-user-graduate"></i>
      </div>
      <div class="stat-card-value"><?php echo $studentCount; ?></div>
      <div class="stat-card-label">Students</div>
    </div>
    
    <?php if($_SESSION['TYPE']=="Administrator"): ?>
    <div class="stat-card">
      <div class="stat-card-icon">
        <i class="fas fa-users"></i>
      </div>
      <div class="stat-card-value"><?php echo $userCount; ?></div>
      <div class="stat-card-label">Users</div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Quick Actions -->
  <div class="mb-5">
    <h3 class="mb-4">
      <i class="fas fa-bolt me-2"></i>Quick Actions
    </h3>
    <div class="content-grid">
      <!-- Content Management -->
      <a href="<?php echo web_root; ?>admin/modules/content/index.php" class="category-card" style="text-decoration: none; color: inherit;">
        <div class="card-icon">
          <i class="fas fa-file-text"></i>
        </div>
        <h3 class="card-title">Learning Content</h3>
        <p class="card-description">Manage educational content, articles, and learning materials</p>
        <div class="card-stats">
          <div class="stat">
            <span class="stat-value"><?php echo $contentCount; ?></span>
            <span class="stat-label">Contents</span>
          </div>
        </div>
        <span class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Manage Content
        </span>
      </a>
      
      <!-- Exercises -->
      <a href="<?php echo web_root; ?>admin/modules/exercises/index.php" class="category-card" style="text-decoration: none; color: inherit;">
        <div class="card-icon">
          <i class="fas fa-question-circle"></i>
        </div>
        <h3 class="card-title">Questions Management</h3>
        <p class="card-description">Create and manage quiz questions, categories, and topics</p>
        <div class="card-stats">
          <div class="stat">
            <span class="stat-value"><?php echo $exerciseCount; ?></span>
            <span class="stat-label">Questions</span>
          </div>
        </div>
        <span class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Manage Questions
        </span>
      </a>
      
      <!-- Registered Students -->
      <a href="<?php echo web_root; ?>admin/modules/students/index.php" class="category-card" style="text-decoration: none; color: inherit;">
        <div class="card-icon">
          <i class="fas fa-user-graduate"></i>
        </div>
        <h3 class="card-title">Registered Students</h3>
        <p class="card-description">View list of students who have registered in the system</p>
        <div class="card-stats">
          <div class="stat">
            <span class="stat-value"><?php echo $studentCount; ?></span>
            <span class="stat-label">Students</span>
          </div>
        </div>
        <span class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>View Students
        </span>
      </a>
      
      <!-- Manage Admin -->
      <?php if($_SESSION['TYPE']=="Administrator"): ?>
      <a href="<?php echo web_root; ?>admin/modules/user/index.php" class="category-card" style="text-decoration: none; color: inherit;">
        <div class="card-icon">
          <i class="fas fa-users"></i>
        </div>
        <h3 class="card-title">Manage Admin</h3>
        <p class="card-description">View and manage administrator accounts</p>
        <div class="card-stats">
          <div class="stat">
            <span class="stat-value"><?php echo $userCount; ?></span>
            <span class="stat-label">Admins</span>
          </div>
        </div>
        <span class="btn btn-primary btn-block">
          <i class="fas fa-arrow-right me-2"></i>Manage Admin
        </span>
      </a>
      <?php endif; ?>
    </div>
  </div>
</div>
