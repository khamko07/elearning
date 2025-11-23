<?php
// Get PDF lessons
$sql = "SELECT * FROM tbllesson WHERE Category='Docs' ORDER BY LessonChapter, LessonTitle";
$mydb->setQuery($sql);
$pdfLessons = $mydb->loadResultList();

// Get Video lessons
$sql = "SELECT * FROM tbllesson WHERE Category='Video' ORDER BY LessonTitle";
$mydb->setQuery($sql);
$videoLessons = $mydb->loadResultList();
?>

<div class="container-fluid">
  <div class="mb-5">
    <h1 class="mb-3">
      <i class="fas fa-graduation-cap me-2"></i><?php echo isset($title) ? $title : 'Lessons'; ?>
    </h1>
    <p class="lead text-muted">Access PDF documents and video lessons</p>
  </div>

  <div class="row">
    <!-- PDF Lessons -->
    <div class="col-lg-6 mb-5">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title mb-0">
            <i class="fas fa-file-pdf me-2 text-danger"></i>PDF Documents
          </h3>
        </div>
        <div class="card-body">
          <?php if (empty($pdfLessons)): ?>
            <div class="empty-state" style="padding: var(--space-8);">
              <i class="fas fa-file-pdf" style="font-size: var(--text-4xl); color: var(--gray-400);"></i>
              <h4 style="margin-top: var(--space-4);">No PDF Documents</h4>
              <p class="text-muted">PDF documents will appear here once uploaded.</p>
            </div>
          <?php else: ?>
            <div class="list-group">
              <?php foreach ($pdfLessons as $lesson): ?>
                <div class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                      <h5 class="mb-1">
                        <i class="fas fa-file-pdf text-danger me-2"></i>
                        <?php echo htmlspecialchars($lesson->LessonTitle); ?>
                      </h5>
                      <?php if ($lesson->LessonChapter): ?>
                        <small class="text-muted">
                          <i class="fas fa-bookmark me-1"></i>Chapter: <?php echo htmlspecialchars($lesson->LessonChapter); ?>
                        </small>
                      <?php endif; ?>
                    </div>
                    <a href="index.php?q=viewpdf&id=<?php echo $lesson->LessonID; ?>" 
                       class="btn btn-primary btn-sm">
                      <i class="fas fa-eye me-1"></i>View PDF
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Video Lessons -->
    <div class="col-lg-6 mb-5">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title mb-0">
            <i class="fas fa-video me-2 text-danger"></i>Video Lessons
          </h3>
        </div>
        <div class="card-body">
          <?php if (empty($videoLessons)): ?>
            <div class="empty-state" style="padding: var(--space-8);">
              <i class="fas fa-video" style="font-size: var(--text-4xl); color: var(--gray-400);"></i>
              <h4 style="margin-top: var(--space-4);">No Video Lessons</h4>
              <p class="text-muted">Video lessons will appear here once uploaded.</p>
            </div>
          <?php else: ?>
            <div class="list-group">
              <?php foreach ($videoLessons as $lesson): ?>
                <div class="list-group-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                      <h5 class="mb-1">
                        <i class="fas fa-video text-danger me-2"></i>
                        <?php echo htmlspecialchars($lesson->LessonTitle); ?>
                      </h5>
                      <?php if ($lesson->LessonDescription): ?>
                        <small class="text-muted">
                          <?php echo htmlspecialchars(substr($lesson->LessonDescription, 0, 100)); ?>
                          <?php echo strlen($lesson->LessonDescription) > 100 ? '...' : ''; ?>
                        </small>
                      <?php endif; ?>
                    </div>
                    <a href="index.php?q=playvideo&id=<?php echo $lesson->LessonID; ?>" 
                       class="btn btn-danger btn-sm">
                      <i class="fas fa-play me-1"></i>Play Video
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.list-group-item {
  border: 1px solid var(--gray-200);
  border-radius: var(--radius-md);
  margin-bottom: var(--space-3);
  padding: var(--space-4);
  transition: all var(--transition-base);
}

.list-group-item:hover {
  background-color: var(--gray-50);
  border-color: var(--primary-blue);
  transform: translateX(4px);
}

.list-group-item h5 {
  color: var(--text-primary);
  font-weight: var(--font-semibold);
  margin-bottom: var(--space-2);
}

.list-group-item small {
  color: var(--text-muted);
  font-size: var(--text-sm);
}
</style>
