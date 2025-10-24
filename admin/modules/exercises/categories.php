<?php
if (!isset($_SESSION['USERID'])){
    redirect(web_root."admin/index.php");
}
?>

<div class="row">
    <div class="col-lg-12"> 
        <h1 class="page-header">Manage Categories & Topics 
            <small>| <a href="index.php" class="btn btn-xs btn-default"><i class="fa fa-arrow-left"></i> Back to Questions</a> |</small>
        </h1> 
    </div>
</div>

<!-- Categories Section -->
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-folder"></i> Categories</h3>
            </div>
            <div class="panel-body">
                <!-- Add Category Form -->
                <form id="addCategoryForm" class="form-inline" style="margin-bottom: 15px;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="categoryName" placeholder="Category Name" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add Category
                    </button>
                </form>
                
                <!-- Categories List -->
                <div id="categoriesList">
                    <?php
                    $sql = "SELECT * FROM tblcategories WHERE IsActive = 1 ORDER BY CategoryName";
                    $mydb->setQuery($sql);
                    $categories = $mydb->loadResultList();
                    
                    foreach ($categories as $category) {
                        echo '<div class="category-item" data-id="'.$category->CategoryID.'">';
                        echo '<div class="row">';
                        echo '<div class="col-md-8">';
                        echo '<strong>'.$category->CategoryName.'</strong>';
                        if ($category->CategoryDescription) {
                            echo '<br><small class="text-muted">'.$category->CategoryDescription.'</small>';
                        }
                        echo '</div>';
                        echo '<div class="col-md-4 text-right">';
                        echo '<button class="btn btn-xs btn-info" onclick="editCategory('.$category->CategoryID.', \''.$category->CategoryName.'\')"><i class="fa fa-edit"></i></button> ';
                        echo '<button class="btn btn-xs btn-danger" onclick="deleteCategory('.$category->CategoryID.')"><i class="fa fa-trash"></i></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<hr style="margin: 10px 0;">';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Topics Section -->
    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-tags"></i> Topics</h3>
            </div>
            <div class="panel-body">
                <!-- Add Topic Form -->
                <form id="addTopicForm" class="form-inline" style="margin-bottom: 15px;">
                    <div class="form-group">
                        <select class="form-control" id="topicCategoryId" required>
                            <option value="">Select Category</option>
                            <?php
                            foreach ($categories as $category) {
                                echo '<option value="'.$category->CategoryID.'">'.$category->CategoryName.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="topicName" placeholder="Topic Name" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add Topic
                    </button>
                </form>
                
                <!-- Topics List -->
                <div id="topicsList">
                    <?php
                    $sql = "SELECT t.*, c.CategoryName 
                            FROM tbltopics t 
                            JOIN tblcategories c ON t.CategoryID = c.CategoryID 
                            WHERE t.IsActive = 1 
                            ORDER BY c.CategoryName, t.TopicName";
                    $mydb->setQuery($sql);
                    $topics = $mydb->loadResultList();
                    
                    $currentCategory = '';
                    foreach ($topics as $topic) {
                        if ($currentCategory != $topic->CategoryName) {
                            if ($currentCategory != '') echo '</div>';
                            echo '<div class="category-group">';
                            echo '<h5 class="text-primary"><i class="fa fa-folder-open"></i> '.$topic->CategoryName.'</h5>';
                            $currentCategory = $topic->CategoryName;
                        }
                        
                        echo '<div class="topic-item" data-id="'.$topic->TopicID.'" style="margin-left: 20px; margin-bottom: 8px;">';
                        echo '<div class="row">';
                        echo '<div class="col-md-8">';
                        echo '<i class="fa fa-tag"></i> '.$topic->TopicName;
                        if ($topic->TopicDescription) {
                            echo '<br><small class="text-muted" style="margin-left: 15px;">'.$topic->TopicDescription.'</small>';
                        }
                        echo '</div>';
                        echo '<div class="col-md-4 text-right">';
                        echo '<button class="btn btn-xs btn-info" onclick="editTopic('.$topic->TopicID.', \''.$topic->TopicName.'\', '.$topic->CategoryID.')"><i class="fa fa-edit"></i></button> ';
                        echo '<button class="btn btn-xs btn-danger" onclick="deleteTopic('.$topic->TopicID.')"><i class="fa fa-trash"></i></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    if ($currentCategory != '') echo '</div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-item, .topic-item {
    padding: 8px;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.category-item:hover, .topic-item:hover {
    background-color: #f5f5f5;
}

.category-group {
    margin-bottom: 15px;
    padding: 10px;
    border-left: 3px solid #5bc0de;
    background-color: #f9f9f9;
}

.form-inline .form-group {
    margin-right: 10px;
}
</style>

<script>
// Add Category
document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const categoryName = document.getElementById('categoryName').value.trim();
    
    if (!categoryName) {
        alert('Please enter category name');
        return;
    }
    
    fetch('categories_controller.php?action=addCategory', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            categoryName: categoryName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Category added successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
});

// Add Topic
document.getElementById('addTopicForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const categoryId = document.getElementById('topicCategoryId').value;
    const topicName = document.getElementById('topicName').value.trim();
    
    if (!categoryId || !topicName) {
        alert('Please select category and enter topic name');
        return;
    }
    
    fetch('categories_controller.php?action=addTopic', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            categoryId: categoryId,
            topicName: topicName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Topic added successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
});

// Edit Category
function editCategory(id, name) {
    const newName = prompt('Edit category name:', name);
    if (newName && newName.trim() !== '') {
        fetch('categories_controller.php?action=editCategory', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                categoryId: id,
                categoryName: newName.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Category updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

// Delete Category
function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category? This will also delete all topics and questions in this category.')) {
        fetch('categories_controller.php?action=deleteCategory', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                categoryId: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Category deleted successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

// Edit Topic
function editTopic(id, name, categoryId) {
    const newName = prompt('Edit topic name:', name);
    if (newName && newName.trim() !== '') {
        fetch('categories_controller.php?action=editTopic', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topicId: id,
                topicName: newName.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Topic updated successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

// Delete Topic
function deleteTopic(id) {
    if (confirm('Are you sure you want to delete this topic? This will also delete all questions in this topic.')) {
        fetch('categories_controller.php?action=deleteTopic', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topicId: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Topic deleted successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}
</script>