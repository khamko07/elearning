<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>

<style>
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
.ai-generate-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
  color: white;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.ai-generate-section h4 {
  color: white;
}
.ai-generate-section label {
  color: white;
  font-weight: 500;
}
.ai-generate-section .form-control {
  background: rgba(255,255,255,0.95);
  border: none;
}
.ai-generate-section .btn-success {
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
  border: none;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
}
.ai-generate-section .btn-success:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0,0,0,0.3);
}
</style>

<form class="form-horizontal span6" action="controller.php?action=add" method="POST">
  <div class="row">
    <div class="col-lg-10">
      <h1 class="page-header">Add New Learning Content</h1>
    </div>
    <div class="col-lg-2 text-right">
      <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#helpModal" style="margin-top: 20px;">
        <i class="fa fa-question-circle"></i> Help Guide
      </button>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Title">Title:</label>
      <div class="col-md-10"><input class="form-control input-sm" id="Title" name="Title" type="text" placeholder="Title"></div>
    </div>
  </div>

  <div class="ai-generate-section">
    <h4 style="margin-top: 0; color: #24292f;">
      <i class="fa fa-magic"></i> AI Content Generator
    </h4>
    <p style="color: #656d76; margin-bottom: 15px;">
      Enter a topic and let AI generate comprehensive learning content for you.
    </p>
    
    <div class="row" style="margin-bottom: 10px;">
      <div class="col-md-12">
        <label for="Topic" style="font-weight: 600;">Topic / Subject:</label>
        <input class="form-control input-sm" id="Topic" name="Topic" type="text" 
               placeholder="e.g., Laravel Controllers, Big Data Analytics, Linear Algebra, React Hooks">
      </div>
    </div>
    
    <div class="row" style="margin-bottom: 10px;">
      <div class="col-md-4">
        <label for="Language" style="font-weight: 600;">Content Language:</label>
        <select class="form-control input-sm" id="Language" name="Language">
          <option value="en">🇬🇧 English</option>
          <option value="vi">🇻🇳 Tiếng Việt</option>
          <option value="th">🇹🇭 ภาษาไทย (Thai)</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="Difficulty" style="font-weight: 600;">Difficulty Level:</label>
        <select class="form-control input-sm" id="Difficulty" name="Difficulty">
          <option value="easy">📗 Easy - Beginner Friendly</option>
          <option value="medium" selected>📘 Medium - Intermediate</option>
          <option value="hard">📕 Hard - Advanced</option>
        </select>
      </div>
      <div class="col-md-4">
        <label style="font-weight: 600;">Quick Templates:</label>
        <select class="form-control input-sm" id="QuickTemplate">
          <option value="">-- Select a template --</option>
          <option value="Programming:PHP Basics">Programming: PHP Basics</option>
          <option value="Programming:Laravel Controllers">Programming: Laravel Controllers</option>
          <option value="Programming:React Hooks">Programming: React Hooks</option>
          <option value="Database:SQL Joins">Database: SQL Joins</option>
          <option value="Database:Database Normalization">Database: Database Normalization</option>
          <option value="Math:Linear Algebra">Math: Linear Algebra</option>
          <option value="Math:Calculus">Math: Calculus</option>
          <option value="Science:Big Data Analytics">Science: Big Data Analytics</option>
          <option value="Science:Machine Learning">Science: Machine Learning</option>
          <option value="Business:Project Management">Business: Project Management</option>
        </select>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-12">
        <button type="button" class="btn btn-success btn-lg btn-block" id="btnGenerate" style="margin-top: 10px;">
          <i class="fa fa-magic"></i> Generate Content with AI
        </button>
      </div>
    </div>
    
    <div style="margin-top: 10px; padding: 8px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 4px; font-size: 12px;">
      <strong>💡 Tip:</strong> Generation takes 10-30 seconds. The AI will create a comprehensive lesson with examples, best practices, and more!
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
            <textarea class="editor-textarea" id="Body" name="Body" placeholder="Write your content in Markdown format...

# Example Heading
## Subheading
- Bullet point 1
- Bullet point 2

