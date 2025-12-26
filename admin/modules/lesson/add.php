                      <?php 
                    if(!isset($_SESSION['USERID'])){
  redirect(web_root."admin/index.php");
}

                      // $autonum = New Autonumber();
                      // $res = $autonum->single_autonumber(2);

                       ?> 
<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-upload me-2"></i>Upload New Lesson
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="controller.php?action=add" method="POST" enctype="multipart/form-data">

          <input name="deptid" type="hidden" value="">
          
          <div class="mb-3">
            <label for="LessonChapter" class="form-label">
              <i class="fas fa-bookmark me-1"></i>Chapter <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="LessonChapter" name="LessonChapter" placeholder="Chapter" type="text" value="" required>
          </div>
                      
          <div class="mb-3">
            <label for="LessonTitle" class="form-label">
              <i class="fas fa-heading me-1"></i>Title <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="LessonTitle" name="LessonTitle" placeholder="Title" type="text" value="" required>
          </div>

          <div class="mb-3">
            <label for="Category" class="form-label">
              <i class="fas fa-file me-1"></i>File Type <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="Category" name="Category" required>
              <option value="Docs">Docs</option>
              <option value="Video">Video</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="file" class="form-label">
              <i class="fas fa-upload me-1"></i>Upload File <span class="text-danger">*</span>
            </label>
            <input type="file" class="form-control" id="file" name="file" required>
            <small class="form-text text-muted">Supported formats: PDF, MP4, and other document/video formats</small>
          </div>
 
          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Save
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