<?php
		check_message(); 
?> 

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-user-graduate me-2"></i>List of Students
      </h1>
      <a href="index.php?view=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Student
      </a>
    </div>
  </div>
</div>

<form action="controller.php?action=delete" Method="POST">  					
  <div class="table-responsive">
    <table id="example" class="table table-striped table-bordered table-hover admin-table" cellspacing="0" style="font-size:12px">
      <thead>
        <tr> 
          <th>#</th> 
          <th>Name</th>
          <th>Address</th> 
          <th>Contact#</th>  
        </tr>	
      </thead> 	

      <tbody>
        <?php 
          $query = "SELECT * FROM `tblstudent`";
          $mydb->setQuery($query);
          $cur = $mydb->loadResultList();

          foreach ($cur as $result) {
            echo '<tr>'; 
            echo '<td width="5%" align="center"></td>'; 
            echo '<td>'. $result->Fname.' ' . $result->Lname .'</td>'; 
            echo '<td>'.$result->Address. '</td>'; 
            echo '<td>'. $result->MobileNo.'</td>'; 
            echo '</tr>';
          } 
        ?>
      </tbody>
    </table>
  </div>
</form> 