**Bold text** and *italic text*

```code
Code block example
```"></textarea>
            <div class="preview-content" id="preview"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-11">
      <div class="col-md-10 col-md-offset-2">
        <button class="btn btn-primary" name="save" type="submit"><i class="fa fa-save"></i> Save Content</button>
        <a href="index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
      </div>
    </div>
  </div>
</form>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;">
          <span>&times;</span>
        </button>
        <h4 class="modal-title">
          <i class="fa fa-question-circle"></i> AI Content Generator - Quick Guide
        </h4>
      </div>
      <div class="modal-body">
        <h4><i class="fa fa-rocket"></i> How to Use</h4>
        <ol>
          <li><strong>Enter a Topic</strong>: Type what you want to teach (e.g., "Laravel Controllers", "Big Data")</li>
          <li><strong>Select Language</strong>: Choose English, Tiếng Việt, or ภาษาไทย</li>
          <li><strong>Choose Difficulty</strong>: Select Easy, Medium, or Hard</li>
          <li><strong>Use Quick Templates</strong> (optional): Select from pre-defined topics</li>
          <li><strong>Click Generate</strong>: Wait 10-30 seconds for AI to create content</li>
          <li><strong>Review & Edit</strong>: Check the generated content and make any changes</li>
          <li><strong>Save</strong>: Click "Save Content" when ready</li>
        </ol>

        <hr>

        <h4><i class="fa fa-globe"></i> Multi-Language Support</h4>
        <div class="row">
          <div class="col-md-4">
            <div style="background: #e3f2fd; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;">
              <h5 style="margin-top: 0;">🇬🇧 English</h5>
              <p style="margin: 0; font-size: 0.9em;">Professional educational content</p>
            </div>
          </div>
          <div class="col-md-4">
            <div style="background: #fff3e0; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;">
              <h5 style="margin-top: 0;">🇻🇳 Tiếng Việt</h5>
              <p style="margin: 0; font-size: 0.9em;">Nội dung giáo dục bằng tiếng Việt</p>
            </div>
          </div>
          <div class="col-md-4">
            <div style="background: #fce4ec; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;">
              <h5 style="margin-top: 0;">🇹🇭 ภาษาไทย</h5>
              <p style="margin: 0; font-size: 0.9em;">เนื้อหาการศึกษาภาษาไทย</p>
            </div>
          </div>
        </div>

        <hr>

        <h4><i class="fa fa-lightbulb-o"></i> Tips for Best Results</h4>
        <div class="row">
          <div class="col-md-6">
            <div style="background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
              <strong>✅ Good Topics:</strong>
              <ul style="margin: 5px 0 0 20px;">
                <li>"Laravel Routing Basics"</li>
                <li>"SQL JOIN Operations"</li>
                <li>"React Hooks Explained"</li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div style="background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
              <strong>❌ Avoid:</strong>
              <ul style="margin: 5px 0 0 20px;">
                <li>"Programming" (too vague)</li>
                <li>"Everything about PHP"</li>
                <li>Empty topics</li>
              </ul>
            </div>
          </div>
        </div>

        <hr>

        <h4><i class="fa fa-file-text"></i> Content Structure</h4>
        <p>The AI will generate comprehensive content with:</p>
        <ul>
          <li>📝 <strong>Introduction</strong> - Overview of the topic</li>
          <li>🔑 <strong>Key Concepts</strong> - Main ideas explained</li>
          <li>📚 <strong>Detailed Sections</strong> - In-depth information</li>
          <li>💡 <strong>Practical Examples</strong> - Real-world applications</li>
          <li>✨ <strong>Best Practices</strong> - Tips and recommendations</li>
          <li>⚠️ <strong>Common Mistakes</strong> - What to avoid</li>
          <li>📖 <strong>Summary</strong> - Key takeaways</li>
        </ul>

        <hr>

        <h4><i class="fa fa-code"></i> Markdown Formatting</h4>
        <p>Content is generated in Markdown format. You can use:</p>
        <div style="background: #f6f8fa; padding: 10px; border-radius: 5px; font-family: monospace;">
          # Heading 1<br>
          ## Heading 2<br>
          **Bold text**<br>
          *Italic text*<br>
          - Bullet point<br>
          `inline code`<br>
          ```code block```
        </div>

        <hr>

        <h4><i class="fa fa-exclamation-triangle"></i> Troubleshooting</h4>
        <ul>
          <li><strong>Takes too long?</strong> Complex topics need more time (up to 30s)</li>
          <li><strong>Error message?</strong> Try simplifying your topic or try again</li>
          <li><strong>Content not perfect?</strong> You can edit it or generate again</li>
        </ul>

        <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin-top: 15px;">
          <strong>💡 Pro Tip:</strong> Generate multiple times to get different variations, then pick the best one!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
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

