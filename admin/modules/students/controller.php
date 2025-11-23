<?php
require_once("../../../include/initialize.php");
if(!isset($_SESSION['USERID'])){
	redirect(web_root."admin/index.php");
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	case 'delete':
		doDelete();
		break;
	default:
		redirect('index.php');
}

function doDelete(){
	global $mydb;
	$id = intval($_GET['id'] ?? 0);
	
	if ($id <= 0) {
		message('Invalid student ID','error');
		redirect('index.php');
		return;
	}
	
	// Check if student exists
	$mydb->setQuery("SELECT * FROM tblstudent WHERE StudentID = {$id}");
	$student = $mydb->loadSingleResult();
	
	if (!$student) {
		message('Student not found','error');
		redirect('index.php');
		return;
	}
	
	// Delete student
	$mydb->setQuery("DELETE FROM tblstudent WHERE StudentID = {$id}");
	
	if ($mydb->executeQuery()) {
		$studentName = $student->Fname . ' ' . $student->Lname;
		message('Student "' . $studentName . '" deleted successfully','success');
	} else {
		$error = $mydb->getError();
		message('Delete failed: ' . ($error ? $error : 'Unknown error'), 'error');
	}
	
	redirect('index.php');
}
?>

