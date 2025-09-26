<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in output

// Start output buffering to prevent any accidental output
ob_start();

session_start();

try {
    require_once("../../../include/initialize.php");
    require_once("gemini_config.php");
} catch (Exception $e) {
    ob_clean();
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to load required files: ' . $e->getMessage()]);
    exit;
}

// Clean any output that might have been generated
ob_clean();

// Set proper headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Check if user is logged in and is admin
if (!isset($_SESSION['USERID'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Chưa đăng nhập']);
    exit;
}

if (!isset($_SESSION['TYPE']) || $_SESSION['TYPE'] != 'Administrator') {
    http_response_code(401);
    echo json_encode(['error' => 'Không có quyền truy cập']);
    exit;
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['topic']) || !isset($input['difficulty'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu thông tin chủ đề hoặc độ khó']);
    exit;
}

$topic = trim($input['topic']);
$difficulty = trim($input['difficulty']);

if (empty($topic)) {
    http_response_code(400);
    echo json_encode(['error' => 'Chủ đề không được để trống']);
    exit;
}

// Get API key from config
$apiKey = getGeminiApiKey();
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'API key chưa được cấu hình. Vui lòng liên hệ quản trị viên.']);
    exit;
}

// Create the prompt for Gemini API
$prompt = "Tạo một câu hỏi trắc nghiệm về chủ đề \"{$topic}\" với độ khó {$difficulty}.

Vui lòng trả lời theo định dạng JSON chính xác sau:
{
    \"question\": \"Câu hỏi của bạn ở đây\",
    \"choices\": {
        \"A\": \"Lựa chọn A\",
        \"B\": \"Lựa chọn B\", 
        \"C\": \"Lựa chọn C\",
        \"D\": \"Lựa chọn D\"
    },
    \"answer\": \"A\"
}

Yêu cầu:
- Câu hỏi phải rõ ràng, có tính giáo dục
- 4 lựa chọn phải hợp lý và không quá dễ đoán
- Đáp án đúng phải chính xác 100%
- Phù hợp cho nền tảng e-learning
- Sử dụng tiếng Việt hoặc tiếng Anh tùy theo chủ đề";

// Prepare the request data
$requestData = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $prompt
                ]
            ]
        ]
    ]
];

// Initialize cURL
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($requestData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'X-goog-api-key: ' . $apiKey
    ],
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

curl_close($ch);

// Check for cURL errors
if ($curlError) {
    http_response_code(500);
    echo json_encode(['error' => 'Network error: ' . $curlError]);
    exit;
}

// Check HTTP status code
if ($httpCode !== 200) {
    http_response_code($httpCode);
    $errorMsg = 'API request failed with status: ' . $httpCode;
    if ($response) {
        $responseData = json_decode($response, true);
        if (isset($responseData['error']['message'])) {
            $errorMsg .= ' - ' . $responseData['error']['message'];
        }
    }
    echo json_encode(['error' => $errorMsg]);
    exit;
}

// Parse the response
$responseData = json_decode($response, true);

if (!$responseData) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to parse API response as JSON']);
    exit;
}

if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Invalid API response format', 
        'debug' => 'Response structure is not as expected',
        'response_keys' => array_keys($responseData)
    ]);
    exit;
}

$generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'];

// Try multiple methods to clean and parse the JSON
$questionData = null;

// Method 1: Clean markdown code blocks
$cleanText = preg_replace('/```json\s*|\s*```/', '', $generatedText);
$cleanText = trim($cleanText);
$questionData = json_decode($cleanText, true);

if (!$questionData) {
    // Method 2: Extract JSON between first { and last }
    $startPos = strpos($generatedText, '{');
    $endPos = strrpos($generatedText, '}');
    
    if ($startPos !== false && $endPos !== false && $endPos > $startPos) {
        $jsonText = substr($generatedText, $startPos, $endPos - $startPos + 1);
        $questionData = json_decode($jsonText, true);
    }
}

if (!$questionData) {
    // Method 3: Manual extraction as fallback
    $questionData = extractQuestionDataFromText($generatedText);
}

// Validate the question data
if (!isValidQuestionData($questionData)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Generated question data is invalid or incomplete',
        'debug_text' => substr($generatedText, 0, 500) . '...',
        'parsed_data' => $questionData
    ]);
    exit;
}

// Return the question data
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'data' => $questionData
]);

function extractQuestionDataFromText($text) {
    $questionData = [
        'question' => '',
        'choices' => ['A' => '', 'B' => '', 'C' => '', 'D' => ''],
        'answer' => 'A'
    ];
    
    // Try to extract question
    if (preg_match('/"question":\s*"([^"]+)"/', $text, $matches)) {
        $questionData['question'] = $matches[1];
    }
    
    // Try to extract choices
    if (preg_match('/"A":\s*"([^"]+)"/', $text, $matches)) {
        $questionData['choices']['A'] = $matches[1];
    }
    if (preg_match('/"B":\s*"([^"]+)"/', $text, $matches)) {
        $questionData['choices']['B'] = $matches[1];
    }
    if (preg_match('/"C":\s*"([^"]+)"/', $text, $matches)) {
        $questionData['choices']['C'] = $matches[1];
    }
    if (preg_match('/"D":\s*"([^"]+)"/', $text, $matches)) {
        $questionData['choices']['D'] = $matches[1];
    }
    
    // Try to extract answer
    if (preg_match('/"answer":\s*"([ABCD])"/', $text, $matches)) {
        $questionData['answer'] = $matches[1];
    }
    
    return $questionData;
}

function isValidQuestionData($data) {
    if (!is_array($data)) return false;
    
    if (empty($data['question'])) return false;
    
    if (!isset($data['choices']) || !is_array($data['choices'])) return false;
    
    $requiredChoices = ['A', 'B', 'C', 'D'];
    foreach ($requiredChoices as $choice) {
        if (empty($data['choices'][$choice])) return false;
    }
    
    if (!isset($data['answer']) || !in_array($data['answer'], $requiredChoices)) return false;
    
    return true;
}
?>