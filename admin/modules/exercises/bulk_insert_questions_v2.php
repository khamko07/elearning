<?php
require_once("../../../include/initialize.php");

// Alternative bulk insert using AUTO_INCREMENT
if (!isset($_SESSION['USERID'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Disable error display and capture errors
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

// Clear any output buffer
ob_clean();

try {
    // Get POST data
    $input = file_get_contents('php://input');
    error_log("Raw input: " . $input);
    
    $data = json_decode($input, true);
    error_log("Decoded data: " . print_r($data, true));
    
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }
    
    $topic = isset($data['topic']) ? trim($data['topic']) : null;
    $questions = isset($data['questions']) ? $data['questions'] : null;
    
    if (!$topic || !$questions || !is_array($questions)) {
        throw new Exception('Missing required data: topic and questions array');
    }
    
    if (empty($questions)) {
        throw new Exception('No questions provided');
    }
    
    $insertedCount = 0;
    $errors = [];
    
    // Start transaction
    $mydb->setQuery("START TRANSACTION");
    $mydb->executeQuery();
    
    foreach ($questions as $index => $question) {
        try {
            // Validate question data
            if (!isset($question['question']) || !isset($question['choices']) || !isset($question['answer'])) {
                $errors[] = "Question " . ($index + 1) . ": Missing required fields";
                continue;
            }
            
            $choices = $question['choices'];
            if (!isset($choices['A']) || !isset($choices['B']) || !isset($choices['C']) || !isset($choices['D'])) {
                $errors[] = "Question " . ($index + 1) . ": Missing choice options";
                continue;
            }
            
            // Escape values
            $questionText = $mydb->escape_value($question['question']);
            $choiceA = $mydb->escape_value($choices['A']);
            $choiceB = $mydb->escape_value($choices['B']);
            $choiceC = $mydb->escape_value($choices['C']);
            $choiceD = $mydb->escape_value($choices['D']);
            $answer = $mydb->escape_value($question['answer']);
            $topicEscaped = $mydb->escape_value($topic);
            
            // Method 3: Let MySQL handle the ID with a unique approach
            // Find the highest existing ExerciseID for this year
            $currentYear = date('Y');
            $sql = "SELECT MAX(CAST(SUBSTRING(ExerciseID, 5) AS UNSIGNED)) as max_num 
                    FROM tblexercise 
                    WHERE ExerciseID LIKE '{$currentYear}%'";
            $mydb->setQuery($sql);
            $result = $mydb->loadSingleResult();
            
            $nextNum = ($result && $result->max_num) ? intval($result->max_num) + 1 : 1;
            $ExerciseID = $currentYear . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
            
            // Double-check uniqueness (in case of concurrent inserts)
            $checkSql = "SELECT COUNT(*) as count FROM tblexercise WHERE ExerciseID = '{$ExerciseID}'";
            $mydb->setQuery($checkSql);
            $checkResult = $mydb->loadSingleResult();
            
            // If still exists, add timestamp suffix
            if ($checkResult->count > 0) {
                $ExerciseID = $currentYear . str_pad($nextNum + time() % 1000, 4, '0', STR_PAD_LEFT);
            }
            
            // Debug log
            error_log("Inserting question " . ($index + 1) . " with ExerciseID: $ExerciseID");
            
            // Insert into tblexercise using direct SQL (using LessonID field to store topic)
            $sql = "INSERT INTO tblexercise (ExerciseID, LessonID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
                    VALUES ('{$ExerciseID}', '{$topicEscaped}', '{$questionText}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}', '0000-00-00')";
            $mydb->setQuery($sql);
            $mydb->executeQuery();
            
            // Get students list once
            if ($index === 0) {
                $sql = "SELECT StudentID FROM tblstudent";
                $mydb->setQuery($sql);
                $allStudents = $mydb->loadResultList();
            }
            
            // Insert into tblstudentquestion for all students
            foreach ($allStudents as $student) {
                $studId = $mydb->escape_value($student->StudentID);
                $sql = "INSERT INTO tblstudentquestion (`ExerciseID`, `LessonID`, `StudentID`, `Question`, `CA`, `CB`, `CC`, `CD`, `QA`) 
                        VALUES ('{$ExerciseID}', '{$topicEscaped}', '{$studId}', '{$questionText}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}')";
                $mydb->setQuery($sql);
                $mydb->executeQuery();
            }
            
            $insertedCount++;
            error_log("Successfully inserted question " . ($index + 1) . " with ExerciseID: $ExerciseID");
            
        } catch (Exception $e) {
            error_log("Error inserting question " . ($index + 1) . ": " . $e->getMessage());
            $errors[] = "Question " . ($index + 1) . ": " . $e->getMessage();
            continue;
        }
    }
    
    if ($insertedCount > 0) {
        // Commit transaction
        $mydb->setQuery("COMMIT");
        $mydb->executeQuery();
        
        // Update autonumber table to keep it in sync
        try {
            $sql = "UPDATE tblautonumbers SET AUTOEND = (
                        SELECT MAX(CAST(SUBSTRING(ExerciseID, 5) AS UNSIGNED)) 
                        FROM tblexercise 
                        WHERE ExerciseID LIKE '" . date('Y') . "%'
                    ) WHERE AUTOKEY = 'ExerciseID'";
            $mydb->setQuery($sql);
            $mydb->executeQuery();
        } catch (Exception $autoUpdateError) {
            error_log("Autonumber sync failed: " . $autoUpdateError->getMessage());
        }
        
        $response = [
            'success' => true,
            'inserted_count' => $insertedCount,
            'message' => "Successfully inserted {$insertedCount} questions"
        ];
        
        if (!empty($errors)) {
            $response['warnings'] = $errors;
        }
        
        echo json_encode($response);
    } else {
        // Rollback transaction
        $mydb->setQuery("ROLLBACK");
        $mydb->executeQuery();
        
        throw new Exception('No questions were inserted. Errors: ' . implode(', ', $errors));
    }
    
} catch (Exception $e) {
    // Rollback transaction on error
    try {
        if (isset($mydb)) {
            $mydb->setQuery("ROLLBACK");
            $mydb->executeQuery();
        }
    } catch (Exception $rollbackError) {
        // Ignore rollback errors
    }
    
    // Log the error
    error_log("Bulk insert error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'details' => isset($errors) ? $errors : []
    ]);
}
?>