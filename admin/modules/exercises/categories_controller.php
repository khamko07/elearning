<?php
require_once ("../../../include/initialize.php");

if (!isset($_SESSION['USERID'])){
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$input = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');

switch ($action) {
    case 'addCategory':
        addCategory($input);
        break;
    case 'editCategory':
        editCategory($input);
        break;
    case 'deleteCategory':
        deleteCategory($input);
        break;
    case 'addTopic':
        addTopic($input);
        break;
    case 'editTopic':
        editTopic($input);
        break;
    case 'deleteTopic':
        deleteTopic($input);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function addCategory($input) {
    global $mydb;
    
    if (!isset($input['categoryName']) || empty(trim($input['categoryName']))) {
        echo json_encode(['success' => false, 'message' => 'Category name is required']);
        return;
    }
    
    $categoryName = $mydb->escape_value(trim($input['categoryName']));
    
    // Check if category already exists
    $sql = "SELECT COUNT(*) as count FROM tblcategories WHERE CategoryName = '{$categoryName}' AND IsActive = 1";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    
    if ($result->count > 0) {
        echo json_encode(['success' => false, 'message' => 'Category already exists']);
        return;
    }
    
    $sql = "INSERT INTO tblcategories (CategoryName, CreatedAt, IsActive) VALUES ('{$categoryName}', NOW(), 1)";
    $mydb->setQuery($sql);
    
    if ($mydb->executeQuery()) {
        echo json_encode(['success' => true, 'message' => 'Category added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add category']);
    }
}

function editCategory($input) {
    global $mydb;
    
    if (!isset($input['categoryId']) || !isset($input['categoryName']) || empty(trim($input['categoryName']))) {
        echo json_encode(['success' => false, 'message' => 'Category ID and name are required']);
        return;
    }
    
    $categoryId = (int)$input['categoryId'];
    $categoryName = $mydb->escape_value(trim($input['categoryName']));
    
    $sql = "UPDATE tblcategories SET CategoryName = '{$categoryName}' WHERE CategoryID = {$categoryId}";
    $mydb->setQuery($sql);
    
    if ($mydb->executeQuery()) {
        echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update category']);
    }
}

function deleteCategory($input) {
    global $mydb;
    
    if (!isset($input['categoryId'])) {
        echo json_encode(['success' => false, 'message' => 'Category ID is required']);
        return;
    }
    
    $categoryId = (int)$input['categoryId'];
    
    // Soft delete - set IsActive to 0
    $sql = "UPDATE tblcategories SET IsActive = 0 WHERE CategoryID = {$categoryId}";
    $mydb->setQuery($sql);
    
    if ($mydb->executeQuery()) {
        // Also soft delete related topics
        $sql = "UPDATE tbltopics SET IsActive = 0 WHERE CategoryID = {$categoryId}";
        $mydb->setQuery($sql);
        $mydb->executeQuery();
        
        echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete category']);
    }
}

function addTopic($input) {
    global $mydb;
    
    if (!isset($input['categoryId']) || !isset($input['topicName']) || empty(trim($input['topicName']))) {
        echo json_encode(['success' => false, 'message' => 'Category ID and topic name are required']);
        return;
    }
    
    $categoryId = (int)$input['categoryId'];
    $topicName = $mydb->escape_value(trim($input['topicName']));
    
    // Check if topic already exists in this category
    $sql = "SELECT COUNT(*) as count FROM tbltopics WHERE CategoryID = {$categoryId} AND TopicName = '{$topicName}' AND IsActive = 1";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    
    if ($result->count > 0) {
        echo json_encode(['success' => false, 'message' => 'Topic already exists in this category']);
        return;
    }
    
    $sql = "INSERT INTO tbltopics (CategoryID, TopicName, CreatedAt, IsActive) VALUES ({$categoryId}, '{$topicName}', NOW(), 1)";
    $mydb->setQuery($sql);
    
    if ($mydb->executeQuery()) {
        echo json_encode(['success' => true, 'message' => 'Topic added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add topic']);
    }
}

function editTopic($input) {
    global $mydb;
    
    if (!isset($input['topicId']) || !isset($input['topicName']) || empty(trim($input['topicName']))) {
        echo json_encode(['success' => false, 'message' => 'Topic ID and name are required']);
        return;
    }
    
    $topicId = (int)$input['topicId'];
    $topicName = $mydb->escape_value(trim($input['topicName']));
    
    $sql = "UPDATE tbltopics SET TopicName = '{$topicName}' WHERE TopicID = {$topicId}";
    $mydb->setQuery($sql);
    
    if ($mydb->executeQuery()) {
        echo json_encode(['success' => true, 'message' => 'Topic updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update topic']);
    }
}

function deleteTopic($input) {
    global $mydb;
    
    if (!isset($input['topicId'])) {
        echo json_encode(['success' => false, 'message' => 'Topic ID is required']);
        return;
    }
    
    $topicId = (int)$input['topicId'];
    
    // Soft delete - set IsActive to 0
    $sql = "UPDATE tbltopics SET IsActive = 0 WHERE TopicID = {$topicId}";
    $mydb->setQuery($sql);
    
    if ($mydb->executeQuery()) {
        echo json_encode(['success' => true, 'message' => 'Topic deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete topic']);
    }
}
?>