<?php
check_message(); 
?> 

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-user-graduate me-2"></i>Registered Students
      </h1>
      <div class="d-flex gap-2">
        <span class="badge bg-primary align-self-center" style="font-size: 1rem; padding: 0.5rem 1rem;">
          <i class="fas fa-users me-1"></i>
          <?php
          $mydb->setQuery("SELECT COUNT(*) as total FROM tblstudent");
          $total = $mydb->loadSingleResult();
          echo $total->total . ' Students';
          ?>
        </span>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php
    global $mydb;
    $mydb->setQuery("SELECT * FROM tblstudent ORDER BY StudentID DESC");
    $rows = $mydb->loadResultList();
    
    if (empty($rows)): ?>
      <div class="text-center py-5">
        <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No Students Registered Yet</h4>
        <p class="text-muted">Students will appear here once they register through the registration page.</p>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover admin-table" id="studentsTable">
          <thead>
            <tr>
              <th width="5%">#</th>
              <th>Student ID</th>
              <th>Full Name</th>
              <th>Username</th>
              <th>Address</th>
              <th>Contact No.</th>
              <th width="15%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach($rows as $r){
              echo '<tr>';
              echo '<td>'.$i++.'</td>';
              echo '<td><strong>#'.str_pad($r->StudentID, 6, '0', STR_PAD_LEFT).'</strong></td>';
              echo '<td><strong>'.htmlspecialchars($r->Fname . ' ' . $r->Lname).'</strong></td>';
              echo '<td><code>'.htmlspecialchars($r->STUDUSERNAME).'</code></td>';
              echo '<td>'.htmlspecialchars($r->Address ? $r->Address : 'N/A').'</td>';
              echo '<td>'.htmlspecialchars($r->MobileNo ? $r->MobileNo : 'N/A').'</td>';
              echo '<td>
                      <div class="btn-group" role="group">
                        <a href="index.php?view=view&id='.$r->StudentID.'" class="btn btn-sm btn-info" title="View Details">
                          <i class="fas fa-eye"></i> View
                        </a>
                        <a href="controller.php?action=delete&id='.$r->StudentID.'" 
                           class="btn btn-sm btn-danger" 
                           title="Delete Student"
                           onclick="return confirm(\'Are you sure you want to delete student: '.htmlspecialchars($r->Fname . ' ' . $r->Lname).'?\\n\\nThis action cannot be undone!\')">
                          <i class="fas fa-trash"></i> Delete
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

