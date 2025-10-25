<?php
// Helper function to generate unique ExerciseID
function generateUniqueExerciseID($mydb) {
    $year = date('Y');
    $maxAttempts = 50;
    
    for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
        // Use microseconds + random for uniqueness
        $microtime = (int)(microtime(true) * 1000000) % 10000;
        $random = rand(0, 999);
        $combined = ($microtime + $random + $attempt) % 10000;
        
        $ExerciseID = $year . str_pad($combined, 4, '0', STR_PAD_LEFT);
        
        // Check if unique
        $sql = "SELECT COUNT(*) as count FROM tblexercise WHERE ExerciseID = '{$ExerciseID}'";
        $mydb->setQuery($sql);
        $result = $mydb->loadSingleResult();
        
        if ($result->count == 0) {
            return $ExerciseID;
        }
        
        // Small delay to ensure different microseconds
        usleep(1000); // 1ms delay
    }
    
    // Fallback: use timestamp + random
    return $year . str_pad(time() % 10000, 4, '0', STR_PAD_LEFT);
}
?>