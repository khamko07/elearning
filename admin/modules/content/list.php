<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>

<style>
.action-buttons .btn {
  margin-right: 5px;
  margin-bottom: 5px;
}
.table tbody tr:hover {
  background-color: #f5f7fb;
}
.content-title {
  font-weight: 600;
  color: #333;
}
.content-topic {
  color: #667eea;
  font-style: italic;
}
</style>

<div class="row"><div class="col-lg-12"><h1 class="page-header">Contents</h1></div></div>
<p><a href="index.php?view=add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a></p>
<table class="table table-striped" id="example">
  <thead><tr><th>#</th><th>Title</th><th>Topic</th><th>Created</th><th>Actions</th></tr></thead>
  <tbody>
    <?php
    global $mydb;
    $mydb->setQuery("SELECT * FROM tblcontent ORDER BY CreatedAt DESC");
    $rows = $mydb->loadResultList();
    $i=1; foreach($rows as $r){
      echo '<tr>';
      echo '<td>'.$i++.'</td>';
      echo '<td><span class="content-title">'.htmlentities($r->Title).'</span></td>';
      echo '<td><span class="content-topic">'.htmlentities($r->Topic).'</span></td>';
      echo '<td>'.date('M j, Y g:i A', strtotime($r->CreatedAt)).'</td>';
      echo '<td class="action-buttons">';
      echo '<a href="index.php?view=preview&id='.$r->ContentID.'" class="btn btn-info btn-sm" title="View Content">';
      echo '<i class="fa fa-eye"></i> View';
      echo '</a>';
      echo '<a href="index.php?view=edit&id='.$r->ContentID.'" class="btn btn-warning btn-sm" title="Edit Content">';
      echo '<i class="fa fa-edit"></i> Edit';
      echo '</a>';
      echo '<a href="controller.php?action=delete&id='.$r->ContentID.'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this content?\')" title="Delete Content">';
      echo '<i class="fa fa-trash"></i> Delete';
      echo '</a>';
      echo '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>


