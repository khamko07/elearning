<?php
// Simplified Gemini API handler
ob_start(); // Start output buffering

session_start();

// Include files with error handling
try {
    if (file_exists("../../../include/initialize.php")) {
        require_once("../../../include/initialize.php");
    } else {
        throw new Exception("initialize.php not found");
    }
    
    if (file_exists("gemini_config.php")) {
        require_once("gemini_config.php");
    } else {
        throw new Exception("gemini_config.php not found");
    }
} catch (Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['error' => 'File loading error: ' . $e->getMessage()]);
    exit;
}

ob_clean(); // Clean any output from includes
header('Content-Type: application/json'); // Set JSON header

// Check authentication
if (!isset($_SESSION['USERID'])) {
    echo json_encode(['error' => 'Chưa đăng nhập']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Chỉ chấp nhận POST request']);
    exit;
}

// Get POST data
$postData = file_get_contents('php://input');
$input = json_decode($postData, true);

if (!$input) {
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

if (!isset($input['topic']) || empty(trim($input['topic']))) {
    echo json_encode(['error' => 'Chủ đề không được để trống']);
    exit;
}

$topic = trim($input['topic']);
$difficulty = isset($input['difficulty']) ? trim($input['difficulty']) : 'trung bình';

// Get API key
$apiKey = getGeminiApiKey();
if (!$apiKey) {
    echo json_encode(['error' => 'API key chưa được cấu hình']);
    exit;
}

// Create simplified prompt
$prompt = "Create a multiple choice question about '{$topic}' with {$difficulty} difficulty.

Return ONLY a valid JSON object in this exact format (no extra text, no markdown):
{
    \"question\": \"Your question here\",
    \"choices\": {
        \"A\": \"Choice A\",
        \"B\": \"Choice B\",
        \"C\": \"Choice C\",
        \"D\": \"Choice D\"
    },
    \"answer\": \"A\"
}";

// API request data
$requestData = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 1000
    ]
];

// Make API request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-goog-api-key: ' . $apiKey
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo json_encode(['error' => 'Lỗi kết nối: ' . $curlError]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(['error' => 'API lỗi: HTTP ' . $httpCode]);
    exit;
}

$responseData = json_decode($response, true);
if (!$responseData || !isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    echo json_encode(['error' => 'Phản hồi API không hợp lệ']);
    exit;
}

$generatedText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);

// Parse JSON from response
$questionData = json_decode($generatedText, true);

if (!$questionData) {
    // Try to extract JSON manually
    $startPos = strpos($generatedText, '{');
    $endPos = strrpos($generatedText, '}');
    
    if ($startPos !== false && $endPos !== false) {
        $jsonText = substr($generatedText, $startPos, $endPos - $startPos + 1);
        $questionData = json_decode($jsonText, true);
    }
}

// Validate and return
if (!$questionData || !isset($questionData['question']) || !isset($questionData['choices']) || !isset($questionData['answer'])) {
    echo json_encode([
        'error' => 'Không thể phân tích câu hỏi từ AI',
        'debug' => substr($generatedText, 0, 300)
    ]);
    exit;
}

// Success response
echo json_encode([
    'success' => true,
    'data' => $questionData
]);
?>