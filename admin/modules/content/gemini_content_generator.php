<?php
/**
 * Gemini API Content Generator for Learning Materials
 * Generates comprehensive educational content in Markdown format
 */

ob_start();
session_start();

// Include required files
try {
    if (file_exists("../../../include/initialize.php")) {
        require_once("../../../include/initialize.php");
    }
    
    if (file_exists("../exercises/gemini_config.php")) {
        require_once("../exercises/gemini_config.php");
    }
} catch (Exception $e) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['error' => 'File loading error: ' . $e->getMessage()]);
    exit;
}

ob_clean();
header('Content-Type: application/json');

// Check authentication
if (!isset($_SESSION['USERID'])) {
    echo json_encode(['error' => 'Unauthorized - Please login']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Only POST requests are allowed']);
    exit;
}

// Get POST data
$postData = file_get_contents('php://input');
$input = json_decode($postData, true);

if (!$input) {
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

$topic = isset($input['topic']) ? trim($input['topic']) : '';
$difficulty = isset($input['difficulty']) ? trim($input['difficulty']) : 'medium';
$title = isset($input['title']) ? trim($input['title']) : '';
$language = isset($input['language']) ? trim($input['language']) : 'en';

if (empty($topic)) {
    echo json_encode(['error' => 'Topic cannot be empty']);
    exit;
}

// Get API key
$apiKey = getGeminiApiKey();
if (!$apiKey) {
    echo json_encode(['error' => 'Gemini API key not configured']);
    exit;
}

// Language settings
$languageSettings = [
    'en' => [
        'name' => 'English',
        'instruction' => 'Write the entire content in English.',
        'sections' => [
            'intro' => 'Introduction',
            'key' => 'Key Concepts',
            'main' => 'Main Content',
            'examples' => 'Practical Examples',
            'best' => 'Best Practices',
            'mistakes' => 'Common Mistakes to Avoid',
            'summary' => 'Summary',
            'further' => 'Further Reading'
        ]
    ],
    'vi' => [
        'name' => 'Tiếng Việt',
        'instruction' => 'Viết toàn bộ nội dung bằng Tiếng Việt. Sử dụng ngôn ngữ tự nhiên, dễ hiểu cho người Việt.',
        'sections' => [
            'intro' => 'Giới Thiệu',
            'key' => 'Khái Niệm Chính',
            'main' => 'Nội Dung Chính',
            'examples' => 'Ví Dụ Thực Tế',
            'best' => 'Thực Hành Tốt Nhất',
            'mistakes' => 'Lỗi Thường Gặp Cần Tránh',
            'summary' => 'Tóm Tắt',
            'further' => 'Đọc Thêm'
        ]
    ],
    'th' => [
        'name' => 'ภาษาไทย',
        'instruction' => 'เขียนเนื้อหาทั้งหมดเป็นภาษาไทย ใช้ภาษาที่เข้าใจง่ายและเป็นธรรมชาติสำหรับคนไทย',
        'sections' => [
            'intro' => 'บทนำ',
            'key' => 'แนวคิดหลัก',
            'main' => 'เนื้อหาหลัก',
            'examples' => 'ตัวอย่างเชิงปฏิบัติ',
            'best' => 'แนวทางปฏิบัติที่ดี',
            'mistakes' => 'ข้อผิดพลาดที่ควรหลีกเลี่ยง',
            'summary' => 'สรุป',
            'further' => 'อ่านเพิ่มเติม'
        ]
    ]
];

$lang = isset($languageSettings[$language]) ? $languageSettings[$language] : $languageSettings['en'];
$sections = $lang['sections'];

// Create comprehensive content generation prompt
$difficultyMap = [
    'easy' => 'beginner-friendly with simple explanations',
    'medium' => 'intermediate level with detailed explanations',
    'hard' => 'advanced level with in-depth technical details'
];

$difficultyDesc = isset($difficultyMap[$difficulty]) ? $difficultyMap[$difficulty] : $difficultyMap['medium'];

$prompt = "You are an expert educator. Create a comprehensive, well-structured learning content about: **{$topic}**

IMPORTANT: {$lang['instruction']}

Difficulty Level: {$difficulty} ({$difficultyDesc})

Format the content in clean Markdown with this structure:

# {$topic}

## {$sections['intro']}
Write a brief, engaging introduction (2-3 paragraphs) explaining what {$topic} is and why it's important.

## {$sections['key']}
Explain the fundamental concepts using:
- Clear bullet points for main ideas
- **Bold text** for important terms
- *Italic* for emphasis
- Code examples with `backticks` if relevant

## {$sections['main']}
Break down the topic into 3-4 major sections with:
### Section 1: [Relevant Heading]
Detailed explanation with examples

### Section 2: [Relevant Heading]
Detailed explanation with examples

### Section 3: [Relevant Heading]
Detailed explanation with examples

## {$sections['examples']}
Provide real-world examples or code snippets (if applicable):
```
// Example code or demonstration
```

## {$sections['best']}
List 5-7 best practices or tips:
- Practice point 1
- Practice point 2
- etc.

## {$sections['mistakes']}
Highlight 3-5 common pitfalls:
- Mistake 1 and how to avoid it
- Mistake 2 and how to avoid it

## {$sections['summary']}
Summarize the key takeaways in 2-3 paragraphs.

## {$sections['further']}
Suggest 3-4 topics for deeper learning.

CRITICAL REQUIREMENTS:
- Write 600-1000 words total
- {$lang['instruction']}
- Use clear, educational language appropriate for {$lang['name']} speakers
- Include practical examples
- Format in clean Markdown only
- No HTML, just Markdown
- Make it engaging and informative
- All section headings, content, and examples must be in {$lang['name']}";

// API request data
$requestData = [
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.8,
        'maxOutputTokens' => 4096,
        'topP' => 0.95,
        'topK' => 40
    ]
];

// Make API request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, GEMINI_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-goog-api-key: ' . $apiKey
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Longer timeout for detailed content

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo json_encode(['error' => 'Connection error: ' . $curlError]);
    exit;
}

if ($httpCode !== 200) {
    $errorData = json_decode($response, true);
    $errorMsg = isset($errorData['error']['message']) ? $errorData['error']['message'] : 'Unknown API error';
    echo json_encode([
        'error' => 'API Error (HTTP ' . $httpCode . '): ' . $errorMsg,
        'details' => $errorData
    ]);
    exit;
}

$responseData = json_decode($response, true);

if (!$responseData || !isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
    echo json_encode([
        'error' => 'Invalid API response format',
        'debug' => substr($response, 0, 500)
    ]);
    exit;
}

$generatedContent = trim($responseData['candidates'][0]['content']['parts'][0]['text']);

// Clean up markdown (remove extra spaces, normalize line breaks)
$generatedContent = preg_replace('/\n{3,}/', "\n\n", $generatedContent);
$generatedContent = trim($generatedContent);

// Success response
echo json_encode([
    'success' => true,
    'content' => $generatedContent,
    'metadata' => [
        'topic' => $topic,
        'difficulty' => $difficulty,
        'language' => $language,
        'language_name' => $lang['name'],
        'word_count' => str_word_count($generatedContent),
        'generated_at' => date('Y-m-d H:i:s')
    ]
]);
?>
