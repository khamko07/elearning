<?php
// AI API for quiz generation using Groq (OpenAI-compatible)
header('Content-Type: application/json');

try {
    if (file_exists("gemini_config.php")) {
        require_once("gemini_config.php");
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'File loading error: ' . $e->getMessage()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Only POST method allowed']);
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
$numQuestions = isset($input['numQuestions']) ? intval($input['numQuestions']) : 1;

// Validate numQuestions
if ($numQuestions < 1 || $numQuestions > 10) {
    echo json_encode(['error' => 'Number of questions must be between 1 and 10']);
    exit;
}

$apiKey = getGroqApiKey();
if (!$apiKey) {
    echo json_encode(['error' => 'API key not configured']);
    exit;
}

// Groq API URL and Model
$apiUrl = defined('GROQ_API_URL') ? GROQ_API_URL : 'https://api.groq.com/openai/v1/chat/completions';
$model = defined('GROQ_MODEL') ? GROQ_MODEL : 'llama-3.3-70b-versatile';

// Build prompt
if ($numQuestions == 1) {
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
} else {
    $prompt = "Create {$numQuestions} multiple choice questions about '{$topic}' with {$difficulty} difficulty.
    
Return only valid JSON array:
[
    {
        \"question\": \"Question 1\",
        \"choices\": {
            \"A\": \"Choice A\",
            \"B\": \"Choice B\",
            \"C\": \"Choice C\",
            \"D\": \"Choice D\"
        },
        \"answer\": \"A\"
    },
    {
        \"question\": \"Question 2\",
        \"choices\": {
            \"A\": \"Choice A\",
            \"B\": \"Choice B\",
            \"C\": \"Choice C\",
            \"D\": \"Choice D\"
        },
        \"answer\": \"B\"
    }
]

Make sure each question is unique and covers different aspects of {$topic}.";
}

// Groq API request body (OpenAI-compatible format)
$requestData = [
    'model' => $model,
    'messages' => [
        [
            'role' => 'system',
            'content' => 'You are a helpful assistant that generates quiz questions. Always respond with valid JSON only, no additional text or explanations.'
        ],
        [
            'role' => 'user',
            'content' => $prompt
        ]
    ],
    'temperature' => 0.7,
    'max_tokens' => 2048
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_TIMEOUT, defined('GROQ_TIMEOUT') ? GROQ_TIMEOUT : 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo json_encode(['error' => 'cURL error: ' . $curlError]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(['error' => "HTTP $httpCode from Groq API. Response: " . substr($response, 0, 300)]);
    exit;
}

$responseData = json_decode($response, true);

// Parse OpenAI-compatible response format
if (!$responseData || !isset($responseData['choices'][0]['message']['content'])) {
    echo json_encode(['error' => 'Invalid response format from Groq API', 'raw_response' => substr($response, 0, 500)]);
    exit;
}

$generatedText = trim($responseData['choices'][0]['message']['content']);

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
    
    // Try array format
    if (!$questionData) {
        $startPos = strpos($generatedText, '[');
        $endPos = strrpos($generatedText, ']');
        
        if ($startPos !== false && $endPos !== false) {
            $jsonText = substr($generatedText, $startPos, $endPos - $startPos + 1);
            $questionData = json_decode($jsonText, true);
        }
    }
}

// Validate question data
if ($numQuestions == 1) {
    // Single question validation
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
            'model_used' => $model,
            'count' => 1
        ]);
        exit;
    }
} else {
    // Multiple questions validation
    if ($questionData && is_array($questionData) && count($questionData) >= 1) {
        $validQuestions = [];
        
        foreach ($questionData as $q) {
            if (isset($q['question']) && 
                isset($q['choices']) && 
                isset($q['answer']) &&
                is_array($q['choices']) &&
                count($q['choices']) >= 4) {
                $validQuestions[] = $q;
            }
        }
        
        if (count($validQuestions) >= 1) {
            // Success!
            echo json_encode([
                'success' => true,
                'data' => $validQuestions,
                'model_used' => $model,
                'count' => count($validQuestions)
            ]);
            exit;
        }
    }
}

// Failed to parse valid question data
echo json_encode([
    'error' => 'Failed to parse valid question format from AI response',
    'raw_text' => substr($generatedText, 0, 500)
]);
?>