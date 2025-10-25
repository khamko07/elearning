<?php
require_once("../../../include/initialize.php");

if (!isset($_SESSION['USERID'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

try {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data || !isset($data['questions']) || !is_array($data['questions'])) {
        throw new Exception('Invalid data format');
    }
    
    $questions = $data['questions'];
    $topic = isset($data['topic']) ? $data['topic'] : 'General';
    
    // Get CategoryID and TopicID from form data (not from topic string)
    $categoryId = isset($data['categoryId']) ? (int)$data['categoryId'] : 1;
    $topicId = isset($data['topicId']) ? (int)$data['topicId'] : 1;
    
    // Validate that CategoryID and TopicID are provided
    if (!$categoryId || !$topicId) {
        throw new Exception('CategoryID and TopicID are required');
    }
    
    $insertedCount = 0;
    $errors = [];
    
    foreach ($questions as $index => $question) {
        try {
            // Validate question structure
            if (!isset($question['question']) || !isset($question['choices']) || !isset($question['answer'])) {
                $errors[] = "Question " . ($index + 1) . ": Missing required fields";
                continue;
            }
            
            $choices = $question['choices'];
            if (!isset($choices['A']) || !isset($choices['B']) || !isset($choices['C']) || !isset($choices['D'])) {
                $errors[] = "Question " . ($index + 1) . ": Missing choice options";
                continue;
            }
            
            // Generate unique ExerciseID
            $year = date('Y');
            $timestamp = time();
            $random = rand(1000, 9999);
            $unique = ($timestamp + $index + $random) % 10000;
            $ExerciseID = $year . str_pad($unique, 4, '0', STR_PAD_LEFT);
            
            // Ensure uniqueness
            $attempts = 0;
            while ($attempts < 20) {
                $sql = "SELECT COUNT(*) as count FROM tblexercise WHERE ExerciseID = '{$ExerciseID}'";
                $mydb->setQuery($sql);
                $result = $mydb->loadSingleResult();
                
                if ($result->count == 0) break;
                
                $random = rand(1000, 9999);
                $ExerciseID = $year . str_pad(($unique + $attempts + $random) % 10000, 4, '0', STR_PAD_LEFT);
                $attempts++;
            }
            
            // Escape values
            $questionText = $mydb->escape_value($question['question']);
            $choiceA = $mydb->escape_value($choices['A']);
            $choiceB = $mydb->escape_value($choices['B']);
            $choiceC = $mydb->escape_value($choices['C']);
            $choiceD = $mydb->escape_value($choices['D']);
            $answer = $mydb->escape_value($question['answer']);
            
            // Insert question
            $sql = "INSERT INTO tblexercise (ExerciseID, LessonID, CategoryID, TopicID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer, ExercisesDate) 
                    VALUES ('{$ExerciseID}', 0, {$categoryId}, {$topicId}, '{$questionText}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}', '0000-00-00')";
            
            $mydb->setQuery($sql);
            $result = $mydb->executeQuery();
            
            if ($result) {
                $insertedCount++;
                
                // Insert into tblstudentquestion for all students
                $sql = "SELECT StudentID FROM tblstudent";
                $mydb->setQuery($sql);
                $students = $mydb->loadResultList();
                
                foreach ($students as $student) {
                    $sql = "INSERT INTO tblstudentquestion (ExerciseID, LessonID, StudentID, Question, CA, CB, CC, CD, QA) 
                            VALUES ('{$ExerciseID}', {$topicId}, {$student->StudentID}, '{$questionText}', '{$choiceA}', '{$choiceB}', '{$choiceC}', '{$choiceD}', '{$answer}')";
                    $mydb->setQuery($sql);
                    $mydb->executeQuery();
                }
            } else {
                $errors[] = "Question " . ($index + 1) . ": Failed to insert";
            }
            
            // Small delay to ensure uniqueness
            usleep(1000);
            
        } catch (Exception $e) {
            $errors[] = "Question " . ($index + 1) . ": " . $e->getMessage();
        }
    }
    
    echo json_encode([
        'success' => true,
        'inserted' => $insertedCount,
        'total' => count($questions),
        'errors' => $errors,
        'message' => "Successfully inserted {$insertedCount} out of " . count($questions) . " questions"
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>