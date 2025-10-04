<?php
require_once("../../../include/initialize.php");

// Simple test for bulk insert
echo "<h2>Bulk Insert Test</h2>";

// Check if classes exist
echo "<h3>Class Check:</h3>";
echo "Exercise class exists: " . (class_exists('Exercise') ? 'YES' : 'NO') . "<br>";
echo "Autonumber class exists: " . (class_exists('Autonumber') ? 'YES' : 'NO') . "<br>";

// Check database connection
echo "<h3>Database Check:</h3>";
echo "Database object: " . (isset($mydb) ? 'YES' : 'NO') . "<br>";

// Test basic operations
if (isset($mydb)) {
    try {
        $mydb->setQuery("SELECT COUNT(*) as total FROM tblexercise");
        $result = $mydb->loadSingleResult();
        echo "Current questions count: " . $result->total . "<br>";
    } catch (Exception $e) {
        echo "Database error: " . $e->getMessage() . "<br>";
    }
}

// Test autonumber
try {
    $autonum = new Autonumber();
    $resauto = $autonum->set_autonumber('ExerciseID');
    $ExerciseID = date('Y') . (isset($resauto->AUTO) ? $resauto->AUTO : '0001');
    echo "Next Exercise ID would be: " . $ExerciseID . "<br>";
} catch (Exception $e) {
    echo "Autonumber error: " . $e->getMessage() . "<br>";
}

// Sample JSON data for testing
$sampleData = [
    'lessonId' => '6',
    'questions' => [
        [
            'question' => 'Test question?',
            'choices' => [
                'A' => 'Choice A',
                'B' => 'Choice B', 
                'C' => 'Choice C',
                'D' => 'Choice D'
            ],
            'answer' => 'A'
        ]
    ]
];

echo "<h3>Sample JSON:</h3>";
echo "<pre>" . json_encode($sampleData, JSON_PRETTY_PRINT) . "</pre>";

// Test button to call bulk insert
echo "<h3>Test API:</h3>";
echo '<button onclick="testBulkInsert()">Test Bulk Insert</button>';
echo '<div id="result"></div>';

?>

<script>
async function testBulkInsert() {
    const sampleData = {
        lessonId: '6',
        questions: [{
            question: 'Test question from API?',
            choices: {
                A: 'Test Choice A',
                B: 'Test Choice B',
                C: 'Test Choice C', 
                D: 'Test Choice D'
            },
            answer: 'A'
        }]
    };
    
    try {
        const response = await fetch('bulk_insert_questions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(sampleData)
        });
        
        const text = await response.text();
        document.getElementById('result').innerHTML = '<h4>Response:</h4><pre>' + text + '</pre>';
        
    } catch (error) {
        document.getElementById('result').innerHTML = '<h4>Error:</h4><pre>' + error.message + '</pre>';
    }
}
</script>