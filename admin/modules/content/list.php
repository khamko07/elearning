<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>

<style>
/* Lao Language Font */
@font-face {
  font-family: 'Phetsarath OT';
  src: url('../../../fonts/Phetsarath OT.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
}

.lao-text {
  font-family: 'Phetsarath OT', Arial, sans-serif !important;
}

.content-title {
  font-weight: var(--font-semibold);
  color: var(--text-primary);
}

.content-topic {
  color: var(--secondary-indigo);
  font-style: italic;
}
</style>

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="page-header mb-0">
        <i class="fas fa-file-text me-2"></i>Learning Contents
      </h1>
      <a href="index.php?view=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Content
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php
    global $mydb;
    $mydb->setQuery("SELECT * FROM tblcontent ORDER BY CreatedAt DESC");
    $rows = $mydb->loadResultList();
    
    // Debug: Check if query executed successfully
    if ($mydb->getError()) {
      echo '<div class="alert alert-danger">Database Error: ' . htmlspecialchars($mydb->getError()) . '</div>';
    }
    
    if (empty($rows)): ?>
      <div class="text-center py-5">
        <i class="fas fa-file-text fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No Content Yet</h4>
        <p class="text-muted">Start by creating your first learning content.</p>
        <a href="index.php?view=add" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>Add Your First Content
        </a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover admin-table" id="contentTable">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th>Title</th>
              <th>Topic</th>
              <th>Created</th>
              <th width="20%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=1; 
            foreach($rows as $r){
              // Detect Lao text
              $hasLao = preg_match('/[\x{0E80}-\x{0EFF}]/u', $r->Title . ' ' . ($r->Topic ?? ''));
              $laoClass = $hasLao ? ' lao-text' : '';
              
              echo '<tr>';
              echo '<td>'.$i++.'</td>';
              echo '<td><span class="content-title'.$laoClass.'">'.htmlspecialchars($r->Title).'</span></td>';
              echo '<td><span class="content-topic'.$laoClass.'">'.htmlspecialchars($r->Topic ?? 'N/A').'</span></td>';
              echo '<td>'.date('M j, Y g:i A', strtotime($r->CreatedAt)).'</td>';
              echo '<td>
                      <div class="btn-group" role="group">
                        <a href="index.php?view=preview&id='.$r->ContentID.'" class="btn btn-sm btn-info" title="View Content">
                          <i class="fas fa-eye"></i> View
                        </a>
                        <a href="index.php?view=edit&id='.$r->ContentID.'" class="btn btn-sm btn-warning" title="Edit Content">
                          <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="controller.php?action=delete&id='.$r->ContentID.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this content?\')" title="Delete Content">
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
    <?php endif; ?>
  </div>
</div>
