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
      <i class="fas fa-edit me-2"></i>Update Lesson
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <form action="controller.php?action=edit" method="POST" enctype="multipart/form-data">

          <input name="LessonID" type="hidden" value="<?php echo $res->LessonID; ?>">
          <input name="deptid" type="hidden" value="">
          
          <div class="mb-3">
            <label for="LessonChapter" class="form-label">
              <i class="fas fa-bookmark me-1"></i>Chapter <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="LessonChapter" name="LessonChapter" placeholder="Chapter" type="text" value="<?php echo $res->LessonChapter; ?>" required>
          </div>
                      
          <div class="mb-3">
            <label for="LessonTitle" class="form-label">
              <i class="fas fa-heading me-1"></i>Title <span class="text-danger">*</span>
            </label>
            <input class="form-control" id="LessonTitle" name="LessonTitle" placeholder="Title" type="text" value="<?php echo $res->LessonTitle; ?>" required>
          </div>

          <div class="mb-3">
            <label for="Category" class="form-label">
              <i class="fas fa-file me-1"></i>File Type <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="Category" name="Category" required>
              <option value="Docs" <?php echo ($res->Category == "Docs") ? "selected" : ""?>>Docs</option>
              <option value="Video" <?php echo ($res->Category == "Video") ? "selected" : ""?>>Video</option>
            </select>
          </div>

      <!--              <div class="form-group">
                    <div class="col-md-11">
                      <label class="col-md-2" align = "right"for=
                      "file">Upload File:</label>

                      <div class="col-md-10">
                      <input type="file" name="file" value="<?php echo $res->FileLocation; ?>" />
                      </div>
                    </div>
                  </div> -->
 
          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Update
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