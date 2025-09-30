<?php
// Test version of Gemini API without session validation
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

$apiKey = getGeminiApiKey();
if (!$apiKey) {
    echo json_encode(['error' => 'API key not configured']);
    exit;
}

// Try multiple models in order of preference (based on available models)
$models = [
    'gemini-2.0-flash',
    'gemini-2.5-flash',
    'gemini-2.5-pro',
    'gemini-pro-latest',
    'gemini-flash-latest'
];

$lastError = '';

foreach ($models as $model) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
    
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
        $lastError = "HTTP $httpCode with model $model. Response: " . substr($response, 0, 200);
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
    
    $lastError = "Invalid question format from $model";
}

// All models failed
echo json_encode([
    'error' => 'All models failed. Last error: ' . $lastError,
    'models_tried' => $models
]);
?>