<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>

<?php
global $mydb;

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
?>

<style>
/* Lao Language Font */
@font-face {
  font-family: 'Phetsarath OT';
  src: url('../../../fonts/Phetsarath OT.ttf') format('truetype');
  font-weight: normal;
  font-style: normal;
}

/* Apply Lao font when Lao language is detected */
.lao-content {
  font-family: 'Phetsarath OT', Arial, sans-serif !important;
}

.lao-content .editor-textarea,
.lao-content .preview-content,
.lao-content h1, .lao-content h2, .lao-content h3, 
.lao-content h4, .lao-content h5, .lao-content h6,
.lao-content p, .lao-content li, .lao-content td, .lao-content th {
  font-family: 'Phetsarath OT', Arial, sans-serif !important;
}

.github-editor {
  border: 1px solid #d1d9e0;
  border-radius: 6px;
  background: #fff;
}
.editor-tabs {
  display: flex;
  background: #f6f8fa;
  border-bottom: 1px solid #d1d9e0;
  border-radius: 6px 6px 0 0;
}
.editor-tab {
  padding: 8px 16px;
  border: none;
  background: transparent;
  cursor: pointer;
  font-size: 14px;
  color: #656d76;
  border-bottom: 2px solid transparent;
}
.editor-tab.active {
  color: #24292f;
  border-bottom-color: #fd8c73;
  background: #fff;
}
.editor-content {
  min-height: 400px;
}
.editor-textarea {
  width: 100%;
  min-height: 400px;
  border: none;
  padding: 16px;
  font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
  font-size: 14px;
  line-height: 1.45;
  resize: vertical;
  outline: none;
}
.preview-content {
  padding: 16px;
  min-height: 400px;
  background: #fff;
  display: none;
}
.preview-content h1 { font-size: 2em; margin: 0.67em 0; font-weight: 600; }
.preview-content h2 { font-size: 1.5em; margin: 0.83em 0; font-weight: 600; }
.preview-content h3 { font-size: 1.17em; margin: 1em 0; font-weight: 600; }
.preview-content h4 { font-size: 1em; margin: 1.33em 0; font-weight: 600; }
.preview-content ul, .preview-content ol { padding-left: 2em; }
.preview-content li { margin: 0.25em 0; }
.preview-content p { margin: 1em 0; line-height: 1.6; }
.preview-content code { 
  background: #f6f8fa; 
  padding: 0.2em 0.4em; 
  border-radius: 3px; 
  font-family: 'SFMono-Regular', Consolas, monospace;
  font-size: 85%;
}
.preview-content pre {
  background: #f6f8fa;
  padding: 16px;
  border-radius: 6px;
  overflow: auto;
  font-family: 'SFMono-Regular', Consolas, monospace;
  font-size: 85%;
}
.preview-content blockquote {
  border-left: 4px solid #d1d9e0;
  padding-left: 16px;
  margin: 0;
  color: #656d76;
}
</style>

<form class="form-horizontal span6" action="controller.php?action=update" method="POST">
  <input type="hidden" name="ContentID" value="<?php echo $content->ContentID; ?>">
  
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edit Content</h1>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Title">Title:</label>
      <div class="col-md-10">
        <input class="form-control input-sm" id="Title" name="Title" type="text" 
               value="<?php echo htmlspecialchars($content->Title); ?>" placeholder="Title">
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Topic">Topic:</label>
      <div class="col-md-10">
        <input class="form-control input-sm" id="Topic" name="Topic" type="text" 
               value="<?php echo htmlspecialchars($content->Topic); ?>" placeholder="Topic">
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label">Content:</label>
      <div class="col-md-10">
        <div class="github-editor">
          <div class="editor-tabs">
            <button type="button" class="editor-tab active" data-tab="write">
              <i class="fa fa-edit"></i> Write
            </button>
            <button type="button" class="editor-tab" data-tab="preview">
              <i class="fa fa-eye"></i> Preview
            </button>
          </div>
          <div class="editor-content">
            <textarea class="editor-textarea" id="Body" name="Body"><?php echo htmlspecialchars($content->Body); ?></textarea>
            <div class="preview-content" id="preview"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-11">
      <div class="col-md-10 col-md-offset-2">
        <button class="btn btn-primary" name="save" type="submit">
          <i class="fa fa-save"></i> Update Content
        </button>
        <a href="index.php?view=preview&id=<?php echo $content->ContentID; ?>" class="btn btn-info">
          <i class="fa fa-eye"></i> View Preview
        </a>
        <a href="index.php" class="btn btn-default">
          <i class="fa fa-arrow-left"></i> Cancel
        </a>
      </div>
    </div>
  </div>
