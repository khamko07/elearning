<?php
require_once("../../../include/initialize.php");
if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); }

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
  case 'add': doAdd(); break;
  case 'update': doUpdate(); break;
  case 'delete': doDelete(); break;
  default: redirect('index.php');
}

function doAdd(){
  global $mydb;
  
  // Debug: Log POST data
  error_log("doAdd called. POST data: " . print_r($_POST, true));
  error_log("POST save: " . (isset($_POST['save']) ? 'YES' : 'NO'));
  
  if (!isset($_POST['save'])) { 
    error_log("No save button in POST, redirecting...");
    message('Form submission error: Save button not found','error');
    redirect('index.php?view=add'); 
    return; 
  }
  
  $title = trim($_POST['Title'] ?? '');
  $topic = trim($_POST['Topic'] ?? '');
  $body  = trim($_POST['Body'] ?? '');
  
  error_log("Title: " . substr($title, 0, 50) . "...");
  error_log("Topic: " . substr($topic, 0, 50) . "...");
  error_log("Body length: " . strlen($body));
  
  if ($title === '' || $body === '') { 
    error_log("Validation failed: Title or Body is empty");
    message('Title and Content are required','error'); 
    redirect('index.php?view=add'); 
    return; 
  }
  
  // Escape values properly
  $title = $mydb->escape_value($title);
  $topic = $mydb->escape_value($topic);
  $body  = $mydb->escape_value($body);
  
  // Get current user ID if available
  $createdBy = isset($_SESSION['USERID']) ? intval($_SESSION['USERID']) : null;
  
  error_log("CreatedBy: " . ($createdBy ?? 'NULL'));
  
  // Check body length
  $bodyLength = strlen($body);
  error_log("Body length: " . $bodyLength);
  
  if ($bodyLength > 16777215) { // MEDIUMTEXT max size
    error_log("Body too long: " . $bodyLength);
    message('Content is too long. Maximum size is 16MB.','error');
    redirect('index.php?view=add');
    return;
  }
  
  // Build SQL query - handle NULL for CreatedBy properly
  // Use prepared statement approach with proper escaping
  if ($createdBy !== null && $createdBy > 0) {
    $sql = "INSERT INTO tblcontent(Title, Topic, Body, CreatedAt, CreatedBy) 
            VALUES('{$title}', '{$topic}', '{$body}', NOW(), {$createdBy})";
  } else {
    $sql = "INSERT INTO tblcontent(Title, Topic, Body, CreatedAt) 
            VALUES('{$title}', '{$topic}', '{$body}', NOW())";
  }
  
  error_log("SQL Query length: " . strlen($sql));
  error_log("SQL Query preview: " . substr($sql, 0, 500) . "...");
  
  $mydb->setQuery($sql);
  
  $result = $mydb->executeQuery();
  
  if ($result) { 
    // Check if insert was successful
    $insertId = $mydb->insert_id();
    $affectedRows = $mydb->affected_rows();
    
    error_log("Insert result: ID=" . $insertId . ", Affected rows=" . $affectedRows);
    
    if ($affectedRows > 0) {
      message('Content saved successfully (ID: ' . $insertId . ')','success'); 
    } else {
      message('Content save completed but no rows were affected','warning'); 
    }
  } else { 
    $error = $mydb->getError();
    $errorNo = $mydb->getErrorNo();
    error_log("Database error: " . $error . " (Error #" . $errorNo . ")");
    message('Save failed: ' . ($error ? $error : 'Unknown error') . ' (Error #' . $errorNo . ')', 'error'); 
  }
  
  redirect('index.php');
}

function doUpdate(){
  global $mydb;
  if (!isset($_POST['save'])) { redirect('index.php'); return; }
  $id = intval($_POST['ContentID'] ?? 0);
  if ($id <= 0) { message('Invalid content ID','error'); redirect('index.php'); return; }
  
  $title = trim($_POST['Title'] ?? '');
  $topic = trim($_POST['Topic'] ?? '');
  $body  = trim($_POST['Body'] ?? '');
  
  if ($title === '' || $body === '') { 
    message('Title and Content are required','error'); 
    redirect("index.php?view=edit&id={$id}"); 
    return; 
  }
  
  $title = $mydb->escape_value($title);
  $topic = $mydb->escape_value($topic);
  $body  = $mydb->escape_value($body);
  
  $mydb->setQuery("UPDATE tblcontent SET Title='{$title}', Topic='{$topic}', Body='{$body}' WHERE ContentID={$id}");
  
  if ($mydb->executeQuery()) { 
    message('Content updated successfully','success'); 
  } else { 
    message('Update failed','error'); 
  }
  
  redirect("index.php?view=preview&id={$id}");
}

function doDelete(){
  global $mydb;
  $id = intval($_GET['id'] ?? 0);
  
  if ($id <= 0) { 
    message('Invalid content ID','error'); 
    redirect('index.php'); 
    return; 
  }
  
  $mydb->setQuery("DELETE FROM tblcontent WHERE ContentID={$id}");
  
  if ($mydb->executeQuery()) { 
    message('Content deleted successfully','success'); 
  } else { 
    message('Delete failed','error'); 
  }
  
  redirect('index.php');
}
?>


