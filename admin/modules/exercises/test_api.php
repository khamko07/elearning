<?php
// Simple test file for Gemini API
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

// Test response
try {
    require_once("../../../include/initialize.php");
    require_once("gemini_config.php");
    
    // Check session
    if (!isset($_SESSION['USERID']) || !isset($_SESSION['TYPE'])) {
        echo json_encode(['error' => 'Session not found. Please login first.']);
        exit;
    }
    
    if ($_SESSION['TYPE'] != 'Administrator') {
        echo json_encode(['error' => 'Admin access required']);
        exit;
    }
    
    // Test API key
    $apiKey = getGeminiApiKey();
    if (!$apiKey) {
        echo json_encode(['error' => 'API key not configured']);
        exit;
    }
    
    // Simple test - return fake data
    $testData = [
        'question' => 'Test question: What is 2 + 2?',
        'choices' => [
            'A' => '3',
            'B' => '4',
            'C' => '5',
            'D' => '6'
        ],
        'answer' => 'B'
    ];
    
    echo json_encode([
        'success' => true,
        'data' => $testData,
        'debug' => [
            'session_userid' => $_SESSION['USERID'],
            'session_type' => $_SESSION['TYPE'],
            'api_key_configured' => !empty($apiKey)
        ]
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Exception: ' . $e->getMessage()]);
}
?>