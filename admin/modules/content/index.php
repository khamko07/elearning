<?php
require_once("../../../include/initialize.php");
if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); }

$view = isset($_GET['view']) ? $_GET['view'] : 'list';
switch ($view) {
  case 'add':
    $content = 'add.php';
    break;
  default:
    $content = 'list.php';
}
require_once("../../navigation/navigations.php");
?>


