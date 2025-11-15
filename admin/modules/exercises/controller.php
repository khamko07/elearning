<?php
require_once("../../../include/initialize.php");
if (!isset($_SESSION['USERID'])) {
	redirect(web_root . "admin/index.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add':
		doInsert();
		break;

	case 'edit':
		doEdit();
		break;

	case 'delete':
		doDelete();
		break;

	case 'bulkDelete':
		doBulkDelete();
		break;
}

function doInsert()
{
	global $mydb;
	if (isset($_POST['save'])) {

		// Generate unique ExerciseID using helper function
		require_once('exercise_id_helper.php');
		$ExerciseID = generateUniqueExerciseID($mydb);

		// Validate required fields
		$required = ['Category', 'Topic', 'Question', 'Answer', 'ChoiceA', 'ChoiceB', 'ChoiceC', 'ChoiceD'];
		foreach ($required as $field) {
			if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
				message("Missing required field: {$field}", "error");
				redirect("index.php?view=add");
				return;
			}
		}

		// Validate that Category and Topic exist and are related
		$categoryId = (int)$_POST['Category'];
		$topicId = (int)$_POST['Topic'];

		$sql = "SELECT COUNT(*) as count FROM tbltopics WHERE TopicID = {$topicId} AND CategoryID = {$categoryId} AND IsActive = 1";
		$mydb->setQuery($sql);
		$result = $mydb->loadSingleResult();

		if ($result->count == 0) {
			message("Invalid Category/Topic combination", "error");
			redirect("index.php?view=add");
			return;
		}

		// Use direct SQL insert instead of Exercise class to ensure CategoryID/TopicID are saved
		$question = $mydb->escape_value($_POST['Question']);
		$choiceA = $mydb->escape_value($_POST['ChoiceA']);
		$choiceB = $mydb->escape_value($_POST['ChoiceB']);
		$choiceC = $mydb->escape_value($_POST['ChoiceC']);
		$choiceD = $mydb->escape_value($_POST['ChoiceD']);
		$answer = $mydb->escape_value($_POST['Answer']);
		$categoryId = (int)$_POST['Category'];
		$topicId = (int)$_POST['Topic'];

		$sql = "INSERT INTO tblexercise (ExerciseID, LessonID, CategoryID, TopicID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
			        VALUES ('{$ExerciseID}', 0, {$categoryId}, {$topicId}, '{$question}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}', '0000-00-00')";
		$mydb->setQuery($sql);
		$result = $mydb->executeQuery();

		if (!$result) {
			message("Failed to create question", "error");
			redirect("index.php?view=add");
			return;
		}

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
			$topicId = $mydb->escape_value($_POST['Topic']);
			$studId = $mydb->escape_value($result->StudentID);
			$exId = $mydb->escape_value($ExerciseID);
			$sql = "INSERT INTO tblstudentquestion (`ExerciseID`, `LessonID`, `StudentID`,`Question`, `CA`, `CB`, `CC`, `CD`, `QA`) 
				VALUES ('{$exId}','{$topicId}','{$studId}','{$q}','{$ca}','{$cb}','{$cc}','{$cd}','{$qa}')";
			$mydb->setQuery($sql);
			$mydb->executeQuery();
		}


		// ExerciseID auto-generated above, no need for autonumber update


		message("New Question created successfully!", "success");
		redirect("index.php");
	}
}

