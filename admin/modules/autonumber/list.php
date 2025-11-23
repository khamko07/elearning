<?php 
if(!isset($_SESSION['USERID'])){
	redirect(web_root."admin/index.php");
}
?>

<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-hashtag me-2"></i>List of Autonumbers
      </h1>
      <a href="index.php?view=add" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Autonumber
      </a>
    </div>
  </div>
</div>

<form action="controller.php?action=delete" Method="POST">  	 		
  <div class="table-responsive">
    <table id="dash-table" class="table table-striped table-hover admin-table" style="font-size:12px" cellspacing="0">

				
				  <thead>
				  	<tr> 
				  		<th>
				  		 <input type="checkbox" name="chkall" id="chkall" onclick="return checkall('selector[]');"> 
				  		 Autonumber</th> 
				  		  <th>Key</th>
				  		 <!-- <th width="10%" align="center">Action</th> -->
				  	</tr>	
				  </thead>  
				  <tbody>
				  	<?php 
				  		$mydb->setQuery("SELECT * FROM `tblautonumbers`");
				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
				  		echo '<tr>'; 
			  			echo '<td> <input type="checkbox" name="selector[]" id="chkall" value="'.$result->AUTOID.'"> ' . $result->AUTOSTART.'' . $result->AUTOEND.'</td>';
			  			echo '<td>' . $result->AUTOKEY.'</td>';
				  		// echo '<td align="center"><a title="Edit" href="index.php?view=edit&id='.$result->AUTOID.'" class="btn btn-info btn-xs  ">  <span class="fa fa-edit fw-fa"></a>
				  		//      <a title="Delete" href="controller.php?action=delete&id='.$result->AUTOID.'" class="btn btn-danger btn-xs  ">  <span class="fa  fa-trash-o fw-fa "></a></td>'; 
				  		echo '</tr>';
				  	} 
				  	?>
      </tbody>
    </table>
  </div>
  
  <div class="mt-3">
    <?php
    if($_SESSION['TYPE']=='Administrator'){
      echo '<button type="submit" class="btn btn-danger" name="delete" onclick="return confirm(\'Are you sure you want to delete selected autonumbers?\')">
              <i class="fas fa-trash me-2"></i>Delete Selected
            </button>';
    }
    ?>
  </div>
</form> 