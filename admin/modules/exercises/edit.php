<?php   
  @$id = $_GET['id'];
  if($id==''){
  redirect("index.php");
}
  $exercise = New Exercise();
  $res = $exercise->single_exercise($id);

?> 

 <form class="form-horizontal span6" action="controller.php?action=edit" method="POST" style="margin-top: 20px;"> 
                        <div class="row">
                           <div class="col-lg-12">
                              <h1 class="page-header">Update Question</h1>
                            </div>
                            <!-- /.col-lg-12 -->
                         </div>
                         
                        <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for="Category">Category:</label>
                          <div class="col-md-8">
                          <input type="hidden" name="ExerciseID" value="<?php echo $res->ExerciseID;?>"> 
                            <select class="form-control" name="Category" id="editCategory" required onchange="loadEditTopics()">
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
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for="Topic">Topic:</label>
                          <div class="col-md-8"> 
                            <select class="form-control" name="Topic" id="editTopic" required>
                                <option value="">Loading topics...</option>
                            </select>
                          </div>
                        </div>
                      </div> 
                       <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "Question">Question:</label>

                          <div class="col-md-8">
                            <textarea  class="form-control input-sm" id="Question" name="Question" placeholder=
                                "Question Name" type="text"><?php echo $res->Question;?></textarea>
                            
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceA">A:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="ChoiceA" name="ChoiceA" placeholder=
                                "" type="text" value="<?php echo $res->ChoiceA; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceB">B:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="ChoiceB" name="ChoiceB" placeholder=
                                "" type="text" value="<?php echo $res->ChoiceB; ?>" required>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceC">C:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="ChoiceC" name="ChoiceC" placeholder=
                                "" type="text" value="<?php echo $res->ChoiceC; ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceD">D:</label>

                          <div class="col-md-8">
                              <input class="form-control input-sm" id="ChoiceD" name="ChoiceD" placeholder=
                                "" type="text" value="<?php echo $res->ChoiceD; ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "Answer">Answer:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="Answer" name="Answer" placeholder=
                                "Answer" type="text" value="<?php echo $res->Answer; ?>" required>
                          </div>
                        </div>
                      </div> 

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "idno"></label>

                          <div class="col-md-8">
                           <button class="btn btn-primary btn-sm" name="save" type="submit" ><span class="fa fa-save fw-fa"></span>  Save</button> 
                           </div>
                        </div>
                      </div> 
                      </form>
<sc
ript>
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
                    const selected = topic.TopicID == <?php echo $res->TopicID; ?> ? 'selected' : '';
                    topicSelect.innerHTML += `<option value="${topic.TopicID}" ${selected}>${topic.TopicName}</option>`;
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
    loadEditTopics();
});
</script>