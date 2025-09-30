<?php
require_once("../../../include/initialize.php");
if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); }

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
  case 'add': doAdd(); break;
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
?>