</form>

<script>
// Function to detect Lao text (Lao Unicode range: U+0E80 to U+0EFF)
function containsLaoText(text) {
  return /[\u0E80-\u0EFF]/.test(text);
}

// Check on page load if content contains Lao text
window.addEventListener('DOMContentLoaded', function() {
  const titleInput = document.getElementById('Title');
  const bodyTextarea = document.getElementById('Body');
  const editorContainer = document.querySelector('.github-editor');
  
  function checkAndApplyLaoFont() {
    const title = titleInput ? titleInput.value : '';
    const body = bodyTextarea ? bodyTextarea.value : '';
    
    if (containsLaoText(title + body)) {
      editorContainer.classList.add('lao-content');
    } else {
      editorContainer.classList.remove('lao-content');
    }
  }
  
  // Check on load
  checkAndApplyLaoFont();
  
  // Check on input
  if (titleInput) titleInput.addEventListener('input', checkAndApplyLaoFont);
  if (bodyTextarea) bodyTextarea.addEventListener('input', checkAndApplyLaoFont);
});

// Simple Markdown to HTML converter
function markdownToHtml(markdown) {
  let html = markdown
    // Headers
    .replace(/^### (.*$)/gim, '<h3>$1</h3>')
    .replace(/^## (.*$)/gim, '<h2>$1</h2>')
    .replace(/^# (.*$)/gim, '<h1>$1</h1>')
    // Bold and Italic
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
    .replace(/\*(.*?)\*/g, '<em>$1</em>')
    // Code blocks
    .replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>')
    // Inline code
    .replace(/`(.*?)`/g, '<code>$1</code>')
    // Lists
    .replace(/^\* (.*$)/gim, '<li>$1</li>')
    .replace(/^- (.*$)/gim, '<li>$1</li>')
    // Blockquotes
    .replace(/^> (.*$)/gim, '<blockquote>$1</blockquote>')
    // Line breaks
    .replace(/\n\n/g, '</p><p>')
    .replace(/\n/g, '<br>');

  // Wrap lists in ul tags
  html = html.replace(/(<li>.*<\/li>)/gs, '<ul>$1</ul>');
  
  // Wrap content in paragraphs
  if (html && !html.startsWith('<h') && !html.startsWith('<ul') && !html.startsWith('<pre')) {
    html = '<p>' + html + '</p>';
  }
  
  return html;
}

// Tab switching
document.querySelectorAll('.editor-tab').forEach(tab => {
  tab.addEventListener('click', function() {
    const tabType = this.dataset.tab;
    
    // Update active tab
    document.querySelectorAll('.editor-tab').forEach(t => t.classList.remove('active'));
    this.classList.add('active');
    
    // Show/hide content
    const textarea = document.getElementById('Body');
    const preview = document.getElementById('preview');
    
    if (tabType === 'write') {
      textarea.style.display = 'block';
      preview.style.display = 'none';
    } else {
      textarea.style.display = 'none';
      preview.style.display = 'block';
      // Update preview content
      preview.innerHTML = markdownToHtml(textarea.value) || '<p style="color: #656d76; font-style: italic;">Nothing to preview</p>';
    }
  });
});

// Real-time preview update (optional)
document.getElementById('Body').addEventListener('input', function() {
  const activeTab = document.querySelector('.editor-tab.active').dataset.tab;
  if (activeTab === 'preview') {
    const preview = document.getElementById('preview');
    preview.innerHTML = markdownToHtml(this.value) || '<p style="color: #656d76; font-style: italic;">Nothing to preview</p>';
  }
});
</script>
