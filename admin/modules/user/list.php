<?php
	 // if (!isset($_SESSION['TYPE'])=='Administrator'){
  //     redirect(web_root."index.php");
  //    }

?>
<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-users me-2"></i>List of Users
      </h1>
      <!-- Add User button removed - not needed -->
    </div>
  </div>
</div>

<form action="controller.php?action=delete" Method="POST">  					
  <div class="table-responsive">
    <table id="example" class="table table-hover table-bordered admin-table" cellspacing="0" style="font-size:12px">
      <thead>
        <tr>
          <th>No.</th>
          <th>Account Name</th>
          <th>Username</th>
          <th width="10%">Action</th>
        </tr>	
      </thead> 
      <tbody>
        <?php 
          $mydb->setQuery("SELECT * FROM `tblusers`");
          $cur = $mydb->loadResultList();

          foreach ($cur as $result) {
            echo '<tr>';
            echo '<td width="5%" align="center"></td>';
            echo '<td>' . $result->NAME.'</td>';
            echo '<td>'. $result->UEMAIL.'</td>';
            echo '<td>
                    <div class="btn-group" role="group">
                      <a title="Edit" href="index.php?view=edit&id='.$result->USERID.'" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a title="Delete" href="controller.php?action=delete&id='.$result->USERID.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this user?\')">
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