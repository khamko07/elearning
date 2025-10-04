<?php
require_once("../../../include/initialize.php");

// Check if user is logged in
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
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }
    
    $lessonId = isset($data['lessonId']) ? $data['lessonId'] : null;
    $questions = isset($data['questions']) ? $data['questions'] : null;
    
    if (!$lessonId || !$questions || !is_array($questions)) {
        throw new Exception('Missing required data: lessonId and questions array');
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
            
            // Generate UNIQUE Exercise ID for each question using multiple methods
            $ExerciseID = null;
            $attempts = 0;
            
            while ($ExerciseID === null && $attempts < 10) {
                try {
                    // Method 1: Try traditional autonumber first
                    if ($attempts === 0) {
                        $autonum = new Autonumber();
                        $resauto = $autonum->set_autonumber('ExerciseID');
                        $baseNumber = isset($resauto->AUTO) ? intval($resauto->AUTO) : 1;
                        $testID = date('Y') . str_pad($baseNumber + $index, 4, '0', STR_PAD_LEFT);
                    } else {
                        // Method 2: Use timestamp + index + random for uniqueness
                        $timestamp = time();
                        $microseconds = intval(microtime(true) * 1000) % 1000;
                        $testID = date('Y') . str_pad(($timestamp % 10000) + $index + $microseconds + $attempts, 4, '0', STR_PAD_LEFT);
                    }
                    
                    // Check if ID already exists
                    $checkSql = "SELECT COUNT(*) as count FROM tblexercise WHERE ExerciseID = '{$testID}'";
                    $mydb->setQuery($checkSql);
                    $result = $mydb->loadSingleResult();
                    
                    if ($result->count == 0) {
                        $ExerciseID = $testID;
                        
                        // Update autonumber table for future use
                        if ($attempts === 0) {
                            try {
                                $autonum->auto_update('ExerciseID');
                            } catch (Exception $autoError) {
                                error_log("Autonumber update failed: " . $autoError->getMessage());
                            }
                        }
                    }
                    
                } catch (Exception $genError) {
                    error_log("ID generation attempt $attempts failed: " . $genError->getMessage());
                }
                
                $attempts++;
                
                if ($ExerciseID === null && $attempts < 10) {
                    // Small delay to ensure uniqueness
                    usleep(1000); // 1ms delay
                }
            }
            
            // Final fallback - use current timestamp + random
            if ($ExerciseID === null) {
                $ExerciseID = date('Y') . str_pad((time() % 10000) + rand(1, 999) + $index, 4, '0', STR_PAD_LEFT);
            }
            
            // Escape values
            $questionText = $mydb->escape_value($question['question']);
            $choiceA = $mydb->escape_value($choices['A']);
            $choiceB = $mydb->escape_value($choices['B']);
            $choiceC = $mydb->escape_value($choices['C']);
            $choiceD = $mydb->escape_value($choices['D']);
            $answer = $mydb->escape_value($question['answer']);
            $lessonIdEscaped = $mydb->escape_value($lessonId);
            
            // Debug log
            error_log("Inserting question " . ($index + 1) . " with ExerciseID: $ExerciseID");
            
            // Insert into tblexercise using direct SQL
            $sql = "INSERT INTO tblexercise (ExerciseID, LessonID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
                    VALUES ('{$ExerciseID}', '{$lessonIdEscaped}', '{$questionText}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}', '0000-00-00')";
            $mydb->setQuery($sql);
            $mydb->executeQuery();
            
            // Get students once outside the loop for efficiency
            if ($index === 0) {
                $sql = "SELECT StudentID FROM tblstudent";
                $mydb->setQuery($sql);
                $allStudents = $mydb->loadResultList();
            }
            
            // Insert into tblstudentquestion for all students
            foreach ($allStudents as $student) {
                $studId = $mydb->escape_value($student->StudentID);
                $sql = "INSERT INTO tblstudentquestion (`ExerciseID`, `LessonID`, `StudentID`, `Question`, `CA`, `CB`, `CC`, `CD`, `QA`) 
                        VALUES ('{$ExerciseID}', '{$lessonIdEscaped}', '{$studId}', '{$questionText}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}')";
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
        'details' => isset($errors) ? $errors : [],
        'debug' => [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]
    ]);
}
?>