<?php
// Test multiple questions generation using test endpoint (no session required)

echo "<h3>Testing Multiple Questions (3 questions)</h3>";

$postData = json_encode([
    'topic' => 'JavaScript',
    'difficulty' => 'trung bình',
    'numQuestions' => 3
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/elearning/admin/modules/exercises/gemini_api_test.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Cookie: PHPSESSID=' . session_create_id()
]);
curl_setopt($ch, CURLOPT_COOKIEJAR, '');
curl_setopt($ch, CURLOPT_COOKIEFILE, '');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
echo "<p><strong>Response:</strong></p>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

// Let's create a simple direct test
echo "<hr><h3>Direct API Test (bypassing session check)</h3>";

require_once("gemini_config.php");

// Test multiple questions generation
$testData = [
    'topic' => 'JavaScript',
    'difficulty' => 'trung bình',
    'numQuestions' => 3
];

echo "<h3>Testing Multiple Questions Generation (3 questions)</h3>";
echo "<p><strong>Request:</strong></p>";
echo "<pre>" . json_encode($testData, JSON_PRETTY_PRINT) . "</pre>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/elearning/admin/modules/exercises/gemini_api_fallback.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
echo "<p><strong>Response:</strong></p>";

if ($response) {
    $result = json_decode($response, true);
    if ($result) {
        echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        
        if (isset($result['success']) && $result['success']) {
            echo "<p style='color: green;'><strong>✅ SUCCESS!</strong></p>";
            if (isset($result['count'])) {
                echo "<p><strong>Generated Questions Count:</strong> {$result['count']}</p>";
            }
        } else {
            echo "<p style='color: red;'><strong>❌ FAILED!</strong></p>";
        }
    } else {
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>No response received</p>";
}

// Also test single question to compare
echo "<hr>";
echo "<h3>Testing Single Question Generation (1 question)</h3>";

$testDataSingle = [
    'topic' => 'JavaScript',
    'difficulty' => 'trung bình',
    'numQuestions' => 1
];

echo "<p><strong>Request:</strong></p>";
echo "<pre>" . json_encode($testDataSingle, JSON_PRETTY_PRINT) . "</pre>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/elearning/admin/modules/exercises/gemini_api_fallback.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testDataSingle));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
echo "<p><strong>Response:</strong></p>";

if ($response) {
    $result = json_decode($response, true);
    if ($result) {
        echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        
        if (isset($result['success']) && $result['success']) {
            echo "<p style='color: green;'><strong>✅ SUCCESS!</strong></p>";
        } else {
            echo "<p style='color: red;'><strong>❌ FAILED!</strong></p>";
        }
    } else {
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>No response received</p>";
}
?>