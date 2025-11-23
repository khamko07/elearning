<?php  
@$id = $_GET['id'];
if($id==''){
  redirect("index.php");
}
$lesson = New Lesson();
$res = $lesson->single_lesson($id);

if(!$res) {
  redirect("index.php?q=lesson");
}
?> 

<div class="container-fluid">
  <!-- Breadcrumb Navigation -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php?q=lesson">
          <i class="fas fa-home me-1"></i>Lessons
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        <?php echo htmlspecialchars($res->LessonTitle); ?>
      </li>
    </ol>
  </nav>

  <!-- PDF Viewer Section -->
  <div class="card mb-4">
    <div class="card-header">
      <h3 class="card-title mb-0">
        <i class="fas fa-file-pdf me-2 text-danger"></i><?php echo htmlspecialchars($res->LessonTitle); ?>
      </h3>
    </div>
    <div class="card-body">
      <div class="pdf-info mb-4">
        <div class="row">
          <div class="col-md-6 mb-3">
            <strong><i class="fas fa-bookmark me-2"></i>Chapter:</strong>
            <span class="ms-2"><?php echo htmlspecialchars($res->LessonChapter ?? 'N/A'); ?></span>
          </div>
          <div class="col-md-6 mb-3">
            <strong><i class="fas fa-file-pdf me-2"></i>Title:</strong>
            <span class="ms-2"><?php echo htmlspecialchars($res->LessonTitle); ?></span>
          </div>
        </div>
      </div>

      <div class="pdf-viewer-container" style="border: 1px solid var(--gray-300); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); background-color: var(--gray-100);">
        <embed 
          src="<?php echo web_root.'admin/modules/lesson/'.$res->FileLocation; ?>" 
          type="application/pdf" 
          width="100%" 
          height="600px"
          style="display: block;"
          aria-label="PDF Document: <?php echo htmlspecialchars($res->LessonTitle); ?>">
        <p class="text-center p-4 text-muted">
          <i class="fas fa-info-circle me-2"></i>
          If the PDF doesn't display, 
          <a href="<?php echo web_root.'admin/modules/lesson/'.$res->FileLocation; ?>" target="_blank" class="text-primary">
            click here to open in a new tab
          </a>
        </p>
      </div>
    </div>
    <div class="card-footer">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <a href="<?php echo web_root.'admin/modules/lesson/'.$res->FileLocation; ?>" 
           download 
           class="btn btn-primary">
          <i class="fas fa-download me-2"></i>Download PDF
        </a>
        <a href="index.php?q=lesson" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left me-2"></i>Back to Lessons
        </a>
      </div>
    </div>
  </div>
</div>

<style>
.pdf-viewer-container {
  min-height: 600px;
}

@media (max-width: 768px) {
  .pdf-viewer-container embed {
    height: 500px;
  }
}
</style>