function doEdit()
{
	global $mydb;
	if (isset($_POST['save'])) {
		$id = $_POST['ExerciseID'];

		// Validate Category/Topic relationship
		$categoryId = (int)$_POST['Category'];
		$topicId = (int)$_POST['Topic'];

		$sql = "SELECT COUNT(*) as count FROM tbltopics WHERE TopicID = {$topicId} AND CategoryID = {$categoryId} AND IsActive = 1";
		$mydb->setQuery($sql);
		$result = $mydb->loadSingleResult();

		if ($result->count == 0) {
			message("Invalid Category/Topic combination", "error");
			redirect("index.php?view=edit&id={$id}");
			return;
		}

		// Use direct SQL update to ensure CategoryID/TopicID are saved
		$question = $mydb->escape_value($_POST['Question']);
		$choiceA = $mydb->escape_value($_POST['ChoiceA']);
		$choiceB = $mydb->escape_value($_POST['ChoiceB']);
		$choiceC = $mydb->escape_value($_POST['ChoiceC']);
		$choiceD = $mydb->escape_value($_POST['ChoiceD']);
		$answer = $mydb->escape_value($_POST['Answer']);
		$categoryId = (int)$_POST['Category'];
		$topicId = (int)$_POST['Topic'];

		$sql = "UPDATE tblexercise SET 
			        LessonID = 0,
			        CategoryID = {$categoryId},
			        TopicID = {$topicId},
			        Question = '{$question}',
			        ChoiceA = '{$choiceA}',
			        ChoiceB = '{$choiceB}',
			        ChoiceC = '{$choiceC}',
			        ChoiceD = '{$choiceD}',
			        Answer = '{$answer}'
			        WHERE ExerciseID = '{$id}'";
		$mydb->setQuery($sql);
		$result = $mydb->executeQuery();

		if (!$result) {
			message("Failed to update question", "error");
			redirect("index.php?view=edit&id={$id}");
			return;
		}

		$sql = "UPDATE tblstudentquestion SET `LessonID`='" . $_POST['Topic'] . "', `Question`='" . $_POST['Question'] . "', `CA`='" . $_POST['ChoiceA'] . "', `CB`='" . $_POST['ChoiceB'] . "', `CC`='" . $_POST['ChoiceC'] . "', `CD`='" . $_POST['ChoiceD'] . "', `QA`='" . $_POST['Answer'] . "' WHERE ExerciseID='{$id}'";
		$mydb->setQuery($sql);
		$mydb->executeQuery();

		message("Question has been updated!", "success");
		redirect("index.php");
	}
}


function doDelete()
{

	global $mydb;

	$id = 	$_GET['id'];

	// Get exercise info before deleting to know which page to return to
	$exercise = new Exercise();
	$exerciseData = $exercise->single_exercise($id);
	$lessonId = isset($exerciseData->LessonID) ? $exerciseData->LessonID : '';

	// Check if tblstudentquestion table exists and delete related records
	$checkTable = "SHOW TABLES LIKE 'tblstudentquestion'";
	$mydb->setQuery($checkTable);
	$result = $mydb->executeQuery();
	
	if ($mydb->num_rows($result) > 0) {
		// Table exists, delete related student questions
		$sql = "DELETE FROM tblstudentquestion WHERE ExerciseID='{$id}'";
		$mydb->setQuery($sql);
		$mydb->executeQuery();
	}

	// Delete related student scores/answers for this exercise
	$sql = "DELETE FROM tblscore WHERE ExerciseID='{$id}'";
	$mydb->setQuery($sql);
	$mydb->executeQuery();

	// Then delete the exercise itself
	$exercise->delete($id);

	message("Question already Deleted!", "info");
	
	// Redirect back to topics page with category if available
	if (!empty($lessonId)) {
		redirect('index.php?view=topics&category=' . $lessonId);
	} else {
		redirect('index.php');
	}
}

function doBulkDelete()
{
	global $mydb;

	if (!isset($_POST['selectedIds']) || !is_array($_POST['selectedIds'])) {
		message("Không có câu hỏi nào được chọn để xóa!", "error");
		redirect('index.php');
		return;
	}

	$selectedIds = $_POST['selectedIds'];
	$deletedCount = 0;

	foreach ($selectedIds as $id) {
		$id = $mydb->escape_value($id);

		// Delete from tblexercise
		$exercise = new Exercise();
		$exercise->delete($id);

		// Delete from tblstudentquestion if exists
		$sql = "DELETE FROM tblstudentquestion WHERE ExerciseID='{$id}'";
		$mydb->setQuery($sql);
		$mydb->executeQuery();

		// Delete from tblscore if exists
		$sql = "DELETE FROM tblscore WHERE ExerciseID='{$id}'";
		$mydb->setQuery($sql);
		$mydb->executeQuery();

		$deletedCount++;
	}

	message("Đã xóa thành công {$deletedCount} câu hỏi!", "success");
	redirect('index.php');
}
