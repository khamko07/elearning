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
  if (!isset($_POST['save'])) { redirect('index.php'); return; }
  $title = trim($_POST['Title'] ?? '');
  $topic = trim($_POST['Topic'] ?? '');
  $body  = trim($_POST['Body'] ?? '');
  if ($title === '' || $body === '') { message('Title and Content are required','error'); redirect('index.php?view=add'); return; }
  $title = $mydb->escape_value($title);
  $topic = $mydb->escape_value($topic);
  $body  = $mydb->escape_value($body);
  $mydb->setQuery("INSERT INTO tblcontent(Title,Topic,Body,CreatedAt) VALUES('{$title}','{$topic}','{$body}',NOW())");
  if ($mydb->executeQuery()) { message('Content saved','success'); } else { message('Save failed','error'); }
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


