<?php
/**
 * Gemini API Configuration
 * 
 * Instructions:
 * 1. Get your Gemini API key from: https://aistudio.google.com/app/apikey
 * 2. Replace the API key below with your actual key
 * 3. Make sure this file is secure and not accessible via web browser
 */

// Gemini API Configuration - Replace with your actual API key
define('GEMINI_API_KEY', 'AIzaSyBhdSiDoNZl0hq7ppE9OlwerwxFPcTxqsM');
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');

// API Settings
define('GEMINI_TIMEOUT', 30); // seconds
define('GEMINI_MAX_RETRIES', 3);

// Question Generation Settings
define('DEFAULT_DIFFICULTY', 'medium');
define('MAX_TOPIC_LENGTH', 100);

/**
 * Get Gemini API Key
 * Priority: 1. Environment variable, 2. Config constant
 */
function getGeminiApiKey() {
    // Check environment variable first (more secure)
    $envKey = getenv('GEMINI_API_KEY');
    if ($envKey && $envKey !== '') {
        return $envKey;
    }
    
    // Fallback to config constant
    if (defined('GEMINI_API_KEY') && GEMINI_API_KEY !== 'YOUR_GEMINI_API_KEY_HERE') {
        return GEMINI_API_KEY;
    }
    
    return null;
}

/**
 * Check if Gemini API is configured
 */
function isGeminiApiConfigured() {
    return getGeminiApiKey() !== null;
}
?>