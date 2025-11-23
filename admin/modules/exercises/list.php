<?php
	 if (!isset($_SESSION['USERID'])){
      redirect(web_root."admin/index.php");
     }

?>
<div class="row mb-4">
  <div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <h1 class="page-header mb-0">
        <i class="fas fa-question-circle me-2"></i>All Questions (Legacy View)
      </h1>
      <div class="btn-group">
        <a href="index.php?view=add" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>Add New Question
        </a>
        <a href="index.php?view=categories" class="btn btn-info">
          <i class="fas fa-cog me-2"></i>Manage Categories
        </a>
        <a href="index.php" class="btn btn-outline-secondary">
          <i class="fas fa-home me-2"></i>Back to Categories View
        </a>
      </div>
    </div>
  </div>
</div>
   		 
<!-- Bulk Actions -->
<div class="row mb-3">
  <div class="col-lg-12">
    <div id="bulkActions" class="alert alert-info" style="display: none;">
      <i class="fas fa-info-circle me-2"></i>
      <strong>Selected:</strong> <span id="selectedCount">0</span> question(s).
      <div class="btn-group ms-3">
        <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
          <i class="fas fa-trash me-1"></i>Delete Selected
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearSelection()">
          <i class="fas fa-times me-1"></i>Clear Selection
        </button>
      </div>
    </div>
  </div>
</div>
   		 
<form action="controller.php?action=delete" Method="POST">  					
  <div class="table-responsive">
    <table id="exerciseTable" class="table table-bordered table-hover admin-table" cellspacing="0" style="font-size:12px">
				
				  <thead>
				  	<tr>
				  		<th width="5%" style="text-align: center; background-color: #f5f5f5;">
				  		    <div style="padding: 5px;">
				  		        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" title="Chọn tất cả" style="width: 18px; height: 18px; cursor: pointer;">
				  		        <br><small style="font-weight: bold;">Select All</small>
				  		    </div>
				  		</th>
				  		<th>No.</th>
				  		<th>Category</th>
				  		<th>Topic</th>
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
				  		$mydb->setQuery("SELECT e.*, c.CategoryName, t.TopicName 
				  		                 FROM `tblexercise` e 
				  		                 LEFT JOIN `tblcategories` c ON e.CategoryID = c.CategoryID 
				  		                 LEFT JOIN `tbltopics` t ON e.TopicID = t.TopicID 
				  		                 ORDER BY c.CategoryName, t.TopicName, e.ExerciseID DESC");
				  		$cur = $mydb->loadResultList();

						$cnt = 1;
						foreach ($cur as $result) {
				  		echo '<tr>';
				  		echo '<td align="center" style="background-color: #f9f9f9;"><input type="checkbox" class="question-checkbox" value="'.$result->ExerciseID.'" onchange="updateBulkActions()" style="width: 16px; height: 16px; cursor: pointer;"></td>';
				  		echo '<td width="5%" align="center">'.$cnt.'</td>';
				  		echo '<td>' . ($result->CategoryName ? $result->CategoryName : 'Uncategorized') . '</td>';
				  		echo '<td>' . ($result->TopicName ? $result->TopicName : 'No Topic') . '</td>'; 
				  		echo '<td>' . $result->Question.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceA.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceB.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceC.'</a></td>'; 
				  		echo '<td>' . $result->ChoiceD.'</a></td>'; 
				  		echo '<td>' . $result->Answer.'</a></td>'; 
				  		echo '<td>
				  		        <div class="btn-group" role="group">
				  		          <a title="Edit" href="index.php?view=edit&id='.$result->ExerciseID.'" class="btn btn-sm btn-primary">
				  		            <i class="fas fa-edit"></i>
				  		          </a>
				  		          <a title="Delete" href="controller.php?action=delete&id='.$result->ExerciseID.'" class="btn btn-sm btn-danger" onclick="return confirmDelete(\''.$result->ExerciseID.'\', \''.addslashes($result->Question).'\')">
				  		            <i class="fas fa-trash"></i>
				  		          </a>
				  		        </div>
				  		      </td>';
				  		echo '</tr>';
				  		$cnt++;
				  		}
				  	?>
      </tbody>
    </table>
  </div>
</form>

<script>
function confirmDelete(exerciseId, questionText) {
    // Truncate question text if too long  
    var displayText = questionText.length > 50 ? questionText.substring(0, 50) + '...' : questionText;
    
    var confirmMessage = 'Delete question: "' + displayText + '"?\n\nThis action cannot be undone!';
    
    return confirm(confirmMessage);
}

// Select All functionality
function toggleSelectAll(selectAllCheckbox) {
    console.log('Toggle select all clicked:', selectAllCheckbox.checked);
    const checkboxes = document.querySelectorAll('.question-checkbox');
    console.log('Found checkboxes:', checkboxes.length);
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateBulkActions();
}



// Update bulk actions visibility and count
function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.question-checkbox:checked');
    const selectedCount = checkboxes.length;
    const bulkActions = document.getElementById('bulkActions');
    const countSpan = document.getElementById('selectedCount');
    
    if (selectedCount > 0) {
        bulkActions.style.display = 'block';
        countSpan.textContent = selectedCount;
    } else {
        bulkActions.style.display = 'none';
    }
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.question-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    if (allCheckboxes.length > 0) {
        selectAllCheckbox.checked = selectedCount === allCheckboxes.length;
        selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < allCheckboxes.length;
    }
}

// Clear all selections
function clearSelection() {
    document.querySelectorAll('.question-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

// Bulk delete function
function bulkDelete() {
    const checkboxes = document.querySelectorAll('.question-checkbox:checked');
    const selectedIds = Array.from(checkboxes).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('Please select at least one question to delete!');
        return;
    }
    
    const confirmMessage = `Delete ${selectedIds.length} selected question(s)?\n\nThis action cannot be undone!`;
    
    if (confirm(confirmMessage)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'controller.php?action=bulkDelete';
        
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selectedIds[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
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
        #bulkActions .alert {
            margin: 0;
            padding: 10px 15px;
        }
        .question-checkbox, #selectAll {
            transform: scale(1.2);
            cursor: pointer;
        }
        #selectAll {
            margin-bottom: 5px;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        th {
            vertical-align: middle !important;
        }
        .question-checkbox {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        /* Force show checkboxes */
        input[type="checkbox"] {
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
        }
    `;
    document.head.appendChild(style);
});
</script>
	 