// Quick Template Selection
document.getElementById('QuickTemplate').addEventListener('change', function() {
  const selectedValue = this.value;
  if (selectedValue) {
    const parts = selectedValue.split(':');
    if (parts.length === 2) {
      const topic = parts[1];
      document.getElementById('Topic').value = topic;
      
      // Auto-fill title if empty
      if (!document.getElementById('Title').value) {
        document.getElementById('Title').value = topic;
      }
    }
  }
});

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

// AI Content Generation
document.getElementById('btnGenerate').addEventListener('click', async function() {
  const topic = document.getElementById('Topic').value.trim();
  const difficulty = document.getElementById('Difficulty').value;
  const title = document.getElementById('Title').value.trim();
  const language = document.getElementById('Language').value;
  
  if (!topic) { 
    alert('Please enter a topic (e.g., Laravel Controllers, Big Data, Algebra)'); 
    return; 
  }
  
  // Show loading state
  const btn = this;
  const originalText = btn.innerHTML;
  btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> AI is generating content...';
  btn.disabled = true;
  
  // Show progress message with language info
  const textarea = document.getElementById('Body');
  const languageNames = {
    'en': 'English',
    'vi': 'Tiếng Việt',
    'th': 'ภาษาไทย (Thai)'
  };
  textarea.value = `⏳ Generating comprehensive learning content in ${languageNames[language]}...\n\nThis may take 10-30 seconds depending on the topic complexity.\n\nPlease wait...`;
  
  try {
    const response = await fetch('gemini_content_generator.php', { 
      method: 'POST', 
      headers: {'Content-Type': 'application/json'}, 
      body: JSON.stringify({ 
        topic: topic,
        difficulty: difficulty,
        title: title,
        language: language
      }) 
    });
    
    const text = await response.text();
    let data;
    
    try { 
      data = JSON.parse(text); 
    } catch(e) { 
      console.error('JSON Parse Error:', e);
      console.log('Raw response:', text);
      throw new Error('Invalid response format from server');
    }
    
    // Check for success
    if (data && data.success && data.content) {
      // Set the generated content
      textarea.value = data.content;
      
      // Auto-fill title if empty
      if (!document.getElementById('Title').value) {
        document.getElementById('Title').value = topic;
      }
      
      // Show success message
      const wordCount = data.metadata && data.metadata.word_count ? data.metadata.word_count : 'N/A';
      const languageName = data.metadata && data.metadata.language_name ? data.metadata.language_name : languageNames[language];
      alert(`✅ Content generated successfully!\n\nTopic: ${topic}\nLanguage: ${languageName}\nDifficulty: ${difficulty}\nWord count: ${wordCount}\n\nPlease review and edit as needed before saving.`);
      
      // Switch to Write tab to show content
      document.querySelector('.editor-tab[data-tab="write"]').click();
      
    } else if (data && data.error) {
      // Show error from API
      throw new Error(data.error);
    } else {
      throw new Error('Unexpected response format');
    }
    
  } catch (e) { 
    console.error('Generation error:', e);
    textarea.value = '';
    alert('❌ AI generation error: ' + e.message + '\n\nPlease try again or contact administrator if the problem persists.'); 
  } finally {
    // Restore button state
    btn.innerHTML = originalText;
    btn.disabled = false;
  }
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


