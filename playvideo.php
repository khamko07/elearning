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

  <!-- Video Player Section -->
  <div class="card mb-4">
    <div class="card-header">
      <h3 class="card-title mb-0">
        <i class="fas fa-video me-2"></i><?php echo htmlspecialchars($res->LessonTitle); ?>
      </h3>
    </div>
    <div class="card-body">
      <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: var(--radius-lg); background-color: var(--gray-900);">
        <video 
          controls 
          style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
          preload="metadata"
          poster="">
          <source src="<?php echo web_root.'admin/modules/lesson/'.$res->FileLocation; ?>" type="video/mp4">
          <source src="<?php echo web_root.'admin/modules/lesson/'.$res->FileLocation; ?>" type="video/ogg">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <strong><i class="fas fa-bookmark me-2"></i>Chapter:</strong>
            <span class="ms-2"><?php echo htmlspecialchars($res->LessonChapter ?? 'N/A'); ?></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <strong><i class="fas fa-file-video me-2"></i>Title:</strong>
            <span class="ms-2"><?php echo htmlspecialchars($res->LessonTitle); ?></span>
          </div>
        </div>
        <?php if($res->LessonDescription): ?>
        <div class="col-12">
          <div class="mt-3 pt-3 border-top">
            <strong><i class="fas fa-align-left me-2"></i>Description:</strong>
            <p class="mt-2 mb-0"><?php echo htmlspecialchars($res->LessonDescription); ?></p>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Navigation Buttons -->
  <div class="text-center">
    <a href="index.php?q=lesson" class="btn btn-outline-secondary btn-lg">
      <i class="fas fa-arrow-left me-2"></i>Back to Lessons
    </a>
  </div>
</div>

<style>
.video-container {
  box-shadow: var(--shadow-lg);
}

video {
  border-radius: var(--radius-lg);
}
</style>
