<?php
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if ($categoryId <= 0) {
    redirect('index.php');
}

// Get category info
$sql = "SELECT * FROM tblcategories WHERE CategoryID = {$categoryId} AND IsActive = 1";
$mydb->setQuery($sql);
$category = $mydb->loadSingleResult();

if (!$category) {
    redirect('index.php');
}
?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="index.php">Exercise Management</a></li>
                <li class="active"><?php echo $category->CategoryName; ?></li>
            </ol>
            
            <h1><?php echo $category->CategoryName; ?> - Topics & Questions
                <small>| <a href="index.php?view=add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add New Question</a> |</small>
            </h1>
            <?php if ($category->CategoryDescription): ?>
                <p class="lead text-muted"><?php echo $category->CategoryDescription; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php 
    $sql = "SELECT t.*, COUNT(e.ExerciseID) as QuestionCount
            FROM tbltopics t 
            LEFT JOIN tblexercise e ON t.TopicID = e.TopicID
            WHERE t.CategoryID = {$categoryId} AND t.IsActive = 1 
            GROUP BY t.TopicID 
            ORDER BY t.TopicName";
    $mydb->setQuery($sql);
    $topics = $mydb->loadResultList();
    
    foreach ($topics as $topic) {
    ?>
    <div class="panel panel-info" style="margin-bottom: 20px;">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-tag"></i> <?php echo $topic->TopicName; ?>
                <span class="badge pull-right"><?php echo $topic->QuestionCount; ?> questions</span>
            </h3>
        </div>
        <div class="panel-body">
            <?php if ($topic->TopicDescription): ?>
                <p class="text-muted"><?php echo $topic->TopicDescription; ?></p>
            <?php endif; ?>
            
            <?php if ($topic->QuestionCount > 0): ?>
                <!-- Questions Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th width="3%">
                                    <input type="checkbox" class="select-all-topic" data-topic="<?php echo $topic->TopicID; ?>" title="Select All">
                                </th>
                                <th width="5%">#</th>
                                <th>Question</th>
                                <th width="8%">A</th>
                                <th width="8%">B</th>
                                <th width="8%">C</th>
                                <th width="8%">D</th>
                                <th width="5%">Answer</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tblexercise WHERE TopicID = {$topic->TopicID} ORDER BY ExerciseID DESC";
                            $mydb->setQuery($sql);
                            $questions = $mydb->loadResultList();
                            
                            $cnt = 1;
                            foreach ($questions as $question) {
                                echo '<tr>';
                                echo '<td align="center"><input type="checkbox" class="question-checkbox topic-'.$topic->TopicID.'" value="'.$question->ExerciseID.'"></td>';
                                echo '<td align="center">'.$cnt.'</td>';
                                echo '<td>'.substr($question->Question, 0, 80).(strlen($question->Question) > 80 ? '...' : '').'</td>';
                                echo '<td>'.substr($question->ChoiceA, 0, 20).(strlen($question->ChoiceA) > 20 ? '...' : '').'</td>';
                                echo '<td>'.substr($question->ChoiceB, 0, 20).(strlen($question->ChoiceB) > 20 ? '...' : '').'</td>';
                                echo '<td>'.substr($question->ChoiceC, 0, 20).(strlen($question->ChoiceC) > 20 ? '...' : '').'</td>';
                                echo '<td>'.substr($question->ChoiceD, 0, 20).(strlen($question->ChoiceD) > 20 ? '...' : '').'</td>';
                                echo '<td align="center"><strong>'.$question->Answer.'</strong></td>';
                                echo '<td>';
                                echo '<a title="Edit" href="index.php?view=edit&id='.$question->ExerciseID.'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> ';
                                echo '<a title="Delete" href="../exercises/controller.php?action=delete&id='.$question->ExerciseID.'" class="btn btn-danger btn-xs" onclick="return confirm(\'Delete this question?\')"><i class="fa fa-trash"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                                $cnt++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Bulk Actions for this topic -->
                <div class="bulk-actions-topic" data-topic="<?php echo $topic->TopicID; ?>" style="display: none; margin-top: 10px;">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        Selected <span class="selected-count">0</span> questions in this topic.
                        <button type="button" class="btn btn-danger btn-sm" onclick="bulkDeleteTopic(<?php echo $topic->TopicID; ?>)">
                            <i class="fa fa-trash"></i> Delete Selected
                        </button>
                        <button type="button" class="btn btn-default btn-sm" onclick="clearTopicSelection(<?php echo $topic->TopicID; ?>)">
                            <i class="fa fa-times"></i> Clear Selection
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fa fa-info-circle"></i> No questions in this topic yet.
                    <a href="index.php?view=add" class="btn btn-sm btn-success">Add First Question</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php } ?>
    
    <?php if (empty($topics)): ?>
    <div class="alert alert-info text-center">
        <i class="fa fa-info-circle"></i> No topics available in this category yet.
        <a href="index.php?view=categories" class="btn btn-sm btn-info">Manage Categories & Topics</a>
    </div>
    <?php endif; ?>
    
    <div class="text-center" style="margin-top: 30px;">
        <a href="index.php" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Back to Categories
        </a>
    </div>

<script>
// Select all for specific topic
$(document).on('change', '.select-all-topic', function() {
    const topicId = $(this).data('topic');
    const isChecked = $(this).is(':checked');
    
    $(`.topic-${topicId}`).prop('checked', isChecked);
    updateBulkActionsTopic(topicId);
});

// Individual checkbox change
$(document).on('change', '.question-checkbox', function() {
    const topicId = $(this).attr('class').match(/topic-(\d+)/)[1];
    updateBulkActionsTopic(topicId);
});

function updateBulkActionsTopic(topicId) {
    const selectedCheckboxes = $(`.topic-${topicId}:checked`);
    const totalCheckboxes = $(`.topic-${topicId}`);
    const bulkActions = $(`.bulk-actions-topic[data-topic="${topicId}"]`);
    const selectedCount = selectedCheckboxes.length;
    
    if (selectedCount > 0) {
        bulkActions.show();
        bulkActions.find('.selected-count').text(selectedCount);
    } else {
        bulkActions.hide();
    }
    
    // Update select all checkbox
    const selectAllCheckbox = $(`.select-all-topic[data-topic="${topicId}"]`);
    if (totalCheckboxes.length > 0) {
        selectAllCheckbox.prop('checked', selectedCount === totalCheckboxes.length);
        selectAllCheckbox.prop('indeterminate', selectedCount > 0 && selectedCount < totalCheckboxes.length);
    }
}

function bulkDeleteTopic(topicId) {
    const selectedCheckboxes = $(`.topic-${topicId}:checked`);
    const selectedIds = selectedCheckboxes.map(function() { return $(this).val(); }).get();
    
    if (selectedIds.length === 0) {
        alert('Please select at least one question to delete!');
        return;
    }
    
    const confirmMessage = `Delete ${selectedIds.length} selected questions?\n\nThis action cannot be undone!`;
    
    if (confirm(confirmMessage)) {
        // Create form and submit
        const form = $('<form>', {
            method: 'POST',
            action: '../exercises/controller.php?action=bulkDelete'
        });
        
        selectedIds.forEach(id => {
            form.append($('<input>', {
                type: 'hidden',
                name: 'selectedIds[]',
                value: id
            }));
        });
        
        $('body').append(form);
        form.submit();
    }
}

function clearTopicSelection(topicId) {
    $(`.topic-${topicId}`).prop('checked', false);
    $(`.select-all-topic[data-topic="${topicId}"]`).prop('checked', false);
    updateBulkActionsTopic(topicId);
}
</script>