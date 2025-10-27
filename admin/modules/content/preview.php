<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>

<style>
/* Lao Language Font */
@font-face {
  font-family: 'Phetsarath OT';
  src: url('../../../fonts/Phetsarath OT.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
}

/* Apply Lao font for Lao content */
.lao-content,
.lao-content * {
  font-family: 'Phetsarath OT', Arial, sans-serif !important;
}

/* Preview Container */
.content-preview-container {
  max-width: 900px;
  margin: 0 auto;
  background: white;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Header Section */
.preview-header {
  border-bottom: 3px solid #667eea;
  padding-bottom: 20px;
  margin-bottom: 30px;
}

.preview-header h1 {
  color: #333;
  font-size: 2.5em;
  margin-bottom: 10px;
  line-height: 1.2;
}

.preview-meta {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  color: #666;
  font-size: 0.95em;
  margin-top: 15px;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 5px;
}

.meta-item i {
  color: #667eea;
}

/* Content Body - Markdown Styles */
.preview-body {
  font-size: 16px;
  line-height: 1.8;
  color: #333;
}

.preview-body h1 {
  font-size: 2.2em;
  margin: 30px 0 20px 0;
  font-weight: 600;
  color: #24292f;
  border-bottom: 2px solid #e1e4e8;
  padding-bottom: 10px;
}

.preview-body h2 {
  font-size: 1.8em;
  margin: 25px 0 15px 0;
  font-weight: 600;
  color: #24292f;
  border-bottom: 1px solid #e1e4e8;
  padding-bottom: 8px;
}

.preview-body h3 {
  font-size: 1.4em;
  margin: 20px 0 12px 0;
  font-weight: 600;
  color: #24292f;
}

.preview-body h4 {
  font-size: 1.2em;
  margin: 18px 0 10px 0;
  font-weight: 600;
  color: #24292f;
}

.preview-body p {
  margin: 15px 0;
  line-height: 1.8;
}

.preview-body ul, .preview-body ol {
  margin: 15px 0;
  padding-left: 30px;
}

.preview-body li {
  margin: 8px 0;
  line-height: 1.6;
}

.preview-body ul li {
  list-style-type: disc;
}

.preview-body ol li {
  list-style-type: decimal;
}

.preview-body strong {
  font-weight: 600;
  color: #24292f;
}

.preview-body em {
  font-style: italic;
}

.preview-body code {
  background: #f6f8fa;
  padding: 3px 6px;
  border-radius: 3px;
  font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
  font-size: 0.9em;
  color: #24292f;
  border: 1px solid #e1e4e8;
}

.preview-body pre {
  background: #f6f8fa;
  padding: 16px;
  border-radius: 6px;
  overflow-x: auto;
  margin: 20px 0;
  border: 1px solid #e1e4e8;
}

.preview-body pre code {
  background: none;
  padding: 0;
  border: none;
  font-size: 0.95em;
  display: block;
  line-height: 1.6;
}

.preview-body blockquote {
  border-left: 4px solid #667eea;
  padding-left: 16px;
  margin: 20px 0;
  color: #656d76;
  font-style: italic;
}

.preview-body hr {
  border: none;
  border-top: 2px solid #e1e4e8;
  margin: 30px 0;
}

.preview-body a {
  color: #667eea;
  text-decoration: none;
}

.preview-body a:hover {
  text-decoration: underline;
}

.preview-body img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 20px auto;
  border-radius: 5px;
}

.preview-body table {
  border-collapse: collapse;
  width: 100%;
  margin: 20px 0;
}

.preview-body table th,
.preview-body table td {
  border: 1px solid #e1e4e8;
  padding: 10px;
  text-align: left;
}

.preview-body table th {
  background: #f6f8fa;
  font-weight: 600;
}

/* Action Buttons */
.preview-actions {
  margin-top: 40px;
  padding-top: 20px;
  border-top: 2px solid #e1e4e8;
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

/* Print Button */
.btn-print {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
}

/* Responsive */
@media (max-width: 768px) {
  .content-preview-container {
    padding: 20px;
  }
  
  .preview-header h1 {
    font-size: 1.8em;
  }
  
  .preview-body h1 { font-size: 1.8em; }
  .preview-body h2 { font-size: 1.5em; }
  .preview-body h3 { font-size: 1.2em; }
  .preview-body h4 { font-size: 1.1em; }
}

/* Print Styles */
@media print {
  .preview-actions,
  .page-header,
  .navbar,
  .sidebar {
    display: none !important;
  }
  
  .content-preview-container {
    box-shadow: none;
    padding: 0;
  }
}
</style>

<?php
global $mydb;

// Function to detect Lao language by checking for Lao Unicode characters
function containsLaoText($text) {
  // Lao Unicode range: U+0E80 to U+0EFF
  return preg_match('/[\x{0E80}-\x{0EFF}]/u', $text) === 1;
}

// Get content ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
  echo '<div class="alert alert-danger">Invalid content ID</div>';
  echo '<a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>';
  exit;
}

// Fetch content
$mydb->setQuery("SELECT * FROM tblcontent WHERE ContentID = {$id}");
$content = $mydb->loadSingleResult();

if (!$content) {
  echo '<div class="alert alert-danger">Content not found</div>';
  echo '<a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>';
  exit;
}

// Convert Markdown to HTML
function parseMarkdown($text) {
  $html = $text;
  
  // Code blocks (must be before inline code)
  $html = preg_replace('/```([a-z]*)\n(.*?)\n```/s', '<pre><code class="language-$1">$2</code></pre>', $html);
  
  // Headers
  $html = preg_replace('/^#### (.*?)$/m', '<h4>$1</h4>', $html);
  $html = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $html);
  $html = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $html);
  $html = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $html);
  
  // Bold and Italic
  $html = preg_replace('/\*\*\*(.*?)\*\*\*/s', '<strong><em>$1</em></strong>', $html);
  $html = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $html);
  $html = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $html);
  $html = preg_replace('/\_\_\_(.*?)\_\_\_/s', '<strong><em>$1</em></strong>', $html);
  $html = preg_replace('/\_\_(.*?)\_\_/s', '<strong>$1</strong>', $html);
  $html = preg_replace('/\_(.*?)\_/s', '<em>$1</em>', $html);
  
  // Inline code
  $html = preg_replace('/`(.*?)`/', '<code>$1</code>', $html);
  
  // Links
  $html = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank">$1</a>', $html);
  
  // Unordered lists
  $html = preg_replace('/^\* (.*?)$/m', '<li>$1</li>', $html);
  $html = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $html);
  $html = preg_replace('/(<li>.*?<\/li>\n?)+/s', '<ul>$0</ul>', $html);
  
  // Ordered lists
  $html = preg_replace('/^\d+\. (.*?)$/m', '<li>$1</li>', $html);
  
  // Blockquotes
  $html = preg_replace('/^> (.*?)$/m', '<blockquote>$1</blockquote>', $html);
  
  // Horizontal rules
  $html = preg_replace('/^---$/m', '<hr>', $html);
  $html = preg_replace('/^\*\*\*$/m', '<hr>', $html);
  
  // Paragraphs (wrap non-tag content)
  $lines = explode("\n", $html);
  $result = [];
  $inBlock = false;
  
  foreach ($lines as $line) {
    $trimmed = trim($line);
    
    // Check if line is a tag
    if (preg_match('/^<(h[1-6]|ul|ol|li|pre|code|blockquote|hr)/', $trimmed)) {
      $inBlock = true;
      $result[] = $line;
    } elseif (preg_match('/<\/(ul|ol|pre|code|blockquote)>/', $trimmed)) {
      $result[] = $line;
      $inBlock = false;
    } elseif (!empty($trimmed) && !$inBlock) {
      $result[] = '<p>' . $line . '</p>';
    } else {
      $result[] = $line;
    }
  }
  
  $html = implode("\n", $result);
  
  return $html;
}

