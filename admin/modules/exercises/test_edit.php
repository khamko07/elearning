<?php
require_once ("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
if($id == ''){
    redirect("index.php");
}

$exercise = New Exercise();
$res = $exercise->single_exercise($id);

if (!$res) {
    message("Exercise not found", "error");
    redirect("index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Edit</title>
    <link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="padding: 20px;">

<h1>Test Edit Exercise</h1>

<form method="POST" action="controller.php?action=edit">
    <input type="hidden" name="ExerciseID" value="<?php echo $res->ExerciseID; ?>">
    
    <div class="form-group">
        <label>Category:</label>
        <select name="Category" id="testCategory" class="form-control" required onchange="loadTestTopics()">
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
    
    <div class="form-group">
        <label>Topic:</label>
        <select name="Topic" id="testTopic" class="form-control" required>
            <option value="">Loading...</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Question:</label>
        <textarea name="Question" class="form-control" required><?php echo htmlspecialchars($res->Question); ?></textarea>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Choice A:</label>
                <input type="text" name="ChoiceA" class="form-control" value="<?php echo htmlspecialchars($res->ChoiceA); ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Choice B:</label>
                <input type="text" name="ChoiceB" class="form-control" value="<?php echo htmlspecialchars($res->ChoiceB); ?>" required>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Choice C:</label>
                <input type="text" name="ChoiceC" class="form-control" value="<?php echo htmlspecialchars($res->ChoiceC); ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Choice D:</label>
                <input type="text" name="ChoiceD" class="form-control" value="<?php echo htmlspecialchars($res->ChoiceD); ?>" required>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label>Answer:</label>
        <select name="Answer" class="form-control" required>
            <option value="A" <?php echo ($res->Answer == 'A') ? 'selected' : ''; ?>>A</option>
            <option value="B" <?php echo ($res->Answer == 'B') ? 'selected' : ''; ?>>B</option>
            <option value="C" <?php echo ($res->Answer == 'C') ? 'selected' : ''; ?>>C</option>
            <option value="D" <?php echo ($res->Answer == 'D') ? 'selected' : ''; ?>>D</option>
        </select>
    </div>
    
    <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
    <a href="index.php" class="btn btn-default">Cancel</a>
</form>

<script>
function loadTestTopics() {
    const categoryId = document.getElementById('testCategory').value;
    const topicSelect = document.getElementById('testTopic');
    
    if (!categoryId) {
        topicSelect.innerHTML = '<option value="">Select Category first</option>';
        return;
    }
    
    topicSelect.innerHTML = '<option value="">Loading...</option>';
    
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
    setTimeout(loadTestTopics, 200);
});
</script>

</body>
</html>