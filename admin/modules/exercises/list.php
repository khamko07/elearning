<?php
	 if (!isset($_SESSION['USERID'])){
      redirect(web_root."admin/index.php");
     }

?>
    <div class="row">
      <div class="col-lg-12"> 
            <h1 class="page-header">List of Question <small>|  <label class="label label-xs" style="font-size: 12px"><a href="index.php?view=add">  <i class="fa fa-plus-circle fw-fa"></i> New</a></label> |</small></h1> 
       		 
       		</div>
        	<!-- /.col-lg-12 -->
   		 </div>
			    <form action="controller.php?action=delete" Method="POST">  					
				<table id="example" class="table table-bordered table-hover" cellspacing="0" style="font-size:12px" >
				
				  <thead>
				  	<tr>
				  		<th>No.</th>
				  		<th>Chủ đề</th>
				  		<th>Question</th>
				  		<th>A</th>
				  		<th>B</th>
				  		<th>C</th>
				  		<th>D</th>
				  		<th>Answer</th>
				  		<th width="10%">Action</th>
				 
				  	</tr>	
				  </thead> 
				  <tbody>
				  	<?php  
				  		$mydb->setQuery("SELECT * FROM `tblexercise` ORDER BY ExerciseID DESC");
				  		$cur = $mydb->loadResultList();

						foreach ($cur as $result) {
				  		echo '<tr>';
				  		echo '<td width="5%" align="center"></td>';
				  		echo '<td>' . htmlspecialchars($result->LessonID).'</a></td>'; 
				  		echo '<td>' . $result->Question.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceA.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceB.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceC.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceD.'</a></td>'; 
				  		echo '<td>' . $result->Answer.'</a></td>'; 
				  		echo '<td > <a title="Edit" href="index.php?view=edit&id='.$result->ExerciseID.'" class="btn btn-primary btn-xs" ><i class="fa fa-pencil fa-fw"></i></a>
				  					 <a title="Delete" href="controller.php?action=delete&id='.$result->ExerciseID.'" class="btn btn-danger btn-xs" onclick="return confirmDelete(\''.$result->ExerciseID.'\', \''.addslashes($result->Question).'\')"><i class="fa fa-bitbucket  fa-fw"></i> </a>
				  					 </td>';
				  		echo '</tr>';
				  	} 
				  	?>
				  </tbody>
					
				</table>
				 
			
				</form>

<script>
function confirmDelete(exerciseId, questionText) {
    // Truncate question text if too long  
    var displayText = questionText.length > 30 ? questionText.substring(0, 30) + '...' : questionText;
    
    var confirmMessage = 'Xóa câu hỏi: "' + displayText + '"?\n\nThao tác này không thể hoàn tác!';
    
    return confirm(confirmMessage);
}

// Style the confirm dialog (works in some browsers)
window.addEventListener('load', function() {
    // Add some CSS for better button styling
    var style = document.createElement('style');
    style.innerHTML = `
        .btn-danger:hover {
            background-color: #c9302c !important;
            border-color: #ac2925 !important;
            transform: scale(1.05);
            transition: all 0.2s;
        }
    `;
    document.head.appendChild(style);
});
</script>
	 