// Detect if content contains Lao text
$isLaoContent = containsLaoText($content->Title . ' ' . $content->Body);
$laoClass = $isLaoContent ? ' lao-content' : '';
?>

<div class="content-preview-container<?php echo $laoClass; ?>">
  <!-- Header -->
  <div class="preview-header">
    <h1><?php echo htmlspecialchars($content->Title); ?></h1>
    <div class="preview-meta">
      <div class="meta-item">
        <i class="fa fa-tag"></i>
        <strong>Topic:</strong> <?php echo htmlspecialchars($content->Topic); ?>
      </div>
      <div class="meta-item">
        <i class="fa fa-calendar"></i>
        <strong>Created:</strong> <?php echo date('F j, Y, g:i a', strtotime($content->CreatedAt)); ?>
      </div>
      <div class="meta-item">
        <i class="fa fa-file-text"></i>
        <strong>Word Count:</strong> <?php echo str_word_count(strip_tags($content->Body)); ?>
      </div>
    </div>
  </div>

  <!-- Content Body -->
  <div class="preview-body">
    <?php echo parseMarkdown($content->Body); ?>
  </div>

  <!-- Actions -->
  <div class="preview-actions">
    <a href="index.php" class="btn btn-default">
      <i class="fa fa-arrow-left"></i> Back to List
    </a>
    <a href="index.php?view=edit&id=<?php echo $content->ContentID; ?>" class="btn btn-warning">
      <i class="fa fa-edit"></i> Edit Content
    </a>
    <button onclick="window.print()" class="btn btn-primary btn-print">
      <i class="fa fa-print"></i> Print
    </button>
    <button onclick="copyContent()" class="btn btn-info">
      <i class="fa fa-copy"></i> Copy Content
    </button>
  </div>
</div>

<script>
function copyContent() {
  const content = <?php echo json_encode($content->Body); ?>;
  
  if (navigator.clipboard) {
    navigator.clipboard.writeText(content).then(function() {
      alert('✅ Content copied to clipboard!');
    }, function(err) {
      console.error('Copy failed:', err);
      fallbackCopy(content);
    });
  } else {
    fallbackCopy(content);
  }
}

function fallbackCopy(text) {
  const textarea = document.createElement('textarea');
  textarea.value = text;
  textarea.style.position = 'fixed';
  textarea.style.opacity = '0';
  document.body.appendChild(textarea);
  textarea.select();
  try {
    document.execCommand('copy');
    alert('✅ Content copied to clipboard!');
  } catch (err) {
    alert('❌ Failed to copy content');
  }
  document.body.removeChild(textarea);
}
</script>
