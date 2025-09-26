<?php
// Alternative API configuration with different models
ob_start();
session_start();

try {
    if (file_exists("../../../include/initialize.php")) {
        require_once("../../../include/initialize.php");
    }
    if (file_exists("gemini_config.php")) {
        require_once("gemini_config.php");
    }
} catch (Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['error' => 'File loading error: ' . $e->getMessage()]);
    exit;
}

ob_clean();
header('Content-Type: application/json');

if (!isset($_SESSION['USERID']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$postData = file_get_contents('php://input');
$input = json_decode($postData, true);

if (!$input || !isset($input['topic']) || empty(trim($input['topic']))) {
    echo json_encode(['error' => 'Topic required']);
    exit;
}

$topic = trim($input['topic']);
$difficulty = isset($input['difficulty']) ? trim($input['difficulty']) : 'medium';

$apiKey = getGeminiApiKey();
if (!$apiKey) {
    echo json_encode(['error' => 'API key not configured']);
    exit;
}

// Try multiple models in order of preference
$models = [
    'gemini-1.5-flash',
    'gemini-1.5-pro', 
    'gemini-pro'
];

$lastError = '';

foreach ($models as $model) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
    
    $prompt = "Create a multiple choice question about '{$topic}' with {$difficulty} difficulty.
    
Return only valid JSON:
{
    \"question\": \"Your question\",
    \"choices\": {
        \"A\": \"Choice A\",
        \"B\": \"Choice B\",
        \"C\": \"Choice C\",
        \"D\": \"Choice D\"
    },
    \"answer\": \"A\"
}";

    $requestData = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt]
                ]
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-goog-api-key: ' . $apiKey
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        $lastError = "cURL error with $model: $curlError";
        continue;
    }

    if ($httpCode !== 200) {
        $lastError = "HTTP $httpCode with model $model";
        continue;
    }

    $responseData = json_decode($response, true);
    if (!$responseData || !isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        $lastError = "Invalid response format from $model";
        continue;
    }

    $generatedText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);
    
    // Try to parse JSON
    $questionData = json_decode($generatedText, true);
    
    if (!$questionData) {
        // Try extracting JSON from text
        $startPos = strpos($generatedText, '{');
        $endPos = strrpos($generatedText, '}');
        
        if ($startPos !== false && $endPos !== false) {
            $jsonText = substr($generatedText, $startPos, $endPos - $startPos + 1);
            $questionData = json_decode($jsonText, true);
        }
    }

    // Validate question data
    if ($questionData && 
        isset($questionData['question']) && 
        isset($questionData['choices']) && 
        isset($questionData['answer']) &&
        is_array($questionData['choices']) &&
        count($questionData['choices']) >= 4) {
        
        // Success!
        echo json_encode([
            'success' => true,
            'data' => $questionData,
            'model_used' => $model
        ]);
        exit;
    }
    
    $lastError = "Invalid question format from $model";
}

// All models failed
echo json_encode([
    'error' => 'All models failed. Last error: ' . $lastError,
    'models_tried' => $models
]);
?>