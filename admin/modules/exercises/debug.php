<?php
// Debug file for Gemini API
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

echo "Debug Information:\n";
echo "================\n";

// Check session
echo "Session USERID: " . (isset($_SESSION['USERID']) ? $_SESSION['USERID'] : 'Not set') . "\n";
echo "Session TYPE: " . (isset($_SESSION['TYPE']) ? $_SESSION['TYPE'] : 'Not set') . "\n";

// Check if files exist
echo "Files check:\n";
echo "initialize.php: " . (file_exists("../../../include/initialize.php") ? "EXISTS" : "NOT FOUND") . "\n";
echo "gemini_config.php: " . (file_exists("gemini_config.php") ? "EXISTS" : "NOT FOUND") . "\n";

// Try to include files
try {
    require_once("../../../include/initialize.php");
    echo "initialize.php loaded successfully\n";
} catch (Exception $e) {
    echo "Error loading initialize.php: " . $e->getMessage() . "\n";
}

try {
    require_once("gemini_config.php");
    echo "gemini_config.php loaded successfully\n";
    
    $apiKey = getGeminiApiKey();
    echo "API Key: " . ($apiKey ? "CONFIGURED" : "NOT CONFIGURED") . "\n";
} catch (Exception $e) {
    echo "Error loading gemini_config.php: " . $e->getMessage() . "\n";
}

// Check POST data
$input = json_decode(file_get_contents('php://input'), true);
echo "POST Data: " . print_r($input, true) . "\n";

?>