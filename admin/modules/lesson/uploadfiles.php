<?php  
    if(!isset($_SESSION['USERID'])){
  redirect(web_root."admin/index.php");
}

  @$id = $_GET['id'];
    if($id==''){
  redirect("index.php");
}
  $lesson = New Lesson();
  $res = $lesson->single_lesson($id);

?> 
 
<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-upload me-2"></i>Update Files
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="controller.php?action=updatefiles" method="POST" enctype="multipart/form-data">

          <input name="LessonID" type="hidden" value="<?php echo $res->LessonID; ?>">
          <input name="deptid" type="hidden" value="">
          
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Current Lesson:</strong> You are updating the file for this lesson.
          </div>
          
          <div class="mb-3">
            <label class="form-label">
              <i class="fas fa-bookmark me-1"></i>Chapter
            </label>
            <p class="form-control-plaintext"><?php echo $res->LessonChapter; ?></p>
          </div>
                      
          <div class="mb-3">
            <label class="form-label">
              <i class="fas fa-heading me-1"></i>Title
            </label>
            <p class="form-control-plaintext"><?php echo $res->LessonTitle; ?></p>
          </div>

          <div class="mb-3">
            <label class="form-label">
              <i class="fas fa-file me-1"></i>File Type
            </label>
            <p class="form-control-plaintext">
              <span class="badge bg-<?php echo ($res->Category == "Video") ? "info" : "secondary"; ?>">
                <?php echo $res->Category; ?>
              </span>
            </p>
          </div>

          <div class="mb-3">
            <label for="file" class="form-label">
              <i class="fas fa-upload me-1"></i>Upload New File <span class="text-danger">*</span>
            </label>
            <input type="file" class="form-control" id="file" name="file" required>
            <small class="form-text text-muted">
              Current file: <?php echo basename($res->FileLocation); ?>
            </small>
          </div>
 
          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Update File
            </button>
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> 
 