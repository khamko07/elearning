<?php
// Test available Gemini models
require_once("gemini_config.php");

$apiKey = getGeminiApiKey();
if (!$apiKey) {
    die("API key not configured");
}

$models = [
    'gemini-1.5-flash',
    'gemini-1.5-pro',
    'gemini-pro',
    'gemini-1.0-pro'
];

echo "<h2>Testing Gemini Models</h2>";

foreach ($models as $model) {
    echo "<h3>Testing: $model</h3>";
    
    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
    
    $requestData = [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Say hello in JSON format: {"message": "your response"}']
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
    
    if ($httpCode == 200) {
        echo "<p style='color: green;'>✅ Model works!</p>";
        $responseData = json_decode($response, true);
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            echo "<p><strong>Response:</strong> " . htmlspecialchars($responseData['candidates'][0]['content']['parts'][0]['text']) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Model failed</p>";
        if ($response) {
            $errorData = json_decode($response, true);
            if (isset($errorData['error']['message'])) {
                echo "<p><strong>Error:</strong> " . htmlspecialchars($errorData['error']['message']) . "</p>";
            } else {
                echo "<p><strong>Raw response:</strong> " . htmlspecialchars(substr($response, 0, 200)) . "</p>";
            }
        }
    }
    
    echo "<hr>";
}
?>