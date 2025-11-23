<?php
	if(!isset($_SESSION['USERID'])){
	redirect(web_root."admin/index.php");
}

?>

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-book me-2"></i>List of Lessons
      </h1>
      <a href="index.php?view=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Lesson
      </a>
    </div>
  </div>
</div>

<form action="controller.php?action=delete" Method="POST">  
  <div class="table-responsive">			
    <table id="example" class="table table-striped table-bordered table-hover admin-table" style="font-size:12px" cellspacing="0">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th>Chapter</th>
          <th>Title</th> 
          <th>File Type</th> 
          <th width="30%">Action</th>
        </tr>	
      </thead> 
      <tbody>
        <?php    
          $mydb->setQuery("SELECT * FROM `tbllesson`");
          $cur = $mydb->loadResultList();

          foreach ($cur as $result) {
            echo '<tr>';
            echo '<td width="5%" align="center"></td>'; 
            echo '<td>'. $result->LessonChapter.'</td>';
            echo '<td>'. $result->LessonTitle.'</td>'; 
            echo '<td><span class="badge bg-'.($result->Category=="Video" ? "info" : "secondary").'">'. $result->Category.'</span></td>';

            if ($result->Category=="Video") {
              $view = "index.php?view=playvideo&id=".$result->LessonID;
            } else {
              $view = "index.php?view=viewpdf&id=".$result->LessonID;
            }
            
            echo '<td>
                    <div class="btn-group" role="group">
                      <a title="Edit Details" href="index.php?view=edit&id='.$result->LessonID.'" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <a title="Change File" href="index.php?view=uploadfile&id='.$result->LessonID.'" class="btn btn-sm btn-secondary">
                        <i class="fas fa-upload"></i> Change File
                      </a>
                      <a title="View Files" href="'.$view.'" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> View
                      </a>
                      <a title="Delete" href="controller.php?action=delete&id='.$result->LessonID.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this lesson?\')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </div>
                  </td>';
            echo '</tr>';
          } 
        ?>
      </tbody>
    </table> 
  </div>
</form>
	 