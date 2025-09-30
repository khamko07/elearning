<?php
// Direct test of Gemini API without session validation
require_once("gemini_config.php");

function testGeminiAPI($topic, $difficulty, $numQuestions) {
    $apiKey = getGeminiApiKey();
    if (!$apiKey) {
        return ['error' => 'API key not configured'];
    }

    // Models to try
    $models = [
        'gemini-2.0-flash',
        'gemini-2.5-flash',
        'gemini-2.5-pro'
    ];

    foreach ($models as $model) {
        echo "<h4>Testing with model: $model</h4>";
        
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

        echo "<p><strong>HTTP Code:</strong> $httpCode</p>";

        if ($curlError) {
            echo "<p><strong>cURL Error:</strong> $curlError</p>";
            continue;
        }

        if ($httpCode !== 200) {
            echo "<p style='color: red;'><strong>❌ FAILED!</strong> HTTP $httpCode</p>";
            echo "<p><strong>Response:</strong></p>";
            echo "<pre>" . htmlspecialchars(substr($response, 0, 500)) . "</pre>";
            continue;
        }

        $responseData = json_decode($response, true);
        if (!$responseData || !isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            echo "<p style='color: red;'><strong>❌ Invalid response format</strong></p>";
            continue;
        }

        $generatedText = trim($responseData['candidates'][0]['content']['parts'][0]['text']);
        
        echo "<p style='color: green;'><strong>✅ SUCCESS!</strong> Model $model works!</p>";
        echo "<p><strong>Generated Text:</strong></p>";
        echo "<pre>" . htmlspecialchars($generatedText) . "</pre>";
        
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

        if ($questionData) {
            echo "<p><strong>Parsed JSON:</strong></p>";
            echo "<pre>" . json_encode($questionData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
            
            if ($numQuestions == 1) {
                if (isset($questionData['question']) && isset($questionData['choices']) && isset($questionData['answer'])) {
                    echo "<p style='color: green;'><strong>✅ Single question format is valid!</strong></p>";
                    return ['success' => true, 'data' => $questionData, 'model_used' => $model, 'count' => 1];
                }
            } else {
                if (is_array($questionData) && count($questionData) >= 1) {
                    $validQuestions = [];
                    foreach ($questionData as $q) {
                        if (isset($q['question']) && isset($q['choices']) && isset($q['answer'])) {
                            $validQuestions[] = $q;
                        }
                    }
                    if (count($validQuestions) >= 1) {
                        echo "<p style='color: green;'><strong>✅ Multiple questions format is valid! Got " . count($validQuestions) . " questions</strong></p>";
                        return ['success' => true, 'data' => $validQuestions, 'model_used' => $model, 'count' => count($validQuestions)];
                    }
                }
            }
        } else {
            echo "<p style='color: orange;'><strong>⚠️ Could not parse JSON from response</strong></p>";
        }
        
        echo "<hr>";
    }
    
    return ['error' => 'All models failed'];
}

echo "<h2>Testing Multiple Questions (3 questions)</h2>";
$result = testGeminiAPI('JavaScript', 'medium', 3);
echo "<p><strong>Final Result:</strong></p>";
echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";

echo "<hr><h2>Testing Single Question (1 question)</h2>";
$result = testGeminiAPI('JavaScript', 'medium', 1);
echo "<p><strong>Final Result:</strong></p>";
echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
?>