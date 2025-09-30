<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>
<div class="row"><div class="col-lg-12"><h1 class="page-header">Contents</h1></div></div>
<p><a href="index.php?view=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a></p>
<table class="table table-striped" id="example">
  <thead><tr><th>#</th><th>Title</th><th>Topic</th><th>Created</th></tr></thead>
  <tbody>
    <?php
    global $mydb;
    $mydb->setQuery("SELECT * FROM tblcontent ORDER BY CreatedAt DESC");
    $rows = $mydb->loadResultList();
    $i=1; foreach($rows as $r){
      echo '<tr><td>'.$i++.'</td><td>'.htmlentities($r->Title).'</td><td>'.htmlentities($r->Topic).'</td><td>'.$r->CreatedAt.'</td></tr>';
    }
    ?>
  </tbody>
</table>


