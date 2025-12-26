<?php
/**
 * Groq API Configuration (OpenAI-compatible)
 * 
 * Instructions:
 * 1. Get your Groq API key from: https://console.groq.com/keys
 * 2. Replace the API key below with your actual key
 * 3. Make sure this file is secure and not accessible via web browser
 */

// Groq API Configuration - Replace with your actual API key
define('GROQ_API_KEY', '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');
define('GROQ_API_URL', 'https://api.groq.com/openai/v1/chat/completions');
define('GROQ_MODEL', 'llama-3.3-70b-versatile');

// API Settings
define('GROQ_TIMEOUT', 30); // seconds
define('GROQ_MAX_RETRIES', 3);

// Question Generation Settings
define('DEFAULT_DIFFICULTY', 'medium');
define('MAX_TOPIC_LENGTH', 100);

/**
 * Get Groq API Key
 * Priority: 1. Environment variable, 2. Config constant
 */
function getGroqApiKey() {
    // Check environment variable first (more secure)
    $envKey = getenv('GROQ_API_KEY');
    if ($envKey && $envKey !== '') {
        return $envKey;
    }
    
    // Fallback to config constant
    if (defined('GROQ_API_KEY') && GROQ_API_KEY !== 'YOUR_GROQ_API_KEY_HERE') {
        return GROQ_API_KEY;
    }
    
    return null;
}

/**
 * Check if Groq API is configured
 */
function isGroqApiConfigured() {
    return getGroqApiKey() !== null;
}

// Backward compatibility aliases (for easier migration)
function getGeminiApiKey() {
    return getGroqApiKey();
}

function isGeminiApiConfigured() {
    return isGroqApiConfigured();
}
?>