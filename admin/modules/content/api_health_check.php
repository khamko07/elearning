<?php
/**
 * Quick API Health Check
 * Tests if Gemini API is working properly
 */

// Include config
require_once("../exercises/gemini_config.php");

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gemini API Health Check</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f7fb; }
        .status { padding: 20px; border-radius: 8px; margin: 20px 0; }
        .success { background: #d4edda; border: 2px solid #28a745; color: #155724; }
        .error { background: #f8d7da; border: 2px solid #dc3545; color: #721c24; }
        .warning { background: #fff3cd; border: 2px solid #ffc107; color: #856404; }
        h1 { color: #333; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .info { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #667eea; }
    </style>
</head>
<body>
    <h1>🔍 Gemini API Health Check</h1>
    
    <?php
    // Check 1: Config file exists
    echo "<div class='info'><strong>Check 1:</strong> Configuration File</div>";
    if (defined('GEMINI_API_KEY')) {
        echo "<div class='status success'>✅ Config file loaded successfully</div>";
    } else {
        echo "<div class='status error'>❌ Config file not found or GEMINI_API_KEY not defined</div>";
        exit;
    }
    
    // Check 2: API Key configured
    echo "<div class='info'><strong>Check 2:</strong> API Key Configuration</div>";
    $apiKey = getGeminiApiKey();
    if ($apiKey && $apiKey !== 'YOUR_GEMINI_API_KEY_HERE') {
        $maskedKey = substr($apiKey, 0, 10) . '...' . substr($apiKey, -5);
        echo "<div class='status success'>✅ API Key is configured<br>Key: <code>{$maskedKey}</code></div>";
    } else {
        echo "<div class='status error'>❌ API Key not configured properly<br>Please edit <code>gemini_config.php</code> and add your API key</div>";
        exit;
    }
    
    // Check 3: cURL available
    echo "<div class='info'><strong>Check 3:</strong> cURL Extension</div>";
    if (function_exists('curl_init')) {
        echo "<div class='status success'>✅ cURL is available</div>";
    } else {
        echo "<div class='status error'>❌ cURL is not available. Please enable php_curl extension</div>";
        exit;
    }
    
    // Check 4: API Endpoint
    echo "<div class='info'><strong>Check 4:</strong> API Endpoint</div>";
    echo "<div class='status success'>✅ Endpoint configured: <code>" . GEMINI_API_URL . "</code></div>";
    
    // Check 5: Test API Call
    echo "<div class='info'><strong>Check 5:</strong> Test API Call</div>";
    echo "<p>Sending a simple test request to Gemini API...</p>";
    
    $testPrompt = "Say 'Hello, API is working!' in exactly that phrase.";
    
    $requestData = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $testPrompt]
                ]
            ]
        ],
        'generationConfig' => [
            'temperature' => 0.1,
            'maxOutputTokens' => 50
        ]
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GEMINI_API_URL);
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
        echo "<div class='status error'>❌ Connection Error: " . htmlspecialchars($curlError) . "</div>";
        exit;
    }
    
    if ($httpCode === 200) {
        $responseData = json_decode($response, true);
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'];
            echo "<div class='status success'>";
            echo "✅ API Call Successful!<br>";
            echo "<strong>Response:</strong> " . htmlspecialchars($generatedText) . "<br>";
            echo "<strong>HTTP Code:</strong> 200 OK";
            echo "</div>";
        } else {
            echo "<div class='status warning'>";
            echo "⚠️ API responded but format unexpected<br>";
            echo "<strong>Response:</strong> <pre>" . htmlspecialchars(substr($response, 0, 500)) . "</pre>";
            echo "</div>";
        }
    } else {
        $errorData = json_decode($response, true);
        $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown error';
        echo "<div class='status error'>";
        echo "❌ API Error<br>";
        echo "<strong>HTTP Code:</strong> {$httpCode}<br>";
        echo "<strong>Error:</strong> " . htmlspecialchars($errorMsg) . "<br>";
        if ($httpCode === 403) {
            echo "<br><strong>Possible causes:</strong><br>";
            echo "- API key is invalid<br>";
            echo "- API key doesn't have proper permissions<br>";
            echo "- API is not enabled for this key<br>";
            echo "<br><strong>Solution:</strong> Get a new API key from <a href='https://aistudio.google.com/app/apikey' target='_blank'>Google AI Studio</a>";
        }
        echo "</div>";
        exit;
    }
    
    // Final Summary
    echo "<div class='info' style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;'>";
    echo "<h2 style='margin-top: 0; color: white;'>🎉 All Checks Passed!</h2>";
    echo "<p>Your Gemini API is configured correctly and working properly.</p>";
    echo "<p><strong>You can now use the AI Content Generator!</strong></p>";
    echo "<p>Next steps:</p>";
    echo "<ul>";
    echo "<li>Go to: <a href='index.php?view=add' style='color: #fff3cd;'>Add Content Page</a></li>";
    echo "<li>Enter a topic (e.g., 'Laravel Controllers')</li>";
    echo "<li>Click 'Generate Content with AI'</li>";
    echo "<li>Wait 15-20 seconds for comprehensive content</li>";
    echo "</ul>";
    echo "</div>";
    ?>
    
    <div style="text-align: center; margin-top: 30px; color: #666;">
        <p>Last checked: <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>
</body>
</html>
