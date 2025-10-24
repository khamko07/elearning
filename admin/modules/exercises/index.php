<?php
require_once("../../../include/initialize.php");
if(!isset($_SESSION['USERID'])){
	redirect(web_root."admin/index.php");
}

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list' :
		$content    = 'list.php';		
		break;
	case 'questions' :
		$content    = 'questions_by_topic.php';		
		break;
	case 'topics' :
		$content    = 'admin_topics.php';		
		break;
	case 'add' :
		$content    = 'add.php';		
		break;
	case 'edit' :
		$content    = 'edit.php';		
		break;
    case 'view' :
		$content    = 'view.php';		
		break;
    case 'categories' :
		$content    = 'categories.php';		
		break;

	default :
		$content    = 'admin_categories.php';		
}
require_once("../../navigation/navigations.php");
?>
  
