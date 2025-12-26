<?php   
  @$id = $_GET['id'];
  if($id==''){
  redirect("index.php");
}
  $exercise = New Exercise();
  $res = $exercise->single_exercise($id);

?> 

<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-edit me-2"></i>Update Question
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-10">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">
          <i class="fas fa-question-circle me-2"></i>Question Details
        </h5>
      </div>
      <div class="card-body">
        <form action="controller.php?action=edit" method="POST">
          <input type="hidden" name="ExerciseID" value="<?php echo $res->ExerciseID;?>">
          
          <div class="mb-3">
            <label for="editCategory" class="form-label">
              <i class="fas fa-folder me-1"></i>Category <span class="text-danger">*</span>
            </label>
            <select class="form-select" name="Category" id="editCategory" required onchange="loadEditTopics()">
              <option value="">Select Category</option>
              <?php
              $sql = "SELECT * FROM tblcategories WHERE IsActive = 1 ORDER BY CategoryName";
              $mydb->setQuery($sql);
              $categories = $mydb->loadResultList();
              foreach ($categories as $category) {
                $selected = ($category->CategoryID == $res->CategoryID) ? 'selected' : '';
                echo '<option value="'.$category->CategoryID.'" '.$selected.'>'.$category->CategoryName.'</option>';
              }
              ?>
            </select>
          </div>
                      
          <div class="mb-3">
            <label for="editTopic" class="form-label">
              <i class="fas fa-tag me-1"></i>Topic <span class="text-danger">*</span>
            </label>
            <select class="form-select" name="Topic" id="editTopic" required>
              <option value="">Loading topics...</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="Question" class="form-label">
              <i class="fas fa-question me-1"></i>Question <span class="text-danger">*</span>
            </label>
            <textarea class="form-control" id="Question" name="Question" placeholder="Question Name" rows="3" required><?php echo $res->Question;?></textarea>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="ChoiceA" class="form-label">
                <i class="fas fa-circle me-1 text-primary"></i>Choice A <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceA" name="ChoiceA" placeholder="Enter choice A" type="text" value="<?php echo $res->ChoiceA; ?>" required>
            </div>

            <div class="col-md-6">
              <label for="ChoiceB" class="form-label">
                <i class="fas fa-circle me-1 text-success"></i>Choice B <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceB" name="ChoiceB" placeholder="Enter choice B" type="text" value="<?php echo $res->ChoiceB; ?>" required>
            </div>

            <div class="col-md-6">
              <label for="ChoiceC" class="form-label">
                <i class="fas fa-circle me-1 text-warning"></i>Choice C <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceC" name="ChoiceC" placeholder="Enter choice C" type="text" value="<?php echo $res->ChoiceC; ?>" required>
            </div>

            <div class="col-md-6">
              <label for="ChoiceD" class="form-label">
                <i class="fas fa-circle me-1 text-danger"></i>Choice D <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceD" name="ChoiceD" placeholder="Enter choice D" type="text" value="<?php echo $res->ChoiceD; ?>" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="Answer" class="form-label">
              <i class="fas fa-check-circle me-1"></i>Correct Answer <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="Answer" name="Answer" required>
              <option value="">-- Select correct answer --</option>
              <option value="A" <?php echo ($res->Answer == "A") ? "selected" : ""?>>A</option>
              <option value="B" <?php echo ($res->Answer == "B") ? "selected" : ""?>>B</option>
              <option value="C" <?php echo ($res->Answer == "C") ? "selected" : ""?>>C</option>
              <option value="D" <?php echo ($res->Answer == "D") ? "selected" : ""?>>D</option>
            </select>
            <small class="form-text text-muted mt-1">Select the correct answer from choices above</small>
          </div>

          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Update
            </button>
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Load topics for edit page
function loadEditTopics() {
    const categoryId = document.getElementById('editCategory').value;
    const topicSelect = document.getElementById('editTopic');
    
    if (!categoryId) {
        topicSelect.innerHTML = '<option value="">Select Category first</option>';
        return;
    }
    
    // Show loading
    topicSelect.innerHTML = '<option value="">Loading topics...</option>';
    
    fetch('get_topics.php?categoryId=' + categoryId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                topicSelect.innerHTML = '<option value="">Select Topic</option>';
                data.topics.forEach(topic => {
                    const selected = topic.TopicID == <?php echo isset($res->TopicID) ? $res->TopicID : 0; ?> ? 'selected' : '';
                    topicSelect.innerHTML += '<option value="' + topic.TopicID + '" ' + selected + '>' + topic.TopicName + '</option>';
                });
            } else {
                topicSelect.innerHTML = '<option value="">Error loading topics</option>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            topicSelect.innerHTML = '<option value="">Error loading topics</option>';
        });
}

// Load topics on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add small delay to ensure DOM is fully loaded
    setTimeout(function() {
        loadEditTopics();
    }, 100);
});
</script>