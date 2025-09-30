<?php
require_once ("../../../include/initialize.php");
	 if (!isset($_SESSION['USERID'])){
      redirect(web_root."admin/index.php");
     }

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add' :
	doInsert();
	break;
	
	case 'edit' :
	doEdit();
	break;
	
	case 'delete' :
	doDelete();
	break; 

	}
   
	function doInsert(){
		global $mydb;
		if(isset($_POST['save'])){

			$autonum = new Autonumber();
			$resauto = $autonum->set_autonumber('ExerciseID');
			$ExerciseID  = date('Y') . (isset($resauto->AUTO) ? $resauto->AUTO : '0001');

			// Validate required fields
			$required = ['Lesson','Question','Answer','ChoiceA','ChoiceB','ChoiceC','ChoiceD'];
			foreach ($required as $field) {
				if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
					message("Missing required field: {$field}", "error");
					redirect("index.php?view=add");
					return;
				}
			}
 
			$exercise = New Exercise();  
			$exercise->ExerciseID 			= $ExerciseID; 
			$exercise->LessonID 			= $_POST['Lesson']; 
			$exercise->Question				= $_POST['Question']; 
			$exercise->Answer				= $_POST['Answer'];
			$exercise->ChoiceA 				= $_POST['ChoiceA'];
			$exercise->ChoiceB				= $_POST['ChoiceB']; 
			$exercise->ChoiceC				= $_POST['ChoiceC']; 
			$exercise->ChoiceD				= $_POST['ChoiceD']; 
			$exercise->create(); 

			$sql = "SELECT * FROM tblstudent";
			$mydb->setQuery($sql);
			$cur = $mydb->loadResultList();
			foreach ($cur as $result) { 
				$q = $mydb->escape_value($_POST['Question']);
				$ca = $mydb->escape_value($_POST['ChoiceA']);
				$cb = $mydb->escape_value($_POST['ChoiceB']);
				$cc = $mydb->escape_value($_POST['ChoiceC']);
				$cd = $mydb->escape_value($_POST['ChoiceD']);
				$qa = $mydb->escape_value($_POST['Answer']);
				$lessonId = $mydb->escape_value($_POST['Lesson']);
				$studId = $mydb->escape_value($result->StudentID);
				$exId = $mydb->escape_value($ExerciseID);
				$sql = "INSERT INTO tblstudentquestion (`ExerciseID`, `LessonID`, `StudentID`,`Question`, `CA`, `CB`, `CC`, `CD`, `QA`) 
				VALUES ('{$exId}','{$lessonId}','{$studId}','{$q}','{$ca}','{$cb}','{$cc}','{$cd}','{$qa}')";
				$mydb->setQuery($sql);
				$mydb->executeQuery();
			}


			$autonum = new Autonumber();
			$autonum->auto_update('ExerciseID');


			message("New Question created successfully!", "success");
			redirect("index.php");
		 
		}

	}

	function doEdit(){
		global $mydb;
	if(isset($_POST['save'])){
			$id = $_POST['ExerciseID'];


			$exercise = New Exercise();   
			$exercise->LessonID 			= $_POST['Lesson']; 
			$exercise->Question				= $_POST['Question']; 
			$exercise->Answer				= $_POST['Answer'];
			$exercise->ChoiceA 				= $_POST['ChoiceA'];
			$exercise->ChoiceB				= $_POST['ChoiceB']; 
			$exercise->ChoiceC				= $_POST['ChoiceC']; 
			$exercise->ChoiceD				= $_POST['ChoiceD']; 
			$exercise->update($id); 

			$sql = "UPDATE tblstudentquestion SET   `LessonID`='".$_POST['Lesson']."', `Question`='".$_POST['Question']."', `CA`='".$_POST['ChoiceA']."', `CB`='".$_POST['ChoiceB']."', `CC`='".$_POST['ChoiceC']."', `CD`='".$_POST['ChoiceD']."', `QA`='".$_POST['Answer']." WHERE ExerciseID='{$id}'";
			$mydb->setQuery($sql);
			$mydb->executeQuery();


			message("Question has been updated!", "success");
			redirect("index.php");
		}
	}


	function doDelete(){
		 
		global $mydb;
		
				$id = 	$_GET['id'];

				$exercise = New Exercise();
	 		 	$exercise->delete($id);

				$sql = "DELETE FROM tblstudentquestion  WHERE ExerciseID='{$id}'";
				$mydb->setQuery($sql);
				$mydb->executeQuery();
			 
			message("Question already Deleted!","info");
			redirect('index.php');
	 
		
	}
?>