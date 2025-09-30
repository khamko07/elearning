<?php
require_once("gemini_config.php");

$apiKey = getGeminiApiKey();
if (!$apiKey) {
    die("API key not configured");
}

// Test different models
$models = [
    'gemini-1.5-flash',
    'gemini-1.5-pro', 
    'gemini-pro',
    'gemini-2.0-flash',
    'gemini-1.0-pro'
];

echo "<h3>Testing Gemini Models:</h3>";

foreach ($models as $model) {
    echo "<h4>Testing model: $model</h4>";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
    
    $prompt = "Create 2 multiple choice questions about 'JavaScript' with medium difficulty.
    
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
]";

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
    }
    
    if ($httpCode == 200) {
        echo "<p style='color: green;'><strong>✅ SUCCESS!</strong> Model $model works!</p>";
        
        $responseData = json_decode($response, true);
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'];
            echo "<p><strong>Response:</strong></p>";
            echo "<pre>" . htmlspecialchars(substr($generatedText, 0, 300)) . "...</pre>";
        }
    } else {
        echo "<p style='color: red;'><strong>❌ FAILED!</strong> HTTP $httpCode</p>";
        if ($response) {
            echo "<p><strong>Error Response:</strong></p>";
            echo "<pre>" . htmlspecialchars(substr($response, 0, 500)) . "</pre>";
        }
    }
    
    echo "<hr>";
}

// Also test listing available models
echo "<h3>Testing Models List API:</h3>";
$listUrl = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $listUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$listResponse = curl_exec($ch);
$listHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p><strong>Models List HTTP Code:</strong> $listHttpCode</p>";

if ($listHttpCode == 200) {
    $listData = json_decode($listResponse, true);
    if (isset($listData['models'])) {
        echo "<p><strong>Available Models:</strong></p>";
        echo "<ul>";
        foreach ($listData['models'] as $model) {
            if (isset($model['name'])) {
                $modelName = str_replace('models/', '', $model['name']);
                echo "<li>$modelName</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<pre>" . htmlspecialchars($listResponse) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>Failed to get models list</p>";
    echo "<pre>" . htmlspecialchars($listResponse) . "</pre>";
}
?>